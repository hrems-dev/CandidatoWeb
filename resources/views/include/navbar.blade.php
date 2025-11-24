<nav class="bg-white shadow-md sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            {{-- Logo --}}
            <div class="flex-shrink-0">
                <a href="{{ route('welcome') }}" class="flex items-center gap-2">
                    <img src="{{ asset('imagen/logo.png') }}" alt="Logo" class="h-10 w-10">
                    <span class="text-2xl font-bold text-blue-900">Percy Mamani</span>
                </a>
            </div>

            {{-- Menu Desktop --}}
            <div class="hidden md:flex space-x-8">
                <a href="{{ route('welcome') }}" class="text-gray-700 hover:text-blue-900 transition {{ Route::currentRouteName() === 'welcome' ? 'text-blue-900 font-semibold' : '' }}">
                    Inicio
                </a>
                <a href="{{ route('candidato.index') }}" class="text-gray-700 hover:text-blue-900 transition {{ Route::currentRouteName() === 'candidato.index' ? 'text-blue-900 font-semibold' : '' }}">
                    Candidato
                </a>
                <a href="{{ route('noticias.index') }}" class="text-gray-700 hover:text-blue-900 transition {{ Route::currentRouteName() === 'noticias.index' ? 'text-blue-900 font-semibold' : '' }}">
                    Noticias
                </a>
                <a href="{{ route('comentarios.index') }}" class="text-gray-700 hover:text-blue-900 transition {{ Route::currentRouteName() === 'comentarios.index' ? 'text-blue-900 font-semibold' : '' }}">
                    Comentarios
                </a>
                <a href="{{ route('citas.index') }}" class="text-gray-700 hover:text-blue-900 transition {{ Route::currentRouteName() === 'citas.index' ? 'text-blue-900 font-semibold' : '' }}">
                    Citas
                </a>
                <a href="{{ route('contacto.index') }}" class="text-gray-700 hover:text-blue-900 transition {{ Route::currentRouteName() === 'contacto.index' ? 'text-blue-900 font-semibold' : '' }}">
                    Contacto
                </a>
                <a href="{{ route('login') }}" class="bg-blue-900 text-white px-4 py-2 rounded hover:bg-blue-800 transition">
                    <i class="fas fa-lock mr-1"></i>Admin
                </a>
            </div>

            {{-- Menu Mobile --}}
            <div class="md:hidden">
                <button id="mobile-menu-btn" class="text-gray-700 hover:text-blue-900">
                    <i class="fas fa-bars text-2xl"></i>
                </button>
            </div>
        </div>
    </div>

    {{-- Mobile Menu --}}
    <div id="mobile-menu" class="hidden md:hidden bg-white border-t">
        <a href="{{ route('welcome') }}" class="block px-4 py-2 text-gray-700 hover:bg-blue-50">Inicio</a>
        <a href="{{ route('candidato.index') }}" class="block px-4 py-2 text-gray-700 hover:bg-blue-50">Candidato</a>
        <a href="{{ route('noticias.index') }}" class="block px-4 py-2 text-gray-700 hover:bg-blue-50">Noticias</a>
        <a href="{{ route('comentarios.index') }}" class="block px-4 py-2 text-gray-700 hover:bg-blue-50">Comentarios</a>
        <a href="{{ route('citas.index') }}" class="block px-4 py-2 text-gray-700 hover:bg-blue-50">Citas</a>
        <a href="{{ route('contacto.index') }}" class="block px-4 py-2 text-gray-700 hover:bg-blue-50">Contacto</a>
        <a href="{{ route('login') }}" class="block px-4 py-2 text-blue-900 font-semibold hover:bg-blue-50">Admin</a>
    </div>
</nav>

<script>
    document.getElementById('mobile-menu-btn').addEventListener('click', function() {
        const menu = document.getElementById('mobile-menu');
        menu.classList.toggle('hidden');
    });
</script>
