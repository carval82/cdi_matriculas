<x-app-layout>
    <x-slot name="header">Nueva Matrícula</x-slot>

    <div class="max-w-3xl mx-auto">
            @if(session('error'))
                <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">{{ session('error') }}</div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form action="{{ route('matriculas.store') }}" method="POST">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="md:col-span-2">
                            <x-input-label for="estudiante_id" value="Estudiante *" />
                            <select id="estudiante_id" name="estudiante_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                <option value="">Seleccionar estudiante</option>
                                @foreach($estudiantes as $est)
                                    <option value="{{ $est->id }}" {{ old('estudiante_id', $estudiantePreseleccionado?->id) == $est->id ? 'selected' : '' }}>
                                        {{ $est->nombre_completo }} - {{ $est->documento ?? $est->codigo }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('estudiante_id')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="estancia_id" value="Estancia *" />
                            <select id="estancia_id" name="estancia_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required onchange="actualizarValores()">
                                <option value="">Seleccionar</option>
                                @foreach($estancias as $est)
                                    <option value="{{ $est->id }}" 
                                            data-matricula="{{ $est->valor_matricula }}" 
                                            data-pension="{{ $est->valor_pension }}"
                                            {{ old('estancia_id', $estudiantePreseleccionado?->estancia_id) == $est->id ? 'selected' : '' }}>
                                        {{ $est->nombre }} ({{ $est->cuposDisponibles() }} cupos)
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('estancia_id')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="acudiente_id" value="Acudiente Responsable *" />
                            <select id="acudiente_id" name="acudiente_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                <option value="">Seleccionar</option>
                                @foreach($acudientes as $acu)
                                    <option value="{{ $acu->id }}" {{ old('acudiente_id', $estudiantePreseleccionado?->acudiente_id) == $acu->id ? 'selected' : '' }}>
                                        {{ $acu->nombre_completo }} - {{ $acu->documento }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('acudiente_id')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="anio" value="Año *" />
                            <x-text-input id="anio" name="anio" type="number" class="mt-1 block w-full" :value="old('anio', now()->year)" required min="2020" />
                            <x-input-error :messages="$errors->get('anio')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="periodo" value="Periodo" />
                            <select id="periodo" name="periodo" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="anual" {{ old('periodo') == 'anual' ? 'selected' : '' }}>Anual</option>
                                <option value="semestre1" {{ old('periodo') == 'semestre1' ? 'selected' : '' }}>Semestre 1</option>
                                <option value="semestre2" {{ old('periodo') == 'semestre2' ? 'selected' : '' }}>Semestre 2</option>
                            </select>
                        </div>

                        <div>
                            <x-input-label for="fecha_matricula" value="Fecha Matrícula *" />
                            <x-text-input id="fecha_matricula" name="fecha_matricula" type="date" class="mt-1 block w-full" :value="old('fecha_matricula', now()->format('Y-m-d'))" required />
                            <x-input-error :messages="$errors->get('fecha_matricula')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="jornada" value="Jornada" />
                            <select id="jornada" name="jornada" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="completa" {{ old('jornada') == 'completa' ? 'selected' : '' }}>Completa</option>
                                <option value="mañana" {{ old('jornada') == 'mañana' ? 'selected' : '' }}>Mañana</option>
                                <option value="tarde" {{ old('jornada') == 'tarde' ? 'selected' : '' }}>Tarde</option>
                            </select>
                        </div>

                        <div>
                            <x-input-label for="valor_matricula" value="Valor Matrícula *" />
                            <x-text-input id="valor_matricula" name="valor_matricula" type="number" step="0.01" class="mt-1 block w-full" :value="old('valor_matricula', 0)" required />
                            <x-input-error :messages="$errors->get('valor_matricula')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="valor_pension" value="Valor Pensión Mensual *" />
                            <x-text-input id="valor_pension" name="valor_pension" type="number" step="0.01" class="mt-1 block w-full" :value="old('valor_pension', 0)" required />
                            <x-input-error :messages="$errors->get('valor_pension')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="descuento" value="Descuento" />
                            <x-text-input id="descuento" name="descuento" type="number" step="0.01" class="mt-1 block w-full" :value="old('descuento', 0)" />
                        </div>

                        <div>
                            <x-input-label for="tipo_descuento" value="Tipo Descuento" />
                            <select id="tipo_descuento" name="tipo_descuento" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="">Ninguno</option>
                                <option value="hermano" {{ old('tipo_descuento') == 'hermano' ? 'selected' : '' }}>Hermano</option>
                                <option value="becado" {{ old('tipo_descuento') == 'becado' ? 'selected' : '' }}>Becado</option>
                                <option value="empleado" {{ old('tipo_descuento') == 'empleado' ? 'selected' : '' }}>Empleado</option>
                                <option value="otro" {{ old('tipo_descuento') == 'otro' ? 'selected' : '' }}>Otro</option>
                            </select>
                        </div>

                        <div class="md:col-span-2">
                            <x-input-label for="observaciones" value="Observaciones" />
                            <textarea id="observaciones" name="observaciones" rows="3" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('observaciones') }}</textarea>
                        </div>
                    </div>

                    <div class="flex items-center gap-4 mt-6">
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 transition">Registrar Matrícula</button>
                        <a href="{{ route('matriculas.index') }}" class="text-sm text-gray-600 hover:underline">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function actualizarValores() {
            const select = document.getElementById('estancia_id');
            const option = select.options[select.selectedIndex];
            if (option.value) {
                document.getElementById('valor_matricula').value = option.dataset.matricula || 0;
                document.getElementById('valor_pension').value = option.dataset.pension || 0;
            }
        }
        // Auto-fill on load if estancia is preselected
        document.addEventListener('DOMContentLoaded', actualizarValores);
    </script>
</x-app-layout>
