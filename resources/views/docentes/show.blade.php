<x-app-layout>
    <x-slot name="header">{{ $docente->nombre_completo }}</x-slot>

    <div class="space-y-6">
        <div class="flex justify-end gap-2">
            <a href="{{ route('docentes.edit', $docente) }}" class="inline-flex items-center gap-2 px-4 py-2 bg-amber-500 rounded-lg font-semibold text-sm text-white hover:bg-amber-600 transition shadow-sm"><i class="fas fa-edit"></i> Editar</a>
        </div>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">{{ session('success') }}</div>
        @endif

        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
            <div class="flex items-start gap-6">
                @if($docente->foto)
                    <img src="{{ asset('storage/' . $docente->foto) }}" alt="Foto" class="h-24 w-24 object-cover rounded-full shadow">
                @else
                    <div class="h-24 w-24 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 text-2xl font-bold shadow">
                        {{ strtoupper(substr($docente->nombres, 0, 1) . substr($docente->apellidos, 0, 1)) }}
                    </div>
                @endif
                <div class="flex-1">
                    <h3 class="text-lg font-semibold text-gray-800">Datos Personales</h3>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-3 text-sm">
                        <div><span class="text-gray-500">Documento:</span><br><span class="font-medium">{{ $docente->tipo_documento }} {{ $docente->documento }}</span></div>
                        <div><span class="text-gray-500">Celular:</span><br><span class="font-medium">{{ $docente->celular ?? '-' }}</span></div>
                        <div><span class="text-gray-500">Email:</span><br><span class="font-medium">{{ $docente->email ?? '-' }}</span></div>
                        <div><span class="text-gray-500">Dirección:</span><br><span class="font-medium">{{ $docente->direccion ?? '-' }}</span></div>
                        <div><span class="text-gray-500">Especialidad:</span><br><span class="font-medium">{{ $docente->especialidad ?? '-' }}</span></div>
                        <div><span class="text-gray-500">Título:</span><br><span class="font-medium">{{ $docente->titulo ?? '-' }}</span></div>
                        <div><span class="text-gray-500">Ingreso:</span><br><span class="font-medium">{{ $docente->fecha_ingreso?->format('d/m/Y') ?? '-' }}</span></div>
                        <div><span class="text-gray-500">Estado:</span><br>
                            <span class="px-2 py-0.5 text-xs rounded-full {{ $docente->activo ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">{{ $docente->activo ? 'Activo' : 'Inactivo' }}</span>
                        </div>
                        <div><span class="text-gray-500">Acceso al Sistema:</span><br>
                            @if($docente->user)
                                <span class="px-2 py-0.5 text-xs rounded-full bg-green-100 text-green-800"><i class="fas fa-check"></i> {{ $docente->user->email }}</span>
                            @else
                                <span class="text-gray-400">Sin acceso</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4"><i class="fas fa-school text-blue-500 mr-1"></i> Grupos Asignados ({{ date('Y') }})</h3>
            @if($docente->gruposActuales->count())
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach($docente->gruposActuales as $grupo)
                        <a href="{{ route('grupos.show', $grupo) }}" class="block p-4 border rounded-xl hover:border-indigo-300 hover:bg-indigo-50 transition">
                            <div class="font-semibold text-gray-800">{{ $grupo->nombre }}</div>
                            <div class="text-sm text-gray-500 mt-1">
                                <span class="inline-flex items-center gap-1"><i class="fas fa-users text-xs"></i> {{ $grupo->estudiantesActivos->count() }} estudiantes</span>
                                <span class="ml-3 inline-flex items-center gap-1"><i class="fas fa-tag text-xs"></i> {{ ucfirst($grupo->pivot->rol) }}</span>
                            </div>
                            <div class="text-xs text-gray-400 mt-1">Jornada: {{ ucfirst($grupo->jornada) }}</div>
                        </a>
                    @endforeach
                </div>
            @else
                <p class="text-gray-500 text-sm">No tiene grupos asignados para este año.</p>
            @endif
        </div>

        @if($docente->observaciones)
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-2">Observaciones</h3>
            <p class="text-sm text-gray-600">{{ $docente->observaciones }}</p>
        </div>
        @endif
    </div>
</x-app-layout>
