<x-app-layout>
    <x-slot name="header">Registrar Pago</x-slot>

    <div class="max-w-3xl mx-auto">
            @if(session('error'))
                <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">{{ session('error') }}</div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form action="{{ route('pagos.store') }}" method="POST">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="md:col-span-2">
                            <x-input-label for="matricula_id" value="Matrícula *" />
                            <select id="matricula_id" name="matricula_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required onchange="actualizarInfoMatricula()">
                                <option value="">Seleccionar matrícula</option>
                                @foreach($matriculas as $mat)
                                    <option value="{{ $mat->id }}"
                                            data-pension="{{ $mat->valor_pension }}"
                                            data-matricula="{{ $mat->valor_matricula }}"
                                            {{ old('matricula_id', $matricula?->id) == $mat->id ? 'selected' : '' }}>
                                        {{ $mat->estudiante->nombre_completo }} - {{ $mat->estancia->nombre }} ({{ $mat->anio }}) [{{ $mat->codigo }}]
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('matricula_id')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="concepto" value="Concepto *" />
                            <select id="concepto" name="concepto" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required onchange="actualizarValorConcepto()">
                                <option value="">Seleccionar</option>
                                <option value="matricula" {{ old('concepto') == 'matricula' ? 'selected' : '' }}>Matrícula</option>
                                <option value="pension" {{ old('concepto') == 'pension' ? 'selected' : '' }}>Pensión</option>
                                <option value="material" {{ old('concepto') == 'material' ? 'selected' : '' }}>Material</option>
                                <option value="otro" {{ old('concepto') == 'otro' ? 'selected' : '' }}>Otro</option>
                            </select>
                            <x-input-error :messages="$errors->get('concepto')" class="mt-2" />
                        </div>

                        <div id="mesContainer">
                            <x-input-label for="mes" value="Mes (para pensión)" />
                            <select id="mes" name="mes" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="">Seleccionar</option>
                                @foreach(['enero','febrero','marzo','abril','mayo','junio','julio','agosto','septiembre','octubre','noviembre','diciembre'] as $m)
                                    <option value="{{ $m }}" {{ old('mes') == $m ? 'selected' : '' }}>{{ ucfirst($m) }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <x-input-label for="valor" value="Valor *" />
                            <x-text-input id="valor" name="valor" type="number" step="0.01" class="mt-1 block w-full" :value="old('valor', 0)" required />
                            <x-input-error :messages="$errors->get('valor')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="descuento" value="Descuento" />
                            <x-text-input id="descuento" name="descuento" type="number" step="0.01" class="mt-1 block w-full" :value="old('descuento', 0)" />
                        </div>

                        <div>
                            <x-input-label for="recargo" value="Recargo" />
                            <x-text-input id="recargo" name="recargo" type="number" step="0.01" class="mt-1 block w-full" :value="old('recargo', 0)" />
                        </div>

                        <div>
                            <x-input-label for="metodo_pago" value="Método de Pago *" />
                            <select id="metodo_pago" name="metodo_pago" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                <option value="efectivo" {{ old('metodo_pago') == 'efectivo' ? 'selected' : '' }}>Efectivo</option>
                                <option value="transferencia" {{ old('metodo_pago') == 'transferencia' ? 'selected' : '' }}>Transferencia</option>
                                <option value="tarjeta" {{ old('metodo_pago') == 'tarjeta' ? 'selected' : '' }}>Tarjeta</option>
                                <option value="nequi" {{ old('metodo_pago') == 'nequi' ? 'selected' : '' }}>Nequi</option>
                                <option value="daviplata" {{ old('metodo_pago') == 'daviplata' ? 'selected' : '' }}>Daviplata</option>
                            </select>
                            <x-input-error :messages="$errors->get('metodo_pago')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="referencia_pago" value="Referencia de Pago" />
                            <x-text-input id="referencia_pago" name="referencia_pago" type="text" class="mt-1 block w-full" :value="old('referencia_pago')" placeholder="Nro. comprobante..." />
                        </div>

                        <div>
                            <x-input-label for="fecha_pago" value="Fecha de Pago *" />
                            <x-text-input id="fecha_pago" name="fecha_pago" type="date" class="mt-1 block w-full" :value="old('fecha_pago', now()->format('Y-m-d'))" required />
                            <x-input-error :messages="$errors->get('fecha_pago')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="fecha_vencimiento" value="Fecha Vencimiento" />
                            <x-text-input id="fecha_vencimiento" name="fecha_vencimiento" type="date" class="mt-1 block w-full" :value="old('fecha_vencimiento')" />
                        </div>

                        <div class="md:col-span-2">
                            <x-input-label for="observaciones" value="Observaciones" />
                            <textarea id="observaciones" name="observaciones" rows="2" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('observaciones') }}</textarea>
                        </div>
                    </div>

                    <div class="flex items-center gap-4 mt-6">
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 transition">Registrar Pago</button>
                        <a href="{{ route('pagos.index') }}" class="text-sm text-gray-600 hover:underline">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function actualizarInfoMatricula() {
            const select = document.getElementById('matricula_id');
            const option = select.options[select.selectedIndex];
            // Store data for use when concept changes
            window.matriculaData = {
                pension: parseFloat(option.dataset.pension) || 0,
                matricula: parseFloat(option.dataset.matricula) || 0,
            };
            actualizarValorConcepto();
        }

        function actualizarValorConcepto() {
            const concepto = document.getElementById('concepto').value;
            const data = window.matriculaData || {};
            if (concepto === 'pension' && data.pension) {
                document.getElementById('valor').value = data.pension;
            } else if (concepto === 'matricula' && data.matricula) {
                document.getElementById('valor').value = data.matricula;
            }
        }

        document.addEventListener('DOMContentLoaded', actualizarInfoMatricula);
    </script>
</x-app-layout>
