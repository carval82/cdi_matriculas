<x-app-layout>
    <x-slot name="header">Evaluaciones</x-slot>

    <div>
        @if(session('success'))
            <div class="mb-4 p-4 bg-green-50 border border-green-200 rounded-xl text-green-700 flex items-center gap-2">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
            </div>
        @endif

        {{-- Filtros --}}
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
                    <label class="block text-xs font-medium text-gray-500 mb-1">Año</label>
                    <input type="number" name="anio" value="{{ $anio }}" min="2020" class="border-gray-300 rounded-md shadow-sm text-sm w-24 focus:border-indigo-500 focus:ring-indigo-500" onchange="this.form.submit()">
                </div>
            </form>
        </div>

        {{-- Lista de estudiantes --}}
        @if($grupo && $estudiantes->count())
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-4 border-b bg-gray-50 flex justify-between items-center">
                    <div>
                        <span class="font-semibold text-gray-800">{{ $grupo->nombre }}</span>
                        <span class="text-sm text-gray-500 ml-2">— {{ $anio }}</span>
                    </div>
                    <span class="text-xs text-gray-400">{{ $estudiantes->count() }} estudiantes · {{ $conceptosCount }} conceptos</span>
                </div>
                <div class="divide-y">
                    @foreach($estudiantes as $est)
                        <a href="{{ route('evaluaciones.estudiante', ['estudiante' => $est->id, 'anio' => $anio]) }}" class="flex items-center justify-between px-5 py-4 hover:bg-indigo-50 transition group">
                            <div class="flex items-center gap-4">
                                @if($est->foto)
                                    <img src="{{ asset('storage/' . $est->foto) }}" class="w-10 h-10 rounded-full object-cover">
                                @else
                                    <div class="w-10 h-10 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 font-bold text-sm">
                                        {{ strtoupper(substr($est->nombres, 0, 1) . substr($est->apellidos, 0, 1)) }}
                                    </div>
                                @endif
                                <div>
                                    <div class="font-medium text-gray-800 group-hover:text-indigo-700">{{ $est->nombre_completo }}</div>
                                    <div class="text-xs text-gray-400">{{ $est->codigo ?? '' }} · {{ $est->documento ?? '' }}</div>
                                </div>
                            </div>
                            <div class="flex items-center gap-4">
                                {{-- Barra de progreso --}}
                                <div class="text-right">
                                    <div class="text-xs text-gray-500 mb-1">{{ $est->evaluaciones_count }} evaluaciones</div>
                                    <div class="w-32 bg-gray-200 rounded-full h-2">
                                        <div class="h-2 rounded-full {{ $est->progreso >= 100 ? 'bg-green-500' : ($est->progreso >= 50 ? 'bg-blue-500' : ($est->progreso > 0 ? 'bg-amber-500' : 'bg-gray-300')) }}" style="width: {{ min($est->progreso, 100) }}%"></div>
                                    </div>
                                </div>
                                <i class="fas fa-chevron-right text-gray-300 group-hover:text-indigo-500"></i>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        @elseif($grupo && $conceptosCount === 0)
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
                <p>Selecciona un grupo para ver los estudiantes y evaluarlos.</p>
            </div>
        @endif
    </div>
</x-app-layout>
