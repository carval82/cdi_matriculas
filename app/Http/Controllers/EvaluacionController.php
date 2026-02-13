<?php

namespace App\Http\Controllers;

use App\Models\ConceptoEvaluativo;
use App\Models\Evaluacion;
use App\Models\Estudiante;
use App\Models\Grupo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EvaluacionController extends Controller
{
    /**
     * Obtener los IDs de grupos permitidos para el usuario actual.
     */
    private function gruposPermitidos()
    {
        $user = Auth::user();
        if ($user->isAdmin() || $user->isSecretaria()) {
            return Grupo::where('activa', true)->orderBy('orden')->get();
        }

        // Docente: solo sus grupos asignados
        $docente = $user->docente;
        if (!$docente) return collect();

        return $docente->gruposActuales()->orderBy('orden')->get();
    }

    /**
     * Vista de evaluación por grupo y periodo (tipo asistencia).
     */
    public function index(Request $request)
    {
        $grupos = $this->gruposPermitidos();
        $conceptos = ConceptoEvaluativo::where('activo', true)->orderBy('orden')->get();
        $periodos = Evaluacion::periodos();
        $valoraciones = Evaluacion::valoraciones();

        $grupoId = $request->grupo_id;
        $periodo = $request->periodo ?? 'P1';
        $anio = $request->anio ?? date('Y');

        $estudiantes = collect();
        $evaluaciones = collect();
        $grupo = null;

        if ($grupoId) {
            // Verificar que el docente tiene acceso a este grupo
            if (!$grupos->contains('id', (int) $grupoId)) {
                abort(403, 'No tienes acceso a este grupo.');
            }

            $grupo = Grupo::find($grupoId);
            $estudiantes = Estudiante::where('grupo_id', $grupoId)
                ->where('estado', 'activo')
                ->orderBy('apellidos')
                ->get();

            $evaluaciones = Evaluacion::where('grupo_id', $grupoId)
                ->where('periodo', $periodo)
                ->where('anio', $anio)
                ->get()
                ->groupBy('estudiante_id');
        }

        return view('evaluaciones.index', compact(
            'grupos', 'conceptos', 'periodos', 'valoraciones',
            'grupo', 'estudiantes', 'evaluaciones',
            'grupoId', 'periodo', 'anio'
        ));
    }

    /**
     * Guardar evaluaciones masivas.
     */
    public function store(Request $request)
    {
        $request->validate([
            'grupo_id' => 'required|exists:grupos,id',
            'periodo' => 'required|in:P1,P2,P3,P4',
            'anio' => 'required|integer',
            'evaluaciones' => 'required|array',
        ]);

        foreach ($request->evaluaciones as $estudianteId => $conceptos) {
            foreach ($conceptos as $conceptoId => $valoracion) {
                if ($valoracion) {
                    Evaluacion::updateOrCreate(
                        [
                            'estudiante_id' => $estudianteId,
                            'concepto_evaluativo_id' => $conceptoId,
                            'periodo' => $request->periodo,
                            'anio' => $request->anio,
                        ],
                        [
                            'grupo_id' => $request->grupo_id,
                            'valoracion' => $valoracion,
                            'observacion' => $request->observaciones[$estudianteId][$conceptoId] ?? null,
                            'evaluado_por' => Auth::id(),
                        ]
                    );
                }
            }
        }

        return redirect()->route('evaluaciones.index', [
            'grupo_id' => $request->grupo_id,
            'periodo' => $request->periodo,
            'anio' => $request->anio,
        ])->with('success', 'Evaluaciones guardadas correctamente.');
    }

    /**
     * Ver evaluación individual de un estudiante.
     */
    public function estudiante(Estudiante $estudiante, Request $request)
    {
        $anio = $request->anio ?? date('Y');
        $conceptos = ConceptoEvaluativo::where('activo', true)->orderBy('orden')->get();
        $periodos = Evaluacion::periodos();
        $valoraciones = Evaluacion::valoraciones();

        $evaluaciones = Evaluacion::where('estudiante_id', $estudiante->id)
            ->where('anio', $anio)
            ->with('concepto')
            ->get()
            ->groupBy('periodo');

        return view('evaluaciones.estudiante', compact(
            'estudiante', 'conceptos', 'periodos', 'valoraciones',
            'evaluaciones', 'anio'
        ));
    }

    // ─── CRUD Conceptos Evaluativos ───

    public function conceptos()
    {
        $conceptos = ConceptoEvaluativo::orderBy('orden')->get();
        return view('evaluaciones.conceptos', compact('conceptos'));
    }

    public function conceptoStore(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:150',
        ]);

        ConceptoEvaluativo::create([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'orden' => $request->orden ?? 0,
            'activo' => true,
        ]);

        return back()->with('success', 'Concepto evaluativo creado.');
    }

    public function conceptoUpdate(Request $request, ConceptoEvaluativo $concepto)
    {
        $request->validate([
            'nombre' => 'required|string|max:150',
        ]);

        $concepto->update($request->only('nombre', 'descripcion', 'orden', 'activo'));
        return back()->with('success', 'Concepto actualizado.');
    }

    public function conceptoDestroy(ConceptoEvaluativo $concepto)
    {
        $concepto->delete();
        return back()->with('success', 'Concepto eliminado.');
    }
}
