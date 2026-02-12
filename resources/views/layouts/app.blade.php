<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'CDI Matrículas') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            :root {
                --sidebar-width: 260px;
                --sidebar-bg: #1e293b;
                --sidebar-hover: #334155;
                --sidebar-active: #3b82f6;
                --sidebar-text: #94a3b8;
                --sidebar-text-active: #ffffff;
                --topbar-height: 60px;
            }

            /* Sidebar */
            .sidebar {
                position: fixed;
                top: 0;
                left: 0;
                width: var(--sidebar-width);
                height: 100vh;
                background: var(--sidebar-bg);
                z-index: 50;
                display: flex;
                flex-direction: column;
                transition: transform 0.3s ease;
                overflow-y: auto;
            }

            .sidebar-brand {
                padding: 20px 20px;
                display: flex;
                align-items: center;
                gap: 12px;
                border-bottom: 1px solid rgba(255,255,255,0.08);
            }

            .sidebar-brand-icon {
                width: 42px;
                height: 42px;
                background: linear-gradient(135deg, #3b82f6, #8b5cf6);
                border-radius: 12px;
                display: flex;
                align-items: center;
                justify-content: center;
                color: white;
                font-size: 1.2rem;
                font-weight: 700;
                flex-shrink: 0;
            }

            .sidebar-brand-text {
                color: white;
                font-weight: 700;
                font-size: 1.05rem;
                line-height: 1.2;
            }

            .sidebar-brand-text small {
                font-weight: 400;
                font-size: 0.7rem;
                color: var(--sidebar-text);
                display: block;
            }

            .sidebar-nav {
                padding: 12px 0;
                flex: 1;
            }

            .sidebar-section {
                padding: 8px 20px 4px;
                font-size: 0.65rem;
                text-transform: uppercase;
                letter-spacing: 1.5px;
                color: #475569;
                font-weight: 600;
                margin-top: 8px;
            }

            .sidebar-link {
                display: flex;
                align-items: center;
                gap: 12px;
                padding: 10px 20px;
                color: var(--sidebar-text);
                text-decoration: none;
                font-size: 0.88rem;
                font-weight: 500;
                transition: all 0.15s ease;
                border-left: 3px solid transparent;
            }

            .sidebar-link:hover {
                background: var(--sidebar-hover);
                color: var(--sidebar-text-active);
            }

            .sidebar-link.active {
                background: rgba(59, 130, 246, 0.1);
                color: var(--sidebar-active);
                border-left-color: var(--sidebar-active);
            }

            .sidebar-link i {
                width: 20px;
                text-align: center;
                font-size: 1rem;
            }

            .sidebar-link .badge {
                margin-left: auto;
                background: var(--sidebar-active);
                color: white;
                font-size: 0.65rem;
                padding: 2px 7px;
                border-radius: 10px;
                font-weight: 600;
            }

            .sidebar-footer {
                padding: 15px 20px;
                border-top: 1px solid rgba(255,255,255,0.08);
            }

            .sidebar-user {
                display: flex;
                align-items: center;
                gap: 10px;
            }

            .sidebar-user-avatar {
                width: 36px;
                height: 36px;
                border-radius: 10px;
                background: linear-gradient(135deg, #3b82f6, #8b5cf6);
                display: flex;
                align-items: center;
                justify-content: center;
                color: white;
                font-weight: 700;
                font-size: 0.85rem;
                flex-shrink: 0;
            }

            .sidebar-user-info {
                flex: 1;
                min-width: 0;
            }

            .sidebar-user-name {
                color: white;
                font-weight: 600;
                font-size: 0.85rem;
                white-space: nowrap;
                overflow: hidden;
                text-overflow: ellipsis;
            }

            .sidebar-user-role {
                color: var(--sidebar-text);
                font-size: 0.7rem;
            }

            /* Main content */
            .main-wrapper {
                margin-left: var(--sidebar-width);
                min-height: 100vh;
                background: #f1f5f9;
            }

            .topbar {
                height: var(--topbar-height);
                background: white;
                border-bottom: 1px solid #e2e8f0;
                display: flex;
                align-items: center;
                justify-content: space-between;
                padding: 0 24px;
                position: sticky;
                top: 0;
                z-index: 40;
            }

            .topbar-left {
                display: flex;
                align-items: center;
                gap: 12px;
            }

            .topbar-title {
                font-weight: 600;
                font-size: 1.1rem;
                color: #1e293b;
            }

            .topbar-right {
                display: flex;
                align-items: center;
                gap: 16px;
            }

            .topbar-btn {
                width: 38px;
                height: 38px;
                border-radius: 10px;
                border: none;
                background: #f1f5f9;
                color: #64748b;
                cursor: pointer;
                display: flex;
                align-items: center;
                justify-content: center;
                transition: all 0.15s;
            }

            .topbar-btn:hover {
                background: #e2e8f0;
                color: #1e293b;
            }

            .main-content {
                padding: 24px;
            }

            /* Mobile toggle */
            .sidebar-toggle {
                display: none;
                background: none;
                border: none;
                color: #64748b;
                font-size: 1.3rem;
                cursor: pointer;
            }

            .sidebar-overlay {
                display: none;
                position: fixed;
                inset: 0;
                background: rgba(0,0,0,0.5);
                z-index: 45;
            }

            @media (max-width: 768px) {
                .sidebar {
                    transform: translateX(-100%);
                }
                .sidebar.open {
                    transform: translateX(0);
                }
                .sidebar-overlay.open {
                    display: block;
                }
                .main-wrapper {
                    margin-left: 0;
                }
                .sidebar-toggle {
                    display: block;
                }
            }
        </style>
    </head>
    <body class="font-sans antialiased">
        <!-- Sidebar Overlay (mobile) -->
        <div class="sidebar-overlay" id="sidebarOverlay" onclick="toggleSidebar()"></div>

        <!-- Sidebar -->
        <aside class="sidebar" id="sidebar">
            <div class="sidebar-brand">
                <div class="sidebar-brand-icon">
                    <i class="fas fa-child"></i>
                </div>
                <div class="sidebar-brand-text">
                    CDI Matrículas
                    <small>Centro de Desarrollo Infantil</small>
                </div>
            </div>

            <nav class="sidebar-nav">
                <div class="sidebar-section">Principal</div>
                <a href="{{ route('dashboard') }}" class="sidebar-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <i class="fas fa-th-large"></i> Dashboard
                </a>

                <div class="sidebar-section">Gestión Académica</div>
                <a href="{{ route('grupos.index') }}" class="sidebar-link {{ request()->routeIs('grupos.*') ? 'active' : '' }}">
                    <i class="fas fa-school"></i> Grupos
                </a>
                <a href="{{ route('estudiantes.index') }}" class="sidebar-link {{ request()->routeIs('estudiantes.*') ? 'active' : '' }}">
                    <i class="fas fa-user-graduate"></i> Estudiantes
                </a>
                <a href="{{ route('acudientes.index') }}" class="sidebar-link {{ request()->routeIs('acudientes.*') ? 'active' : '' }}">
                    <i class="fas fa-users"></i> Acudientes
                </a>

                <div class="sidebar-section">Financiero</div>
                <a href="{{ route('matriculas.index') }}" class="sidebar-link {{ request()->routeIs('matriculas.*') ? 'active' : '' }}">
                    <i class="fas fa-file-signature"></i> Matrículas
                </a>
                <a href="{{ route('pagos.index') }}" class="sidebar-link {{ request()->routeIs('pagos.*') ? 'active' : '' }}">
                    <i class="fas fa-money-bill-wave"></i> Pagos
                </a>

                <div class="sidebar-section">Sistema</div>
                <a href="{{ route('establecimiento.edit') }}" class="sidebar-link {{ request()->routeIs('establecimiento.*') ? 'active' : '' }}">
                    <i class="fas fa-building"></i> Establecimiento
                </a>
                <a href="{{ route('profile.edit') }}" class="sidebar-link {{ request()->routeIs('profile.*') ? 'active' : '' }}">
                    <i class="fas fa-user-cog"></i> Mi Perfil
                </a>
                <a href="{{ route('acerca') }}" class="sidebar-link {{ request()->routeIs('acerca') ? 'active' : '' }}">
                    <i class="fas fa-info-circle"></i> Acerca de
                </a>
            </nav>

            <div class="sidebar-footer">
                <div class="sidebar-user">
                    <div class="sidebar-user-avatar">
                        {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                    </div>
                    <div class="sidebar-user-info">
                        <div class="sidebar-user-name">{{ Auth::user()->name }}</div>
                        <div class="sidebar-user-role">Administrador</div>
                    </div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="topbar-btn" title="Cerrar Sesión" style="width:32px;height:32px;">
                            <i class="fas fa-sign-out-alt" style="font-size:0.85rem;"></i>
                        </button>
                    </form>
                </div>
            </div>
        </aside>

        <!-- Main Content -->
        <div class="main-wrapper">
            <div class="topbar">
                <div class="topbar-left">
                    <button class="sidebar-toggle" onclick="toggleSidebar()">
                        <i class="fas fa-bars"></i>
                    </button>
                    @isset($header)
                        <div class="topbar-title">{{ $header }}</div>
                    @endisset
                </div>
                <div class="topbar-right">
                    <div class="text-sm text-gray-500">
                        <i class="far fa-calendar-alt mr-1"></i>
                        {{ now()->translatedFormat('l, d M Y') }}
                    </div>
                </div>
            </div>

            <main class="main-content">
                {{ $slot }}
            </main>
        </div>

        <script>
            function toggleSidebar() {
                document.getElementById('sidebar').classList.toggle('open');
                document.getElementById('sidebarOverlay').classList.toggle('open');
            }
        </script>
    </body>
</html>
