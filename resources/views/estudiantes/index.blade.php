<x-app-layout>
    <x-slot name="header">Estudiantes</x-slot>

    <div>
            @if(session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">{{ session('error') }}</div>
            @endif

            <!-- Filtros -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-4 mb-4">
                <form method="GET" class="flex flex-wrap gap-3 items-end">
                    <div class="flex-1 min-w-[200px]">
                        <x-input-label for="buscar" value="Buscar" />
                        <x-text-input id="buscar" name="buscar" type="text" class="mt-1 block w-full" :value="request('buscar')" placeholder="Nombre, documento, código..." />
                    </div>
                    <div>
                        <x-input-label for="grupo_id" value="Grupo" />
                        <select name="grupo_id" id="grupo_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="">Todas</option>
                            @foreach($grupos as $est)
                                <option value="{{ $est->id }}" {{ request('grupo_id') == $est->id ? 'selected' : '' }}>{{ $est->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <x-input-label for="estado" value="Estado" />
                        <select name="estado" id="estado" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="">Todos</option>
                            <option value="activo" {{ request('estado') == 'activo' ? 'selected' : '' }}>Activo</option>
                            <option value="retirado" {{ request('estado') == 'retirado' ? 'selected' : '' }}>Retirado</option>
                            <option value="graduado" {{ request('estado') == 'graduado' ? 'selected' : '' }}>Graduado</option>
                        </select>
                    </div>
                    <div class="flex gap-2">
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 transition">Filtrar</button>
                        <a href="{{ route('estudiantes.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-300 transition">Limpiar</a>
                    </div>
                </form>
            </div>

            <!-- Tabla -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Código</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nombre</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Edad</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Grupo</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Acudiente</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Estado</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($estudiantes as $est)
                                <tr>
                                    <td class="px-4 py-3 text-sm">{{ $est->codigo }}</td>
                                    <td class="px-4 py-3 text-sm font-medium">{{ $est->nombre_completo }}</td>
                                    <td class="px-4 py-3 text-sm">{{ $est->edad }}</td>
                                    <td class="px-4 py-3 text-sm">{{ $est->grupo?->nombre ?? '-' }}</td>
                                    <td class="px-4 py-3 text-sm">{{ $est->acudiente?->nombre_completo }}</td>
                                    <td class="px-4 py-3 text-sm">
                                        <span class="px-2 py-0.5 text-xs rounded-full {{ $est->estado === 'activo' ? 'bg-green-100 text-green-800' : ($est->estado === 'retirado' ? 'bg-red-100 text-red-800' : 'bg-gray-100 text-gray-800') }}">
                                            {{ ucfirst($est->estado) }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 text-sm flex gap-2">
                                        <a href="{{ route('estudiantes.show', $est) }}" class="text-indigo-600 hover:underline">Ver</a>
                                        <a href="{{ route('estudiantes.edit', $est) }}" class="text-amber-600 hover:underline">Editar</a>
                                        <a href="{{ route('matriculas.create', ['estudiante_id' => $est->id]) }}" class="text-green-600 hover:underline">Matricular</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-4 py-6 text-center text-gray-500">No se encontraron estudiantes.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="p-4">{{ $estudiantes->links() }}</div>
            </div>
    </div>
</x-app-layout>
