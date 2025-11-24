<!-- resources/views/components/mobile-navigation.blade.php -->
<header x-data="{ open: false }" class="bg-white shadow-lg mb-5">
    <div class="max-w-7xl mx-auto px-4">
        <div class="flex justify-between items-center h-16">
            <!-- Logo con ícono -->
            <div class="flex items-center space-x-2">
                <i class="fa-regular fa-chart-bar text-blue-600 text-xl"></i>
                <a href="#1" class="text-xl font-bold text-gray-800 hover:text-blue-600">
                    Percy Mamani
                </a>
            </div>

            <!-- Botón hamburguesa (móvil) -->
            <div class="md:hidden">
                <button @click="open = !open" class="text-gray-700 hover:text-blue-600 focus:outline-none">
                    
                    <!-- Icono hamburguesa -->
                    <svg x-show="!open" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>

                    <!-- Icono cerrar -->
                    <svg x-show="open" x-cloak class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M6 18L18 6M6 6l12 12"/>
                    </svg>

                </button>
            </div>

            <!-- Menú desktop -->
            <nav class="hidden md:block">
                <ul class="flex items-center space-x-6">
                    <li>
                        <a href="#1" class="text-gray-700 hover:text-blue-600 transition flex items-center gap-2">
                            <i class="fa-solid fa-house"></i>
                            <span>Inicio</span>
                        </a>
                    </li>
                    <li>
                        <a href="#2" class="text-gray-700 hover:text-blue-600 transition flex items-center gap-2">
                            <i class="fa-solid fa-users"></i>
                            <span>Nosotros</span>
                        </a>
                    </li>
                    <li>
                        <a href="#3" class="text-gray-700 hover:text-blue-600 transition flex items-center gap-2">
                            <i class="fa-solid fa-scale-balanced"></i>
                            <span>Áreas legales</span>
                        </a>
                    </li>
                    <li>
                        <a href="#4" class="text-gray-700 hover:text-blue-600 transition flex items-center gap-2">
                            <i class="fa-solid fa-newspaper"></i>
                            <span>Publicaciones</span>
                        </a>
                    </li>
                    <li>
                        <a href="#5" class="text-gray-700 hover:text-blue-600 transition flex items-center gap-2">
                            <i class="fa-solid fa-envelope"></i>
                            <span>Contacto</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>

    <!-- Menú móvil -->
    <nav
        x-show="open"
        x-cloak
        x-transition
        class="md:hidden border-t border-gray-200"
    >
        <ul class="px-2 pt-2 pb-3 space-y-1">
            <li>
                <a href="#1" class="flex items-center gap-3 px-3 py-2 rounded-md text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition">
                    <i class="fa-solid fa-house w-5"></i>
                    <span>Inicio</span>
                </a>
            </li>
            <li>
                <a href="#2" class="flex items-center gap-3 px-3 py-2 rounded-md text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition">
                    <i class="fa-solid fa-users w-5"></i>
                    <span>Nosotros</span>
                </a>
            </li>
            <li>
                <a href="#3" class="flex items-center gap-3 px-3 py-2 rounded-md text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition">
                    <i class="fa-solid fa-scale-balanced w-5"></i>
                    <span>Áreas legales</span>
                </a>
            </li>
            <li>
                <a href="#4" class="flex items-center gap-3 px-3 py-2 rounded-md text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition">
                    <i class="fa-solid fa-newspaper w-5"></i>
                    <span>Publicaciones</span>
                </a>
            </li>
            <li>
                <a href="#5" class="flex items-center gap-3 px-3 py-2 rounded-md text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition">
                    <i class="fa-solid fa-envelope w-5"></i>
                    <span>Contacto</span>
                </a>
            </li>
        </ul>
    </nav>
</header>
