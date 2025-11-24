@include('include.head')

<div class="container mx-auto">
    @include('include.navbar')

    {{-- Breadcrumb --}}
    <div class="bg-gray-100 py-4">
        <div class="max-w-7xl mx-auto px-4">
            <nav class="text-sm text-gray-600">
                <a href="{{ route('welcome') }}" class="hover:text-blue-900">Inicio</a>
                <span class="mx-2">/</span>
                <span class="text-blue-900 font-semibold">Comentarios</span>
            </nav>
        </div>
    </div>

    {{-- Main Content --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="mb-12">
            <h1 class="text-5xl font-bold mb-2">Lo que dicen de mi labor</h1>
            <p class="text-xl text-gray-600">Opiniones y testimonios de las personas que hemos ayudado</p>
        </div>

        {{-- Estadísticas --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
            <div class="bg-blue-50 p-6 rounded-lg border border-blue-200">
                <div class="text-center">
                    <div class="text-4xl font-bold text-blue-900 mb-2">{{ $total ?? 0 }}</div>
                    <p class="text-gray-600">Comentarios Verificados</p>
                </div>
            </div>

            <div class="bg-yellow-50 p-6 rounded-lg border border-yellow-200">
                <div class="text-center">
                    <div class="flex justify-center items-center gap-1 mb-2">
                        @for($i = 1; $i <= 5; $i++)
                            @if($i <= round($calificacionPromedio ?? 0))
                                <i class="fas fa-star text-yellow-400 text-2xl"></i>
                            @else
                                <i class="fas fa-star text-gray-300 text-2xl"></i>
                            @endif
                        @endfor
                    </div>
                    <p class="text-gray-600">{{ number_format($calificacionPromedio ?? 0, 1) }} de 5.0</p>
                </div>
            </div>

            <div class="bg-green-50 p-6 rounded-lg border border-green-200">
                <div class="text-center">
                    <div class="text-2xl text-green-600 mb-2">
                        <i class="fas fa-heart"></i>
                    </div>
                    <p class="text-gray-600">Tu confianza es nuestro mejor aval</p>
                </div>
            </div>
        </div>

        {{-- Formulario para agregar comentario --}}
        <div class="bg-white p-8 rounded-lg shadow-md mb-12">
            <h2 class="text-2xl font-bold mb-6">Deja tu comentario</h2>

            @if(session('success'))
                <div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-800 rounded">
                    <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
                </div>
            @endif

            <form action="{{ route('comentarios.store') }}" method="POST" class="space-y-6">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block font-semibold text-gray-700 mb-2">Nombre *</label>
                        <input
                            type="text"
                            name="nombre"
                            required
                            placeholder="Tu nombre completo"
                            class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-600"
                            value="{{ old('nombre') }}"
                        >
                        @error('nombre')<span class="text-red-600 text-sm">{{ $message }}</span>@enderror
                    </div>

                    <div>
                        <label class="block font-semibold text-gray-700 mb-2">Email *</label>
                        <input
                            type="email"
                            name="email"
                            required
                            placeholder="tu@email.com"
                            class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-600"
                            value="{{ old('email') }}"
                        >
                        @error('email')<span class="text-red-600 text-sm">{{ $message }}</span>@enderror
                    </div>
                </div>

                <div>
                    <label class="block font-semibold text-gray-700 mb-2">Ubicación (Opcional)</label>
                    <input
                        type="text"
                        name="ubicacion"
                        placeholder="Tu ciudad"
                        class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-600"
                        value="{{ old('ubicacion') }}"
                    >
                    @error('ubicacion')<span class="text-red-600 text-sm">{{ $message }}</span>@enderror
                </div>

                <div>
                    <label class="block font-semibold text-gray-700 mb-2">Tu Calificación *</label>
                    <div class="flex gap-2 text-3xl">
                        @for($i = 1; $i <= 5; $i++)
                            <input
                                type="radio"
                                name="calificacion"
                                value="{{ $i }}"
                                id="star{{ $i }}"
                                class="hidden"
                                @if(old('calificacion') == $i) checked @endif
                            >
                            <label for="star{{ $i }}" class="cursor-pointer transition hover:scale-110">
                                <i class="fas fa-star text-gray-300 hover:text-yellow-400" data-value="{{ $i }}"></i>
                            </label>
                        @endfor
                    </div>
                    @error('calificacion')<span class="text-red-600 text-sm">{{ $message }}</span>@enderror
                </div>

                <div>
                    <label class="block font-semibold text-gray-700 mb-2">Tu Comentario *</label>
                    <textarea
                        name="contenido"
                        required
                        placeholder="Comparte tu experiencia... (mínimo 10 caracteres)"
                        rows="6"
                        class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-600"
                    >{{ old('contenido') }}</textarea>
                    @error('contenido')<span class="text-red-600 text-sm">{{ $message }}</span>@enderror
                </div>

                <div class="bg-blue-50 border border-blue-200 p-4 rounded text-sm text-blue-900">
                    <i class="fas fa-info-circle mr-2"></i>
                    Tu comentario será revisado antes de ser publicado para mantener una comunidad segura y respetuosa.
                </div>

                <button
                    type="submit"
                    class="w-full bg-blue-900 text-white font-bold py-3 rounded hover:bg-blue-800 transition flex items-center justify-center gap-2"
                >
                    <i class="fas fa-paper-plane"></i>Enviar Comentario
                </button>
            </form>
        </div>

        {{-- Comments Grid --}}
        @if($comentarios->count() > 0)
            <h2 class="text-3xl font-bold mb-8">Comentarios Verificados</h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-12">
                @foreach($comentarios as $comentario)
                    <div class="bg-white p-6 rounded-lg shadow-md border-l-4 border-blue-900 hover:shadow-lg transition">
                        {{-- Header --}}
                        <div class="flex items-start justify-between mb-4">
                            <div class="flex-1">
                                <h3 class="font-bold text-lg">{{ $comentario->nombre }}</h3>
                                @if($comentario->ubicacion)
                                    <p class="text-sm text-gray-600">
                                        <i class="fas fa-map-marker-alt mr-1"></i>{{ $comentario->ubicacion }}
                                    </p>
                                @endif
                            </div>
                            <span class="bg-green-100 text-green-800 px-3 py-1 rounded text-xs font-semibold whitespace-nowrap ml-2">
                                <i class="fas fa-check-circle mr-1"></i>Verificado
                            </span>
                        </div>

                        {{-- Calificación con estrellas --}}
                        <div class="flex gap-1 mb-4">
                            @for($i = 1; $i <= 5; $i++)
                                @if($i <= $comentario->calificacion)
                                    <i class="fas fa-star text-yellow-400"></i>
                                @else
                                    <i class="fas fa-star text-gray-300"></i>
                                @endif
                            @endfor
                        </div>

                        {{-- Contenido --}}
                        <p class="text-gray-700 mb-4 leading-relaxed">
                            "{{ $comentario->contenido }}"
                        </p>

                        {{-- Footer --}}
                        <div class="flex justify-between items-center text-sm text-gray-500 pt-4 border-t">
                            <span>
                                <i class="far fa-calendar mr-1"></i>
                                {{ $comentario->created_at->format('d/m/Y') }}
                            </span>
                            <form action="{{ route('comentarios.like', $comentario->id) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="text-red-600 hover:text-red-800 font-semibold transition">
                                    <i class="fas fa-heart mr-1"></i>
                                    <span>{{ $comentario->likes ?? 0 }}</span>
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Paginación --}}
            <div class="flex justify-center mb-12">
                {{ $comentarios->links() }}
            </div>
        @else
            <div class="text-center py-12 bg-gray-50 rounded-lg">
                <i class="fas fa-comments text-6xl text-gray-300 mb-4 block"></i>
                <h3 class="text-2xl font-semibold text-gray-600 mb-2">Aún no hay comentarios</h3>
                <p class="text-gray-500">¡Sé el primero en compartir tu experiencia!</p>
            </div>
        @endif
    </div>

    @include('include.footer')
</div>

<script>
    // Interactividad para las estrellas de calificación
    document.querySelectorAll('.fa-star').forEach(star => {
        star.addEventListener('click', function() {
            const value = this.dataset.value;
            document.querySelector(`#star${value}`).checked = true;
        });

        star.addEventListener('mouseover', function() {
            const value = this.dataset.value;
            document.querySelectorAll('.fa-star').forEach((s, index) => {
                if (index < value) {
                    s.classList.add('text-yellow-400');
                    s.classList.remove('text-gray-300');
                } else {
                    s.classList.add('text-gray-300');
                    s.classList.remove('text-yellow-400');
                }
            });
        });
    });

    document.querySelector('.flex.gap-2')?.addEventListener('mouseout', function() {
        const checked = document.querySelector('input[name="calificacion"]:checked');
        document.querySelectorAll('.fa-star').forEach((s, index) => {
            if (checked && index < checked.value) {
                s.classList.add('text-yellow-400');
                s.classList.remove('text-gray-300');
            } else {
                s.classList.add('text-gray-300');
                s.classList.remove('text-yellow-400');
            }
        });
    });
</script>

