<x-app-layout>
    <x-slot name="header">Acerca de</x-slot>

    <div class="max-w-4xl mx-auto">
        <div class="bg-white rounded-2xl shadow-sm overflow-hidden">
            <!-- Header con gradiente -->
            <div class="relative bg-gradient-to-r from-blue-600 via-indigo-600 to-purple-600 px-8 py-12 text-center">
                <div class="absolute inset-0 opacity-10">
                    <div class="absolute inset-0" style="background-image: url('data:image/svg+xml,%3Csvg width=&quot;60&quot; height=&quot;60&quot; viewBox=&quot;0 0 60 60&quot; xmlns=&quot;http://www.w3.org/2000/svg&quot;%3E%3Cg fill=&quot;none&quot; fill-rule=&quot;evenodd&quot;%3E%3Cg fill=&quot;%23ffffff&quot; fill-opacity=&quot;0.4&quot;%3E%3Cpath d=&quot;M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z&quot;/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"></div>
                </div>
                <div class="relative">
                    <div class="inline-flex items-center justify-center w-20 h-20 bg-white/20 backdrop-blur-sm rounded-2xl mb-4">
                        <i class="fas fa-child text-white text-3xl"></i>
                    </div>
                    <h1 class="text-3xl font-bold text-white">CDI Matrículas</h1>
                    <p class="text-blue-100 mt-2 text-lg">Sistema de Gestión de Matrículas</p>
                    <p class="text-blue-200 text-sm mt-1">Centro de Desarrollo Infantil</p>
                    <div class="mt-4 inline-flex items-center gap-2 bg-white/20 backdrop-blur-sm rounded-full px-4 py-1.5">
                        <span class="w-2 h-2 bg-green-400 rounded-full animate-pulse"></span>
                        <span class="text-white text-sm font-medium">Versión 1.0.0</span>
                    </div>
                </div>
            </div>

            <!-- Contenido -->
            <div class="p-8 space-y-8">
                <!-- Descripción -->
                <div>
                    <h2 class="text-lg font-bold text-gray-800 flex items-center gap-2">
                        <i class="fas fa-star text-amber-500"></i> Descripción
                    </h2>
                    <p class="mt-3 text-gray-600 leading-relaxed">
                        <strong>CDI Matrículas</strong> es un sistema integral diseñado para la gestión académica y financiera 
                        de Centros de Desarrollo Infantil. Permite administrar grupos, estudiantes, acudientes, 
                        matrículas y pagos de forma eficiente y organizada.
                    </p>
                </div>

                <!-- Módulos -->
                <div>
                    <h2 class="text-lg font-bold text-gray-800 flex items-center gap-2">
                        <i class="fas fa-puzzle-piece text-blue-500"></i> Módulos
                    </h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                        <div class="flex items-start gap-3 p-4 bg-blue-50 rounded-xl">
                            <div class="w-10 h-10 bg-blue-500 rounded-lg flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-school text-white"></i>
                            </div>
                            <div>
                                <div class="font-semibold text-gray-800">Grupos</div>
                                <div class="text-sm text-gray-500">Párvulos, Jardín, Pre-Jardín, Preescolar y más</div>
                            </div>
                        </div>
                        <div class="flex items-start gap-3 p-4 bg-purple-50 rounded-xl">
                            <div class="w-10 h-10 bg-purple-500 rounded-lg flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-user-graduate text-white"></i>
                            </div>
                            <div>
                                <div class="font-semibold text-gray-800">Estudiantes</div>
                                <div class="text-sm text-gray-500">Registro completo con datos médicos y personales</div>
                            </div>
                        </div>
                        <div class="flex items-start gap-3 p-4 bg-green-50 rounded-xl">
                            <div class="w-10 h-10 bg-green-500 rounded-lg flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-users text-white"></i>
                            </div>
                            <div>
                                <div class="font-semibold text-gray-800">Acudientes</div>
                                <div class="text-sm text-gray-500">Gestión de padres y responsables</div>
                            </div>
                        </div>
                        <div class="flex items-start gap-3 p-4 bg-amber-50 rounded-xl">
                            <div class="w-10 h-10 bg-amber-500 rounded-lg flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-file-signature text-white"></i>
                            </div>
                            <div>
                                <div class="font-semibold text-gray-800">Matrículas</div>
                                <div class="text-sm text-gray-500">Proceso de matrícula con seguimiento de pensiones</div>
                            </div>
                        </div>
                        <div class="flex items-start gap-3 p-4 bg-emerald-50 rounded-xl">
                            <div class="w-10 h-10 bg-emerald-500 rounded-lg flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-money-bill-wave text-white"></i>
                            </div>
                            <div>
                                <div class="font-semibold text-gray-800">Pagos</div>
                                <div class="text-sm text-gray-500">Control de pagos, recibos y estados de cuenta</div>
                            </div>
                        </div>
                        <div class="flex items-start gap-3 p-4 bg-rose-50 rounded-xl">
                            <div class="w-10 h-10 bg-rose-500 rounded-lg flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-chart-bar text-white"></i>
                            </div>
                            <div>
                                <div class="font-semibold text-gray-800">Dashboard</div>
                                <div class="text-sm text-gray-500">Estadísticas y resumen en tiempo real</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tecnologías -->
                <div>
                    <h2 class="text-lg font-bold text-gray-800 flex items-center gap-2">
                        <i class="fas fa-code text-green-500"></i> Tecnologías
                    </h2>
                    <div class="flex flex-wrap gap-2 mt-3">
                        <span class="px-3 py-1.5 bg-red-100 text-red-700 rounded-lg text-sm font-medium">Laravel 12</span>
                        <span class="px-3 py-1.5 bg-blue-100 text-blue-700 rounded-lg text-sm font-medium">Tailwind CSS</span>
                        <span class="px-3 py-1.5 bg-purple-100 text-purple-700 rounded-lg text-sm font-medium">Blade</span>
                        <span class="px-3 py-1.5 bg-orange-100 text-orange-700 rounded-lg text-sm font-medium">MySQL</span>
                        <span class="px-3 py-1.5 bg-yellow-100 text-yellow-700 rounded-lg text-sm font-medium">JavaScript</span>
                        <span class="px-3 py-1.5 bg-cyan-100 text-cyan-700 rounded-lg text-sm font-medium">Font Awesome</span>
                    </div>
                </div>

                <!-- Desarrollado con -->
                <div class="border-t pt-6">
                    <h2 class="text-lg font-bold text-gray-800 flex items-center gap-2">
                        <i class="fas fa-laptop-code text-indigo-500"></i> Desarrollado con
                    </h2>
                    <div class="mt-4 space-y-4">
                        <div class="flex items-center gap-5 p-5 bg-gradient-to-r from-blue-50 to-purple-50 rounded-xl">
                            <img src="{{ asset('image/logo-icon.png') }}" alt="LC Design" class="w-16 h-16 object-contain flex-shrink-0">
                            <div class="flex-1">
                                <div class="font-bold text-gray-800 text-lg">LUIS CARLOS CORREA ARRIETA</div>
                                <div class="text-indigo-600 text-sm font-medium">Analista y Desarrollador de Software</div>
                                <div class="text-gray-500 text-xs mt-1">Graduado del SENA</div>
                                <div class="flex flex-wrap items-center gap-4 mt-3 text-sm">
                                    <a href="tel:3012481020" class="inline-flex items-center gap-1.5 text-gray-500 hover:text-indigo-600 transition">
                                        <i class="fas fa-phone-alt text-xs"></i> 301 248 1020
                                    </a>
                                    <a href="mailto:contacto@lcdesign.com.co" class="inline-flex items-center gap-1.5 text-gray-500 hover:text-indigo-600 transition">
                                        <i class="fas fa-envelope text-xs"></i> contacto@lcdesign.com.co
                                    </a>
                                    <a href="https://github.com/carval82" target="_blank" class="inline-flex items-center gap-1.5 text-gray-500 hover:text-gray-700 transition">
                                        <i class="fab fa-github text-xs"></i> GitHub
                                    </a>
                                </div>
                                <div class="mt-3 inline-flex items-center gap-2 px-3 py-1 bg-indigo-100 text-indigo-700 rounded-full text-xs font-semibold">
                                    <i class="fas fa-building text-[10px]"></i> LC Design — Desarrollo de Software
                                </div>
                            </div>
                        </div>
                        <div class="flex items-center gap-4 p-5 bg-gradient-to-r from-emerald-50 to-cyan-50 rounded-xl">
                            <div class="w-16 h-16 bg-gradient-to-br from-emerald-500 to-cyan-500 rounded-2xl flex items-center justify-center flex-shrink-0 shadow-lg">
                                <i class="fas fa-wind text-white text-xl"></i>
                            </div>
                            <div>
                                <div class="font-bold text-gray-800 text-lg">Windsurf - Cascade AI</div>
                                <div class="text-gray-500 text-sm">Asistente de programación con inteligencia artificial</div>
                                <div class="text-xs text-gray-400 mt-1">Pair programming potenciado por IA para desarrollo ágil</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Footer -->
                <div class="text-center text-sm text-gray-400 pt-4 border-t">
                    &copy; {{ date('Y') }} CDI Matrículas — LC Design + Cascade AI. Todos los derechos reservados.
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
