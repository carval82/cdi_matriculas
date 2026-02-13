<?php

namespace App\Http\Controllers;

use App\Models\Estudiante;
use App\Models\Acudiente;
use App\Models\Grupo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class EstudianteController extends Controller
{
    private function gruposPermitidos()
    {
        $user = Auth::user();
        if ($user->isAdmin() || $user->isSecretaria()) {
            return null; // sin restricción
        }
        $docente = $user->docente;
        if (!$docente) return collect();
        return $docente->gruposActuales()->pluck('grupos.id');
    }

    public function index(Request $request)
    {
        $query = Estudiante::with(['grupo', 'acudiente']);

        // Docente: solo estudiantes de sus grupos
        $grupoIds = $this->gruposPermitidos();
        if ($grupoIds !== null) {
            $query->whereIn('grupo_id', $grupoIds);
        }

        if ($request->filled('grupo_id')) {
            $query->where('grupo_id', $request->grupo_id);
        }

        if ($request->filled('estado')) {
            $query->where('estado', $request->estado);
        }

        if ($request->filled('buscar')) {
            $buscar = $request->buscar;
            $query->where(function ($q) use ($buscar) {
                $q->where('nombres', 'like', "%{$buscar}%")
                  ->orWhere('apellidos', 'like', "%{$buscar}%")
                  ->orWhere('documento', 'like', "%{$buscar}%")
                  ->orWhere('codigo', 'like', "%{$buscar}%");
            });
        }

        $estudiantes = $query->orderBy('apellidos')->paginate(20)->withQueryString();

        // Grupos para el filtro: docente solo ve sus grupos
        if ($grupoIds !== null) {
            $grupos = Grupo::whereIn('id', $grupoIds)->orderBy('orden')->get();
        } else {
            $grupos = Grupo::where('activa', true)->orderBy('orden')->get();
        }

        return view('estudiantes.index', compact('estudiantes', 'grupos'));
    }

    public function create()
    {
        $grupos = Grupo::where('activa', true)->orderBy('orden')->get();
        $acudientes = Acudiente::where('activo', true)->orderBy('nombres')->get();

        return view('estudiantes.create', compact('grupos', 'acudientes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombres' => 'required|string|max:100',
            'apellidos' => 'required|string|max:100',
            'fecha_nacimiento' => 'required|date',
            'acudiente_id' => 'required|exists:acudientes,id',
            'grupo_id' => 'nullable|exists:grupos,id',
            'foto' => 'nullable|image|max:2048',
        ]);

        $data = $request->except('foto');

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('estudiantes', 'public');
        }

        if (empty($data['fecha_ingreso'])) {
            $data['fecha_ingreso'] = now()->toDateString();
        }

        $estudiante = Estudiante::create($data);

        // Generar código automático
        if (!$estudiante->codigo) {
            $estudiante->update(['codigo' => sprintf('EST-%04d', $estudiante->id)]);
        }

        return redirect()->route('estudiantes.index')
            ->with('success', 'Estudiante registrado exitosamente.');
    }

    public function show(Estudiante $estudiante)
    {
        $estudiante->load(['grupo', 'acudiente', 'acudienteSecundario', 'matriculas.grupo', 'pagos']);

        return view('estudiantes.show', compact('estudiante'));
    }

    public function edit(Estudiante $estudiante)
    {
        $grupos = Grupo::where('activa', true)->orderBy('orden')->get();
        $acudientes = Acudiente::where('activo', true)->orderBy('nombres')->get();

        return view('estudiantes.edit', compact('estudiante', 'grupos', 'acudientes'));
    }

    public function update(Request $request, Estudiante $estudiante)
    {
        $request->validate([
            'nombres' => 'required|string|max:100',
            'apellidos' => 'required|string|max:100',
            'fecha_nacimiento' => 'required|date',
            'acudiente_id' => 'required|exists:acudientes,id',
            'foto' => 'nullable|image|max:2048',
        ]);

        $data = $request->except('foto');

        if ($request->hasFile('foto')) {
            if ($estudiante->foto) {
                Storage::disk('public')->delete($estudiante->foto);
            }
            $data['foto'] = $request->file('foto')->store('estudiantes', 'public');
        }

        $estudiante->update($data);

        return redirect()->route('estudiantes.show', $estudiante)
            ->with('success', 'Estudiante actualizado exitosamente.');
    }

    public function destroy(Estudiante $estudiante)
    {
        if ($estudiante->matriculas()->where('estado', 'activa')->exists()) {
            return back()->with('error', 'No se puede eliminar, tiene matrícula activa.');
        }

        if ($estudiante->foto) {
            Storage::disk('public')->delete($estudiante->foto);
        }

        $estudiante->delete();

        return redirect()->route('estudiantes.index')
            ->with('success', 'Estudiante eliminado.');
    }
}
