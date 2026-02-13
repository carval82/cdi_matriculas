<?php

namespace App\Http\Controllers;

use App\Models\Docente;
use App\Models\Grupo;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class DocenteController extends Controller
{
    public function index()
    {
        $docentes = Docente::with('gruposActuales')->orderBy('apellidos')->get();
        return view('docentes.index', compact('docentes'));
    }

    public function create()
    {
        $grupos = Grupo::where('activa', true)->orderBy('orden')->get();
        return view('docentes.create', compact('grupos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombres' => 'required|string|max:100',
            'apellidos' => 'required|string|max:100',
            'documento' => 'required|string|max:30|unique:docentes,documento',
            'celular' => 'nullable|string|max:30',
            'email' => 'nullable|email|max:100',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'crear_usuario' => 'nullable|boolean',
        ]);

        $data = $request->except(['foto', 'crear_usuario', 'grupos', 'password']);

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('docentes', 'public');
        }

        // Crear usuario de acceso si se solicita
        if ($request->crear_usuario && $request->email) {
            $user = User::create([
                'name' => $request->nombres . ' ' . $request->apellidos,
                'email' => $request->email,
                'password' => Hash::make($request->password ?? $request->documento),
                'role' => 'docente',
                'activo' => true,
            ]);
            $data['user_id'] = $user->id;
        }

        $docente = Docente::create($data);

        // Asignar grupos
        if ($request->filled('grupos')) {
            foreach ($request->grupos as $grupoId) {
                $docente->grupos()->attach($grupoId, [
                    'rol' => 'titular',
                    'anio' => date('Y'),
                ]);
            }
        }

        return redirect()->route('docentes.index')
            ->with('success', 'Docente creado exitosamente.');
    }

    public function show(Docente $docente)
    {
        $docente->load(['gruposActuales.estudiantesActivos', 'user']);
        return view('docentes.show', compact('docente'));
    }

    public function edit(Docente $docente)
    {
        $grupos = Grupo::where('activa', true)->orderBy('orden')->get();
        $gruposAsignados = $docente->gruposActuales()->pluck('grupos.id')->toArray();
        return view('docentes.edit', compact('docente', 'grupos', 'gruposAsignados'));
    }

    public function update(Request $request, Docente $docente)
    {
        $request->validate([
            'nombres' => 'required|string|max:100',
            'apellidos' => 'required|string|max:100',
            'documento' => 'required|string|max:30|unique:docentes,documento,' . $docente->id,
            'foto' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $data = $request->except(['foto', 'crear_usuario', 'grupos', 'password', '_token', '_method']);

        if ($request->hasFile('foto')) {
            if ($docente->foto) {
                Storage::disk('public')->delete($docente->foto);
            }
            $data['foto'] = $request->file('foto')->store('docentes', 'public');
        }

        $docente->update($data);

        // Sincronizar grupos del año actual
        $docente->grupos()->wherePivot('anio', date('Y'))->detach();
        if ($request->filled('grupos')) {
            foreach ($request->grupos as $grupoId) {
                $docente->grupos()->attach($grupoId, [
                    'rol' => 'titular',
                    'anio' => date('Y'),
                ]);
            }
        }

        // Crear usuario si se solicita y no tiene
        if ($request->crear_usuario && $request->email && !$docente->user_id) {
            $user = User::create([
                'name' => $docente->nombre_completo,
                'email' => $request->email,
                'password' => Hash::make($request->password ?? $docente->documento),
                'role' => 'docente',
                'activo' => true,
            ]);
            $docente->update(['user_id' => $user->id]);
        }

        return redirect()->route('docentes.show', $docente)
            ->with('success', 'Docente actualizado.');
    }

    public function destroy(Docente $docente)
    {
        if ($docente->foto) {
            Storage::disk('public')->delete($docente->foto);
        }
        $docente->delete();

        return redirect()->route('docentes.index')
            ->with('success', 'Docente eliminado.');
    }
}
