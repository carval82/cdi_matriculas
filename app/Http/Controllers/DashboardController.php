<?php

namespace App\Http\Controllers;

use App\Models\Estancia;
use App\Models\Estudiante;
use App\Models\Matricula;
use App\Models\Pago;

class DashboardController extends Controller
{
    public function index()
    {
        $anioActual = now()->year;

        $stats = [
            'total_estudiantes' => Estudiante::where('estado', 'activo')->count(),
            'total_matriculas' => Matricula::where('anio', $anioActual)->where('estado', 'activa')->count(),
            'total_estancias' => Estancia::where('activa', true)->count(),
            'ingresos_mes' => Pago::where('estado', 'pagado')
                ->whereMonth('fecha_pago', now()->month)
                ->whereYear('fecha_pago', $anioActual)
                ->sum('total'),
        ];

        $estancias = Estancia::where('activa', true)
            ->withCount(['estudiantes' => fn($q) => $q->where('estado', 'activo')])
            ->orderBy('orden')
            ->get();

        $ultimasMatriculas = Matricula::with(['estudiante', 'estancia'])
            ->where('anio', $anioActual)
            ->latest()
            ->limit(5)
            ->get();

        $ultimosPagos = Pago::with(['estudiante', 'matricula.estancia'])
            ->where('estado', 'pagado')
            ->latest('fecha_pago')
            ->limit(5)
            ->get();

        return view('dashboard', compact('stats', 'estancias', 'ultimasMatriculas', 'ultimosPagos', 'anioActual'));
    }
}
