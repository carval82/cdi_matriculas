<x-app-layout>
    <x-slot name="header">Evaluación: {{ $estudiante->nombre_completo }}</x-slot>

    <div class="space-y-6">
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
                    <p class="text-sm text-gray-500">{{ $estudiante->grupo?->nombre ?? 'Sin grupo' }} · {{ $estudiante->edad }}</p>
                </div>
            </div>
            <a href="{{ route('estudiantes.show', $estudiante) }}" class="text-sm text-indigo-600 hover:underline"><i class="fas fa-arrow-left mr-1"></i> Ver Estudiante</a>
        </div>

        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-4">
            <form method="GET" class="flex gap-3 items-end">
                <input type="hidden" name="estudiante" value="{{ $estudiante->id }}">
                <div>
                    <label class="block text-xs font-medium text-gray-500 mb-1">Año</label>
                    <input type="number" name="anio" value="{{ $anio }}" min="2020" class="border-gray-300 rounded-md shadow-sm text-sm w-24 focus:border-indigo-500 focus:ring-indigo-500">
                </div>
                <button type="submit" class="px-4 py-2 bg-indigo-600 text-white text-sm font-semibold rounded-lg hover:bg-indigo-700 transition">
                    <i class="fas fa-search"></i> Consultar
                </button>
            </form>
        </div>

        @if($conceptos->count())
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-4 border-b bg-gray-50">
                <span class="font-semibold text-gray-800">Evaluaciones {{ $anio }}</span>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase min-w-[200px]">Concepto Evaluativo</th>
                            @foreach($periodos as $pk => $pv)
                                <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase">{{ $pv }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($conceptos as $c)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3 text-sm font-medium text-gray-800" title="{{ $c->descripcion }}">
                                    {{ $c->nombre }}
                                </td>
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
                                    <td class="px-4 py-3 text-center">
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

            {{-- Resumen --}}
            <div class="p-4 border-t bg-gray-50">
                <h4 class="text-sm font-semibold text-gray-700 mb-3">Resumen por Periodo</h4>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                    @foreach($periodos as $pk => $pv)
                        @php
                            $periodoEvals = $evaluaciones[$pk] ?? collect();
                            $total = $periodoEvals->count();
                            $sup = $periodoEvals->where('valoracion', 'superior')->count();
                            $alt = $periodoEvals->where('valoracion', 'alto')->count();
                            $bas = $periodoEvals->where('valoracion', 'basico')->count();
                            $baj = $periodoEvals->where('valoracion', 'bajo')->count();
                            $enp = $periodoEvals->where('valoracion', 'en_proceso')->count();
                        @endphp
                        <div class="p-3 bg-white border rounded-xl">
                            <div class="font-semibold text-sm text-gray-700 mb-2">{{ $pv }}</div>
                            @if($total)
                                <div class="space-y-1 text-xs">
                                    <div class="flex justify-between"><span class="text-blue-600">Superior</span><span class="font-bold">{{ $sup }}</span></div>
                                    <div class="flex justify-between"><span class="text-green-600">Alto</span><span class="font-bold">{{ $alt }}</span></div>
                                    <div class="flex justify-between"><span class="text-yellow-600">Básico</span><span class="font-bold">{{ $bas }}</span></div>
                                    <div class="flex justify-between"><span class="text-red-600">Bajo</span><span class="font-bold">{{ $baj }}</span></div>
                                    <div class="flex justify-between"><span class="text-gray-500">En Proceso</span><span class="font-bold">{{ $enp }}</span></div>
                                </div>
                            @else
                                <p class="text-xs text-gray-400">Sin evaluar</p>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        @else
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-8 text-center text-gray-500">
                <p>No hay conceptos evaluativos creados.</p>
                <a href="{{ route('conceptos.index') }}" class="text-indigo-600 hover:underline text-sm mt-2 inline-block">Crear conceptos evaluativos</a>
            </div>
        @endif
    </div>
</x-app-layout>
