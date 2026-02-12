<x-app-layout>
    <x-slot name="header">Estancia: {{ $estancia->nombre }}</x-slot>

    <div class="space-y-6">
        <div class="flex justify-end">
            <a href="{{ route('estancias.edit', $estancia) }}" class="inline-flex items-center gap-2 px-4 py-2 bg-amber-500 rounded-lg font-semibold text-sm text-white hover:bg-amber-600 transition shadow-sm">
                <i class="fas fa-edit"></i> Editar
            </a>
        </div>
            <!-- Info -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
                    <div>
                        <span class="text-gray-500">Código:</span>
                        <span class="font-medium ml-1">{{ $estancia->codigo ?? '-' }}</span>
                    </div>
                    <div>
                        <span class="text-gray-500">Jornada:</span>
                        <span class="font-medium ml-1">{{ ucfirst($estancia->jornada) }}</span>
                    </div>
                    <div>
                        <span class="text-gray-500">Edad:</span>
                        <span class="font-medium ml-1">{{ $estancia->edad_minima ?? '?' }} - {{ $estancia->edad_maxima ?? '?' }} meses</span>
                    </div>
                    <div>
                        <span class="text-gray-500">Capacidad:</span>
                        <span class="font-medium ml-1">{{ $estancia->capacidad }} cupos</span>
                    </div>
                    <div>
                        <span class="text-gray-500">Matrícula:</span>
                        <span class="font-medium ml-1">${{ number_format($estancia->valor_matricula, 0, ',', '.') }}</span>
                    </div>
                    <div>
                        <span class="text-gray-500">Pensión:</span>
                        <span class="font-medium ml-1">${{ number_format($estancia->valor_pension, 0, ',', '.') }}</span>
                    </div>
                </div>
                @if($estancia->descripcion)
                    <p class="mt-4 text-sm text-gray-600">{{ $estancia->descripcion }}</p>
                @endif
            </div>

            <!-- Estudiantes -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold text-gray-800">Estudiantes Activos ({{ $estancia->estudiantes->count() }})</h3>
                    <a href="{{ route('estudiantes.create') }}" class="text-sm text-indigo-600 hover:underline">+ Nuevo Estudiante</a>
                </div>

                @if($estancia->estudiantes->count())
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Código</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nombre</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Edad</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Acudiente</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Acciones</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($estancia->estudiantes as $est)
                                    <tr>
                                        <td class="px-4 py-3 text-sm">{{ $est->codigo }}</td>
                                        <td class="px-4 py-3 text-sm font-medium">{{ $est->nombre_completo }}</td>
                                        <td class="px-4 py-3 text-sm">{{ $est->edad }}</td>
                                        <td class="px-4 py-3 text-sm">{{ $est->acudiente?->nombre_completo }}</td>
                                        <td class="px-4 py-3 text-sm">
                                            <a href="{{ route('estudiantes.show', $est) }}" class="text-indigo-600 hover:underline">Ver</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-gray-500 text-sm">No hay estudiantes en esta estancia.</p>
                @endif
            </div>
    </div>
</x-app-layout>
