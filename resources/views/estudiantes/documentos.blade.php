<x-app-layout>
    <x-slot name="header">Documentos — {{ $estudiante->nombre_completo }}</x-slot>

    @if(session('success'))
        <div class="mb-4 p-4 bg-green-50 border border-green-200 rounded-xl text-green-700 flex items-center gap-2">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="mb-4 p-4 bg-red-50 border border-red-200 rounded-xl text-red-700 flex items-center gap-2">
            <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Panel izquierdo: Subir documento --}}
        <div class="space-y-6">
            <div class="bg-white rounded-2xl shadow-sm p-6">
                <h2 class="text-lg font-bold text-gray-800 flex items-center gap-2 mb-4">
                    <div class="w-8 h-8 bg-purple-500 rounded-lg flex items-center justify-center">
                        <i class="fas fa-cloud-upload-alt text-white text-sm"></i>
                    </div>
                    Subir Documento
                </h2>
                <form action="{{ route('estudiantes.documentos.store', $estudiante) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Tipo de Documento *</label>
                        <select name="tipo" required class="w-full rounded-lg border-gray-300 text-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="">Seleccionar...</option>
                            @foreach($tipos as $key => $label)
                                <option value="{{ $key }}">{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nombre / Descripción *</label>
                        <input type="text" name="nombre" required placeholder="Ej: Registro civil de nacimiento" class="w-full rounded-lg border-gray-300 text-sm focus:border-indigo-500 focus:ring-indigo-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Archivo (PDF, JPG, PNG) *</label>
                        <input type="file" name="archivo" accept=".pdf,.jpg,.jpeg,.png" required class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-purple-50 file:text-purple-700 hover:file:bg-purple-100 cursor-pointer">
                        <p class="text-xs text-gray-400 mt-1">Máximo 10MB</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Observaciones</label>
                        <textarea name="observaciones" rows="2" placeholder="Opcional..." class="w-full rounded-lg border-gray-300 text-sm focus:border-indigo-500 focus:ring-indigo-500"></textarea>
                    </div>
                    <button type="submit" class="w-full bg-purple-600 hover:bg-purple-700 text-white font-semibold py-3 px-4 rounded-xl transition flex items-center justify-center gap-2">
                        <i class="fas fa-upload"></i> Subir Documento
                    </button>
                </form>
            </div>

            {{-- Info del estudiante --}}
            <div class="bg-white rounded-2xl shadow-sm p-5">
                <div class="flex items-center gap-3 mb-3">
                    @if($estudiante->foto)
                        <img src="{{ asset('storage/' . $estudiante->foto) }}" class="w-12 h-12 rounded-full object-cover">
                    @else
                        <div class="w-12 h-12 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 font-bold">
                            {{ strtoupper(substr($estudiante->nombres, 0, 1) . substr($estudiante->apellidos, 0, 1)) }}
                        </div>
                    @endif
                    <div>
                        <div class="font-semibold text-gray-800">{{ $estudiante->nombre_completo }}</div>
                        <div class="text-sm text-gray-500">{{ $estudiante->grupo?->nombre ?? 'Sin grupo' }} — {{ $estudiante->codigo }}</div>
                    </div>
                </div>
                <div class="flex gap-2">
                    <a href="{{ route('estudiantes.show', $estudiante) }}" class="flex-1 text-center px-3 py-2 bg-gray-100 text-gray-700 rounded-lg text-sm hover:bg-gray-200 transition">
                        <i class="fas fa-user mr-1"></i> Ver Perfil
                    </a>
                    @if($estudiante->matriculaActiva)
                    <a href="{{ route('matriculas.show', $estudiante->matriculaActiva) }}" class="flex-1 text-center px-3 py-2 bg-indigo-100 text-indigo-700 rounded-lg text-sm hover:bg-indigo-200 transition">
                        <i class="fas fa-file-signature mr-1"></i> Matrícula
                    </a>
                    @endif
                </div>
            </div>
        </div>

        {{-- Panel derecho: Lista de documentos --}}
        <div class="lg:col-span-2">
            <div class="bg-white rounded-2xl shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b bg-gray-50 flex items-center justify-between">
                    <h2 class="text-lg font-bold text-gray-800 flex items-center gap-2">
                        <i class="fas fa-folder-open text-purple-500"></i> Documentos del Estudiante
                    </h2>
                    <span class="text-sm text-gray-500">{{ count($documentos) }} archivo(s)</span>
                </div>

                @if(count($documentos) === 0)
                    <div class="p-12 text-center">
                        <div class="w-16 h-16 bg-gray-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-folder-open text-gray-400 text-2xl"></i>
                        </div>
                        <p class="text-gray-500 font-medium">No hay documentos cargados</p>
                        <p class="text-gray-400 text-sm mt-1">Sube el primer documento usando el formulario.</p>
                    </div>
                @else
                    <div class="divide-y">
                        @foreach($documentos as $doc)
                            <div class="px-6 py-4 flex items-center justify-between hover:bg-gray-50 transition">
                                <div class="flex items-center gap-4 min-w-0 flex-1">
                                    @php
                                        $ext = pathinfo($doc->archivo, PATHINFO_EXTENSION);
                                        $isPdf = strtolower($ext) === 'pdf';
                                    @endphp
                                    <div class="w-10 h-10 rounded-xl flex items-center justify-center flex-shrink-0 {{ $isPdf ? 'bg-red-100' : 'bg-blue-100' }}">
                                        <i class="fas {{ $isPdf ? 'fa-file-pdf text-red-600' : 'fa-file-image text-blue-600' }}"></i>
                                    </div>
                                    <div class="min-w-0">
                                        <div class="font-medium text-gray-800 text-sm truncate">{{ $doc->nombre }}</div>
                                        <div class="text-xs text-gray-400 flex items-center gap-3 mt-0.5">
                                            <span class="px-2 py-0.5 bg-purple-100 text-purple-700 rounded-full text-[10px] font-semibold">{{ $tipos[$doc->tipo] ?? ucfirst($doc->tipo) }}</span>
                                            <span><i class="fas fa-calendar-alt mr-1"></i>{{ $doc->created_at->format('d/m/Y H:i') }}</span>
                                        </div>
                                        @if($doc->observaciones)
                                            <div class="text-xs text-gray-400 mt-1">{{ $doc->observaciones }}</div>
                                        @endif
                                    </div>
                                </div>
                                <div class="flex items-center gap-2 flex-shrink-0 ml-4">
                                    <a href="{{ asset('storage/' . $doc->archivo) }}" target="_blank" class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition" title="Ver">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ asset('storage/' . $doc->archivo) }}" download class="p-2 text-gray-600 hover:bg-gray-100 rounded-lg transition" title="Descargar">
                                        <i class="fas fa-download"></i>
                                    </a>
                                    <form action="{{ route('estudiantes.documentos.destroy', $doc) }}" method="POST" class="inline" onsubmit="return confirm('¿Eliminar este documento?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2 text-red-500 hover:bg-red-50 rounded-lg transition" title="Eliminar">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
