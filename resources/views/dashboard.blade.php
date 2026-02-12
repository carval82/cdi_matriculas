<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            CDI - Centro de Desarrollo Infantil
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- Stats -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-sm text-gray-500">Estudiantes Activos</div>
                    <div class="text-3xl font-bold text-indigo-600">{{ $stats['total_estudiantes'] }}</div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-sm text-gray-500">Matrículas {{ $anioActual }}</div>
                    <div class="text-3xl font-bold text-green-600">{{ $stats['total_matriculas'] }}</div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-sm text-gray-500">Estancias Activas</div>
                    <div class="text-3xl font-bold text-amber-600">{{ $stats['total_estancias'] }}</div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-sm text-gray-500">Ingresos del Mes</div>
                    <div class="text-3xl font-bold text-emerald-600">${{ number_format($stats['ingresos_mes'], 0, ',', '.') }}</div>
                </div>
            </div>

            <!-- Estancias con ocupación -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Estancias - Ocupación</h3>
                    @if($estancias->count())
                        <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-4">
                            @foreach($estancias as $estancia)
                                <a href="{{ route('estancias.show', $estancia) }}" class="block border rounded-lg p-4 hover:shadow-md transition">
                                    <div class="font-semibold text-gray-800">{{ $estancia->nombre }}</div>
                                    <div class="text-sm text-gray-500 mt-1">{{ $estancia->jornada }}</div>
                                    <div class="mt-3">
                                        @php
                                            $ocupados = $estancia->estudiantes_count;
                                            $capacidad = $estancia->capacidad;
                                            $porcentaje = $capacidad > 0 ? round(($ocupados / $capacidad) * 100) : 0;
                                            $color = $porcentaje >= 90 ? 'bg-red-500' : ($porcentaje >= 70 ? 'bg-amber-500' : 'bg-green-500');
                                        @endphp
                                        <div class="w-full bg-gray-200 rounded-full h-2.5">
                                            <div class="{{ $color }} h-2.5 rounded-full" style="width: {{ min($porcentaje, 100) }}%"></div>
                                        </div>
                                        <div class="text-xs text-gray-500 mt-1">{{ $ocupados }} / {{ $capacidad }} cupos ({{ $porcentaje }}%)</div>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-500">No hay estancias configuradas. <a href="{{ route('estancias.create') }}" class="text-indigo-600 hover:underline">Crear primera estancia</a></p>
                    @endif
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Últimas matrículas -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-semibold text-gray-800">Últimas Matrículas</h3>
                            <a href="{{ route('matriculas.create') }}" class="text-sm text-indigo-600 hover:underline">+ Nueva</a>
                        </div>
                        @forelse($ultimasMatriculas as $mat)
                            <div class="flex justify-between items-center py-2 border-b last:border-0">
                                <div>
                                    <div class="font-medium text-sm">{{ $mat->estudiante->nombre_completo }}</div>
                                    <div class="text-xs text-gray-500">{{ $mat->estancia->nombre }} - {{ $mat->codigo }}</div>
                                </div>
                                <span class="text-xs px-2 py-1 rounded-full {{ $mat->estado === 'activa' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                    {{ ucfirst($mat->estado) }}
                                </span>
                            </div>
                        @empty
                            <p class="text-gray-500 text-sm">Sin matrículas registradas.</p>
                        @endforelse
                    </div>
                </div>

                <!-- Últimos pagos -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-semibold text-gray-800">Últimos Pagos</h3>
                            <a href="{{ route('pagos.create') }}" class="text-sm text-indigo-600 hover:underline">+ Nuevo</a>
                        </div>
                        @forelse($ultimosPagos as $pago)
                            <div class="flex justify-between items-center py-2 border-b last:border-0">
                                <div>
                                    <div class="font-medium text-sm">{{ $pago->estudiante->nombre_completo }}</div>
                                    <div class="text-xs text-gray-500">{{ ucfirst($pago->concepto) }} {{ $pago->mes ? '- ' . ucfirst($pago->mes) : '' }}</div>
                                </div>
                                <div class="text-sm font-semibold text-green-600">${{ number_format($pago->total, 0, ',', '.') }}</div>
                            </div>
                        @empty
                            <p class="text-gray-500 text-sm">Sin pagos registrados.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
