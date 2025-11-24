@include('include.head')

<div class="flex h-screen bg-gray-100">
    {{-- Sidebar Admin --}}
    <div class="w-64 bg-gray-900 text-white p-6 shadow-lg">
        <div class="mb-8">
            <h2 class="text-2xl font-bold">
                <i class="fas fa-lock mr-2"></i>Admin
            </h2>
            <p class="text-gray-400 text-sm mt-1">Percy Mamani</p>
        </div>

        <nav class="space-y-4">
            <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 rounded {{ Route::currentRouteName() === 'admin.dashboard' ? 'bg-blue-600' : 'hover:bg-gray-800' }} transition">
                <i class="fas fa-chart-line mr-2"></i>Dashboard
            </a>
            <a href="{{ route('admin.citas.index') }}" class="block px-4 py-2 rounded {{ str_contains(Route::currentRouteName(), 'admin.citas') ? 'bg-blue-600' : 'hover:bg-gray-800' }} transition">
                <i class="fas fa-calendar mr-2"></i>Citas
            </a>
            <a href="{{ route('admin.noticias.index') }}" class="block px-4 py-2 rounded {{ str_contains(Route::currentRouteName(), 'admin.noticias') ? 'bg-blue-600' : 'hover:bg-gray-800' }} transition">
                <i class="fas fa-newspaper mr-2"></i>Noticias
            </a>
            <a href="{{ route('admin.comentarios.index') }}" class="block px-4 py-2 rounded {{ str_contains(Route::currentRouteName(), 'admin.comentarios') ? 'bg-blue-600' : 'hover:bg-gray-800' }} transition">
                <i class="fas fa-comments mr-2"></i>Comentarios
            </a>
            <a href="{{ route('admin.contactos.index') }}" class="block px-4 py-2 rounded {{ str_contains(Route::currentRouteName(), 'admin.contactos') ? 'bg-blue-600' : 'hover:bg-gray-800' }} transition">
                <i class="fas fa-envelope mr-2"></i>Contactos
            </a>
        </nav>

        <hr class="my-6 border-gray-700">

        <div class="space-y-2">
            <a href="{{ route('profile.edit') }}" class="block px-4 py-2 rounded hover:bg-gray-800 transition text-sm">
                <i class="fas fa-user mr-2"></i>Mi Perfil
            </a>
            <form method="POST" action="{{ route('logout') }}" class="inline-block w-full">
                @csrf
                <button type="submit" class="w-full text-left px-4 py-2 rounded hover:bg-gray-800 transition text-sm">
                    <i class="fas fa-sign-out-alt mr-2"></i>Cerrar Sesión
                </button>
            </form>
        </div>
    </div>

    {{-- Main Content --}}
    <div class="flex-1 overflow-auto">
        {{-- Top Bar --}}
        <div class="bg-white border-b border-gray-200 p-6 flex justify-between items-center">
            <h1 class="text-3xl font-bold text-gray-800">Dashboard</h1>
            <div class="text-right">
                <p class="text-gray-600">
                    <i class="fas fa-user-circle mr-2"></i>
                    {{ Auth::user()->name ?? 'Admin' }}
                </p>
            </div>
        </div>

        {{-- Dashboard Content --}}
        <div class="p-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                {{-- Card Citas --}}
                <div class="bg-white p-6 rounded-lg shadow-md border-l-4 border-blue-500">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-gray-600 text-sm font-semibold">CITAS PENDIENTES</p>
                            <p class="text-3xl font-bold text-gray-800 mt-2">12</p>
                        </div>
                        <i class="fas fa-calendar text-blue-500 text-2xl"></i>
                    </div>
                    <a href="{{ route('admin.citas.index') }}" class="text-blue-500 text-sm mt-4 inline-block hover:underline">Ver todas →</a>
                </div>

                {{-- Card Noticias --}}
                <div class="bg-white p-6 rounded-lg shadow-md border-l-4 border-green-500">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-gray-600 text-sm font-semibold">NOTICIAS PUBLICADAS</p>
                            <p class="text-3xl font-bold text-gray-800 mt-2">8</p>
                        </div>
                        <i class="fas fa-newspaper text-green-500 text-2xl"></i>
                    </div>
                    <a href="{{ route('admin.noticias.index') }}" class="text-green-500 text-sm mt-4 inline-block hover:underline">Ver todas →</a>
                </div>

                {{-- Card Comentarios --}}
                <div class="bg-white p-6 rounded-lg shadow-md border-l-4 border-yellow-500">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-gray-600 text-sm font-semibold">COMENTARIOS PENDIENTES</p>
                            <p class="text-3xl font-bold text-gray-800 mt-2">5</p>
                        </div>
                        <i class="fas fa-comments text-yellow-500 text-2xl"></i>
                    </div>
                    <a href="{{ route('admin.comentarios.index') }}" class="text-yellow-500 text-sm mt-4 inline-block hover:underline">Ver todos →</a>
                </div>

                {{-- Card Contactos --}}
                <div class="bg-white p-6 rounded-lg shadow-md border-l-4 border-red-500">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-gray-600 text-sm font-semibold">MENSAJES NUEVOS</p>
                            <p class="text-3xl font-bold text-gray-800 mt-2">3</p>
                        </div>
                        <i class="fas fa-envelope text-red-500 text-2xl"></i>
                    </div>
                    <a href="{{ route('admin.contactos.index') }}" class="text-red-500 text-sm mt-4 inline-block hover:underline">Ver todos →</a>
                </div>
            </div>

            {{-- CRUD Citas Section --}}
            <div id="citas-section" class="mb-8">
                <h2 class="text-2xl font-bold text-gray-800 mb-6">Gestión de Citas</h2>
                @livewire('Citas')
            </div>

            {{-- CRUD Noticias Section --}}
            <div id="noticias-section" class="mb-8">
                <h2 class="text-2xl font-bold text-gray-800 mb-6">Gestión de Noticias</h2>
                @livewire('Noticias')
            </div>

            {{-- CRUD Contactos Section --}}
            <div id="contactos-section" class="mb-8">
                <h2 class="text-2xl font-bold text-gray-800 mb-6">Gestión de Contactos</h2>
                @livewire('Contactos')
            </div>

            {{-- Recent Activity --}}
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <h2 class="text-xl font-bold mb-4">Actividad Reciente</h2>
                    <div class="space-y-3">
                        <div class="flex items-center text-sm border-b pb-3">
                            <i class="fas fa-check-circle text-green-500 mr-3"></i>
                            <span class="text-gray-700">Cita #123 fue aceptada</span>
                            <span class="text-gray-500 ml-auto text-xs">Hace 2 horas</span>
                        </div>
                        <div class="flex items-center text-sm border-b pb-3">
                            <i class="fas fa-plus-circle text-blue-500 mr-3"></i>
                            <span class="text-gray-700">Nueva noticia creada</span>
                            <span class="text-gray-500 ml-auto text-xs">Hace 5 horas</span>
                        </div>
                        <div class="flex items-center text-sm">
                            <i class="fas fa-comment-circle text-yellow-500 mr-3"></i>
                            <span class="text-gray-700">Comentario pendiente de revisión</span>
                            <span class="text-gray-500 ml-auto text-xs">Hace 1 día</span>
                        </div>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-lg shadow-md">
                    <h2 class="text-xl font-bold mb-4">Estadísticas</h2>
                    <div class="space-y-3">
                        <div class="flex justify-between items-center">
                            <span class="text-gray-700">Citas Completadas</span>
                            <span class="font-bold text-gray-800">45</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-700">Citas Rechazadas</span>
                            <span class="font-bold text-gray-800">3</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-700">Comentarios Aprobados</span>
                            <span class="font-bold text-gray-800">28</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-700">Comentarios Rechazados</span>
                            <span class="font-bold text-gray-800">2</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
