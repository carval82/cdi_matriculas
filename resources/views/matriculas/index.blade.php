<x-app-layout>
    <x-slot name="header">Matrículas</x-slot>

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
                        <x-input-label for="buscar" value="Buscar estudiante" />
                        <x-text-input id="buscar" name="buscar" type="text" class="mt-1 block w-full" :value="request('buscar')" placeholder="Nombre o documento..." />
                    </div>
                    <div>
                        <x-input-label for="anio" value="Año" />
                        <select name="anio" id="anio" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            @foreach($anios as $a)
                                <option value="{{ $a }}" {{ request('anio', now()->year) == $a ? 'selected' : '' }}>{{ $a }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <x-input-label for="estancia_id" value="Estancia" />
                        <select name="estancia_id" id="estancia_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="">Todas</option>
                            @foreach($estancias as $est)
                                <option value="{{ $est->id }}" {{ request('estancia_id') == $est->id ? 'selected' : '' }}>{{ $est->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <x-input-label for="estado" value="Estado" />
                        <select name="estado" id="estado" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="">Todos</option>
                            <option value="activa" {{ request('estado') == 'activa' ? 'selected' : '' }}>Activa</option>
                            <option value="cancelada" {{ request('estado') == 'cancelada' ? 'selected' : '' }}>Cancelada</option>
                            <option value="finalizada" {{ request('estado') == 'finalizada' ? 'selected' : '' }}>Finalizada</option>
                        </select>
                    </div>
                    <div class="flex gap-2">
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 transition">Filtrar</button>
                        <a href="{{ route('matriculas.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-300 transition">Limpiar</a>
                    </div>
                </form>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Código</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Estudiante</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Estancia</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Año</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Matrícula</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Pensión</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Estado</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($matriculas as $mat)
                                <tr>
                                    <td class="px-4 py-3 text-sm font-mono">{{ $mat->codigo }}</td>
                                    <td class="px-4 py-3 text-sm font-medium">{{ $mat->estudiante->nombre_completo }}</td>
                                    <td class="px-4 py-3 text-sm">{{ $mat->estancia->nombre }}</td>
                                    <td class="px-4 py-3 text-sm">{{ $mat->anio }}</td>
                                    <td class="px-4 py-3 text-sm">${{ number_format($mat->valor_matricula, 0, ',', '.') }}</td>
                                    <td class="px-4 py-3 text-sm">${{ number_format($mat->valor_pension, 0, ',', '.') }}</td>
                                    <td class="px-4 py-3 text-sm">
                                        <span class="px-2 py-0.5 text-xs rounded-full {{ $mat->estado === 'activa' ? 'bg-green-100 text-green-800' : ($mat->estado === 'cancelada' ? 'bg-red-100 text-red-800' : 'bg-gray-100 text-gray-800') }}">
                                            {{ ucfirst($mat->estado) }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 text-sm flex gap-2">
                                        <a href="{{ route('matriculas.show', $mat) }}" class="text-indigo-600 hover:underline">Ver</a>
                                        <a href="{{ route('matriculas.edit', $mat) }}" class="text-amber-600 hover:underline">Editar</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="px-4 py-6 text-center text-gray-500">No se encontraron matrículas.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="p-4">{{ $matriculas->links() }}</div>
            </div>
    </div>
</x-app-layout>
