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
            <a href="{{ route('admin.citas.index') }}" class="block px-4 py-2 rounded hover:bg-gray-800 transition">
                <i class="fas fa-calendar mr-2"></i>Citas
            </a>
            <a href="{{ route('admin.noticias.index') }}" class="block px-4 py-2 rounded hover:bg-gray-800 transition">
                <i class="fas fa-newspaper mr-2"></i>Noticias
            </a>
            <a href="{{ route('admin.comentarios.index') }}" class="block px-4 py-2 rounded bg-blue-600">
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
            <h1 class="text-3xl font-bold text-gray-800">Gestión de Comentarios</h1>
        </div>
        
        {{-- Content --}}
        <div class="p-8">
            {{-- Filters --}}
            <div class="bg-white p-6 rounded-lg shadow-md mb-6">
                <div class="flex gap-4 flex-wrap">
                    <button class="px-4 py-2 bg-blue-900 text-white rounded hover:bg-blue-800">Todos</button>
                    <button class="px-4 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300">Pendientes</button>
                    <button class="px-4 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300">Aprobados</button>
                    <button class="px-4 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300">Rechazados</button>
                </div>
            </div>
            
            {{-- Comentarios Grid --}}
            <div class="space-y-4">
                <div class="bg-white p-6 rounded-lg shadow-md border-l-4 border-yellow-500">
                    <div class="flex justify-between items-start mb-4">
                        <div>
                            <h3 class="font-bold text-lg">María García</h3>
                            <p class="text-sm text-gray-600">Carabaya</p>
                        </div>
                        <span class="px-3 py-1 bg-yellow-100 text-yellow-800 rounded-full text-xs font-semibold">Pendiente</span>
                    </div>
                    
                    <div class="flex gap-1 mb-3">
                        <i class="fas fa-star text-yellow-400"></i>
                        <i class="fas fa-star text-yellow-400"></i>
                        <i class="fas fa-star text-yellow-400"></i>
                        <i class="fas fa-star text-yellow-400"></i>
                        <i class="fas fa-star text-yellow-400"></i>
                    </div>
                    
                    <p class="text-gray-700 mb-4">Excelente trabajo, Percy ha sido de gran ayuda para nuestra comunidad...</p>
                    
                    <div class="flex gap-2">
                        <button class="bg-green-500 text-white px-4 py-2 rounded text-sm hover:bg-green-600">
                            <i class="fas fa-check mr-2"></i>Aprobar
                        </button>
                        <button class="bg-red-500 text-white px-4 py-2 rounded text-sm hover:bg-red-600">
                            <i class="fas fa-times mr-2"></i>Rechazar
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
