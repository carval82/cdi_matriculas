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
     * Lista de estudiantes por grupo para evaluar individualmente.
     */
    public function index(Request $request)
    {
        $grupos = $this->gruposPermitidos();
        $grupoId = $request->grupo_id;
        $anio = $request->anio ?? date('Y');

        $estudiantes = collect();
        $grupo = null;
        $conceptosCount = ConceptoEvaluativo::where('activo', true)->count();

        if ($grupoId) {
            if (!$grupos->contains('id', (int) $grupoId)) {
                abort(403, 'No tienes acceso a este grupo.');
            }

            $grupo = Grupo::find($grupoId);
            $estudiantes = Estudiante::where('grupo_id', $grupoId)
                ->where('estado', 'activo')
                ->orderBy('apellidos')
                ->get();

            // Contar evaluaciones por estudiante para mostrar progreso
            $totalConceptos = $conceptosCount * 4; // 4 periodos
            foreach ($estudiantes as $est) {
                $est->evaluaciones_count = Evaluacion::where('estudiante_id', $est->id)
                    ->where('anio', $anio)
                    ->count();
                $est->progreso = $totalConceptos > 0 ? round(($est->evaluaciones_count / $totalConceptos) * 100) : 0;
            }
        }

        return view('evaluaciones.index', compact(
            'grupos', 'grupo', 'estudiantes', 'grupoId', 'anio', 'conceptosCount'
        ));
    }

    /**
     * Ver y editar evaluación individual de un estudiante.
     */
    public function estudiante(Estudiante $estudiante, Request $request)
    {
        $periodo = $request->periodo ?? 'P1';
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
            'evaluaciones', 'anio', 'periodo'
        ));
    }

    /**
     * Guardar evaluación individual de un estudiante.
     */
    public function store(Request $request)
    {
        $request->validate([
            'estudiante_id' => 'required|exists:estudiantes,id',
            'periodo' => 'required|in:P1,P2,P3,P4',
            'anio' => 'required|integer',
        ]);

        $estudiante = Estudiante::findOrFail($request->estudiante_id);

        if ($request->has('evaluaciones')) {
            foreach ($request->evaluaciones as $conceptoId => $valoracion) {
                if ($valoracion) {
                    Evaluacion::updateOrCreate(
                        [
                            'estudiante_id' => $estudiante->id,
                            'concepto_evaluativo_id' => $conceptoId,
                            'periodo' => $request->periodo,
                            'anio' => $request->anio,
                        ],
                        [
                            'grupo_id' => $estudiante->grupo_id,
                            'valoracion' => $valoracion,
                            'observacion' => $request->observaciones[$conceptoId] ?? null,
                            'evaluado_por' => Auth::id(),
                        ]
                    );
                }
            }
        }

        return redirect()->route('evaluaciones.estudiante', [
            'estudiante' => $estudiante->id,
            'periodo' => $request->periodo,
            'anio' => $request->anio,
        ])->with('success', 'Evaluación guardada correctamente para ' . $estudiante->nombre_completo);
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
