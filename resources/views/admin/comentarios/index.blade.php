@include('include.head')

<div class="flex h-screen bg-gray-100">
    {{-- Sidebar Admin --}}
    <div class="w-64 bg-gray-900 text-white p-6 shadow-lg overflow-y-auto">
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
        <div class="bg-white border-b border-gray-200 p-6 flex justify-between items-center sticky top-0 z-40">
            <h1 class="text-3xl font-bold text-gray-800">Gestión de Comentarios</h1>
            <div class="flex items-center gap-4">
                <span class="text-gray-600">Bienvenido Admin</span>
                <img src="https://ui-avatars.com/api/?name=Percy+Mamani" alt="Avatar" class="w-10 h-10 rounded-full">
            </div>
        </div>

        {{-- Page Content --}}
        <div class="p-8">
            @livewire('comentarios-admin')
        </div>
    </div>
</div>

@include('include.footer')
