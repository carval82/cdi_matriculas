<x-app-layout>
    <x-slot name="header">Usuarios del Sistema</x-slot>

    <div>
        <div class="flex justify-between items-center mb-5">
            <div></div>
            <a href="{{ route('users.create') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 rounded-lg font-semibold text-sm text-white hover:bg-blue-700 transition shadow-sm">
                <i class="fas fa-plus"></i> Nuevo Usuario
            </a>
        </div>

        @if(session('success'))
            <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">{{ session('error') }}</div>
        @endif

        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Usuario</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Rol</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Docente Vinculado</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Estado</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($users as $user)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3">
                                    <div class="flex items-center gap-3">
                                        <div class="h-9 w-9 rounded-full bg-gradient-to-br {{ $user->role === 'admin' ? 'from-red-500 to-rose-600' : ($user->role === 'docente' ? 'from-blue-500 to-indigo-600' : 'from-amber-500 to-orange-600') }} flex items-center justify-center text-white font-bold text-xs">
                                            {{ strtoupper(substr($user->name, 0, 2)) }}
                                        </div>
                                        <div>
                                            <div class="font-medium text-gray-900">{{ $user->name }}</div>
                                            <div class="text-xs text-gray-400">ID: {{ $user->id }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-4 py-3 text-sm">{{ $user->email }}</td>
                                <td class="px-4 py-3 text-sm">
                                    @php
                                        $rolColors = ['admin' => 'bg-red-100 text-red-800', 'docente' => 'bg-blue-100 text-blue-800', 'secretaria' => 'bg-amber-100 text-amber-800'];
                                        $rolIcons = ['admin' => 'fa-shield-alt', 'docente' => 'fa-chalkboard-teacher', 'secretaria' => 'fa-user-tie'];
                                    @endphp
                                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 text-xs font-semibold rounded-full {{ $rolColors[$user->role] ?? 'bg-gray-100 text-gray-800' }}">
                                        <i class="fas {{ $rolIcons[$user->role] ?? 'fa-user' }} text-[10px]"></i>
                                        {{ ucfirst($user->role) }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-sm">
                                    @if($user->docente)
                                        <a href="{{ route('docentes.show', $user->docente) }}" class="text-indigo-600 hover:underline text-xs">
                                            <i class="fas fa-link"></i> {{ $user->docente->nombre_completo }}
                                        </a>
                                    @else
                                        <span class="text-gray-400 text-xs">—</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-sm">
                                    <span class="px-2 py-0.5 text-xs rounded-full {{ $user->activo ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $user->activo ? 'Activo' : 'Inactivo' }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-sm">
                                    <div class="flex gap-2">
                                        <a href="{{ route('users.edit', $user) }}" class="text-amber-600 hover:text-amber-800" title="Editar"><i class="fas fa-edit"></i></a>
                                        @if($user->id !== auth()->id())
                                            <form action="{{ route('users.destroy', $user) }}" method="POST" onsubmit="return confirm('¿Eliminar este usuario?')" class="inline">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-800" title="Eliminar"><i class="fas fa-trash"></i></button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mt-6 bg-white overflow-hidden shadow-sm sm:rounded-lg p-5">
            <h3 class="font-semibold text-gray-800 mb-3"><i class="fas fa-info-circle text-blue-500 mr-1"></i> Roles del Sistema</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="p-4 bg-red-50 rounded-xl border border-red-100">
                    <div class="flex items-center gap-2 mb-2">
                        <span class="inline-flex items-center justify-center w-8 h-8 bg-red-500 rounded-lg text-white"><i class="fas fa-shield-alt text-sm"></i></span>
                        <span class="font-bold text-red-800">Administrador</span>
                    </div>
                    <p class="text-xs text-red-700">Acceso total al sistema: gestión de grupos, estudiantes, matrículas, pagos, docentes, usuarios y configuración.</p>
                </div>
                <div class="p-4 bg-blue-50 rounded-xl border border-blue-100">
                    <div class="flex items-center gap-2 mb-2">
                        <span class="inline-flex items-center justify-center w-8 h-8 bg-blue-500 rounded-lg text-white"><i class="fas fa-chalkboard-teacher text-sm"></i></span>
                        <span class="font-bold text-blue-800">Docente</span>
                    </div>
                    <p class="text-xs text-blue-700">Acceso a sus grupos asignados, toma de asistencia, consulta de estudiantes y seguimiento pedagógico.</p>
                </div>
                <div class="p-4 bg-amber-50 rounded-xl border border-amber-100">
                    <div class="flex items-center gap-2 mb-2">
                        <span class="inline-flex items-center justify-center w-8 h-8 bg-amber-500 rounded-lg text-white"><i class="fas fa-user-tie text-sm"></i></span>
                        <span class="font-bold text-amber-800">Secretaria</span>
                    </div>
                    <p class="text-xs text-amber-700">Gestión de matrículas, pagos, estudiantes y acudientes. Sin acceso a configuración del sistema ni usuarios.</p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
