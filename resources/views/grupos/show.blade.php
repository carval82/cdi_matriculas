<x-app-layout>
    <x-slot name="header">Grupo: {{ $grupo->nombre }}</x-slot>

    <div class="space-y-6">
        <div class="flex justify-end">
            <a href="{{ route('grupos.edit', $grupo) }}" class="inline-flex items-center gap-2 px-4 py-2 bg-amber-500 rounded-lg font-semibold text-sm text-white hover:bg-amber-600 transition shadow-sm">
                <i class="fas fa-edit"></i> Editar
            </a>
        </div>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
                    <div><span class="text-gray-500">Código:</span><span class="font-medium ml-1">{{ $grupo->codigo ?? '-' }}</span></div>
                    <div><span class="text-gray-500">Jornada:</span><span class="font-medium ml-1">{{ ucfirst($grupo->jornada) }}</span></div>
                    <div><span class="text-gray-500">Edad:</span><span class="font-medium ml-1">{{ $grupo->edad_minima ?? '?' }} - {{ $grupo->edad_maxima ?? '?' }} meses</span></div>
                    <div><span class="text-gray-500">Capacidad:</span><span class="font-medium ml-1">{{ $grupo->capacidad }} cupos</span></div>
                </div>
                @if($grupo->descripcion)
                    <p class="mt-4 text-sm text-gray-600">{{ $grupo->descripcion }}</p>
                @endif
            </div>

            @if($grupo->docentesActuales->count())
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-3"><i class="fas fa-chalkboard-teacher text-indigo-500 mr-1"></i> Docentes Asignados ({{ date('Y') }})</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                    @foreach($grupo->docentesActuales as $doc)
                        <a href="{{ route('docentes.show', $doc) }}" class="flex items-center gap-3 p-3 border rounded-lg hover:bg-indigo-50 transition">
                            @if($doc->foto)
                                <img src="{{ asset('storage/' . $doc->foto) }}" class="h-10 w-10 rounded-full object-cover">
                            @else
                                <div class="h-10 w-10 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 font-bold text-sm">
                                    {{ strtoupper(substr($doc->nombres, 0, 1) . substr($doc->apellidos, 0, 1)) }}
                                </div>
                            @endif
                            <div>
                                <div class="font-medium text-sm">{{ $doc->nombre_completo }}</div>
                                <div class="text-xs text-gray-500">{{ ucfirst($doc->pivot->rol) }} — {{ $doc->especialidad ?? '' }}</div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold text-gray-800">Estudiantes Activos ({{ $grupo->estudiantes->count() }})</h3>
                    <a href="{{ route('estudiantes.create') }}" class="text-sm text-indigo-600 hover:underline">+ Nuevo Estudiante</a>
                </div>
                @if($grupo->estudiantes->count())
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
                                @foreach($grupo->estudiantes as $est)
                                    <tr>
                                        <td class="px-4 py-3 text-sm">{{ $est->codigo }}</td>
                                        <td class="px-4 py-3 text-sm font-medium">{{ $est->nombre_completo }}</td>
                                        <td class="px-4 py-3 text-sm">{{ $est->edad }}</td>
                                        <td class="px-4 py-3 text-sm">{{ $est->acudiente?->nombre_completo }}</td>
                                        <td class="px-4 py-3 text-sm"><a href="{{ route('estudiantes.show', $est) }}" class="text-indigo-600 hover:underline">Ver</a></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-gray-500 text-sm">No hay estudiantes en este grupo.</p>
                @endif
            </div>
    </div>
</x-app-layout>
