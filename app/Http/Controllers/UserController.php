<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Docente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('docente')->orderBy('name')->get();
        return view('users.index', compact('users'));
    }

    public function create()
    {
        $docentes = Docente::whereNull('user_id')->where('activo', true)->orderBy('apellidos')->get();
        return view('users.create', compact('docentes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => 'required|in:admin,docente,secretaria',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'activo' => $request->boolean('activo', true),
        ]);

        // Vincular docente si se seleccionó
        if ($request->filled('docente_id')) {
            Docente::where('id', $request->docente_id)->update(['user_id' => $user->id]);
        }

        return redirect()->route('users.index')
            ->with('success', 'Usuario creado exitosamente.');
    }

    public function edit(User $user)
    {
        $docentes = Docente::where(function ($q) use ($user) {
            $q->whereNull('user_id')->orWhere('user_id', $user->id);
        })->where('activo', true)->orderBy('apellidos')->get();

        $docenteVinculado = Docente::where('user_id', $user->id)->first();

        return view('users.edit', compact('user', 'docentes', 'docenteVinculado'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'role' => 'required|in:admin,docente,secretaria',
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'activo' => $request->boolean('activo', true),
        ];

        if ($request->filled('password')) {
            $request->validate([
                'password' => ['confirmed', Rules\Password::defaults()],
            ]);
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        // Desvincular docente anterior
        Docente::where('user_id', $user->id)->update(['user_id' => null]);

        // Vincular nuevo docente
        if ($request->filled('docente_id')) {
            Docente::where('id', $request->docente_id)->update(['user_id' => $user->id]);
        }

        return redirect()->route('users.index')
            ->with('success', 'Usuario actualizado.');
    }

    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'No puedes eliminar tu propio usuario.');
        }

        Docente::where('user_id', $user->id)->update(['user_id' => null]);
        $user->delete();

        return redirect()->route('users.index')
            ->with('success', 'Usuario eliminado.');
    }
}
