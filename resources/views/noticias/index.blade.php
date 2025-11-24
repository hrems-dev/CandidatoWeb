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
        <div class="flex justify-between items-center mb-12">
            <div>
                <h1 class="text-5xl font-bold mb-2">Noticias y Actividades</h1>
                <p class="text-gray-600">Mantente actualizado con nuestras últimas noticias</p>
            </div>
        </div>

        {{-- Búsqueda y Filtros --}}
        <div class="mb-8 bg-white p-6 rounded-lg shadow-md">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <form action="{{ route('noticias.buscar') }}" method="GET" class="flex gap-2">
                    <input
                        type="text"
                        name="q"
                        placeholder="Buscar noticias..."
                        class="flex-1 px-4 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-600"
                        value="{{ request('q', '') }}"
                    >
                    <button type="submit" class="px-6 py-2 bg-blue-900 text-white rounded hover:bg-blue-800 transition">
                        <i class="fas fa-search"></i>
                    </button>
                </form>

                <div>
                    <select onchange="if(this.value) window.location.href = this.value;" class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-600">
                        <option value="">Filtrar por tipo</option>
                        <option value="{{ route('noticias.porTipo', 'noticia') }}">Noticias</option>
                        <option value="{{ route('noticias.porTipo', 'actividad') }}">Actividades</option>
                        <option value="{{ route('noticias.porTipo', 'evento') }}">Eventos</option>
                    </select>
                </div>

                <div class="flex items-center justify-end text-gray-600">
                    <span><strong>{{ $noticias->total() }}</strong> noticias encontradas</span>
                </div>
            </div>
        </div>

        {{-- Mensaje de búsqueda --}}
        @if(request('q'))
            <div class="mb-6 p-4 bg-blue-50 border border-blue-200 rounded text-blue-900">
                Resultados para: <strong>"{{ request('q') }}"</strong>
            </div>
        @endif

        {{-- News Grid --}}
        @if($noticias->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-12">
                @foreach($noticias as $noticia)
                    <article class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition transform hover:scale-105 duration-300">
                        {{-- Imagen --}}
                        <div class="relative h-48 overflow-hidden bg-gray-200">
                            @if($noticia->imagen)
                                <img src="{{ asset('storage/' . $noticia->imagen) }}"
                                     alt="{{ $noticia->titulo }}"
                                     class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-blue-500 to-blue-900">
                                    <i class="fas fa-newspaper text-white text-4xl opacity-50"></i>
                                </div>
                            @endif

                            {{-- Badge de tipo --}}
                            <span class="absolute top-4 left-4 bg-blue-900 text-white px-3 py-1 rounded-full text-xs font-semibold">
                                {{ ucfirst($noticia->tipo) }}
                            </span>

                            {{-- Contador de vistas --}}
                            <span class="absolute top-4 right-4 bg-black bg-opacity-50 text-white px-3 py-1 rounded text-xs font-semibold">
                                <i class="fas fa-eye mr-1"></i>{{ $noticia->vistas ?? 0 }}
                            </span>
                        </div>

                        {{-- Contenido --}}
                        <div class="p-6">
                            <a href="{{ route('noticias.show', $noticia->slug) }}" class="group">
                                <h3 class="text-xl font-bold mt-0 mb-3 group-hover:text-blue-900 transition">
                                    {{ $noticia->titulo }}
                                </h3>
                            </a>

                            {{-- Categoría --}}
                            @if($noticia->categoria)
                                <span class="inline-block mb-3 text-xs text-gray-500">
                                    <i class="fas fa-folder mr-1"></i>{{ $noticia->categoria }}
                                </span>
                            @endif

                            {{-- Resumen --}}
                            <p class="text-gray-700 text-sm mb-4 line-clamp-2">
                                {{ $noticia->resumen ?? substr($noticia->contenido, 0, 150) }}...
                            </p>

                            {{-- Footer --}}
                            <div class="flex justify-between items-center text-sm text-gray-500 pt-4 border-t">
                                <span>
                                    <i class="far fa-calendar mr-1"></i>
                                    {{ $noticia->fecha_publicacion?->format('d/m/Y') ?? $noticia->created_at->format('d/m/Y') }}
                                </span>
                                <a href="{{ route('noticias.show', $noticia->slug) }}" class="text-blue-900 font-semibold hover:underline">
                                    Leer más →
                                </a>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>

            {{-- Paginación --}}
            <div class="flex justify-center mb-12">
                {{ $noticias->links() }}
            </div>
        @else
            <div class="text-center py-12 bg-gray-50 rounded-lg">
                <i class="fas fa-inbox text-6xl text-gray-300 mb-4 block"></i>
                <h3 class="text-2xl font-semibold text-gray-600 mb-2">No hay noticias disponibles</h3>
                <p class="text-gray-500">Pronto habrá nuevas noticias para compartir contigo</p>
                <a href="{{ route('noticias.index') }}" class="inline-block mt-4 px-6 py-2 bg-blue-900 text-white rounded hover:bg-blue-800 transition">
                    Ver todas las noticias
                </a>
            </div>
        @endif
    </div>

    @include('include.footer')
</div>

