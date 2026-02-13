<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Matrícula {{ $matricula->codigo }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; font-size: 12px; color: #333; padding: 20px; }

        .header { display: flex; align-items: center; border-bottom: 3px solid #1e40af; padding-bottom: 15px; margin-bottom: 15px; }
        .header-logo { width: 80px; height: 80px; margin-right: 15px; }
        .header-logo img { width: 100%; height: 100%; object-fit: contain; }
        .header-info { flex: 1; text-align: center; }
        .header-info h1 { font-size: 18px; color: #1e40af; margin-bottom: 2px; }
        .header-info p { font-size: 11px; color: #555; }
        .header-code { text-align: right; font-size: 11px; }
        .header-code .code { font-size: 16px; font-weight: bold; color: #1e40af; }

        .title { background: #1e40af; color: white; text-align: center; padding: 8px; font-size: 14px; font-weight: bold; margin-bottom: 15px; letter-spacing: 1px; }

        .section { margin-bottom: 12px; }
        .section-title { background: #e8edf5; padding: 5px 10px; font-weight: bold; font-size: 12px; color: #1e40af; border-left: 3px solid #1e40af; margin-bottom: 8px; }

        .data-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 6px 12px; padding: 0 10px; }
        .data-grid.cols-3 { grid-template-columns: repeat(3, 1fr); }
        .data-grid.cols-2 { grid-template-columns: repeat(2, 1fr); }
        .data-item { margin-bottom: 4px; }
        .data-label { font-size: 9px; color: #888; text-transform: uppercase; letter-spacing: 0.5px; }
        .data-value { font-size: 12px; font-weight: 600; }

        .signatures { display: grid; grid-template-columns: 1fr 1fr; gap: 40px; margin-top: 60px; padding: 0 30px; }
        .signature-box { text-align: center; }
        .signature-line { border-top: 1px solid #333; padding-top: 5px; margin-top: 60px; }
        .signature-name { font-weight: bold; font-size: 12px; }
        .signature-role { font-size: 10px; color: #666; }
        .signature-doc { font-size: 10px; color: #888; }

        .footer { margin-top: 30px; text-align: center; font-size: 9px; color: #999; border-top: 1px solid #ddd; padding-top: 10px; }

        .observaciones { padding: 8px 10px; font-size: 11px; color: #555; background: #fafafa; border: 1px dashed #ddd; min-height: 40px; }

        .compromiso { padding: 10px; font-size: 10px; color: #444; line-height: 1.6; text-align: justify; border: 1px solid #ddd; background: #fefefe; margin-bottom: 15px; }

        @media print {
            body { padding: 10px; }
            .no-print { display: none !important; }
            @page { margin: 15mm; size: letter; }
        }
    </style>
</head>
<body>
    {{-- Botón imprimir --}}
    <div class="no-print" style="text-align: center; margin-bottom: 20px;">
        <button onclick="window.print()" style="padding: 10px 30px; background: #1e40af; color: white; border: none; border-radius: 8px; font-size: 14px; cursor: pointer; margin-right: 10px;">
            <strong>🖨️ Imprimir Matrícula</strong>
        </button>
        <a href="{{ route('matriculas.show', $matricula) }}" style="padding: 10px 30px; background: #6b7280; color: white; border: none; border-radius: 8px; font-size: 14px; text-decoration: none;">
            ← Volver
        </a>
    </div>

    {{-- Encabezado --}}
    <div class="header">
        <div class="header-logo">
            @if($establecimiento && $establecimiento->logo)
                <img src="{{ asset('storage/' . $establecimiento->logo) }}" alt="Logo">
            @else
                <div style="width:80px;height:80px;background:#1e40af;border-radius:10px;display:flex;align-items:center;justify-content:center;color:white;font-size:24px;font-weight:bold;">CDI</div>
            @endif
        </div>
        <div class="header-info">
            <h1>{{ $establecimiento->nombre ?? 'Centro de Desarrollo Infantil' }}</h1>
            @if($establecimiento->nit)<p>NIT: {{ $establecimiento->nit }}</p>@endif
            @if($establecimiento->resolucion)<p>{{ $establecimiento->resolucion }}</p>@endif
            <p>{{ $establecimiento->direccion ?? '' }} {{ $establecimiento->ciudad ? '- ' . $establecimiento->ciudad : '' }}</p>
            <p>Tel: {{ $establecimiento->telefono ?? $establecimiento->celular ?? '' }} | {{ $establecimiento->email ?? '' }}</p>
        </div>
        <div class="header-code">
            <div class="code">{{ $matricula->codigo }}</div>
            <div>Fecha: {{ $matricula->fecha_matricula->format('d/m/Y') }}</div>
        </div>
    </div>

    <div class="title">CONSTANCIA DE MATRÍCULA — AÑO {{ $matricula->anio }}</div>

    {{-- Datos del estudiante --}}
    <div class="section">
        <div class="section-title">DATOS DEL ESTUDIANTE</div>
        <div class="data-grid">
            <div class="data-item">
                <div class="data-label">Nombres y Apellidos</div>
                <div class="data-value">{{ $matricula->estudiante->nombre_completo }}</div>
            </div>
            <div class="data-item">
                <div class="data-label">Documento</div>
                <div class="data-value">{{ $matricula->estudiante->tipo_documento }} {{ $matricula->estudiante->documento ?? 'N/A' }}</div>
            </div>
            <div class="data-item">
                <div class="data-label">Fecha Nacimiento</div>
                <div class="data-value">{{ $matricula->estudiante->fecha_nacimiento->format('d/m/Y') }}</div>
            </div>
            <div class="data-item">
                <div class="data-label">Edad</div>
                <div class="data-value">{{ $matricula->estudiante->edad }}</div>
            </div>
            <div class="data-item">
                <div class="data-label">Género</div>
                <div class="data-value">{{ ucfirst($matricula->estudiante->genero) }}</div>
            </div>
            <div class="data-item">
                <div class="data-label">RH</div>
                <div class="data-value">{{ $matricula->estudiante->rh ?? 'N/A' }}</div>
            </div>
            <div class="data-item">
                <div class="data-label">EPS</div>
                <div class="data-value">{{ $matricula->estudiante->eps ?? 'N/A' }}</div>
            </div>
            <div class="data-item">
                <div class="data-label">Código Estudiante</div>
                <div class="data-value">{{ $matricula->estudiante->codigo ?? 'N/A' }}</div>
            </div>
        </div>
    </div>

    {{-- Datos académicos --}}
    <div class="section">
        <div class="section-title">DATOS ACADÉMICOS</div>
        <div class="data-grid">
            <div class="data-item">
                <div class="data-label">Grupo</div>
                <div class="data-value">{{ $matricula->grupo->nombre }}</div>
            </div>
            <div class="data-item">
                <div class="data-label">Jornada</div>
                <div class="data-value">{{ ucfirst($matricula->jornada) }}</div>
            </div>
            <div class="data-item">
                <div class="data-label">Año Lectivo</div>
                <div class="data-value">{{ $matricula->anio }}</div>
            </div>
            <div class="data-item">
                <div class="data-label">Periodo</div>
                <div class="data-value">{{ ucfirst($matricula->periodo) }}</div>
            </div>
        </div>
    </div>

    {{-- Datos del acudiente --}}
    <div class="section">
        <div class="section-title">DATOS DEL ACUDIENTE</div>
        <div class="data-grid">
            <div class="data-item">
                <div class="data-label">Nombres y Apellidos</div>
                <div class="data-value">{{ $matricula->acudiente->nombre_completo }}</div>
            </div>
            <div class="data-item">
                <div class="data-label">Documento</div>
                <div class="data-value">{{ $matricula->acudiente->tipo_documento ?? 'CC' }} {{ $matricula->acudiente->documento }}</div>
            </div>
            <div class="data-item">
                <div class="data-label">Parentesco</div>
                <div class="data-value">{{ $matricula->acudiente->parentesco ?? 'N/A' }}</div>
            </div>
            <div class="data-item">
                <div class="data-label">Celular</div>
                <div class="data-value">{{ $matricula->acudiente->celular ?? $matricula->acudiente->telefono ?? 'N/A' }}</div>
            </div>
            @if($matricula->acudiente->email)
            <div class="data-item">
                <div class="data-label">Email</div>
                <div class="data-value">{{ $matricula->acudiente->email }}</div>
            </div>
            @endif
            @if($matricula->acudiente->direccion)
            <div class="data-item">
                <div class="data-label">Dirección</div>
                <div class="data-value">{{ $matricula->acudiente->direccion }}</div>
            </div>
            @endif
        </div>
    </div>

    {{-- Datos financieros --}}
    <div class="section">
        <div class="section-title">DATOS FINANCIEROS</div>
        <div class="data-grid cols-3">
            <div class="data-item">
                <div class="data-label">Valor Matrícula</div>
                <div class="data-value">${{ number_format($matricula->valor_matricula, 0, ',', '.') }}</div>
            </div>
            <div class="data-item">
                <div class="data-label">Pensión Mensual</div>
                <div class="data-value">${{ number_format($matricula->valor_pension, 0, ',', '.') }}</div>
            </div>
            @if($matricula->descuento > 0)
            <div class="data-item">
                <div class="data-label">Descuento</div>
                <div class="data-value">${{ number_format($matricula->descuento, 0, ',', '.') }} ({{ $matricula->tipo_descuento }})</div>
            </div>
            @endif
        </div>
    </div>

    {{-- Observaciones --}}
    @if($matricula->observaciones)
    <div class="section">
        <div class="section-title">OBSERVACIONES</div>
        <div class="observaciones">{{ $matricula->observaciones }}</div>
    </div>
    @endif

    {{-- Compromiso --}}
    <div class="section">
        <div class="section-title">COMPROMISO DEL ACUDIENTE</div>
        <div class="compromiso">
            Yo, <strong>{{ $matricula->acudiente->nombre_completo }}</strong>, identificado(a) con {{ $matricula->acudiente->tipo_documento ?? 'CC' }}
            No. <strong>{{ $matricula->acudiente->documento }}</strong>, en calidad de acudiente del menor
            <strong>{{ $matricula->estudiante->nombre_completo }}</strong>, me comprometo a cumplir con el reglamento interno del
            <strong>{{ $establecimiento->nombre ?? 'Centro de Desarrollo Infantil' }}</strong>, a realizar los pagos de pensión de manera oportuna,
            a participar activamente en el proceso formativo del menor y a mantener actualizada la información de contacto y documentación requerida.
        </div>
    </div>

    {{-- Firmas --}}
    <div class="signatures">
        <div class="signature-box">
            <div class="signature-line">
                <div class="signature-name">{{ $establecimiento->representante_legal ?? 'Rector(a) / Director(a)' }}</div>
                <div class="signature-role">{{ $establecimiento->representante_legal ? 'Rector(a) / Director(a)' : '' }}</div>
                <div class="signature-doc">{{ $establecimiento->nombre ?? 'CDI' }}</div>
            </div>
        </div>
        <div class="signature-box">
            <div class="signature-line">
                <div class="signature-name">{{ $matricula->acudiente->nombre_completo }}</div>
                <div class="signature-role">Acudiente</div>
                <div class="signature-doc">{{ $matricula->acudiente->tipo_documento ?? 'CC' }} {{ $matricula->acudiente->documento }}</div>
            </div>
        </div>
    </div>

    <div class="footer">
        {{ $establecimiento->nombre ?? 'CDI' }} — {{ $establecimiento->direccion ?? '' }} {{ $establecimiento->ciudad ? ', ' . $establecimiento->ciudad : '' }}<br>
        Documento generado el {{ now()->format('d/m/Y H:i') }} | {{ $matricula->codigo }}
    </div>
</body>
</html>
