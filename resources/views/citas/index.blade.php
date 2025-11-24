@include('include.head')

<div class="container mx-auto">
    @include('include.navbar')

    {{-- Breadcrumb --}}
    <div class="bg-gray-100 py-4">
        <div class="max-w-7xl mx-auto px-4">
            <nav class="text-sm text-gray-600">
                <a href="{{ route('welcome') }}" class="hover:text-blue-900">Inicio</a>
                <span class="mx-2">/</span>
                <span class="text-blue-900 font-semibold">Agendar Cita</span>
            </nav>
        </div>
    </div>

    {{-- Main Content --}}
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <h1 class="text-5xl font-bold mb-4">Agendar Cita Legal</h1>
        <p class="text-xl text-gray-700 mb-12">Completa el formulario y recibirás una confirmación por correo. Las citas son gratuitas.</p>

        {{-- Form Section --}}
        <div class="bg-white p-8 rounded-lg shadow-lg">
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

            <form method="POST" action="{{ route('citas.store') }}" class="space-y-6">
                @csrf

                {{-- Personal Info --}}
                <fieldset>
                    <legend class="text-2xl font-bold mb-4">Información Personal</legend>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-gray-700 font-semibold mb-2">Nombre Completo *</label>
                            <input type="text" name="nombre" required class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-900 @error('nombre') border-red-500 @enderror" value="{{ old('nombre') }}">
                            @error('nombre') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-gray-700 font-semibold mb-2">Correo Electrónico *</label>
                            <input type="email" name="email" required class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-900 @error('email') border-red-500 @enderror" value="{{ old('email') }}">
                            @error('email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-gray-700 font-semibold mb-2">Teléfono *</label>
                            <input type="tel" name="telefono" required class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-900 @error('telefono') border-red-500 @enderror" value="{{ old('telefono') }}">
                            @error('telefono') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-gray-700 font-semibold mb-2">Documento de Identidad</label>
                            <input type="text" name="documento_identidad" class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-900" value="{{ old('documento_identidad') }}">
                        </div>
                    </div>
                </fieldset>

                {{-- Consultation Type --}}
                <fieldset>
                    <legend class="text-2xl font-bold mb-4">Tipo de Consulta</legend>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <label class="flex items-center">
                            <input type="radio" name="tipo_consulta" value="asesoría legal" required class="mr-3 w-4 h-4" {{ old('tipo_consulta') == 'asesoría legal' ? 'checked' : '' }}>
                            <span>Asesoría Legal</span>
                        </label>
                        <label class="flex items-center">
                            <input type="radio" name="tipo_consulta" value="trámite administrativo" required class="mr-3 w-4 h-4" {{ old('tipo_consulta') == 'trámite administrativo' ? 'checked' : '' }}>
                            <span>Trámite Administrativo</span>
                        </label>
                        <label class="flex items-center">
                            <input type="radio" name="tipo_consulta" value="defensa penal" required class="mr-3 w-4 h-4" {{ old('tipo_consulta') == 'defensa penal' ? 'checked' : '' }}>
                            <span>Defensa Penal</span>
                        </label>
                        <label class="flex items-center">
                            <input type="radio" name="tipo_consulta" value="derechos laborales" required class="mr-3 w-4 h-4" {{ old('tipo_consulta') == 'derechos laborales' ? 'checked' : '' }}>
                            <span>Derechos Laborales</span>
                        </label>
                        <label class="flex items-center">
                            <input type="radio" name="tipo_consulta" value="familia" required class="mr-3 w-4 h-4" {{ old('tipo_consulta') == 'familia' ? 'checked' : '' }}>
                            <span>Familia</span>
                        </label>
                        <label class="flex items-center">
                            <input type="radio" name="tipo_consulta" value="otro" required class="mr-3 w-4 h-4" {{ old('tipo_consulta') == 'otro' ? 'checked' : '' }}>
                            <span>Otro</span>
                        </label>
                    </div>
                    @error('tipo_consulta') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </fieldset>

                {{-- Description --}}
                <fieldset>
                    <legend class="text-2xl font-bold mb-4">Describe tu Situación</legend>
                    <textarea name="descripcion" required rows="6" class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-900 @error('descripcion') border-red-500 @enderror" placeholder="Cuéntanos brevemente sobre tu caso...">{{ old('descripcion') }}</textarea>
                    @error('descripcion') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </fieldset>

                {{-- Submit Button --}}
                <div class="flex gap-4">
                    <button type="submit" class="bg-blue-900 text-white px-8 py-3 rounded font-bold hover:bg-blue-800 transition">
                        <i class="fas fa-check mr-2"></i>Solicitar Cita
                    </button>
                    <button type="reset" class="bg-gray-300 text-gray-700 px-8 py-3 rounded font-bold hover:bg-gray-400 transition">
                        Limpiar
                    </button>
                </div>
            </form>
        </div>
    </div>

    @include('include.footer')
</div>
