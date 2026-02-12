<x-app-layout>
    <x-slot name="header">Recibo {{ $pago->recibo }}</x-slot>

    <div class="max-w-3xl mx-auto">
        <div class="flex justify-end gap-3 mb-4">
            <a href="{{ route('pagos.recibo', $pago) }}" target="_blank" class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 rounded-lg font-semibold text-sm text-white hover:bg-blue-700 transition shadow-sm">
                <i class="fas fa-print"></i> Imprimir Recibo
            </a>
            @if($pago->estado === 'pagado')
                <form action="{{ route('pagos.destroy', $pago) }}" method="POST" onsubmit="return confirm('¿Anular este pago?')">
                    @csrf @method('DELETE')
                    <button type="submit" class="inline-flex items-center gap-2 px-4 py-2 bg-red-600 rounded-lg font-semibold text-sm text-white hover:bg-red-700 transition shadow-sm"><i class="fas fa-ban"></i> Anular Pago</button>
                </form>
            @endif
        </div>
            @if(session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">{{ session('success') }}</div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="text-center mb-6">
                    <h3 class="text-2xl font-bold text-gray-800">Recibo de Pago</h3>
                    <p class="text-gray-500">{{ $pago->recibo }}</p>
                    <span class="mt-2 inline-block px-3 py-1 text-sm rounded-full {{ $pago->estado === 'pagado' ? 'bg-green-100 text-green-800' : ($pago->estado === 'anulado' ? 'bg-red-100 text-red-800' : 'bg-amber-100 text-amber-800') }}">
                        {{ ucfirst($pago->estado) }}
                    </span>
                </div>

                <div class="grid grid-cols-2 gap-4 text-sm border-t pt-4">
                    <div><span class="text-gray-500">Estudiante:</span><br>
                        <a href="{{ route('estudiantes.show', $pago->estudiante) }}" class="font-medium text-indigo-600 hover:underline">{{ $pago->estudiante->nombre_completo }}</a>
                    </div>
                    <div><span class="text-gray-500">Grupo:</span><br><span class="font-medium">{{ $pago->matricula?->grupo?->nombre ?? '-' }}</span></div>
                    <div><span class="text-gray-500">Matrícula:</span><br>
                        <a href="{{ route('matriculas.show', $pago->matricula) }}" class="font-medium text-indigo-600 hover:underline">{{ $pago->matricula->codigo }}</a>
                    </div>
                    <div><span class="text-gray-500">Concepto:</span><br><span class="font-medium">{{ ucfirst($pago->concepto) }}</span></div>
                    @if($pago->mes)
                    <div><span class="text-gray-500">Mes:</span><br><span class="font-medium">{{ ucfirst($pago->mes) }}</span></div>
                    @endif
                    <div><span class="text-gray-500">Fecha de Pago:</span><br><span class="font-medium">{{ $pago->fecha_pago->format('d/m/Y') }}</span></div>
                    <div><span class="text-gray-500">Método:</span><br><span class="font-medium">{{ ucfirst($pago->metodo_pago) }}</span></div>
                    @if($pago->referencia_pago)
                    <div><span class="text-gray-500">Referencia:</span><br><span class="font-medium">{{ $pago->referencia_pago }}</span></div>
                    @endif
                </div>

                <div class="border-t mt-4 pt-4">
                    <div class="flex justify-between text-sm py-1">
                        <span class="text-gray-500">Valor:</span>
                        <span>${{ number_format($pago->valor, 0, ',', '.') }}</span>
                    </div>
                    @if($pago->descuento > 0)
                    <div class="flex justify-between text-sm py-1">
                        <span class="text-gray-500">Descuento:</span>
                        <span class="text-red-600">-${{ number_format($pago->descuento, 0, ',', '.') }}</span>
                    </div>
                    @endif
                    @if($pago->recargo > 0)
                    <div class="flex justify-between text-sm py-1">
                        <span class="text-gray-500">Recargo:</span>
                        <span class="text-amber-600">+${{ number_format($pago->recargo, 0, ',', '.') }}</span>
                    </div>
                    @endif
                    <div class="flex justify-between text-lg font-bold py-2 border-t mt-2">
                        <span>Total:</span>
                        <span class="text-green-600">${{ number_format($pago->total, 0, ',', '.') }}</span>
                    </div>
                </div>

                @if($pago->observaciones)
                    <div class="border-t mt-4 pt-4">
                        <span class="text-sm text-gray-500">Observaciones:</span>
                        <p class="text-sm mt-1">{{ $pago->observaciones }}</p>
                    </div>
                @endif

                <div class="mt-6 flex gap-3">
                    <a href="{{ route('matriculas.show', $pago->matricula) }}" class="text-sm text-indigo-600 hover:underline">Ver Matrícula</a>
                    <a href="{{ route('pagos.index') }}" class="text-sm text-gray-600 hover:underline">Volver a Pagos</a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
