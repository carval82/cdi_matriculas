<x-app-layout>
    <x-slot name="header">Dashboard</x-slot>

    <style>
        .stat-card { background: white; border-radius: 16px; padding: 20px; box-shadow: 0 1px 3px rgba(0,0,0,0.06); display: flex; align-items: center; justify-content: space-between; gap: 16px; }
        .stat-card .stat-icon { width: 56px; height: 56px; border-radius: 14px; display: flex; align-items: center; justify-content: center; font-size: 1.3rem; flex-shrink: 0; }
        .stat-card .stat-label { font-size: 0.75rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; color: #94a3b8; }
        .stat-card .stat-value { font-size: 1.8rem; font-weight: 800; color: #1e293b; margin-top: 2px; }
        .stat-card .stat-sub { font-size: 0.7rem; color: #94a3b8; margin-top: 2px; }
        .card { background: white; border-radius: 16px; box-shadow: 0 1px 3px rgba(0,0,0,0.06); padding: 24px; }
        .card-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 20px; }
        .card-title { font-size: 1rem; font-weight: 700; color: #1e293b; display: flex; align-items: center; gap: 8px; }
        .card-action { font-size: 0.8rem; font-weight: 600; padding: 6px 14px; border-radius: 8px; text-decoration: none; transition: all 0.15s; }
        .estancia-card { border-radius: 14px; padding: 20px; color: white; text-decoration: none; display: block; transition: all 0.2s; }
        .estancia-card:hover { transform: translateY(-2px); box-shadow: 0 8px 25px rgba(0,0,0,0.15); }
        .progress-bar { width: 100%; height: 6px; background: rgba(255,255,255,0.25); border-radius: 10px; overflow: hidden; }
        .progress-fill { height: 100%; background: white; border-radius: 10px; transition: width 0.5s; }
        .list-item { display: flex; align-items: center; justify-content: space-between; padding: 12px; margin: 0 -12px; border-radius: 10px; text-decoration: none; color: inherit; transition: background 0.15s; border-bottom: 1px solid #f1f5f9; }
        .list-item:last-child { border-bottom: none; }
        .list-item:hover { background: #f8fafc; }
        .list-icon { width: 40px; height: 40px; border-radius: 10px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
        .badge { font-size: 0.7rem; padding: 3px 10px; border-radius: 20px; font-weight: 600; }
        .empty-state { text-align: center; padding: 32px 16px; }
        .empty-state i { font-size: 2.5rem; color: #e2e8f0; }
        .empty-state p { color: #94a3b8; font-size: 0.85rem; margin-top: 8px; }
        .grid-stats { display: grid; grid-template-columns: repeat(4, 1fr); gap: 16px; }
        .grid-estancias { display: grid; grid-template-columns: repeat(auto-fill, minmax(220px, 1fr)); gap: 16px; }
        .grid-two { display: grid; grid-template-columns: repeat(2, 1fr); gap: 20px; }
        @media (max-width: 900px) { .grid-stats { grid-template-columns: repeat(2, 1fr); } .grid-two { grid-template-columns: 1fr; } }
        @media (max-width: 600px) { .grid-stats { grid-template-columns: 1fr; } }
    </style>

    <div style="display:flex;flex-direction:column;gap:24px;">
        <!-- Stats Cards -->
        <div class="grid-stats">
            <div class="stat-card" style="border-left: 4px solid #3b82f6;">
                <div>
                    <div class="stat-label">Estudiantes Activos</div>
                    <div class="stat-value">{{ $stats['total_estudiantes'] }}</div>
                </div>
                <div class="stat-icon" style="background:#eff6ff;color:#3b82f6;"><i class="fas fa-user-graduate"></i></div>
            </div>
            <div class="stat-card" style="border-left: 4px solid #22c55e;">
                <div>
                    <div class="stat-label">Matrículas {{ $anioActual }}</div>
                    <div class="stat-value">{{ $stats['total_matriculas'] }}</div>
                </div>
                <div class="stat-icon" style="background:#f0fdf4;color:#22c55e;"><i class="fas fa-file-signature"></i></div>
            </div>
            <div class="stat-card" style="border-left: 4px solid #a855f7;">
                <div>
                    <div class="stat-label">Grupos Activos</div>
                    <div class="stat-value">{{ $stats['total_grupos'] }}</div>
                </div>
                <div class="stat-icon" style="background:#faf5ff;color:#a855f7;"><i class="fas fa-school"></i></div>
            </div>
            <div class="stat-card" style="border-left: 4px solid #10b981;">
                <div>
                    <div class="stat-label">Ingresos del Mes</div>
                    <div class="stat-value">${{ number_format($stats['ingresos_mes'], 0, ',', '.') }}</div>
                </div>
                <div class="stat-icon" style="background:#ecfdf5;color:#10b981;"><i class="fas fa-dollar-sign"></i></div>
            </div>
        </div>

        <!-- Estancias con ocupación -->
        <div class="card">
            <div class="card-header">
                <div class="card-title"><i class="fas fa-school" style="color:#a855f7;"></i> Grupos - Ocupación</div>
                <a href="{{ route('grupos.create') }}" class="card-action" style="background:#faf5ff;color:#a855f7;">
                    <i class="fas fa-plus"></i> Nueva
                </a>
            </div>
            @if($grupos->count())
                @php
                    $gradients = [
                        'linear-gradient(135deg, #3b82f6, #2563eb)',
                        'linear-gradient(135deg, #a855f7, #7c3aed)',
                        'linear-gradient(135deg, #10b981, #059669)',
                        'linear-gradient(135deg, #f59e0b, #d97706)',
                        'linear-gradient(135deg, #f43f5e, #e11d48)',
                        'linear-gradient(135deg, #06b6d4, #0891b2)',
                    ];
                @endphp
                <div class="grid-estancias">
                    @foreach($grupos as $grupo)
                        @php
                            $ocupados = $grupo->estudiantes_count;
                            $capacidad = $grupo->capacidad;
                            $porcentaje = $capacidad > 0 ? round(($ocupados / $capacidad) * 100) : 0;
                        @endphp
                        <a href="{{ route('grupos.show', $grupo) }}" class="estancia-card" style="background:{{ $gradients[$loop->index % count($gradients)] }};">
                            <div style="display:flex;justify-content:space-between;align-items:start;">
                                <div style="font-weight:700;font-size:1.1rem;">{{ $grupo->nombre }}</div>
                                <div style="background:rgba(255,255,255,0.2);border-radius:6px;padding:2px 8px;font-size:0.7rem;">{{ ucfirst($grupo->jornada) }}</div>
                            </div>
                            <div style="margin-top:16px;">
                                <div style="display:flex;justify-content:space-between;font-size:0.8rem;opacity:0.85;margin-bottom:6px;">
                                    <span>Ocupación</span>
                                    <span style="font-weight:700;opacity:1;">{{ $ocupados }}/{{ $capacidad }}</span>
                                </div>
                                <div class="progress-bar">
                                    <div class="progress-fill" style="width:{{ min($porcentaje, 100) }}%;"></div>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            @else
                <div class="empty-state">
                    <i class="fas fa-school"></i>
                    <p>No hay grupos configurados.</p>
                    <a href="{{ route('grupos.create') }}" style="display:inline-flex;align-items:center;gap:4px;margin-top:8px;font-size:0.85rem;color:#a855f7;font-weight:600;text-decoration:none;">
                        <i class="fas fa-plus"></i> Crear primer grupo
                    </a>
                </div>
            @endif
        </div>

        <div class="grid-two">
            <!-- Últimas matrículas -->
            <div class="card">
                <div class="card-header">
                    <div class="card-title"><i class="fas fa-file-signature" style="color:#22c55e;"></i> Últimas Matrículas</div>
                    <a href="{{ route('matriculas.create') }}" class="card-action" style="background:#f0fdf4;color:#16a34a;">
                        <i class="fas fa-plus"></i> Nueva
                    </a>
                </div>
                @forelse($ultimasMatriculas as $mat)
                    <a href="{{ route('matriculas.show', $mat) }}" class="list-item">
                        <div style="display:flex;align-items:center;gap:12px;">
                            <div class="list-icon" style="background:#f0fdf4;color:#22c55e;"><i class="fas fa-user-graduate"></i></div>
                            <div>
                                <div style="font-weight:600;font-size:0.85rem;color:#1e293b;">{{ $mat->estudiante->nombre_completo }}</div>
                                <div style="font-size:0.75rem;color:#94a3b8;">{{ $mat->grupo->nombre }} &middot; {{ $mat->codigo }}</div>
                            </div>
                        </div>
                        <span class="badge" style="{{ $mat->estado === 'activa' ? 'background:#dcfce7;color:#16a34a;' : 'background:#f1f5f9;color:#64748b;' }}">
                            {{ ucfirst($mat->estado) }}
                        </span>
                    </a>
                @empty
                    <div class="empty-state">
                        <i class="fas fa-file-alt"></i>
                        <p>Sin matrículas registradas</p>
                    </div>
                @endforelse
            </div>

            <!-- Últimos pagos -->
            <div class="card">
                <div class="card-header">
                    <div class="card-title"><i class="fas fa-money-bill-wave" style="color:#10b981;"></i> Últimos Pagos</div>
                    <a href="{{ route('pagos.create') }}" class="card-action" style="background:#ecfdf5;color:#059669;">
                        <i class="fas fa-plus"></i> Nuevo
                    </a>
                </div>
                @forelse($ultimosPagos as $pago)
                    <a href="{{ route('pagos.show', $pago) }}" class="list-item">
                        <div style="display:flex;align-items:center;gap:12px;">
                            <div class="list-icon" style="background:#ecfdf5;color:#10b981;"><i class="fas fa-receipt"></i></div>
                            <div>
                                <div style="font-weight:600;font-size:0.85rem;color:#1e293b;">{{ $pago->estudiante->nombre_completo }}</div>
                                <div style="font-size:0.75rem;color:#94a3b8;">{{ ucfirst($pago->concepto) }}{{ $pago->mes ? ' &middot; ' . ucfirst($pago->mes) : '' }}</div>
                            </div>
                        </div>
                        <div style="font-weight:700;font-size:0.9rem;color:#10b981;">${{ number_format($pago->total, 0, ',', '.') }}</div>
                    </a>
                @empty
                    <div class="empty-state">
                        <i class="fas fa-coins"></i>
                        <p>Sin pagos registrados</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>
