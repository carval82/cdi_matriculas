<x-app-layout>
    <x-slot name="header">Nuevo Usuario</x-slot>

    <div class="max-w-2xl mx-auto">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
            <form action="{{ route('users.store') }}" method="POST">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="md:col-span-2">
                        <x-input-label for="name" value="Nombre Completo *" />
                        <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name')" required />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="email" value="Email *" />
                        <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email')" required />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="role" value="Rol *" />
                        <select id="role" name="role" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                            <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Administrador</option>
                            <option value="docente" {{ old('role') == 'docente' ? 'selected' : '' }}>Docente</option>
                            <option value="secretaria" {{ old('role') == 'secretaria' ? 'selected' : '' }}>Secretaria</option>
                        </select>
                        <x-input-error :messages="$errors->get('role')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="password" value="Contraseña *" />
                        <x-text-input id="password" name="password" type="password" class="mt-1 block w-full" required />
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="password_confirmation" value="Confirmar Contraseña *" />
                        <x-text-input id="password_confirmation" name="password_confirmation" type="password" class="mt-1 block w-full" required />
                    </div>

                    <div>
                        <x-input-label for="docente_id" value="Vincular a Docente (opcional)" />
                        <select id="docente_id" name="docente_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="">— Ninguno —</option>
                            @foreach($docentes as $doc)
                                <option value="{{ $doc->id }}" {{ old('docente_id') == $doc->id ? 'selected' : '' }}>
                                    {{ $doc->nombre_completo }} — {{ $doc->documento }}
                                </option>
                            @endforeach
                        </select>
                        <p class="text-xs text-gray-400 mt-1">Solo muestra docentes sin usuario asignado</p>
                    </div>

                    <div>
                        <x-input-label for="activo" value="Estado" />
                        <select id="activo" name="activo" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="1" selected>Activo</option>
                            <option value="0">Inactivo</option>
                        </select>
                    </div>
                </div>

                <div class="flex items-center gap-4 mt-6">
                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 transition">
                        <i class="fas fa-save mr-2"></i> Crear Usuario
                    </button>
                    <a href="{{ route('users.index') }}" class="text-sm text-gray-600 hover:underline">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
