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
            <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 rounded hover:bg-gray-800 transition">
                <i class="fas fa-chart-line mr-2"></i>Dashboard
            </a>
            <a href="{{ route('admin.citas.index') }}" class="block px-4 py-2 rounded bg-blue-600">
                <i class="fas fa-calendar mr-2"></i>Citas
            </a>
            <a href="{{ route('admin.noticias.index') }}" class="block px-4 py-2 rounded hover:bg-gray-800 transition">
                <i class="fas fa-newspaper mr-2"></i>Noticias
            </a>
            <a href="{{ route('admin.comentarios.index') }}" class="block px-4 py-2 rounded hover:bg-gray-800 transition">
                <i class="fas fa-comments mr-2"></i>Comentarios
            </a>
            <a href="{{ route('admin.contactos.index') }}" class="block px-4 py-2 rounded hover:bg-gray-800 transition">
                <i class="fas fa-envelope mr-2"></i>Contactos
            </a>
        </nav>
    </div>

    {{-- Main Content --}}
    <div class="flex-1 overflow-auto">
        {{-- Top Bar --}}
        <div class="bg-white border-b border-gray-200 p-6 flex justify-between items-center">
            <h1 class="text-3xl font-bold text-gray-800">Gestión de Citas</h1>
            <div class="text-right">
                <p class="text-gray-600">
                    <i class="fas fa-user-circle mr-2"></i>
                    {{ Auth::user()->name ?? 'Admin' }}
                </p>
            </div>
        </div>

        {{-- Content --}}
        <div class="p-8">
            {{-- Livewire Component --}}
            @livewire('citas')
        </div>
    </div>
</div>

@include('include.footer')
