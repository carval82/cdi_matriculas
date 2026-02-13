<x-app-layout>
    <x-slot name="header">Docentes</x-slot>

    <div>
        <div class="flex justify-between items-center mb-5">
            <div></div>
            <a href="{{ route('docentes.create') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 rounded-lg font-semibold text-sm text-white hover:bg-blue-700 transition shadow-sm">
                <i class="fas fa-plus"></i> Nuevo Docente
            </a>
        </div>

        @if(session('success'))
            <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">{{ session('success') }}</div>
        @endif

        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Docente</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Documento</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Celular</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Especialidad</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Grupos Asignados</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Acceso</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($docentes as $docente)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3">
                                    <div class="flex items-center gap-3">
                                        @if($docente->foto)
                                            <img src="{{ asset('storage/' . $docente->foto) }}" class="h-10 w-10 rounded-full object-cover">
                                        @else
                                            <div class="h-10 w-10 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 font-bold text-sm">
                                                {{ strtoupper(substr($docente->nombres, 0, 1) . substr($docente->apellidos, 0, 1)) }}
                                            </div>
                                        @endif
                                        <div>
                                            <div class="font-medium text-gray-900">{{ $docente->nombre_completo }}</div>
                                            <div class="text-xs text-gray-500">{{ $docente->email ?? '' }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-4 py-3 text-sm">{{ $docente->tipo_documento }} {{ $docente->documento }}</td>
                                <td class="px-4 py-3 text-sm">{{ $docente->celular ?? '-' }}</td>
                                <td class="px-4 py-3 text-sm">{{ $docente->especialidad ?? '-' }}</td>
                                <td class="px-4 py-3 text-sm">
                                    @forelse($docente->gruposActuales as $g)
                                        <span class="inline-block px-2 py-0.5 text-xs rounded-full bg-blue-100 text-blue-800 mr-1">{{ $g->nombre }}</span>
                                    @empty
                                        <span class="text-gray-400 text-xs">Sin asignar</span>
                                    @endforelse
                                </td>
                                <td class="px-4 py-3 text-sm">
                                    @if($docente->user_id)
                                        <span class="px-2 py-0.5 text-xs rounded-full bg-green-100 text-green-800"><i class="fas fa-check"></i> Sí</span>
                                    @else
                                        <span class="px-2 py-0.5 text-xs rounded-full bg-gray-100 text-gray-500">No</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-sm">
                                    <div class="flex gap-2">
                                        <a href="{{ route('docentes.show', $docente) }}" class="text-indigo-600 hover:text-indigo-800"><i class="fas fa-eye"></i></a>
                                        <a href="{{ route('docentes.edit', $docente) }}" class="text-amber-600 hover:text-amber-800"><i class="fas fa-edit"></i></a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="7" class="px-4 py-8 text-center text-gray-500">No se encontraron docentes.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
