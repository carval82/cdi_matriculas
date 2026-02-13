<x-app-layout>
    <x-slot name="header">Evaluaciones</x-slot>

    <div>
        @if(session('success'))
            <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">{{ session('success') }}</div>
        @endif

        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-4 mb-4">
            <form method="GET" class="flex flex-wrap gap-3 items-end">
                <div class="flex-1 min-w-[200px]">
                    <label class="block text-xs font-medium text-gray-500 mb-1">Grupo</label>
                    <select name="grupo_id" class="w-full border-gray-300 rounded-md shadow-sm text-sm focus:border-indigo-500 focus:ring-indigo-500" onchange="this.form.submit()">
                        <option value="">-- Seleccionar Grupo --</option>
                        @foreach($grupos as $g)
                            <option value="{{ $g->id }}" {{ $grupoId == $g->id ? 'selected' : '' }}>{{ $g->nombre }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-500 mb-1">Periodo</label>
                    <select name="periodo" class="border-gray-300 rounded-md shadow-sm text-sm focus:border-indigo-500 focus:ring-indigo-500" onchange="this.form.submit()">
                        @foreach($periodos as $k => $v)
                            <option value="{{ $k }}" {{ $periodo == $k ? 'selected' : '' }}>{{ $v }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-500 mb-1">Año</label>
                    <input type="number" name="anio" value="{{ $anio }}" min="2020" class="border-gray-300 rounded-md shadow-sm text-sm w-24 focus:border-indigo-500 focus:ring-indigo-500" onchange="this.form.submit()">
                </div>
            </form>
        </div>

        @if($grupo && $estudiantes->count() && $conceptos->count())
            <form action="{{ route('evaluaciones.store') }}" method="POST">
                @csrf
                <input type="hidden" name="grupo_id" value="{{ $grupo->id }}">
                <input type="hidden" name="periodo" value="{{ $periodo }}">
                <input type="hidden" name="anio" value="{{ $anio }}">

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-4 border-b bg-gray-50 flex justify-between items-center">
                        <div>
                            <span class="font-semibold text-gray-800">{{ $grupo->nombre }}</span>
                            <span class="text-sm text-gray-500 ml-2">{{ $periodos[$periodo] }} — {{ $anio }}</span>
                        </div>
                        <span class="text-xs text-gray-400">{{ $estudiantes->count() }} estudiantes · {{ $conceptos->count() }} conceptos</span>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase sticky left-0 bg-gray-50 z-10 min-w-[200px]">Estudiante</th>
                                    @foreach($conceptos as $c)
                                        <th class="px-3 py-3 text-center text-xs font-medium text-gray-500 uppercase min-w-[140px]" title="{{ $c->descripcion }}">
                                            {{ Str::limit($c->nombre, 20) }}
                                        </th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($estudiantes as $est)
                                    @php $estEvals = $evaluaciones[$est->id] ?? collect(); @endphp
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-3 py-2 sticky left-0 bg-white z-10 border-r">
                                            <a href="{{ route('evaluaciones.estudiante', $est) }}" class="text-sm font-medium text-indigo-600 hover:underline">
                                                {{ $est->nombre_completo }}
                                            </a>
                                        </td>
                                        @foreach($conceptos as $c)
                                            @php
                                                $eval = $estEvals->firstWhere('concepto_evaluativo_id', $c->id);
                                                $val = $eval?->valoracion ?? '';
                                            @endphp
                                            <td class="px-2 py-2 text-center">
                                                <select name="evaluaciones[{{ $est->id }}][{{ $c->id }}]"
                                                    class="w-full text-xs border-gray-200 rounded-md py-1.5 px-2 focus:border-indigo-500 focus:ring-indigo-500
                                                    {{ $val == 'superior' ? 'bg-blue-50 text-blue-700' : '' }}
                                                    {{ $val == 'alto' ? 'bg-green-50 text-green-700' : '' }}
                                                    {{ $val == 'basico' ? 'bg-yellow-50 text-yellow-700' : '' }}
                                                    {{ $val == 'bajo' ? 'bg-red-50 text-red-700' : '' }}
                                                    {{ $val == 'en_proceso' ? 'bg-gray-50 text-gray-600' : '' }}"
                                                    onchange="this.className = this.className.replace(/bg-\w+-50|text-\w+-\d+/g, ''); var c = {'superior':'bg-blue-50 text-blue-700','alto':'bg-green-50 text-green-700','basico':'bg-yellow-50 text-yellow-700','bajo':'bg-red-50 text-red-700','en_proceso':'bg-gray-50 text-gray-600'}; if(c[this.value]) this.className += ' ' + c[this.value];">
                                                    <option value="">—</option>
                                                    @foreach($valoraciones as $vk => $vl)
                                                        <option value="{{ $vk }}" {{ $val == $vk ? 'selected' : '' }}>{{ $vl }}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                        @endforeach
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="p-4 border-t bg-gray-50 flex justify-between items-center">
                        <div class="flex gap-3 text-xs">
                            <span class="px-2 py-1 rounded bg-blue-50 text-blue-700">Superior</span>
                            <span class="px-2 py-1 rounded bg-green-50 text-green-700">Alto</span>
                            <span class="px-2 py-1 rounded bg-yellow-50 text-yellow-700">Básico</span>
                            <span class="px-2 py-1 rounded bg-red-50 text-red-700">Bajo</span>
                            <span class="px-2 py-1 rounded bg-gray-50 text-gray-600">En Proceso</span>
                        </div>
                        <button type="submit" class="inline-flex items-center gap-2 px-6 py-2 bg-indigo-600 rounded-lg font-semibold text-sm text-white hover:bg-indigo-700 transition shadow-sm">
                            <i class="fas fa-save"></i> Guardar Evaluaciones
                        </button>
                    </div>
                </div>
            </form>
        @elseif($grupo && !$conceptos->count())
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-8 text-center text-gray-500">
                <i class="fas fa-list-alt text-4xl text-gray-300 mb-3"></i>
                <p>No hay conceptos evaluativos creados.</p>
                <a href="{{ route('conceptos.index') }}" class="text-indigo-600 hover:underline text-sm mt-2 inline-block">Crear conceptos evaluativos</a>
            </div>
        @elseif($grupo)
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-8 text-center text-gray-500">
                <p>No hay estudiantes activos en este grupo.</p>
            </div>
        @else
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-8 text-center text-gray-500">
                <i class="fas fa-star text-4xl text-gray-300 mb-3"></i>
                <p>Selecciona un grupo para evaluar.</p>
            </div>
        @endif
    </div>
</x-app-layout>
