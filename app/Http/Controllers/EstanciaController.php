<?php

namespace App\Http\Controllers;

use App\Models\Estancia;
use Illuminate\Http\Request;

class EstanciaController extends Controller
{
    public function index()
    {
        $estancias = Estancia::withCount(['estudiantes' => fn($q) => $q->where('estado', 'activo')])
            ->orderBy('orden')
            ->get();

        return view('estancias.index', compact('estancias'));
    }

    public function create()
    {
        return view('estancias.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:100',
            'codigo' => 'nullable|string|max:20|unique:estancias,codigo',
            'capacidad' => 'required|integer|min:1',
            'valor_matricula' => 'required|numeric|min:0',
            'valor_pension' => 'required|numeric|min:0',
        ]);

        Estancia::create($request->all());

        return redirect()->route('estancias.index')
            ->with('success', 'Estancia creada exitosamente.');
    }

    public function show(Estancia $estancia)
    {
        $estancia->load(['estudiantes' => fn($q) => $q->where('estado', 'activo')->with('acudiente')]);

        return view('estancias.show', compact('estancia'));
    }

    public function edit(Estancia $estancia)
    {
        return view('estancias.edit', compact('estancia'));
    }

    public function update(Request $request, Estancia $estancia)
    {
        $request->validate([
            'nombre' => 'required|string|max:100',
            'codigo' => 'nullable|string|max:20|unique:estancias,codigo,' . $estancia->id,
            'capacidad' => 'required|integer|min:1',
            'valor_matricula' => 'required|numeric|min:0',
            'valor_pension' => 'required|numeric|min:0',
        ]);

        $estancia->update($request->all());

        return redirect()->route('estancias.index')
            ->with('success', 'Estancia actualizada exitosamente.');
    }

    public function destroy(Estancia $estancia)
    {
        if ($estancia->estudiantes()->where('estado', 'activo')->exists()) {
            return back()->with('error', 'No se puede eliminar, tiene estudiantes activos.');
        }

        $estancia->delete();

        return redirect()->route('estancias.index')
            ->with('success', 'Estancia eliminada.');
    }
}
