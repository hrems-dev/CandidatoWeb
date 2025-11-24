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
            <div>
                <a href="{{ route('admin.noticias.index') }}" class="text-blue-600 hover:underline text-sm">
                    <i class="fas fa-arrow-left mr-2"></i>Volver
                </a>
                <h1 class="text-3xl font-bold text-gray-800">Crear Nueva Noticia</h1>
            </div>
        </div>
        
        {{-- Content --}}
        <div class="p-8">
            <div class="bg-white p-8 rounded-lg shadow-md max-w-4xl">
                <form method="POST" action="#" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    
                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">Título *</label>
                        <input type="text" required class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-900">
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-gray-700 font-semibold mb-2">Tipo *</label>
                            <select required class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-900">
                                <option value="">Selecciona un tipo</option>
                                <option>Noticia</option>
                                <option>Actividad</option>
                                <option>Evento</option>
                            </select>
                        </div>
                        
                        <div>
                            <label class="block text-gray-700 font-semibold mb-2">Estado *</label>
                            <select required class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-900">
                                <option>Borrador</option>
                                <option>Publicado</option>
                            </select>
                        </div>
                    </div>
                    
                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">Contenido *</label>
                        <textarea required rows="8" class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-900"></textarea>
                    </div>
                    
                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">Imagen</label>
                        <input type="file" accept="image/*" class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-900">
                    </div>
                    
                    <div class="flex gap-4">
                        <button type="submit" class="bg-blue-900 text-white px-8 py-2 rounded hover:bg-blue-800">
                            <i class="fas fa-save mr-2"></i>Guardar
                        </button>
                        <a href="{{ route('admin.noticias.index') }}" class="bg-gray-300 text-gray-700 px-8 py-2 rounded hover:bg-gray-400 inline-block">
                            Cancelar
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
