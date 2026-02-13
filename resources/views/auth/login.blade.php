@php $cdi = \App\Models\Establecimiento::datos(); @endphp
<x-guest-layout>
    <div class="login-card rounded-2xl shadow-2xl p-8 md:p-10">
        <!-- Logo & Header -->
        <div class="text-center mb-8">
            @if($cdi && $cdi->logo)
                <img src="{{ asset('storage/' . $cdi->logo) }}" alt="Logo" class="mx-auto h-20 w-20 object-contain rounded-xl shadow-md mb-4">
            @else
                <div class="mx-auto h-20 w-20 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-xl shadow-lg flex items-center justify-center mb-4">
                    <i class="fas fa-graduation-cap text-white text-3xl"></i>
                </div>
            @endif
            <h1 class="text-2xl font-bold text-gray-800">{{ $cdi->nombre ?? config('app.name', 'CDI Matrículas') }}</h1>
            <p class="text-sm text-gray-500 mt-1">Sistema de Gestión Académica</p>
        </div>

        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        @if($errors->any())
            <div class="mb-4 p-3 bg-red-50 border border-red-200 rounded-xl">
                <div class="flex items-center gap-2 text-red-700 text-sm">
                    <i class="fas fa-exclamation-circle"></i>
                    <span>Credenciales incorrectas. Intenta de nuevo.</span>
                </div>
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Email -->
            <div class="mb-4">
                <label for="email" class="block text-sm font-semibold text-gray-600 mb-2">Correo electrónico</label>
                <div class="input-group relative">
                    <i class="fas fa-envelope input-icon"></i>
                    <input id="email" type="email" name="email" value="{{ old('email') }}"
                        class="login-input" placeholder="usuario@correo.com"
                        required autofocus autocomplete="username">
                </div>
            </div>

            <!-- Password -->
            <div class="mb-4">
                <label for="password" class="block text-sm font-semibold text-gray-600 mb-2">Contraseña</label>
                <div class="input-group relative">
                    <i class="fas fa-lock input-icon"></i>
                    <input id="password" type="password" name="password"
                        class="login-input" placeholder="••••••••"
                        required autocomplete="current-password">
                    <button type="button" onclick="togglePassword()" class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 hover:text-indigo-500 transition">
                        <i id="eye-icon" class="fas fa-eye text-sm"></i>
                    </button>
                </div>
            </div>

            <!-- Remember + Forgot -->
            <div class="flex items-center justify-between mb-6">
                <label for="remember_me" class="flex items-center gap-2 cursor-pointer">
                    <input id="remember_me" type="checkbox" name="remember"
                        class="w-4 h-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500 transition">
                    <span class="text-sm text-gray-500">Recordarme</span>
                </label>
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="text-sm text-indigo-600 hover:text-indigo-800 font-medium transition">
                        ¿Olvidaste tu contraseña?
                    </a>
                @endif
            </div>

            <!-- Submit -->
            <button type="submit" class="login-btn flex items-center justify-center gap-2">
                <i class="fas fa-sign-in-alt"></i>
                Iniciar Sesión
            </button>
        </form>

        <!-- Footer -->
        <div class="mt-8 pt-6 border-t border-gray-100 text-center">
            <p class="text-xs text-gray-400">
                <i class="fas fa-shield-alt mr-1"></i> Acceso seguro — Solo personal autorizado
            </p>
        </div>
    </div>

    <!-- Credits -->
    <div class="text-center mt-6">
        <p class="text-xs text-indigo-200 opacity-60">
            Desarrollado por <span class="font-semibold">LC Design</span> & <span class="font-semibold">Cascade AI</span>
        </p>
    </div>

    <script>
        function togglePassword() {
            const input = document.getElementById('password');
            const icon = document.getElementById('eye-icon');
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.replace('fa-eye', 'fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.replace('fa-eye-slash', 'fa-eye');
            }
        }
    </script>
</x-guest-layout>
