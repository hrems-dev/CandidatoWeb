@include('include.head')

<div class="container mx-auto">
    @include('include.navbar')

    {{-- Breadcrumb --}}
    <div class="bg-gray-100 py-4">
        <div class="max-w-7xl mx-auto px-4">
            <nav class="text-sm text-gray-600">
                <a href="{{ route('welcome') }}" class="hover:text-blue-900">Inicio</a>
                <span class="mx-2">/</span>
                <a href="{{ route('noticias.index') }}" class="hover:text-blue-900">Noticias</a>
                <span class="mx-2">/</span>
                <span class="text-blue-900 font-semibold">{{ $noticia->titulo }}</span>
            </nav>
        </div>
    </div>

    {{-- Main Content --}}
    <div class="max-w-4xl mx-auto px-4 py-12">
        {{-- Imagen principal --}}
        <div class="mb-8 rounded-lg overflow-hidden shadow-lg">
            @if($noticia->imagen)
                <img src="{{ asset('storage/' . $noticia->imagen) }}"
                     alt="{{ $noticia->titulo }}"
                     class="w-full h-96 object-cover">
            @else
                <div class="w-full h-96 bg-gradient-to-br from-blue-500 to-blue-900 flex items-center justify-center">
                    <i class="fas fa-newspaper text-white text-6xl opacity-50"></i>
                </div>
            @endif
        </div>

        {{-- Header --}}
        <div class="mb-8">
            <div class="flex flex-wrap gap-3 mb-4">
                <span class="bg-blue-900 text-white px-4 py-1 rounded-full text-sm font-semibold">
                    {{ ucfirst($noticia->tipo) }}
                </span>
                @if($noticia->categoria)
                    <span class="bg-gray-200 text-gray-800 px-4 py-1 rounded-full text-sm font-semibold">
                        {{ $noticia->categoria }}
                    </span>
                @endif
                <span class="bg-gray-100 text-gray-700 px-4 py-1 rounded-full text-sm">
                    <i class="fas fa-eye mr-1"></i>{{ $noticia->vistas ?? 0 }} vistas
                </span>
            </div>

            <h1 class="text-5xl font-bold mb-4 text-gray-900">{{ $noticia->titulo }}</h1>

            <div class="flex items-center gap-6 text-gray-600 pb-6 border-b">
                <span>
                    <i class="fas fa-calendar mr-2 text-blue-900"></i>
                    {{ $noticia->fecha_publicacion?->format('d \d\e F \d\e Y') ?? $noticia->created_at->format('d \d\e F \d\e Y') }}
                </span>
                <span>
                    <i class="fas fa-user-circle mr-2 text-blue-900"></i>
                    Publicado por
                </span>
            </div>
        </div>

        {{-- Resumen/Descripción --}}
        @if($noticia->resumen)
            <div class="bg-blue-50 border-l-4 border-blue-900 p-6 mb-8 rounded">
                <p class="text-lg text-gray-700 leading-relaxed">{{ $noticia->resumen }}</p>
            </div>
        @endif

        {{-- Contenido --}}
        <article class="prose prose-lg max-w-none mb-12 text-gray-700 leading-relaxed">
            <div class="whitespace-pre-wrap">{{ $noticia->contenido }}</div>
        </article>

        {{-- Compartir --}}
        <div class="bg-gray-50 p-6 rounded-lg mb-12 border border-gray-200">
            <h3 class="font-bold text-lg mb-4">Compartir esta noticia:</h3>
            <div class="flex gap-4 flex-wrap">
                <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(route('noticias.show', $noticia->slug)) }}"
                   target="_blank"
                   class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700 transition flex items-center gap-2">
                    <i class="fab fa-facebook"></i>Facebook
                </a>
                <a href="https://twitter.com/intent/tweet?url={{ urlencode(route('noticias.show', $noticia->slug)) }}&text={{ urlencode($noticia->titulo) }}"
                   target="_blank"
                   class="bg-blue-400 text-white px-6 py-2 rounded hover:bg-blue-500 transition flex items-center gap-2">
                    <i class="fab fa-twitter"></i>Twitter
                </a>
                <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode(route('noticias.show', $noticia->slug)) }}"
                   target="_blank"
                   class="bg-blue-700 text-white px-6 py-2 rounded hover:bg-blue-800 transition flex items-center gap-2">
                    <i class="fab fa-linkedin"></i>LinkedIn
                </a>
                <a href="mailto:?subject={{ urlencode($noticia->titulo) }}&body={{ urlencode(route('noticias.show', $noticia->slug)) }}"
                   class="bg-gray-600 text-white px-6 py-2 rounded hover:bg-gray-700 transition flex items-center gap-2">
                    <i class="fas fa-envelope"></i>Email
                </a>
            </div>
        </div>

        {{-- Noticias Relacionadas --}}
        @if($relacionadas->count() > 0)
            <section class="mb-12">
                <h2 class="text-3xl font-bold mb-8">Noticias Relacionadas</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    @foreach($relacionadas as $item)
                        <a href="{{ route('noticias.show', $item->slug) }}" class="group">
                            <article class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition transform hover:scale-105">
                                <div class="h-40 overflow-hidden bg-gray-200">
                                    @if($item->imagen)
                                        <img src="{{ asset('storage/' . $item->imagen) }}"
                                             alt="{{ $item->titulo }}"
                                             class="w-full h-full object-cover group-hover:scale-110 transition duration-300">
                                    @else
                                        <div class="w-full h-full bg-gradient-to-br from-blue-400 to-blue-800 flex items-center justify-center">
                                            <i class="fas fa-newspaper text-white text-3xl opacity-50"></i>
                                        </div>
                                    @endif
                                </div>
                                <div class="p-4">
                                    <h3 class="font-bold text-lg group-hover:text-blue-900 transition mb-2">
                                        {{ $item->titulo }}
                                    </h3>
                                    <p class="text-sm text-gray-600 line-clamp-2">
                                        {{ $item->resumen ?? substr($item->contenido, 0, 80) }}...
                                    </p>
                                    <span class="text-xs text-gray-500 block mt-2">
                                        {{ $item->fecha_publicacion?->format('d/m/Y') ?? $item->created_at->format('d/m/Y') }}
                                    </span>
                                </div>
                            </article>
                        </a>
                    @endforeach
                </div>
            </section>
        @endif

        {{-- Newsletter --}}
        <div class="bg-gradient-to-r from-blue-900 to-blue-700 text-white p-8 rounded-lg mb-12">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-center">
                <div>
                    <h2 class="text-2xl font-bold mb-2">¡Suscríbete a nuestro boletín!</h2>
                    <p class="text-blue-100">Recibe las últimas noticias y actualizaciones en tu correo</p>
                </div>
                <form class="flex gap-2">
                    <input
                        type="email"
                        placeholder="Tu email"
                        required
                        class="flex-1 px-4 py-3 rounded text-gray-900 focus:outline-none"
                    >
                    <button
                        type="submit"
                        class="bg-white text-blue-900 px-6 py-3 rounded font-bold hover:bg-blue-50 transition whitespace-nowrap"
                    >
                        Suscribirse
                    </button>
                </form>
            </div>
        </div>
    </div>

    @include('include.footer')
</div>
