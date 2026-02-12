<x-app-layout>
    <x-slot name="header">Acudientes</x-slot>

    <div>
            @if(session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">{{ session('error') }}</div>
            @endif

            <!-- Búsqueda -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-4 mb-4">
                <form method="GET" class="flex gap-3 items-end">
                    <div class="flex-1">
                        <x-input-label for="buscar" value="Buscar" />
                        <x-text-input id="buscar" name="buscar" type="text" class="mt-1 block w-full" :value="request('buscar')" placeholder="Nombre, documento..." />
                    </div>
                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 transition">Buscar</button>
                    <a href="{{ route('acudientes.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-300 transition">Limpiar</a>
                </form>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Documento</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nombre</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Parentesco</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Celular</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Estudiantes</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($acudientes as $acu)
                                <tr>
                                    <td class="px-4 py-3 text-sm">{{ $acu->tipo_documento }} {{ $acu->documento }}</td>
                                    <td class="px-4 py-3 text-sm font-medium">{{ $acu->nombre_completo }}</td>
                                    <td class="px-4 py-3 text-sm">{{ $acu->parentesco ?? '-' }}</td>
                                    <td class="px-4 py-3 text-sm">{{ $acu->celular ?? $acu->telefono ?? '-' }}</td>
                                    <td class="px-4 py-3 text-sm">
                                        <span class="px-2 py-0.5 text-xs rounded-full bg-indigo-100 text-indigo-800">{{ $acu->estudiantes_count }}</span>
                                    </td>
                                    <td class="px-4 py-3 text-sm flex gap-2">
                                        <a href="{{ route('acudientes.show', $acu) }}" class="text-indigo-600 hover:underline">Ver</a>
                                        <a href="{{ route('acudientes.edit', $acu) }}" class="text-amber-600 hover:underline">Editar</a>
                                        <form action="{{ route('acudientes.destroy', $acu) }}" method="POST" class="inline" onsubmit="return confirm('¿Eliminar este acudiente?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:underline">Eliminar</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-4 py-6 text-center text-gray-500">No se encontraron acudientes.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="p-4">{{ $acudientes->links() }}</div>
            </div>
    </div>
</x-app-layout>
