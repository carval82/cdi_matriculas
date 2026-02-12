<?php

namespace App\Http\Controllers;

use App\Models\Matricula;
use App\Models\Estudiante;
use App\Models\Grupo;
use App\Models\Acudiente;
use App\Models\Pago;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MatriculaController extends Controller
{
    public function index(Request $request)
    {
        $query = Matricula::with(['estudiante', 'grupo', 'acudiente']);

        if ($request->filled('anio')) {
            $query->where('anio', $request->anio);
        } else {
            $query->where('anio', now()->year);
        }

        if ($request->filled('grupo_id')) {
            $query->where('grupo_id', $request->grupo_id);
        }

        if ($request->filled('estado')) {
            $query->where('estado', $request->estado);
        }

        if ($request->filled('buscar')) {
            $buscar = $request->buscar;
            $query->whereHas('estudiante', function ($q) use ($buscar) {
                $q->where('nombres', 'like', "%{$buscar}%")
                  ->orWhere('apellidos', 'like', "%{$buscar}%")
                  ->orWhere('documento', 'like', "%{$buscar}%");
            });
        }

        $matriculas = $query->latest('fecha_matricula')->paginate(20)->withQueryString();
        $grupos = Grupo::where('activa', true)->orderBy('orden')->get();
        $anios = Matricula::select('anio')->distinct()->orderByDesc('anio')->pluck('anio');

        if ($anios->isEmpty()) {
            $anios = collect([now()->year]);
        }

        return view('matriculas.index', compact('matriculas', 'grupos', 'anios'));
    }

    public function create(Request $request)
    {
        $grupos = Grupo::where('activa', true)->orderBy('orden')->get();
        $estudiantes = Estudiante::where('estado', 'activo')->orderBy('apellidos')->get();
        $acudientes = Acudiente::where('activo', true)->orderBy('nombres')->get();

        $estudiantePreseleccionado = null;
        if ($request->filled('estudiante_id')) {
            $estudiantePreseleccionado = Estudiante::with('acudiente')->find($request->estudiante_id);
        }

        return view('matriculas.create', compact('grupos', 'estudiantes', 'acudientes', 'estudiantePreseleccionado'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'estudiante_id' => 'required|exists:estudiantes,id',
            'grupo_id' => 'required|exists:grupos,id',
            'acudiente_id' => 'required|exists:acudientes,id',
            'anio' => 'required|integer|min:2020',
            'fecha_matricula' => 'required|date',
            'valor_matricula' => 'required|numeric|min:0',
            'valor_pension' => 'required|numeric|min:0',
        ]);

        // Verificar que no tenga matrícula activa en el mismo año
        $existe = Matricula::where('estudiante_id', $request->estudiante_id)
            ->where('anio', $request->anio)
            ->where('estado', 'activa')
            ->exists();

        if ($existe) {
            return back()->withInput()
                ->with('error', 'El estudiante ya tiene una matrícula activa para este año.');
        }

        DB::beginTransaction();
        try {
            $matricula = Matricula::create(array_merge($request->all(), [
                'codigo' => Matricula::generarCodigo($request->anio),
                'created_by' => Auth::id(),
            ]));

            // Actualizar estancia del estudiante
            $matricula->estudiante->update([
                'grupo_id' => $request->grupo_id,
                'estado' => 'activo',
            ]);

            DB::commit();

            return redirect()->route('matriculas.show', $matricula)
                ->with('success', 'Matrícula registrada exitosamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Error al registrar matrícula: ' . $e->getMessage());
        }
    }

    public function show(Matricula $matricula)
    {
        $matricula->load(['estudiante.acudiente', 'grupo', 'acudiente', 'pagos']);

        $meses = ['Enero','Febrero','Marzo','Abril','Mayo','Junio',
                   'Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'];

        $pensionesEstado = [];
        foreach ($meses as $mes) {
            $pago = $matricula->pagos->where('concepto', 'pension')->where('mes', strtolower($mes))->first();
            $pensionesEstado[$mes] = $pago ? $pago->estado : 'pendiente';
        }

        return view('matriculas.show', compact('matricula', 'pensionesEstado'));
    }

    public function edit(Matricula $matricula)
    {
        $grupos = Grupo::where('activa', true)->orderBy('orden')->get();
        $acudientes = Acudiente::where('activo', true)->orderBy('nombres')->get();

        return view('matriculas.edit', compact('matricula', 'grupos', 'acudientes'));
    }

    public function update(Request $request, Matricula $matricula)
    {
        $request->validate([
            'grupo_id' => 'required|exists:grupos,id',
            'valor_matricula' => 'required|numeric|min:0',
            'valor_pension' => 'required|numeric|min:0',
        ]);

        $matricula->update($request->all());

        if ($matricula->estado === 'activa') {
            $matricula->estudiante->update(['grupo_id' => $request->grupo_id]);
        }

        return redirect()->route('matriculas.show', $matricula)
            ->with('success', 'Matrícula actualizada.');
    }

    public function destroy(Matricula $matricula)
    {
        if ($matricula->pagos()->where('estado', 'pagado')->exists()) {
            return back()->with('error', 'No se puede eliminar, tiene pagos registrados.');
        }

        $matricula->delete();

        return redirect()->route('matriculas.index')
            ->with('success', 'Matrícula eliminada.');
    }
}
