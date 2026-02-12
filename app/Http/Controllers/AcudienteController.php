<?php

namespace App\Http\Controllers;

use App\Models\Acudiente;
use Illuminate\Http\Request;

class AcudienteController extends Controller
{
    public function index(Request $request)
    {
        $query = Acudiente::withCount('estudiantes');

        if ($request->filled('buscar')) {
            $buscar = $request->buscar;
            $query->where(function ($q) use ($buscar) {
                $q->where('nombres', 'like', "%{$buscar}%")
                  ->orWhere('apellidos', 'like', "%{$buscar}%")
                  ->orWhere('documento', 'like', "%{$buscar}%");
            });
        }

        $acudientes = $query->orderBy('nombres')->paginate(20)->withQueryString();

        return view('acudientes.index', compact('acudientes'));
    }

    public function create()
    {
        return view('acudientes.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'documento' => 'required|string|max:30|unique:acudientes,documento',
            'nombres' => 'required|string|max:100',
            'apellidos' => 'required|string|max:100',
            'celular' => 'nullable|string|max:30',
        ]);

        Acudiente::create($request->all());

        return redirect()->route('acudientes.index')
            ->with('success', 'Acudiente registrado exitosamente.');
    }

    public function show(Acudiente $acudiente)
    {
        $acudiente->load(['estudiantes.estancia']);

        return view('acudientes.show', compact('acudiente'));
    }

    public function edit(Acudiente $acudiente)
    {
        return view('acudientes.edit', compact('acudiente'));
    }

    public function update(Request $request, Acudiente $acudiente)
    {
        $request->validate([
            'documento' => 'required|string|max:30|unique:acudientes,documento,' . $acudiente->id,
            'nombres' => 'required|string|max:100',
            'apellidos' => 'required|string|max:100',
        ]);

        $acudiente->update($request->all());

        return redirect()->route('acudientes.index')
            ->with('success', 'Acudiente actualizado exitosamente.');
    }

    public function destroy(Acudiente $acudiente)
    {
        if ($acudiente->estudiantes()->exists()) {
            return back()->with('error', 'No se puede eliminar, tiene estudiantes asociados.');
        }

        $acudiente->delete();

        return redirect()->route('acudientes.index')
            ->with('success', 'Acudiente eliminado.');
    }

    public function buscar(Request $request)
    {
        $termino = $request->get('q', '');
        $acudientes = Acudiente::where('activo', true)
            ->where(function ($q) use ($termino) {
                $q->where('nombres', 'like', "%{$termino}%")
                  ->orWhere('apellidos', 'like', "%{$termino}%")
                  ->orWhere('documento', 'like', "%{$termino}%");
            })
            ->limit(10)
            ->get();

        return response()->json($acudientes);
    }
}
