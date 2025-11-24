@include('include.head')

<div class="container mx-auto">
    @include('include.navbar')
    
    {{-- Breadcrumb --}}
    <div class="bg-gray-100 py-4">
        <div class="max-w-7xl mx-auto px-4">
            <nav class="text-sm text-gray-600">
                <a href="{{ route('welcome') }}" class="hover:text-blue-900">Inicio</a>
                <span class="mx-2">/</span>
                <span class="text-blue-900 font-semibold">Noticias</span>
            </nav>
        </div>
    </div>
    
    {{-- Main Content --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <h1 class="text-5xl font-bold mb-12">Noticias y Actividades</h1>
        
        {{-- Filter Section --}}
        <div class="mb-8">
            <div class="flex gap-4 flex-wrap">
                <button class="px-4 py-2 bg-blue-900 text-white rounded hover:bg-blue-800">Todas</button>
                <button class="px-4 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300">Noticias</button>
                <button class="px-4 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300">Actividades</button>
                <button class="px-4 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300">Eventos</button>
            </div>
        </div>
        
        {{-- News Grid --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            {{-- News Card Template --}}
            <article class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition">
                <img src="https://via.placeholder.com/400x250" alt="Noticia" class="w-full h-48 object-cover">
                <div class="p-6">
                    <span class="text-sm text-blue-900 font-semibold">Noticia</span>
                    <h3 class="text-xl font-bold mt-2 mb-3">Título de la Noticia</h3>
                    <p class="text-gray-700 text-sm mb-4">Descripción breve de la noticia...</p>
                    <div class="flex justify-between items-center text-sm text-gray-500">
                        <span><i class="far fa-calendar mr-2"></i>Fecha</span>
                        <span><i class="far fa-eye mr-2"></i>123 vistas</span>
                    </div>
                </div>
            </article>
                        <article class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition">
                <img src="https://via.placeholder.com/400x250" alt="Noticia" class="w-full h-48 object-cover">
                <div class="p-6">
                    <span class="text-sm text-blue-900 font-semibold">Noticia</span>
                    <h3 class="text-xl font-bold mt-2 mb-3">Título de la Noticia</h3>
                    <p class="text-gray-700 text-sm mb-4">Descripción breve de la noticia...</p>
                    <div class="flex justify-between items-center text-sm text-gray-500">
                        <span><i class="far fa-calendar mr-2"></i>Fecha</span>
                        <span><i class="far fa-eye mr-2"></i>100 vistas</span>
                    </div>
                </div>
            </article>
                        <article class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition">
                <img src="https://via.placeholder.com/400x250" alt="Noticia" class="w-full h-48 object-cover">
                <div class="p-6">
                    <span class="text-sm text-blue-900 font-semibold">Noticia</span>
                    <h3 class="text-xl font-bold mt-2 mb-3">Título de la Noticia</h3>
                    <p class="text-gray-700 text-sm mb-4">Descripción breve de la noticia...</p>
                    <div class="flex justify-between items-center text-sm text-gray-500">
                        <span><i class="far fa-calendar mr-2"></i>Fecha</span>
                        <span><i class="far fa-eye mr-2"></i>123 vistas</span>
                    </div>
                </div>
            </article>
        </div>
    </div>
    
    @include('include.footer')
</div>
