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
            <a href="{{ route('admin.comentarios.index') }}" class="block px-4 py-2 rounded hover:bg-gray-800 transition">
                <i class="fas fa-comments mr-2"></i>Comentarios
            </a>
            <a href="{{ route('admin.contactos.index') }}" class="block px-4 py-2 rounded bg-blue-600">
                <i class="fas fa-envelope mr-2"></i>Contactos
            </a>
        </nav>
    </div>
    
    {{-- Main Content --}}
    <div class="flex-1 overflow-auto">
        {{-- Top Bar --}}
        <div class="bg-white border-b border-gray-200 p-6 flex justify-between items-center">
            <h1 class="text-3xl font-bold text-gray-800">Gestión de Contactos</h1>
        </div>
        
        {{-- Content --}}
        <div class="p-8">
            {{-- Filters --}}
            <div class="bg-white p-6 rounded-lg shadow-md mb-6">
                <div class="flex gap-4 flex-wrap">
                    <button class="px-4 py-2 bg-blue-900 text-white rounded hover:bg-blue-800">Todos</button>
                    <button class="px-4 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300">Nuevos</button>
                    <button class="px-4 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300">Respondidos</button>
                </div>
            </div>
            
            {{-- Contactos Table --}}
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <table class="w-full">
                    <thead class="bg-gray-100 border-b">
                        <tr>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Nombre</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Correo</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Asunto</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Estado</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Fecha</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="border-b hover:bg-gray-50">
                            <td class="px-6 py-4 text-sm font-medium">Carlos López</td>
                            <td class="px-6 py-4 text-sm">carlos@example.com</td>
                            <td class="px-6 py-4 text-sm">Consulta sobre servicios</td>
                            <td class="px-6 py-4">
                                <span class="px-3 py-1 bg-red-100 text-red-800 rounded-full text-xs font-semibold">Nuevo</span>
                            </td>
                            <td class="px-6 py-4 text-sm">2025-11-23</td>
                            <td class="px-6 py-4 text-sm">
                                <a href="#" class="text-blue-600 hover:underline">Responder</a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
