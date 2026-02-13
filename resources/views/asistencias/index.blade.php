<x-app-layout>
    <x-slot name="header">Toma de Asistencia</x-slot>

    <div>
        @if(session('success'))
            <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">{{ session('success') }}</div>
        @endif

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
                    <label class="block text-xs font-medium text-gray-500 mb-1">Fecha</label>
                    <input type="date" name="fecha" value="{{ $fecha }}" class="border-gray-300 rounded-md shadow-sm text-sm focus:border-indigo-500 focus:ring-indigo-500" onchange="this.form.submit()">
                </div>
            </form>
        </div>

        @if($grupo && $estudiantes->count())
            <form action="{{ route('asistencias.store') }}" method="POST">
                @csrf
                <input type="hidden" name="grupo_id" value="{{ $grupo->id }}">
                <input type="hidden" name="fecha" value="{{ $fecha }}">

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-4 border-b bg-gray-50 flex justify-between items-center">
                        <div>
                            <span class="font-semibold text-gray-800">{{ $grupo->nombre }}</span>
                            <span class="text-sm text-gray-500 ml-2">{{ \Carbon\Carbon::parse($fecha)->translatedFormat('l, d \\d\\e F Y') }}</span>
                        </div>
                        <div class="flex gap-2 text-xs">
                            <button type="button" onclick="marcarTodos('presente')" class="px-3 py-1 bg-green-100 text-green-700 rounded-full hover:bg-green-200 transition">Todos Presentes</button>
                            <button type="button" onclick="marcarTodos('ausente')" class="px-3 py-1 bg-red-100 text-red-700 rounded-full hover:bg-red-200 transition">Todos Ausentes</button>
                        </div>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase w-8">#</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Estudiante</th>
                                    <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase">
                                        <span class="inline-flex items-center gap-1"><i class="fas fa-check-circle text-green-500"></i> Presente</span>
                                    </th>
                                    <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase">
                                        <span class="inline-flex items-center gap-1"><i class="fas fa-times-circle text-red-500"></i> Ausente</span>
                                    </th>
                                    <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase">
                                        <span class="inline-flex items-center gap-1"><i class="fas fa-clock text-amber-500"></i> Tardanza</span>
                                    </th>
                                    <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase">
                                        <span class="inline-flex items-center gap-1"><i class="fas fa-file-alt text-blue-500"></i> Excusa</span>
                                    </th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Obs.</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($estudiantes as $i => $est)
                                    @php $estadoActual = $asistencias[$est->id] ?? 'presente'; @endphp
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-4 py-2 text-sm text-gray-500">{{ $i + 1 }}</td>
                                        <td class="px-4 py-2">
                                            <div class="flex items-center gap-2">
                                                @if($est->foto)
                                                    <img src="{{ asset('storage/' . $est->foto) }}" class="h-8 w-8 rounded-full object-cover">
                                                @else
                                                    <div class="h-8 w-8 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 font-bold text-xs">
                                                        {{ strtoupper(substr($est->nombres, 0, 1) . substr($est->apellidos, 0, 1)) }}
                                                    </div>
                                                @endif
                                                <span class="text-sm font-medium">{{ $est->nombre_completo }}</span>
                                            </div>
                                        </td>
                                        @foreach(['presente', 'ausente', 'tardanza', 'excusa'] as $estado)
                                            <td class="px-4 py-2 text-center">
                                                <input type="radio" name="asistencia[{{ $est->id }}]" value="{{ $estado }}"
                                                    class="asist-radio-{{ $est->id }} text-{{ $estado == 'presente' ? 'green' : ($estado == 'ausente' ? 'red' : ($estado == 'tardanza' ? 'amber' : 'blue')) }}-600 focus:ring-indigo-500"
                                                    {{ $estadoActual == $estado ? 'checked' : '' }}>
                                            </td>
                                        @endforeach
                                        <td class="px-4 py-2">
                                            <input type="text" name="observaciones[{{ $est->id }}]" class="w-full border-gray-300 rounded text-xs py-1 px-2" placeholder="...">
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="p-4 border-t bg-gray-50 flex justify-between items-center">
                        <div class="text-sm text-gray-500">{{ $estudiantes->count() }} estudiantes</div>
                        <button type="submit" class="inline-flex items-center gap-2 px-6 py-2 bg-green-600 rounded-lg font-semibold text-sm text-white hover:bg-green-700 transition shadow-sm">
                            <i class="fas fa-save"></i> Guardar Asistencia
                        </button>
                    </div>
                </div>
            </form>
        @elseif($grupo)
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-8 text-center text-gray-500">
                <i class="fas fa-users text-4xl text-gray-300 mb-3"></i>
                <p>No hay estudiantes activos en este grupo.</p>
            </div>
        @else
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-8 text-center text-gray-500">
                <i class="fas fa-clipboard-list text-4xl text-gray-300 mb-3"></i>
                <p>Selecciona un grupo para tomar asistencia.</p>
            </div>
        @endif
    </div>

    <script>
        function marcarTodos(estado) {
            document.querySelectorAll('input[type="radio"][value="' + estado + '"]').forEach(r => r.checked = true);
        }
    </script>
</x-app-layout>
