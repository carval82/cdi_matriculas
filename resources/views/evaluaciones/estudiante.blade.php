<x-app-layout>
    <x-slot name="header">Evaluación: {{ $estudiante->nombre_completo }}</x-slot>

    <div class="space-y-6">
        @if(session('success'))
            <div class="p-4 bg-green-50 border border-green-200 rounded-xl text-green-700 flex items-center gap-2">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
            </div>
        @endif

        {{-- Info del estudiante --}}
        <div class="flex justify-between items-center">
            <div class="flex items-center gap-3">
                @if($estudiante->foto)
                    <img src="{{ asset('storage/' . $estudiante->foto) }}" class="h-12 w-12 rounded-full object-cover shadow">
                @else
                    <div class="h-12 w-12 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 font-bold">
                        {{ strtoupper(substr($estudiante->nombres, 0, 1) . substr($estudiante->apellidos, 0, 1)) }}
                    </div>
                @endif
                <div>
                    <h2 class="font-semibold text-gray-800">{{ $estudiante->nombre_completo }}</h2>
                    <p class="text-sm text-gray-500">{{ $estudiante->grupo?->nombre ?? 'Sin grupo' }} · {{ $estudiante->edad }} · {{ $estudiante->codigo }}</p>
                </div>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('evaluaciones.index', ['grupo_id' => $estudiante->grupo_id, 'anio' => $anio]) }}" class="text-sm text-indigo-600 hover:underline"><i class="fas fa-arrow-left mr-1"></i> Volver al grupo</a>
            </div>
        </div>

        {{-- Tabs de periodo + año --}}
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-4 border-b bg-gray-50 flex flex-wrap items-center justify-between gap-3">
                <div class="flex gap-1">
                    @foreach($periodos as $pk => $pv)
                        <a href="{{ route('evaluaciones.estudiante', ['estudiante' => $estudiante->id, 'periodo' => $pk, 'anio' => $anio]) }}"
                           class="px-4 py-2 rounded-lg text-sm font-semibold transition {{ $periodo == $pk ? 'bg-indigo-600 text-white shadow-sm' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                            {{ $pv }}
                            @php $pCount = isset($evaluaciones[$pk]) ? $evaluaciones[$pk]->count() : 0; @endphp
                            @if($pCount > 0)
                                <span class="ml-1 text-xs {{ $periodo == $pk ? 'text-indigo-200' : 'text-gray-400' }}">{{ $pCount }}</span>
                            @endif
                        </a>
                    @endforeach
                </div>
                <form method="GET" class="flex gap-2 items-center">
                    <input type="hidden" name="periodo" value="{{ $periodo }}">
                    <label class="text-xs text-gray-500">Año:</label>
                    <input type="number" name="anio" value="{{ $anio }}" min="2020" class="border-gray-300 rounded-md shadow-sm text-sm w-20 focus:border-indigo-500 focus:ring-indigo-500" onchange="this.form.submit()">
                </form>
            </div>

            {{-- Formulario de evaluación individual --}}
            @if($conceptos->count())
                <form action="{{ route('evaluaciones.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="estudiante_id" value="{{ $estudiante->id }}">
                    <input type="hidden" name="periodo" value="{{ $periodo }}">
                    <input type="hidden" name="anio" value="{{ $anio }}">

                    <div class="divide-y">
                        @foreach($conceptos as $c)
                            @php
                                $eval = isset($evaluaciones[$periodo]) ? $evaluaciones[$periodo]->firstWhere('concepto_evaluativo_id', $c->id) : null;
                                $val = $eval?->valoracion ?? '';
                                $obs = $eval?->observacion ?? '';
                            @endphp
                            <div class="px-5 py-4 hover:bg-gray-50 transition">
                                <div class="flex flex-col md:flex-row md:items-center gap-3">
                                    <div class="flex-1 min-w-0">
                                        <div class="font-medium text-gray-800 text-sm">{{ $c->nombre }}</div>
                                        @if($c->descripcion)
                                            <div class="text-xs text-gray-400 mt-0.5">{{ $c->descripcion }}</div>
                                        @endif
                                    </div>
                                    <div class="flex items-center gap-3 flex-shrink-0">
                                        <select name="evaluaciones[{{ $c->id }}]"
                                            class="border-gray-200 rounded-lg text-sm py-2 px-3 focus:border-indigo-500 focus:ring-indigo-500 min-w-[150px]
                                            {{ $val == 'superior' ? 'bg-blue-50 text-blue-700 border-blue-200' : '' }}
                                            {{ $val == 'alto' ? 'bg-green-50 text-green-700 border-green-200' : '' }}
                                            {{ $val == 'basico' ? 'bg-yellow-50 text-yellow-700 border-yellow-200' : '' }}
                                            {{ $val == 'bajo' ? 'bg-red-50 text-red-700 border-red-200' : '' }}
                                            {{ $val == 'en_proceso' ? 'bg-gray-50 text-gray-600' : '' }}"
                                            onchange="var c={'superior':'bg-blue-50 text-blue-700 border-blue-200','alto':'bg-green-50 text-green-700 border-green-200','basico':'bg-yellow-50 text-yellow-700 border-yellow-200','bajo':'bg-red-50 text-red-700 border-red-200','en_proceso':'bg-gray-50 text-gray-600'}; this.className=this.className.replace(/bg-\w+-50|text-\w+-\d+|border-\w+-\d+/g,''); if(c[this.value]) this.className+=' '+c[this.value];">
                                            <option value="">— Sin evaluar —</option>
                                            @foreach($valoraciones as $vk => $vl)
                                                <option value="{{ $vk }}" {{ $val == $vk ? 'selected' : '' }}>{{ $vl }}</option>
                                            @endforeach
                                        </select>
                                        <input type="text" name="observaciones[{{ $c->id }}]" value="{{ $obs }}" placeholder="Observación..."
                                            class="border-gray-200 rounded-lg text-sm py-2 px-3 focus:border-indigo-500 focus:ring-indigo-500 w-48 hidden md:block">
                                    </div>
                                </div>
                                <div class="mt-2 md:hidden">
                                    <input type="text" name="observaciones[{{ $c->id }}]" value="{{ $obs }}" placeholder="Observación..."
                                        class="w-full border-gray-200 rounded-lg text-sm py-2 px-3 focus:border-indigo-500 focus:ring-indigo-500">
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="p-4 border-t bg-gray-50 flex justify-between items-center">
                        <div class="flex gap-2 text-xs">
                            <span class="px-2 py-1 rounded bg-blue-50 text-blue-700">Superior</span>
                            <span class="px-2 py-1 rounded bg-green-50 text-green-700">Alto</span>
                            <span class="px-2 py-1 rounded bg-yellow-50 text-yellow-700">Básico</span>
                            <span class="px-2 py-1 rounded bg-red-50 text-red-700">Bajo</span>
                            <span class="px-2 py-1 rounded bg-gray-100 text-gray-600">En Proceso</span>
                        </div>
                        <button type="submit" class="inline-flex items-center gap-2 px-6 py-2.5 bg-indigo-600 rounded-lg font-semibold text-sm text-white hover:bg-indigo-700 transition shadow-sm">
                            <i class="fas fa-save"></i> Guardar {{ $periodos[$periodo] }}
                        </button>
                    </div>
                </form>
            @else
                <div class="p-8 text-center text-gray-500">
                    <p>No hay conceptos evaluativos creados.</p>
                    <a href="{{ route('conceptos.index') }}" class="text-indigo-600 hover:underline text-sm mt-2 inline-block">Crear conceptos evaluativos</a>
                </div>
            @endif
        </div>

        {{-- Resumen general de todos los periodos --}}
        @if($conceptos->count())
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-4 border-b bg-gray-50">
                <span class="font-semibold text-gray-800">Resumen Anual {{ $anio }}</span>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase min-w-[200px]">Concepto</th>
                            @foreach($periodos as $pk => $pv)
                                <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase">{{ $pv }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($conceptos as $c)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-2.5 text-sm font-medium text-gray-800">{{ $c->nombre }}</td>
                                @foreach($periodos as $pk => $pv)
                                    @php
                                        $eval = isset($evaluaciones[$pk]) ? $evaluaciones[$pk]->firstWhere('concepto_evaluativo_id', $c->id) : null;
                                        $val = $eval?->valoracion ?? '';
                                        $colors = [
                                            'superior' => 'bg-blue-100 text-blue-800',
                                            'alto' => 'bg-green-100 text-green-800',
                                            'basico' => 'bg-yellow-100 text-yellow-800',
                                            'bajo' => 'bg-red-100 text-red-800',
                                            'en_proceso' => 'bg-gray-100 text-gray-600',
                                        ];
                                    @endphp
                                    <td class="px-4 py-2.5 text-center">
                                        @if($val)
                                            <span class="inline-block px-2.5 py-1 text-xs font-semibold rounded-full {{ $colors[$val] ?? '' }}">
                                                {{ $valoraciones[$val] ?? $val }}
                                            </span>
                                        @else
                                            <span class="text-gray-300">—</span>
                                        @endif
                                    </td>
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endif
    </div>
</x-app-layout>
