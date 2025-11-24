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
            <a href="{{ route('admin.noticias.index') }}" class="block px-4 py-2 rounded bg-blue-600">
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
            <h1 class="text-3xl font-bold text-gray-800">Gestión de Noticias</h1>
            <a href="{{ route('admin.noticias.create') }}" class="bg-blue-900 text-white px-4 py-2 rounded hover:bg-blue-800">
                <i class="fas fa-plus mr-2"></i>Nueva Noticia
            </a>
        </div>
        
        {{-- Content --}}
        <div class="p-8">
            {{-- Noticias Table --}}
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <table class="w-full">
                    <thead class="bg-gray-100 border-b">
                        <tr>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Título</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Tipo</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Estado</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Fecha</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Vistas</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="border-b hover:bg-gray-50">
                            <td class="px-6 py-4 text-sm font-medium">Noticia Importante</td>
                            <td class="px-6 py-4 text-sm">Noticia</td>
                            <td class="px-6 py-4">
                                <span class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-xs font-semibold">Publicado</span>
                            </td>
                            <td class="px-6 py-4 text-sm">2025-11-23</td>
                            <td class="px-6 py-4 text-sm">245</td>
                            <td class="px-6 py-4 text-sm space-x-2">
                                <a href="{{ route('admin.noticias.edit', 1) }}" class="text-blue-600 hover:underline">Editar</a>
                                <button class="text-red-600 hover:underline">Eliminar</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
