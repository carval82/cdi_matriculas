<x-app-layout>
    <x-slot name="header">Conceptos Evaluativos</x-slot>

    <div class="space-y-6">
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">{{ session('success') }}</div>
        @endif

        {{-- Formulario crear --}}
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
            <h3 class="font-semibold text-gray-800 mb-4"><i class="fas fa-plus-circle text-indigo-500 mr-1"></i> Nuevo Concepto Evaluativo</h3>
            <form action="{{ route('conceptos.store') }}" method="POST">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-4 gap-3 items-end">
                    <div class="md:col-span-2">
                        <x-input-label for="nombre" value="Nombre / Dimensión *" />
                        <x-text-input id="nombre" name="nombre" type="text" class="mt-1 block w-full" placeholder="Ej: Dimensión Cognitiva" required />
                        <x-input-error :messages="$errors->get('nombre')" class="mt-2" />
                    </div>
                    <div>
                        <x-input-label for="descripcion" value="Descripción" />
                        <x-text-input id="descripcion" name="descripcion" type="text" class="mt-1 block w-full" placeholder="Opcional" />
                    </div>
                    <div>
                        <x-input-label for="orden" value="Orden" />
                        <div class="flex gap-2">
                            <x-text-input id="orden" name="orden" type="number" class="mt-1 block w-20" value="0" />
                            <button type="submit" class="mt-1 inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase hover:bg-indigo-700 transition">
                                <i class="fas fa-save mr-1"></i> Crear
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        {{-- Lista --}}
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-4 border-b bg-gray-50">
                <span class="font-semibold text-gray-800">Conceptos Registrados ({{ $conceptos->count() }})</span>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase w-12">Orden</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nombre</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Descripción</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase w-20">Estado</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase w-32">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($conceptos as $c)
                            <tr class="hover:bg-gray-50" id="row-{{ $c->id }}">
                                <td class="px-4 py-3 text-sm text-gray-500">{{ $c->orden }}</td>
                                <td class="px-4 py-3">
                                    <span class="font-medium text-gray-800" id="nombre-{{ $c->id }}">{{ $c->nombre }}</span>
                                </td>
                                <td class="px-4 py-3 text-sm text-gray-500">{{ $c->descripcion ?? '—' }}</td>
                                <td class="px-4 py-3">
                                    <span class="px-2 py-0.5 text-xs rounded-full {{ $c->activo ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $c->activo ? 'Activo' : 'Inactivo' }}
                                    </span>
                                </td>
                                <td class="px-4 py-3">
                                    <div class="flex gap-2">
                                        <button type="button" onclick="editarConcepto({{ $c->id }}, '{{ addslashes($c->nombre) }}', '{{ addslashes($c->descripcion) }}', {{ $c->orden }}, {{ $c->activo ? 'true' : 'false' }})"
                                            class="text-amber-600 hover:text-amber-800 text-sm" title="Editar">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <form action="{{ route('conceptos.destroy', $c) }}" method="POST" onsubmit="return confirm('¿Eliminar este concepto? Se eliminarán todas las evaluaciones asociadas.')" class="inline">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-800 text-sm" title="Eliminar">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="px-4 py-8 text-center text-gray-500">No hay conceptos evaluativos. Crea el primero arriba.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Sugerencias --}}
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
            <h3 class="font-semibold text-gray-800 mb-3"><i class="fas fa-lightbulb text-amber-500 mr-1"></i> Sugerencias de Dimensiones (Primera Infancia)</h3>
            <div class="grid grid-cols-2 md:grid-cols-3 gap-2 text-sm">
                @foreach([
                    'Dimensión Cognitiva' => 'Pensamiento lógico, resolución de problemas, exploración',
                    'Dimensión Comunicativa' => 'Lenguaje oral, expresión, comprensión lectora',
                    'Dimensión Corporal' => 'Motricidad fina y gruesa, coordinación, esquema corporal',
                    'Dimensión Socio-afectiva' => 'Relaciones interpersonales, emociones, autonomía',
                    'Dimensión Estética' => 'Creatividad, expresión artística, sensibilidad',
                    'Dimensión Ética' => 'Valores, normas de convivencia, respeto',
                    'Dimensión Espiritual' => 'Sentido de trascendencia, identidad cultural',
                    'Autonomía e Independencia' => 'Hábitos, autocuidado, toma de decisiones',
                    'Convivencia' => 'Trabajo en equipo, resolución de conflictos',
                ] as $nombre => $desc)
                    <div class="p-2 bg-gray-50 rounded-lg border text-xs">
                        <span class="font-semibold text-gray-700">{{ $nombre }}</span>
                        <p class="text-gray-400 mt-0.5">{{ $desc }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    {{-- Modal editar --}}
    <div id="modal-editar" class="fixed inset-0 bg-black/50 z-50 flex items-center justify-center" style="display:none;">
        <div class="bg-white rounded-2xl shadow-2xl p-6 w-full max-w-md mx-4">
            <h3 class="font-semibold text-gray-800 mb-4">Editar Concepto</h3>
            <form id="form-editar" method="POST">
                @csrf @method('PUT')
                <div class="space-y-3">
                    <div>
                        <x-input-label value="Nombre *" />
                        <x-text-input id="edit-nombre" name="nombre" type="text" class="mt-1 block w-full" required />
                    </div>
                    <div>
                        <x-input-label value="Descripción" />
                        <x-text-input id="edit-descripcion" name="descripcion" type="text" class="mt-1 block w-full" />
                    </div>
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <x-input-label value="Orden" />
                            <x-text-input id="edit-orden" name="orden" type="number" class="mt-1 block w-full" />
                        </div>
                        <div>
                            <x-input-label value="Estado" />
                            <select id="edit-activo" name="activo" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                                <option value="1">Activo</option>
                                <option value="0">Inactivo</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="flex gap-3 mt-5">
                    <button type="submit" class="flex-1 px-4 py-2 bg-indigo-600 text-white rounded-lg font-semibold text-sm hover:bg-indigo-700 transition">Guardar</button>
                    <button type="button" onclick="document.getElementById('modal-editar').style.display='none'" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg font-semibold text-sm hover:bg-gray-300 transition">Cancelar</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function editarConcepto(id, nombre, desc, orden, activo) {
            document.getElementById('form-editar').action = '/conceptos-evaluativos/' + id;
            document.getElementById('edit-nombre').value = nombre;
            document.getElementById('edit-descripcion').value = desc;
            document.getElementById('edit-orden').value = orden;
            document.getElementById('edit-activo').value = activo ? '1' : '0';
            document.getElementById('modal-editar').style.display = 'flex';
        }
    </script>
</x-app-layout>
