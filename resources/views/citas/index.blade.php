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
            <form method="POST" action="#" class="space-y-6">
                @csrf

                {{-- Personal Info --}}
                <fieldset>
                    <legend class="text-2xl font-bold mb-4">Información Personal</legend>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-gray-700 font-semibold mb-2">Nombre Completo *</label>
                            <input type="text" required class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-900">
                        </div>
                        <div>
                            <label class="block text-gray-700 font-semibold mb-2">Correo Electrónico *</label>
                            <input type="email" required class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-900">
                        </div>
                        <div>
                            <label class="block text-gray-700 font-semibold mb-2">Teléfono *</label>
                            <input type="tel" required class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-900">
                        </div>
                        <div>
                            <label class="block text-gray-700 font-semibold mb-2">Documento de Identidad</label>
                            <input type="text" class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-900">
                        </div>
                    </div>
                </fieldset>

                {{-- Consultation Type --}}
                <fieldset>
                    <legend class="text-2xl font-bold mb-4">Tipo de Consulta</legend>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <label class="flex items-center">
                            <input type="radio" name="tipo_consulta" required class="mr-3 w-4 h-4">
                            <span>Asesoría Legal</span>
                        </label>
                        <label class="flex items-center">
                            <input type="radio" name="tipo_consulta" required class="mr-3 w-4 h-4">
                            <span>Trámite Administrativo</span>
                        </label>
                        <label class="flex items-center">
                            <input type="radio" name="tipo_consulta" required class="mr-3 w-4 h-4">
                            <span>Defensa Penal</span>
                        </label>
                        <label class="flex items-center">
                            <input type="radio" name="tipo_consulta" required class="mr-3 w-4 h-4">
                            <span>Derechos Laborales</span>
                        </label>
                        <label class="flex items-center">
                            <input type="radio" name="tipo_consulta" required class="mr-3 w-4 h-4">
                            <span>Familia</span>
                        </label>
                        <label class="flex items-center">
                            <input type="radio" name="tipo_consulta" required class="mr-3 w-4 h-4">
                            <span>Otro</span>
                        </label>
                    </div>
                </fieldset>

                {{-- Description --}}
                <fieldset>
                    <legend class="text-2xl font-bold mb-4">Describe tu Situación</legend>
                    <textarea required rows="6" class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-900" placeholder="Cuéntanos brevemente sobre tu caso..."></textarea>
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
