<x-app-layout>
    <x-slot name="header">Reporte de Asistencia</x-slot>

    <div>
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-4 mb-4">
            <form method="GET" class="flex flex-wrap gap-3 items-end">
                <div class="flex-1 min-w-[200px]">
                    <label class="block text-xs font-medium text-gray-500 mb-1">Grupo</label>
                    <select name="grupo_id" class="w-full border-gray-300 rounded-md shadow-sm text-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <option value="">-- Seleccionar Grupo --</option>
                        @foreach($grupos as $g)
                            <option value="{{ $g->id }}" {{ $grupoId == $g->id ? 'selected' : '' }}>{{ $g->nombre }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-500 mb-1">Mes</label>
                    <select name="mes" class="border-gray-300 rounded-md shadow-sm text-sm focus:border-indigo-500 focus:ring-indigo-500">
                        @foreach($meses as $i => $m)
                            <option value="{{ $i + 1 }}" {{ $mes == ($i + 1) ? 'selected' : '' }}>{{ $m }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-500 mb-1">Año</label>
                    <input type="number" name="anio" value="{{ $anio }}" min="2020" class="border-gray-300 rounded-md shadow-sm text-sm w-24 focus:border-indigo-500 focus:ring-indigo-500">
                </div>
                <button type="submit" class="px-4 py-2 bg-indigo-600 text-white text-sm font-semibold rounded-lg hover:bg-indigo-700 transition">
                    <i class="fas fa-search"></i> Consultar
                </button>
            </form>
        </div>

        @if($grupo && count($datos))
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-4 border-b bg-gray-50">
                    <span class="font-semibold text-gray-800">{{ $grupo->nombre }}</span>
                    <span class="text-sm text-gray-500 ml-2">{{ $meses[$mes - 1] }} {{ $anio }} — {{ $diasClase->count() }} días registrados</span>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">#</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Estudiante</th>
                                <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase">
                                    <span class="text-green-600"><i class="fas fa-check"></i> P</span>
                                </th>
                                <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase">
                                    <span class="text-red-600"><i class="fas fa-times"></i> A</span>
                                </th>
                                <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase">
                                    <span class="text-amber-600"><i class="fas fa-clock"></i> T</span>
                                </th>
                                <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase">
                                    <span class="text-blue-600"><i class="fas fa-file"></i> E</span>
                                </th>
                                <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase">% Asist.</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($datos as $i => $d)
                                @php
                                    $porcentaje = $d['total_dias'] > 0 ? round(($d['presentes'] + $d['tardanzas']) / $d['total_dias'] * 100) : 0;
                                    $color = $porcentaje >= 80 ? 'green' : ($porcentaje >= 60 ? 'amber' : 'red');
                                @endphp
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-2 text-sm text-gray-500">{{ $i + 1 }}</td>
                                    <td class="px-4 py-2 text-sm font-medium">
                                        <a href="{{ route('estudiantes.show', $d['estudiante']) }}" class="text-indigo-600 hover:underline">{{ $d['estudiante']->nombre_completo }}</a>
                                    </td>
                                    <td class="px-4 py-2 text-center text-sm font-semibold text-green-600">{{ $d['presentes'] }}</td>
                                    <td class="px-4 py-2 text-center text-sm font-semibold text-red-600">{{ $d['ausentes'] }}</td>
                                    <td class="px-4 py-2 text-center text-sm font-semibold text-amber-600">{{ $d['tardanzas'] }}</td>
                                    <td class="px-4 py-2 text-center text-sm font-semibold text-blue-600">{{ $d['excusas'] }}</td>
                                    <td class="px-4 py-2 text-center">
                                        <span class="px-2 py-0.5 text-xs font-bold rounded-full bg-{{ $color }}-100 text-{{ $color }}-800">{{ $porcentaje }}%</span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @elseif($grupo)
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-8 text-center text-gray-500">
                <p>No hay registros de asistencia para este periodo.</p>
            </div>
        @endif
    </div>
</x-app-layout>
