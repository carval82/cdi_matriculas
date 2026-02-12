<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recibo {{ $pago->recibo }}</title>
    <style>
        @page {
            size: 216mm 140mm; /* Media carta */
            margin: 8mm;
        }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            font-size: 11px;
            color: #1e293b;
            background: white;
        }
        .recibo {
            width: 200mm;
            max-width: 100%;
            margin: 0 auto;
            border: 2px solid #3b82f6;
            border-radius: 8px;
            overflow: hidden;
        }

        /* Header */
        .header {
            background: linear-gradient(135deg, #1e40af, #3b82f6);
            color: white;
            padding: 10px 16px;
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .header-logo {
            width: 60px;
            height: 60px;
            border-radius: 8px;
            object-fit: contain;
            background: white;
            padding: 4px;
            flex-shrink: 0;
        }
        .header-logo-placeholder {
            width: 60px;
            height: 60px;
            border-radius: 8px;
            background: rgba(255,255,255,0.2);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            flex-shrink: 0;
        }
        .header-info { flex: 1; }
        .header-info h1 { font-size: 16px; font-weight: 800; letter-spacing: 0.5px; }
        .header-info p { font-size: 9px; opacity: 0.85; margin-top: 2px; }
        .header-recibo {
            text-align: right;
            flex-shrink: 0;
        }
        .header-recibo .label { font-size: 9px; opacity: 0.8; text-transform: uppercase; letter-spacing: 1px; }
        .header-recibo .numero { font-size: 18px; font-weight: 800; margin-top: 2px; }
        .header-recibo .fecha { font-size: 9px; opacity: 0.8; margin-top: 4px; }

        /* Body */
        .body { padding: 12px 16px; }

        /* Info grid */
        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 6px 20px;
            margin-bottom: 12px;
            padding-bottom: 10px;
            border-bottom: 1px dashed #cbd5e1;
        }
        .info-item { display: flex; gap: 4px; }
        .info-item .label { color: #64748b; font-size: 10px; min-width: 70px; }
        .info-item .value { font-weight: 600; font-size: 10.5px; }

        /* Detalle pago */
        .detalle {
            margin-bottom: 12px;
        }
        .detalle-title {
            font-size: 10px;
            font-weight: 700;
            color: #3b82f6;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 6px;
        }
        .detalle-table {
            width: 100%;
            border-collapse: collapse;
        }
        .detalle-table th {
            background: #f1f5f9;
            padding: 5px 8px;
            text-align: left;
            font-size: 9px;
            font-weight: 700;
            color: #475569;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border-bottom: 1px solid #e2e8f0;
        }
        .detalle-table th:last-child { text-align: right; }
        .detalle-table td {
            padding: 5px 8px;
            font-size: 10.5px;
            border-bottom: 1px solid #f1f5f9;
        }
        .detalle-table td:last-child { text-align: right; font-weight: 600; }
        .detalle-table .total-row td {
            border-top: 2px solid #1e40af;
            border-bottom: none;
            font-size: 13px;
            font-weight: 800;
            padding-top: 8px;
            color: #1e40af;
        }

        /* Footer */
        .footer {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            padding-top: 10px;
            border-top: 1px dashed #cbd5e1;
        }
        .footer-firma {
            text-align: center;
            width: 45%;
        }
        .footer-firma .linea {
            border-top: 1px solid #94a3b8;
            margin-top: 30px;
            padding-top: 4px;
            font-size: 9px;
            color: #64748b;
        }
        .footer-obs {
            font-size: 9px;
            color: #94a3b8;
            text-align: center;
            margin-top: 8px;
            padding-top: 6px;
        }

        .estado-badge {
            display: inline-block;
            padding: 2px 10px;
            border-radius: 20px;
            font-size: 9px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .estado-pagado { background: #dcfce7; color: #166534; }
        .estado-anulado { background: #fee2e2; color: #991b1b; text-decoration: line-through; }
        .estado-pendiente { background: #fef3c7; color: #92400e; }

        @media print {
            body { -webkit-print-color-adjust: exact; print-color-adjust: exact; }
            .no-print { display: none !important; }
        }
        .print-actions {
            text-align: center;
            padding: 16px;
            background: #f8fafc;
        }
        .print-actions button, .print-actions a {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 8px 20px;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            border: none;
            margin: 0 4px;
        }
        .btn-print { background: #3b82f6; color: white; }
        .btn-print:hover { background: #2563eb; }
        .btn-back { background: #e2e8f0; color: #475569; }
        .btn-back:hover { background: #cbd5e1; }
    </style>
</head>
<body>
    <div class="print-actions no-print">
        <button class="btn-print" onclick="window.print()">
            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M6 9V2h12v7M6 18H4a2 2 0 01-2-2v-5a2 2 0 012-2h16a2 2 0 012 2v5a2 2 0 01-2 2h-2M6 14h12v8H6z"/></svg>
            Imprimir Recibo
        </button>
        <a class="btn-back" href="{{ route('pagos.show', $pago) }}">
            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>
            Volver
        </a>
    </div>

    <div class="recibo">
        <div class="header">
            @if($establecimiento && $establecimiento->logo)
                <img src="{{ $establecimiento->logoUrl() }}" alt="Logo" class="header-logo">
            @else
                <div class="header-logo-placeholder">🏫</div>
            @endif
            <div class="header-info">
                <h1>{{ $establecimiento->nombre ?? 'Centro de Desarrollo Infantil' }}</h1>
                @if($establecimiento?->nit)
                    <p>NIT: {{ $establecimiento->nit }}</p>
                @endif
                @if($establecimiento?->direccion || $establecimiento?->ciudad)
                    <p>{{ $establecimiento->direccion }} {{ $establecimiento->ciudad ? '- ' . $establecimiento->ciudad : '' }}</p>
                @endif
                @if($establecimiento?->telefono || $establecimiento?->celular)
                    <p>Tel: {{ $establecimiento->telefono ?? $establecimiento->celular }}</p>
                @endif
            </div>
            <div class="header-recibo">
                <div class="label">Recibo de Pago</div>
                <div class="numero">{{ $pago->recibo }}</div>
                <div class="fecha">{{ $pago->fecha_pago->format('d/m/Y') }}</div>
                <div style="margin-top:4px;">
                    <span class="estado-badge estado-{{ $pago->estado }}">{{ ucfirst($pago->estado) }}</span>
                </div>
            </div>
        </div>

        <div class="body">
            <div class="info-grid">
                <div class="info-item">
                    <span class="label">Estudiante:</span>
                    <span class="value">{{ $pago->estudiante->nombre_completo }}</span>
                </div>
                <div class="info-item">
                    <span class="label">Documento:</span>
                    <span class="value">{{ $pago->estudiante->tipo_documento }} {{ $pago->estudiante->documento ?? '-' }}</span>
                </div>
                <div class="info-item">
                    <span class="label">Grupo:</span>
                    <span class="value">{{ $pago->matricula?->grupo?->nombre ?? '-' }}</span>
                </div>
                <div class="info-item">
                    <span class="label">Matrícula:</span>
                    <span class="value">{{ $pago->matricula->codigo }} ({{ $pago->matricula->anio }})</span>
                </div>
                <div class="info-item">
                    <span class="label">Acudiente:</span>
                    <span class="value">{{ $pago->matricula?->acudiente?->nombre_completo ?? '-' }}</span>
                </div>
                <div class="info-item">
                    <span class="label">Método:</span>
                    <span class="value">{{ ucfirst($pago->metodo_pago) }}</span>
                </div>
                @if($pago->referencia_pago)
                <div class="info-item">
                    <span class="label">Referencia:</span>
                    <span class="value">{{ $pago->referencia_pago }}</span>
                </div>
                @endif
            </div>

            <div class="detalle">
                <div class="detalle-title">Detalle del Pago</div>
                <table class="detalle-table">
                    <thead>
                        <tr>
                            <th>Concepto</th>
                            <th>Periodo</th>
                            <th>Valor</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{ ucfirst($pago->concepto) }}</td>
                            <td>{{ $pago->mes ? ucfirst($pago->mes) : '-' }}</td>
                            <td>${{ number_format($pago->valor, 0, ',', '.') }}</td>
                        </tr>
                        @if($pago->descuento > 0)
                        <tr>
                            <td colspan="2" style="color:#64748b;">Descuento</td>
                            <td style="color:#dc2626;">-${{ number_format($pago->descuento, 0, ',', '.') }}</td>
                        </tr>
                        @endif
                        @if($pago->recargo > 0)
                        <tr>
                            <td colspan="2" style="color:#64748b;">Recargo</td>
                            <td style="color:#d97706;">+${{ number_format($pago->recargo, 0, ',', '.') }}</td>
                        </tr>
                        @endif
                        <tr class="total-row">
                            <td colspan="2">TOTAL PAGADO</td>
                            <td>${{ number_format($pago->total, 0, ',', '.') }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            @if($pago->observaciones)
                <div style="font-size:9px;color:#64748b;margin-bottom:8px;">
                    <strong>Obs:</strong> {{ $pago->observaciones }}
                </div>
            @endif

            <div class="footer">
                <div class="footer-firma">
                    <div class="linea">Firma Responsable</div>
                </div>
                <div class="footer-firma">
                    <div class="linea">Firma Acudiente</div>
                </div>
            </div>

            <div class="footer-obs">
                {{ $establecimiento?->lema ?? 'Este recibo es válido como comprobante de pago.' }}
            </div>
        </div>
    </div>
</body>
</html>
