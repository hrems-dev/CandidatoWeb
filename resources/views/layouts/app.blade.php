<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'CandidatoWeb')</title>

    <!-- Tailwind CSS -->
    @vite('resources/css/app.css')

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Livewire Styles -->
    @livewireStyles

    @stack('styles')
</head>
<body class="bg-gray-50">
    <!-- Navigation -->
    <nav class="bg-white shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center">
                    <h1 class="text-2xl font-bold text-blue-600">
                        <a href="{{ route('welcome') }}">CandidatoWeb</a>
                    </h1>
                </div>

                <div class="hidden md:flex gap-8">
                    <a href="{{ route('noticias.index') }}" class="text-gray-700 hover:text-blue-600 transition">
                        Noticias
                    </a>
                    <a href="{{ route('citas.index') }}" class="text-gray-700 hover:text-blue-600 transition">
                        Citas
                    </a>
                    <a href="{{ route('contacto.index') }}" class="text-gray-700 hover:text-blue-600 transition">
                        Contacto
                    </a>

                    @auth
                        <a href="{{ route('admin.dashboard') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                            <i class="fas fa-tachometer-alt"></i> Admin
                        </a>
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="text-gray-700 hover:text-red-600 transition">
                                <i class="fas fa-sign-out-alt"></i> Logout
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="text-gray-700 hover:text-blue-600 transition">
                            <i class="fas fa-sign-in-alt"></i> Login
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-12 mt-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-8">
                <div>
                    <h3 class="text-xl font-bold mb-4">CandidatoWeb</h3>
                    <p class="text-gray-400">Plataforma integral de gestión política</p>
                </div>
                <div>
                    <h4 class="font-bold mb-4">Enlaces Rápidos</h4>
                    <ul class="space-y-2 text-gray-400">
                        <li><a href="{{ route('noticias.index') }}" class="hover:text-white">Noticias</a></li>
                        <li><a href="{{ route('citas.index') }}" class="hover:text-white">Solicitar Cita</a></li>
                        <li><a href="{{ route('contacto.index') }}" class="hover:text-white">Contacto</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-bold mb-4">Contacto</h4>
                    <ul class="space-y-2 text-gray-400">
                        <li><i class="fas fa-phone"></i> +51 987 654 321</li>
                        <li><i class="fas fa-envelope"></i> info@candidatoweb.com</li>
                        <li><i class="fas fa-map-marker-alt"></i> Lima, Perú</li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-gray-800 pt-8 text-center text-gray-400">
                <p>&copy; 2025 CandidatoWeb. Todos los derechos reservados.</p>
            </div>
        </div>
    </footer>

    <!-- Vite JS -->
    @vite('resources/js/app.js')

    <!-- Livewire Scripts -->
    @livewireScripts

    @stack('scripts')
</body>
</html>
