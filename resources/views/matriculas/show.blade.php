<x-app-layout>
    <x-slot name="header">Matrícula {{ $matricula->codigo }}</x-slot>

    <div class="space-y-6">
        <div class="flex justify-end gap-2 flex-wrap">
            <a href="{{ route('matriculas.print', $matricula) }}" target="_blank" class="inline-flex items-center gap-2 px-4 py-2 bg-indigo-600 rounded-lg font-semibold text-sm text-white hover:bg-indigo-700 transition shadow-sm"><i class="fas fa-print"></i> Imprimir Matrícula</a>
            <a href="{{ route('estudiantes.documentos', $matricula->estudiante) }}" class="inline-flex items-center gap-2 px-4 py-2 bg-purple-600 rounded-lg font-semibold text-sm text-white hover:bg-purple-700 transition shadow-sm"><i class="fas fa-folder-open"></i> Documentos</a>
            <a href="{{ route('pagos.create', ['matricula_id' => $matricula->id]) }}" class="inline-flex items-center gap-2 px-4 py-2 bg-green-600 rounded-lg font-semibold text-sm text-white hover:bg-green-700 transition shadow-sm"><i class="fas fa-money-bill-wave"></i> Registrar Pago</a>
            <a href="{{ route('matriculas.edit', $matricula) }}" class="inline-flex items-center gap-2 px-4 py-2 bg-amber-500 rounded-lg font-semibold text-sm text-white hover:bg-amber-600 transition shadow-sm"><i class="fas fa-edit"></i> Editar</a>
        </div>
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">{{ session('success') }}</div>
            @endif

            <!-- Info matrícula -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
                    <div><span class="text-gray-500">Estudiante:</span><br>
                        <a href="{{ route('estudiantes.show', $matricula->estudiante) }}" class="font-medium text-indigo-600 hover:underline">{{ $matricula->estudiante->nombre_completo }}</a>
                    </div>
                    <div><span class="text-gray-500">Grupo:</span><br><span class="font-medium">{{ $matricula->grupo->nombre }}</span></div>
                    <div><span class="text-gray-500">Año:</span><br><span class="font-medium">{{ $matricula->anio }} - {{ ucfirst($matricula->periodo) }}</span></div>
                    <div><span class="text-gray-500">Jornada:</span><br><span class="font-medium">{{ ucfirst($matricula->jornada) }}</span></div>
                    <div><span class="text-gray-500">Fecha Matrícula:</span><br><span class="font-medium">{{ $matricula->fecha_matricula->format('d/m/Y') }}</span></div>
                    <div><span class="text-gray-500">Valor Matrícula:</span><br><span class="font-medium text-green-600">${{ number_format($matricula->valor_matricula, 0, ',', '.') }}</span></div>
                    <div><span class="text-gray-500">Pensión Mensual:</span><br><span class="font-medium text-green-600">${{ number_format($matricula->valor_pension, 0, ',', '.') }}</span></div>
                    <div><span class="text-gray-500">Estado:</span><br>
                        <span class="px-2 py-0.5 text-xs rounded-full {{ $matricula->estado === 'activa' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">{{ ucfirst($matricula->estado) }}</span>
                    </div>
                    @if($matricula->descuento > 0)
                    <div><span class="text-gray-500">Descuento:</span><br><span class="font-medium text-amber-600">${{ number_format($matricula->descuento, 0, ',', '.') }} ({{ $matricula->tipo_descuento }})</span></div>
                    @endif
                    <div><span class="text-gray-500">Acudiente:</span><br>
                        <a href="{{ route('acudientes.show', $matricula->acudiente) }}" class="font-medium text-indigo-600 hover:underline">{{ $matricula->acudiente->nombre_completo }}</a>
                    </div>
                </div>
                @if($matricula->observaciones)
                    <p class="mt-4 text-sm text-gray-600">{{ $matricula->observaciones }}</p>
                @endif
            </div>

            <!-- PDF Firmado -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-3"><i class="fas fa-file-pdf text-red-500 mr-1"></i> Matrícula Firmada (PDF)</h3>
                @if($matricula->pdf_firmado)
                    <div class="flex items-center gap-4 p-4 bg-green-50 border border-green-200 rounded-lg">
                        <i class="fas fa-file-pdf text-red-500 text-2xl"></i>
                        <div class="flex-1">
                            <p class="font-medium text-gray-800">PDF firmado cargado</p>
                            <p class="text-sm text-gray-500">{{ basename($matricula->pdf_firmado) }}</p>
                        </div>
                        <a href="{{ asset('storage/' . $matricula->pdf_firmado) }}" target="_blank" class="px-4 py-2 bg-blue-600 text-white rounded-lg text-sm font-semibold hover:bg-blue-700 transition"><i class="fas fa-eye mr-1"></i> Ver</a>
                        <a href="{{ asset('storage/' . $matricula->pdf_firmado) }}" download class="px-4 py-2 bg-gray-600 text-white rounded-lg text-sm font-semibold hover:bg-gray-700 transition"><i class="fas fa-download mr-1"></i> Descargar</a>
                    </div>
                @endif
                <form action="{{ route('matriculas.uploadPdf', $matricula) }}" method="POST" enctype="multipart/form-data" class="mt-3 flex items-end gap-3">
                    @csrf
                    <div class="flex-1">
                        <label class="block text-sm font-medium text-gray-700 mb-1">{{ $matricula->pdf_firmado ? 'Reemplazar PDF' : 'Subir PDF firmado' }}</label>
                        <input type="file" name="pdf_firmado" accept=".pdf" required class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                    </div>
                    <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-lg text-sm font-semibold hover:bg-indigo-700 transition whitespace-nowrap"><i class="fas fa-upload mr-1"></i> Subir PDF</button>
                </form>
            </div>

            <!-- Estado de pensiones -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Estado de Pensiones {{ $matricula->anio }}</h3>
                <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-3">
                    @foreach($pensionesEstado as $mes => $estado)
                        <div class="border rounded-lg p-3 text-center {{ $estado === 'pagado' ? 'bg-green-50 border-green-300' : ($estado === 'vencido' ? 'bg-red-50 border-red-300' : 'bg-gray-50 border-gray-200') }}">
                            <div class="text-xs font-semibold text-gray-600">{{ $mes }}</div>
                            <div class="mt-1">
                                @if($estado === 'pagado')
                                    <span class="text-green-600 text-lg">&#10003;</span>
                                @elseif($estado === 'vencido')
                                    <span class="text-red-600 text-lg">&#10007;</span>
                                @else
                                    <span class="text-gray-400 text-lg">&#8212;</span>
                                @endif
                            </div>
                            <div class="text-xs mt-1 {{ $estado === 'pagado' ? 'text-green-600' : ($estado === 'vencido' ? 'text-red-600' : 'text-gray-400') }}">
                                {{ ucfirst($estado) }}
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Historial de pagos -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold text-gray-800">Historial de Pagos</h3>
                    <a href="{{ route('pagos.create', ['matricula_id' => $matricula->id]) }}" class="text-sm text-indigo-600 hover:underline">+ Registrar Pago</a>
                </div>
                @if($matricula->pagos->count())
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Recibo</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Concepto</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Mes</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Valor</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Método</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Fecha</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Estado</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @foreach($matricula->pagos->sortByDesc('fecha_pago') as $pago)
                                    <tr>
                                        <td class="px-4 py-2 text-sm font-mono">{{ $pago->recibo }}</td>
                                        <td class="px-4 py-2 text-sm">{{ ucfirst($pago->concepto) }}</td>
                                        <td class="px-4 py-2 text-sm">{{ $pago->mes ? ucfirst($pago->mes) : '-' }}</td>
                                        <td class="px-4 py-2 text-sm font-medium">${{ number_format($pago->total, 0, ',', '.') }}</td>
                                        <td class="px-4 py-2 text-sm">{{ ucfirst($pago->metodo_pago) }}</td>
                                        <td class="px-4 py-2 text-sm">{{ $pago->fecha_pago->format('d/m/Y') }}</td>
                                        <td class="px-4 py-2 text-sm">
                                            <span class="px-2 py-0.5 text-xs rounded-full {{ $pago->estado === 'pagado' ? 'bg-green-100 text-green-800' : ($pago->estado === 'anulado' ? 'bg-red-100 text-red-800' : 'bg-amber-100 text-amber-800') }}">
                                                {{ ucfirst($pago->estado) }}
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-gray-500 text-sm">Sin pagos registrados.</p>
                @endif
            </div>
    </div>
</x-app-layout>
