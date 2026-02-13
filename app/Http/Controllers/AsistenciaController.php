<?php

namespace App\Http\Controllers;

use App\Models\Asistencia;
use App\Models\Grupo;
use App\Models\Estudiante;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AsistenciaController extends Controller
{
    private function gruposPermitidos()
    {
        $user = Auth::user();
        if ($user->isAdmin() || $user->isSecretaria()) {
            return Grupo::where('activa', true)->orderBy('orden')->get();
        }
        $docente = $user->docente;
        if (!$docente) return collect();
        return $docente->gruposActuales()->orderBy('orden')->get();
    }

    public function index(Request $request)
    {
        $grupos = $this->gruposPermitidos();
        $grupoId = $request->grupo_id;
        $fecha = $request->fecha ?? now()->format('Y-m-d');

        $asistencias = collect();
        $estudiantes = collect();
        $grupo = null;

        if ($grupoId) {
            if (!$grupos->contains('id', (int) $grupoId)) {
                abort(403, 'No tienes acceso a este grupo.');
            }
            $grupo = Grupo::find($grupoId);
            $estudiantes = Estudiante::where('grupo_id', $grupoId)
                ->where('estado', 'activo')
                ->orderBy('apellidos')
                ->get();

            $asistencias = Asistencia::where('grupo_id', $grupoId)
                ->where('fecha', $fecha)
                ->pluck('estado', 'estudiante_id');
        }

        return view('asistencias.index', compact('grupos', 'grupo', 'estudiantes', 'asistencias', 'fecha', 'grupoId'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'grupo_id' => 'required|exists:grupos,id',
            'fecha' => 'required|date',
            'asistencia' => 'required|array',
        ]);

        // Verificar acceso al grupo
        $grupos = $this->gruposPermitidos();
        if (!$grupos->contains('id', (int) $request->grupo_id)) {
            abort(403, 'No tienes acceso a este grupo.');
        }

        foreach ($request->asistencia as $estudianteId => $estado) {
            Asistencia::updateOrCreate(
                [
                    'estudiante_id' => $estudianteId,
                    'fecha' => $request->fecha,
                ],
                [
                    'grupo_id' => $request->grupo_id,
                    'estado' => $estado,
                    'observacion' => $request->observaciones[$estudianteId] ?? null,
                    'registrado_por' => Auth::id(),
                ]
            );
        }

        return redirect()->route('asistencias.index', [
            'grupo_id' => $request->grupo_id,
            'fecha' => $request->fecha,
        ])->with('success', 'Asistencia registrada correctamente.');
    }

    public function reporte(Request $request)
    {
        $grupos = $this->gruposPermitidos();
        $grupoId = $request->grupo_id;
        $mes = $request->mes ?? now()->month;
        $anio = $request->anio ?? now()->year;

        $datos = [];
        $grupo = null;
        $diasClase = [];

        if ($grupoId) {
            $grupo = Grupo::find($grupoId);
            $estudiantes = Estudiante::where('grupo_id', $grupoId)
                ->where('estado', 'activo')
                ->orderBy('apellidos')
                ->get();

            $asistencias = Asistencia::where('grupo_id', $grupoId)
                ->whereMonth('fecha', $mes)
                ->whereYear('fecha', $anio)
                ->get();

            $diasClase = $asistencias->pluck('fecha')->unique()->sort()->values();

            foreach ($estudiantes as $est) {
                $estAsist = $asistencias->where('estudiante_id', $est->id);
                $datos[] = [
                    'estudiante' => $est,
                    'presentes' => $estAsist->where('estado', 'presente')->count(),
                    'ausentes' => $estAsist->where('estado', 'ausente')->count(),
                    'tardanzas' => $estAsist->where('estado', 'tardanza')->count(),
                    'excusas' => $estAsist->where('estado', 'excusa')->count(),
                    'total_dias' => $diasClase->count(),
                ];
            }
        }

        $meses = ['Enero','Febrero','Marzo','Abril','Mayo','Junio',
                   'Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'];

        return view('asistencias.reporte', compact('grupos', 'grupo', 'datos', 'diasClase', 'mes', 'anio', 'grupoId', 'meses'));
    }
}
