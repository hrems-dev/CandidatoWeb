@include('include.head')

<div class="container mx-auto">
    @include('include.navbar')

    {{-- Breadcrumb --}}
    <div class="bg-gray-100 py-4">
        <div class="max-w-7xl mx-auto px-4">
            <nav class="text-sm text-gray-600">
                <a href="{{ route('welcome') }}" class="hover:text-blue-900">Inicio</a>
                <span class="mx-2">/</span>
                <span class="text-blue-900 font-semibold">Contacto</span>
            </nav>
        </div>
    </div>

    {{-- Main Content --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <h1 class="text-5xl font-bold mb-12">Contáctame</h1>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-12">
            {{-- Contact Info Cards --}}
            <div class="bg-blue-50 p-6 rounded-lg">
                <i class="fas fa-phone text-3xl text-blue-900 mb-4"></i>
                <h3 class="text-xl font-bold mb-2">Teléfono</h3>
                <p class="text-gray-700">+51 XXX XXX XXX</p>
            </div>

            <div class="bg-blue-50 p-6 rounded-lg">
                <i class="fas fa-envelope text-3xl text-blue-900 mb-4"></i>
                <h3 class="text-xl font-bold mb-2">Correo</h3>
                <p class="text-gray-700">contacto@percymamani.pe</p>
            </div>

            <div class="bg-blue-50 p-6 rounded-lg">
                <i class="fas fa-map-marker-alt text-3xl text-blue-900 mb-4"></i>
                <h3 class="text-xl font-bold mb-2">Ubicación</h3>
                <p class="text-gray-700">Carabaya, Puno</p>
            </div>
        </div>

        {{-- Contact Form --}}
        <div class="bg-white p-8 rounded-lg shadow-lg">
            <h2 class="text-2xl font-bold mb-6">Envía un Mensaje</h2>

            @if ($errors->any())
                <div class="mb-6 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if (session('success'))
                <div class="mb-6 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <form method="POST" action="{{ route('contacto.store') }}" class="space-y-6">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">Nombre *</label>
                        <input type="text" name="nombre" required class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-900 @error('nombre') border-red-500 @enderror" value="{{ old('nombre') }}">
                        @error('nombre') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">Correo Electrónico *</label>
                        <input type="email" name="email" required class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-900 @error('email') border-red-500 @enderror" value="{{ old('email') }}">
                        @error('email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div>
                    <label class="block text-gray-700 font-semibold mb-2">Teléfono</label>
                    <input type="tel" name="telefono" class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-900" value="{{ old('telefono') }}">
                </div>

                <div>
                    <label class="block text-gray-700 font-semibold mb-2">Asunto *</label>
                    <input type="text" name="asunto" required class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-900 @error('asunto') border-red-500 @enderror" value="{{ old('asunto') }}">
                    @error('asunto') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-gray-700 font-semibold mb-2">Mensaje *</label>
                    <textarea name="mensaje" required rows="8" class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-900 @error('mensaje') border-red-500 @enderror" placeholder="Tu mensaje aquí...">{{ old('mensaje') }}</textarea>
                    @error('mensaje') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <button type="submit" class="bg-blue-900 text-white px-8 py-3 rounded font-bold hover:bg-blue-800 transition w-full md:w-auto">
                    <i class="fas fa-paper-plane mr-2"></i>Enviar Mensaje
                </button>
            </form>
        </div>
    </div>

    @include('include.footer')
</div>
