<x-app-layout>
    <x-slot name="header">Pagos</x-slot>

    <div>
            @if(session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">{{ session('success') }}</div>
            @endif

            <!-- Filtros -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-4 mb-4">
                <form method="GET" class="flex flex-wrap gap-3 items-end">
                    <div class="flex-1 min-w-[200px]">
                        <x-input-label for="buscar" value="Buscar estudiante" />
                        <x-text-input id="buscar" name="buscar" type="text" class="mt-1 block w-full" :value="request('buscar')" placeholder="Nombre..." />
                    </div>
                    <div>
                        <x-input-label for="concepto" value="Concepto" />
                        <select name="concepto" id="concepto" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="">Todos</option>
                            <option value="matricula" {{ request('concepto') == 'matricula' ? 'selected' : '' }}>Matrícula</option>
                            <option value="pension" {{ request('concepto') == 'pension' ? 'selected' : '' }}>Pensión</option>
                            <option value="material" {{ request('concepto') == 'material' ? 'selected' : '' }}>Material</option>
                            <option value="otro" {{ request('concepto') == 'otro' ? 'selected' : '' }}>Otro</option>
                        </select>
                    </div>
                    <div>
                        <x-input-label for="estado" value="Estado" />
                        <select name="estado" id="estado" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="">Todos</option>
                            <option value="pagado" {{ request('estado') == 'pagado' ? 'selected' : '' }}>Pagado</option>
                            <option value="pendiente" {{ request('estado') == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                            <option value="anulado" {{ request('estado') == 'anulado' ? 'selected' : '' }}>Anulado</option>
                        </select>
                    </div>
                    <div class="flex gap-2">
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 transition">Filtrar</button>
                        <a href="{{ route('pagos.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-300 transition">Limpiar</a>
                    </div>
                </form>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Recibo</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Estudiante</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Grupo</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Concepto</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Mes</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Total</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Método</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Fecha</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Estado</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($pagos as $pago)
                                <tr>
                                    <td class="px-4 py-3 text-sm font-mono">{{ $pago->recibo }}</td>
                                    <td class="px-4 py-3 text-sm font-medium">{{ $pago->estudiante->nombre_completo }}</td>
                                    <td class="px-4 py-3 text-sm">{{ $pago->matricula?->grupo?->nombre ?? '-' }}</td>
                                    <td class="px-4 py-3 text-sm">{{ ucfirst($pago->concepto) }}</td>
                                    <td class="px-4 py-3 text-sm">{{ $pago->mes ? ucfirst($pago->mes) : '-' }}</td>
                                    <td class="px-4 py-3 text-sm font-medium">${{ number_format($pago->total, 0, ',', '.') }}</td>
                                    <td class="px-4 py-3 text-sm">{{ ucfirst($pago->metodo_pago) }}</td>
                                    <td class="px-4 py-3 text-sm">{{ $pago->fecha_pago->format('d/m/Y') }}</td>
                                    <td class="px-4 py-3 text-sm">
                                        <span class="px-2 py-0.5 text-xs rounded-full {{ $pago->estado === 'pagado' ? 'bg-green-100 text-green-800' : ($pago->estado === 'anulado' ? 'bg-red-100 text-red-800' : 'bg-amber-100 text-amber-800') }}">
                                            {{ ucfirst($pago->estado) }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 text-sm">
                                        <a href="{{ route('pagos.show', $pago) }}" class="text-indigo-600 hover:underline">Ver</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="10" class="px-4 py-6 text-center text-gray-500">No se encontraron pagos.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="p-4">{{ $pagos->links() }}</div>
            </div>
    </div>
</x-app-layout>
