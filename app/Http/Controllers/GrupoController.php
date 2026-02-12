<?php

namespace App\Http\Controllers;

use App\Models\Grupo;
use Illuminate\Http\Request;

class GrupoController extends Controller
{
    public function index()
    {
        $grupos = Grupo::withCount(['estudiantes' => fn($q) => $q->where('estado', 'activo')])
            ->orderBy('orden')
            ->get();

        return view('grupos.index', compact('grupos'));
    }

    public function create()
    {
        return view('grupos.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:100',
            'codigo' => 'nullable|string|max:20|unique:grupos,codigo',
            'capacidad' => 'required|integer|min:1',
        ]);

        Grupo::create($request->all());

        return redirect()->route('grupos.index')
            ->with('success', 'Grupo creado exitosamente.');
    }

    public function show(Grupo $grupo)
    {
        $grupo->load(['estudiantes' => fn($q) => $q->where('estado', 'activo')->with('acudiente')]);

        return view('grupos.show', compact('grupo'));
    }

    public function edit(Grupo $grupo)
    {
        return view('grupos.edit', compact('grupo'));
    }

    public function update(Request $request, Grupo $grupo)
    {
        $request->validate([
            'nombre' => 'required|string|max:100',
            'codigo' => 'nullable|string|max:20|unique:grupos,codigo,' . $grupo->id,
            'capacidad' => 'required|integer|min:1',
        ]);

        $grupo->update($request->all());

        return redirect()->route('grupos.index')
            ->with('success', 'Grupo actualizado exitosamente.');
    }

    public function destroy(Grupo $grupo)
    {
        if ($grupo->estudiantes()->where('estado', 'activo')->exists()) {
            return back()->with('error', 'No se puede eliminar, tiene estudiantes activos.');
        }

        $grupo->delete();

        return redirect()->route('grupos.index')
            ->with('success', 'Grupo eliminado.');
    }
}
