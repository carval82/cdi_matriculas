<x-app-layout>
    <x-slot name="header">Backup y Restauración</x-slot>

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
        {{-- Panel izquierdo: Acciones --}}
        <div class="space-y-6">
            {{-- Crear Backup --}}
            <div class="bg-white rounded-2xl shadow-sm p-6">
                <h2 class="text-lg font-bold text-gray-800 flex items-center gap-2 mb-4">
                    <div class="w-8 h-8 bg-blue-500 rounded-lg flex items-center justify-center">
                        <i class="fas fa-database text-white text-sm"></i>
                    </div>
                    Crear Backup
                </h2>
                <p class="text-sm text-gray-500 mb-4">
                    Genera una copia de seguridad completa de la base de datos (estructura + datos).
                </p>
                <form action="{{ route('backup.create') }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-4 rounded-xl transition flex items-center justify-center gap-2">
                        <i class="fas fa-download"></i> Generar Backup Ahora
                    </button>
                </form>
            </div>

            {{-- Restaurar desde archivo --}}
            <div class="bg-white rounded-2xl shadow-sm p-6">
                <h2 class="text-lg font-bold text-gray-800 flex items-center gap-2 mb-4">
                    <div class="w-8 h-8 bg-amber-500 rounded-lg flex items-center justify-center">
                        <i class="fas fa-upload text-white text-sm"></i>
                    </div>
                    Restaurar desde Archivo
                </h2>
                <p class="text-sm text-gray-500 mb-4">
                    Sube un archivo <strong>.sql</strong> para restaurar la base de datos.
                </p>
                <form action="{{ route('backup.restore') }}" method="POST" enctype="multipart/form-data" onsubmit="return confirm('⚠️ ADVERTENCIA: Esto reemplazará TODOS los datos actuales. ¿Estás seguro?')">
                    @csrf
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Archivo SQL</label>
                        <input type="file" name="backup_file" accept=".sql" required
                               class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-amber-50 file:text-amber-700 hover:file:bg-amber-100 cursor-pointer">
                    </div>
                    <button type="submit" class="w-full bg-amber-500 hover:bg-amber-600 text-white font-semibold py-3 px-4 rounded-xl transition flex items-center justify-center gap-2">
                        <i class="fas fa-upload"></i> Restaurar Base de Datos
                    </button>
                </form>
            </div>

            {{-- Info --}}
            <div class="bg-gradient-to-br from-blue-50 to-indigo-50 rounded-2xl p-5 border border-blue-100">
                <h3 class="font-semibold text-blue-800 flex items-center gap-2 mb-3">
                    <i class="fas fa-info-circle"></i> Información
                </h3>
                <ul class="text-sm text-blue-700 space-y-2">
                    <li class="flex items-start gap-2">
                        <i class="fas fa-check text-blue-500 mt-0.5 text-xs"></i>
                        Los backups incluyen estructura y datos completos.
                    </li>
                    <li class="flex items-start gap-2">
                        <i class="fas fa-check text-blue-500 mt-0.5 text-xs"></i>
                        Se almacenan en <code class="bg-blue-100 px-1 rounded">storage/app/backups/</code>
                    </li>
                    <li class="flex items-start gap-2">
                        <i class="fas fa-check text-blue-500 mt-0.5 text-xs"></i>
                        Restaurar reemplaza todos los datos actuales.
                    </li>
                    <li class="flex items-start gap-2">
                        <i class="fas fa-exclamation-triangle text-amber-500 mt-0.5 text-xs"></i>
                        Crea un backup antes de restaurar.
                    </li>
                </ul>
            </div>
        </div>

        {{-- Panel derecho: Lista de backups --}}
        <div class="lg:col-span-2">
            <div class="bg-white rounded-2xl shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b bg-gray-50 flex items-center justify-between">
                    <h2 class="text-lg font-bold text-gray-800 flex items-center gap-2">
                        <i class="fas fa-history text-gray-500"></i> Backups Disponibles
                    </h2>
                    <span class="text-sm text-gray-500">{{ count($backups) }} archivo(s)</span>
                </div>

                @if(count($backups) === 0)
                    <div class="p-12 text-center">
                        <div class="w-16 h-16 bg-gray-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-inbox text-gray-400 text-2xl"></i>
                        </div>
                        <p class="text-gray-500 font-medium">No hay backups disponibles</p>
                        <p class="text-gray-400 text-sm mt-1">Genera tu primer backup con el botón de la izquierda.</p>
                    </div>
                @else
                    <div class="divide-y">
                        @foreach($backups as $backup)
                            <div class="px-6 py-4 flex items-center justify-between hover:bg-gray-50 transition">
                                <div class="flex items-center gap-4 min-w-0 flex-1">
                                    <div class="w-10 h-10 bg-indigo-100 rounded-xl flex items-center justify-center flex-shrink-0">
                                        <i class="fas fa-file-code text-indigo-600"></i>
                                    </div>
                                    <div class="min-w-0">
                                        <div class="font-medium text-gray-800 truncate text-sm">{{ $backup['filename'] }}</div>
                                        <div class="text-xs text-gray-400 flex items-center gap-3 mt-0.5">
                                            <span><i class="fas fa-calendar-alt mr-1"></i>{{ $backup['date'] }}</span>
                                            <span><i class="fas fa-weight-hanging mr-1"></i>{{ $backup['size'] }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex items-center gap-2 flex-shrink-0 ml-4">
                                    {{-- Restaurar --}}
                                    <form action="{{ route('backup.restore') }}" method="POST" class="inline"
                                          onsubmit="return confirm('⚠️ ADVERTENCIA: Esto reemplazará TODOS los datos actuales con este backup.\n\nArchivo: {{ $backup['filename'] }}\n\n¿Estás seguro?')">
                                        @csrf
                                        <input type="hidden" name="filename" value="{{ $backup['filename'] }}">
                                        <button type="submit" class="p-2 text-amber-600 hover:bg-amber-50 rounded-lg transition" title="Restaurar">
                                            <i class="fas fa-undo"></i>
                                        </button>
                                    </form>
                                    {{-- Descargar --}}
                                    <a href="{{ route('backup.download', $backup['filename']) }}" class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition" title="Descargar">
                                        <i class="fas fa-download"></i>
                                    </a>
                                    {{-- Eliminar --}}
                                    <form action="{{ route('backup.destroy', $backup['filename']) }}" method="POST" class="inline"
                                          onsubmit="return confirm('¿Eliminar este backup?\n{{ $backup['filename'] }}')">
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
