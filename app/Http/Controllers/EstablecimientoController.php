<?php

namespace App\Http\Controllers;

use App\Models\Establecimiento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EstablecimientoController extends Controller
{
    public function edit()
    {
        $establecimiento = Establecimiento::first() ?? new Establecimiento();
        return view('establecimiento.edit', compact('establecimiento'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:200',
            'nit' => 'nullable|string|max:50',
            'direccion' => 'nullable|string|max:200',
            'telefono' => 'nullable|string|max:50',
            'celular' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:100',
            'ciudad' => 'nullable|string|max:100',
            'departamento' => 'nullable|string|max:100',
            'representante_legal' => 'nullable|string|max:200',
            'logo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'descripcion' => 'nullable|string',
            'lema' => 'nullable|string|max:255',
            'resolucion' => 'nullable|string|max:200',
        ]);

        $establecimiento = Establecimiento::first();
        $data = $request->except(['logo', '_token', '_method']);

        if ($request->hasFile('logo')) {
            if ($establecimiento && $establecimiento->logo) {
                Storage::disk('public')->delete($establecimiento->logo);
            }
            $data['logo'] = $request->file('logo')->store('establecimiento', 'public');
        }

        if ($establecimiento) {
            $establecimiento->update($data);
        } else {
            Establecimiento::create($data);
        }

        return redirect()->route('establecimiento.edit')
            ->with('success', 'Datos del establecimiento actualizados.');
    }
}
