<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Estancias</h2>
            <a href="{{ route('estancias.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 transition">
                + Nueva Estancia
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">{{ session('error') }}</div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($estancias as $estancia)
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <div class="flex justify-between items-start">
                                <div>
                                    <h3 class="text-lg font-bold text-gray-800">{{ $estancia->nombre }}</h3>
                                    @if($estancia->codigo)
                                        <span class="text-xs bg-indigo-100 text-indigo-800 px-2 py-0.5 rounded">{{ $estancia->codigo }}</span>
                                    @endif
                                </div>
                                <span class="text-xs px-2 py-1 rounded-full {{ $estancia->activa ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                    {{ $estancia->activa ? 'Activa' : 'Inactiva' }}
                                </span>
                            </div>

                            <div class="mt-4 space-y-2 text-sm text-gray-600">
                                <div class="flex justify-between">
                                    <span>Jornada:</span>
                                    <span class="font-medium">{{ ucfirst($estancia->jornada) }}</span>
                                </div>
                                @if($estancia->edad_minima || $estancia->edad_maxima)
                                <div class="flex justify-between">
                                    <span>Edad:</span>
                                    <span class="font-medium">{{ $estancia->edad_minima ?? '?' }} - {{ $estancia->edad_maxima ?? '?' }} meses</span>
                                </div>
                                @endif
                                <div class="flex justify-between">
                                    <span>Matrícula:</span>
                                    <span class="font-medium">${{ number_format($estancia->valor_matricula, 0, ',', '.') }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span>Pensión:</span>
                                    <span class="font-medium">${{ number_format($estancia->valor_pension, 0, ',', '.') }}</span>
                                </div>
                            </div>

                            <!-- Barra de ocupación -->
                            <div class="mt-4">
                                @php
                                    $ocupados = $estancia->estudiantes_count;
                                    $capacidad = $estancia->capacidad;
                                    $porcentaje = $capacidad > 0 ? round(($ocupados / $capacidad) * 100) : 0;
                                    $color = $porcentaje >= 90 ? 'bg-red-500' : ($porcentaje >= 70 ? 'bg-amber-500' : 'bg-green-500');
                                @endphp
                                <div class="flex justify-between text-xs text-gray-500 mb-1">
                                    <span>Ocupación</span>
                                    <span>{{ $ocupados }} / {{ $capacidad }}</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2">
                                    <div class="{{ $color }} h-2 rounded-full" style="width: {{ min($porcentaje, 100) }}%"></div>
                                </div>
                            </div>

                            <div class="mt-4 flex gap-2">
                                <a href="{{ route('estancias.show', $estancia) }}" class="text-sm text-indigo-600 hover:underline">Ver</a>
                                <a href="{{ route('estancias.edit', $estancia) }}" class="text-sm text-amber-600 hover:underline">Editar</a>
                                <form action="{{ route('estancias.destroy', $estancia) }}" method="POST" class="inline" onsubmit="return confirm('¿Eliminar esta estancia?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-sm text-red-600 hover:underline">Eliminar</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 text-center text-gray-500">
                        No hay estancias registradas. Crea la primera para comenzar.
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>
