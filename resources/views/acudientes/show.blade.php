<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ $acudiente->nombre_completo }}</h2>
            <a href="{{ route('acudientes.edit', $acudiente) }}" class="inline-flex items-center px-4 py-2 bg-amber-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-amber-600 transition">Editar</a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-3">Datos del Acudiente</h3>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
                    <div><span class="text-gray-500">Documento:</span><br><span class="font-medium">{{ $acudiente->tipo_documento }} {{ $acudiente->documento }}</span></div>
                    <div><span class="text-gray-500">Parentesco:</span><br><span class="font-medium">{{ $acudiente->parentesco ?? '-' }}</span></div>
                    <div><span class="text-gray-500">Celular:</span><br><span class="font-medium">{{ $acudiente->celular ?? '-' }}</span></div>
                    <div><span class="text-gray-500">Teléfono:</span><br><span class="font-medium">{{ $acudiente->telefono ?? '-' }}</span></div>
                    <div><span class="text-gray-500">Email:</span><br><span class="font-medium">{{ $acudiente->email ?? '-' }}</span></div>
                    <div><span class="text-gray-500">Dirección:</span><br><span class="font-medium">{{ $acudiente->direccion ?? '-' }}</span></div>
                    <div><span class="text-gray-500">Barrio:</span><br><span class="font-medium">{{ $acudiente->barrio ?? '-' }}</span></div>
                    <div><span class="text-gray-500">EPS:</span><br><span class="font-medium">{{ $acudiente->eps ?? '-' }}</span></div>
                    <div><span class="text-gray-500">Ocupación:</span><br><span class="font-medium">{{ $acudiente->ocupacion ?? '-' }}</span></div>
                    <div><span class="text-gray-500">Empresa:</span><br><span class="font-medium">{{ $acudiente->empresa_trabajo ?? '-' }}</span></div>
                </div>
                @if($acudiente->observaciones)
                    <p class="mt-4 text-sm text-gray-600">{{ $acudiente->observaciones }}</p>
                @endif
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-3">Estudiantes a Cargo</h3>
                @if($acudiente->estudiantes->count())
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @foreach($acudiente->estudiantes as $est)
                            <a href="{{ route('estudiantes.show', $est) }}" class="block border rounded-lg p-4 hover:shadow-md transition">
                                <div class="font-medium">{{ $est->nombre_completo }}</div>
                                <div class="text-sm text-gray-500">{{ $est->estancia?->nombre ?? 'Sin estancia' }} - {{ $est->edad }}</div>
                                <span class="mt-1 inline-block px-2 py-0.5 text-xs rounded-full {{ $est->estado === 'activo' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">{{ ucfirst($est->estado) }}</span>
                            </a>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500 text-sm">No tiene estudiantes asociados.</p>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
