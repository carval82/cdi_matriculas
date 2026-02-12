<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ $estudiante->nombre_completo }}</h2>
            <div class="flex gap-2">
                <a href="{{ route('matriculas.create', ['estudiante_id' => $estudiante->id]) }}" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 transition">Matricular</a>
                <a href="{{ route('estudiantes.edit', $estudiante) }}" class="inline-flex items-center px-4 py-2 bg-amber-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-amber-600 transition">Editar</a>
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">{{ session('success') }}</div>
            @endif

            <!-- Datos personales -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="flex items-start gap-6">
                    @if($estudiante->foto)
                        <img src="{{ asset('storage/' . $estudiante->foto) }}" alt="Foto" class="h-24 w-24 object-cover rounded-full shadow">
                    @else
                        <div class="h-24 w-24 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 text-2xl font-bold shadow">
                            {{ strtoupper(substr($estudiante->nombres, 0, 1) . substr($estudiante->apellidos, 0, 1)) }}
                        </div>
                    @endif
                    <div class="flex-1">
                        <h3 class="text-lg font-semibold text-gray-800">Datos Personales</h3>
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-3 text-sm">
                            <div><span class="text-gray-500">Código:</span><br><span class="font-medium">{{ $estudiante->codigo ?? '-' }}</span></div>
                            <div><span class="text-gray-500">Documento:</span><br><span class="font-medium">{{ $estudiante->tipo_documento }} {{ $estudiante->documento ?? '-' }}</span></div>
                            <div><span class="text-gray-500">Fecha Nac.:</span><br><span class="font-medium">{{ $estudiante->fecha_nacimiento->format('d/m/Y') }}</span></div>
                            <div><span class="text-gray-500">Edad:</span><br><span class="font-medium">{{ $estudiante->edad }}</span></div>
                            <div><span class="text-gray-500">Género:</span><br><span class="font-medium">{{ ucfirst($estudiante->genero) }}</span></div>
                            <div><span class="text-gray-500">RH:</span><br><span class="font-medium">{{ $estudiante->rh ?? '-' }}</span></div>
                            <div><span class="text-gray-500">EPS:</span><br><span class="font-medium">{{ $estudiante->eps ?? '-' }}</span></div>
                            <div><span class="text-gray-500">Estancia:</span><br><span class="font-medium">{{ $estudiante->estancia?->nombre ?? 'Sin asignar' }}</span></div>
                            <div><span class="text-gray-500">Estado:</span><br>
                                <span class="px-2 py-0.5 text-xs rounded-full {{ $estudiante->estado === 'activo' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">{{ ucfirst($estudiante->estado) }}</span>
                            </div>
                            <div><span class="text-gray-500">Ingreso:</span><br><span class="font-medium">{{ $estudiante->fecha_ingreso?->format('d/m/Y') ?? '-' }}</span></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Info médica -->
            @if($estudiante->alergias || $estudiante->condiciones_medicas || $estudiante->medicamentos)
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-3">Información Médica</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
                    @if($estudiante->alergias)
                        <div><span class="text-gray-500">Alergias:</span><p class="mt-1">{{ $estudiante->alergias }}</p></div>
                    @endif
                    @if($estudiante->condiciones_medicas)
                        <div><span class="text-gray-500">Condiciones:</span><p class="mt-1">{{ $estudiante->condiciones_medicas }}</p></div>
                    @endif
                    @if($estudiante->medicamentos)
                        <div><span class="text-gray-500">Medicamentos:</span><p class="mt-1">{{ $estudiante->medicamentos }}</p></div>
                    @endif
                </div>
            </div>
            @endif

            <!-- Acudientes -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-3">Acudientes</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @if($estudiante->acudiente)
                        <div class="border rounded-lg p-4">
                            <div class="text-xs text-indigo-600 font-semibold mb-1">ACUDIENTE PRINCIPAL</div>
                            <div class="font-medium">{{ $estudiante->acudiente->nombre_completo }}</div>
                            <div class="text-sm text-gray-500">{{ $estudiante->acudiente->parentesco ?? '' }} - {{ $estudiante->acudiente->documento }}</div>
                            <div class="text-sm text-gray-500 mt-1">Tel: {{ $estudiante->acudiente->celular ?? $estudiante->acudiente->telefono ?? '-' }}</div>
                        </div>
                    @endif
                    @if($estudiante->acudienteSecundario)
                        <div class="border rounded-lg p-4">
                            <div class="text-xs text-gray-500 font-semibold mb-1">ACUDIENTE SECUNDARIO</div>
                            <div class="font-medium">{{ $estudiante->acudienteSecundario->nombre_completo }}</div>
                            <div class="text-sm text-gray-500">{{ $estudiante->acudienteSecundario->parentesco ?? '' }} - {{ $estudiante->acudienteSecundario->documento }}</div>
                            <div class="text-sm text-gray-500 mt-1">Tel: {{ $estudiante->acudienteSecundario->celular ?? $estudiante->acudienteSecundario->telefono ?? '-' }}</div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Matrículas -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="flex justify-between items-center mb-3">
                    <h3 class="text-lg font-semibold text-gray-800">Historial de Matrículas</h3>
                    <a href="{{ route('matriculas.create', ['estudiante_id' => $estudiante->id]) }}" class="text-sm text-indigo-600 hover:underline">+ Nueva</a>
                </div>
                @if($estudiante->matriculas->count())
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Código</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Año</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Estancia</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Estado</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Acciones</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @foreach($estudiante->matriculas->sortByDesc('anio') as $mat)
                                    <tr>
                                        <td class="px-4 py-2 text-sm">{{ $mat->codigo }}</td>
                                        <td class="px-4 py-2 text-sm">{{ $mat->anio }}</td>
                                        <td class="px-4 py-2 text-sm">{{ $mat->estancia?->nombre }}</td>
                                        <td class="px-4 py-2 text-sm">
                                            <span class="px-2 py-0.5 text-xs rounded-full {{ $mat->estado === 'activa' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">{{ ucfirst($mat->estado) }}</span>
                                        </td>
                                        <td class="px-4 py-2 text-sm"><a href="{{ route('matriculas.show', $mat) }}" class="text-indigo-600 hover:underline">Ver</a></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-gray-500 text-sm">Sin matrículas registradas.</p>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
