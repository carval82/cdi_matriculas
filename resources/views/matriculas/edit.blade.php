<x-app-layout>
    <x-slot name="header">Editar Matrícula: {{ $matricula->codigo }}</x-slot>

    <div class="max-w-3xl mx-auto">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form action="{{ route('matriculas.update', $matricula) }}" method="POST">
                    @csrf @method('PUT')
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="md:col-span-2">
                            <x-input-label value="Estudiante" />
                            <p class="mt-1 text-sm font-medium text-gray-800">{{ $matricula->estudiante->nombre_completo }}</p>
                        </div>

                        <div>
                            <x-input-label for="estancia_id" value="Estancia *" />
                            <select id="estancia_id" name="estancia_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                @foreach($estancias as $est)
                                    <option value="{{ $est->id }}" {{ old('estancia_id', $matricula->estancia_id) == $est->id ? 'selected' : '' }}>{{ $est->nombre }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <x-input-label for="acudiente_id" value="Acudiente *" />
                            <select id="acudiente_id" name="acudiente_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                @foreach($acudientes as $acu)
                                    <option value="{{ $acu->id }}" {{ old('acudiente_id', $matricula->acudiente_id) == $acu->id ? 'selected' : '' }}>{{ $acu->nombre_completo }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <x-input-label for="valor_matricula" value="Valor Matrícula *" />
                            <x-text-input id="valor_matricula" name="valor_matricula" type="number" step="0.01" class="mt-1 block w-full" :value="old('valor_matricula', $matricula->valor_matricula)" required />
                        </div>

                        <div>
                            <x-input-label for="valor_pension" value="Valor Pensión *" />
                            <x-text-input id="valor_pension" name="valor_pension" type="number" step="0.01" class="mt-1 block w-full" :value="old('valor_pension', $matricula->valor_pension)" required />
                        </div>

                        <div>
                            <x-input-label for="descuento" value="Descuento" />
                            <x-text-input id="descuento" name="descuento" type="number" step="0.01" class="mt-1 block w-full" :value="old('descuento', $matricula->descuento)" />
                        </div>

                        <div>
                            <x-input-label for="tipo_descuento" value="Tipo Descuento" />
                            <select id="tipo_descuento" name="tipo_descuento" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="">Ninguno</option>
                                @foreach(['hermano','becado','empleado','otro'] as $t)
                                    <option value="{{ $t }}" {{ old('tipo_descuento', $matricula->tipo_descuento) == $t ? 'selected' : '' }}>{{ ucfirst($t) }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <x-input-label for="jornada" value="Jornada" />
                            <select id="jornada" name="jornada" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="completa" {{ old('jornada', $matricula->jornada) == 'completa' ? 'selected' : '' }}>Completa</option>
                                <option value="mañana" {{ old('jornada', $matricula->jornada) == 'mañana' ? 'selected' : '' }}>Mañana</option>
                                <option value="tarde" {{ old('jornada', $matricula->jornada) == 'tarde' ? 'selected' : '' }}>Tarde</option>
                            </select>
                        </div>

                        <div>
                            <x-input-label for="estado" value="Estado" />
                            <select id="estado" name="estado" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="activa" {{ old('estado', $matricula->estado) == 'activa' ? 'selected' : '' }}>Activa</option>
                                <option value="cancelada" {{ old('estado', $matricula->estado) == 'cancelada' ? 'selected' : '' }}>Cancelada</option>
                                <option value="finalizada" {{ old('estado', $matricula->estado) == 'finalizada' ? 'selected' : '' }}>Finalizada</option>
                                <option value="suspendida" {{ old('estado', $matricula->estado) == 'suspendida' ? 'selected' : '' }}>Suspendida</option>
                            </select>
                        </div>

                        <div class="md:col-span-2">
                            <x-input-label for="observaciones" value="Observaciones" />
                            <textarea id="observaciones" name="observaciones" rows="3" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('observaciones', $matricula->observaciones) }}</textarea>
                        </div>
                    </div>

                    <div class="flex items-center gap-4 mt-6">
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 transition">Actualizar</button>
                        <a href="{{ route('matriculas.show', $matricula) }}" class="text-sm text-gray-600 hover:underline">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
