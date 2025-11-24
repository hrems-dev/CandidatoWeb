@include('include.head')

<div class="container mx-auto">
    @include('include.navbar')
    
    {{-- Hero Section --}}
    <section class="bg-gradient-to-r from-blue-900 to-blue-800 text-white py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
                <div>
                    <h1 class="text-5xl font-bold mb-4">Percy Mamani</h1>
                    <p class="text-2xl text-blue-100 mb-6">Abogado y Líder Social de Carabaya</p>
                    <p class="text-lg text-blue-100 mb-8">Comprometido con la justicia, la igualdad y el desarrollo integral de nuestras comunidades.</p>
                    <div class="flex flex-col sm:flex-row gap-4">
                        <a href="{{ route('citas.index') }}" class="bg-white text-blue-900 px-8 py-3 rounded font-semibold hover:bg-blue-50 transition inline-block text-center">
                            <i class="fas fa-calendar mr-2"></i>Agendar Cita
                        </a>
                        <a href="{{ route('candidato.index') }}" class="bg-blue-700 text-white px-8 py-3 rounded font-semibold hover:bg-blue-600 transition inline-block text-center">
                            <i class="fas fa-info-circle mr-2"></i>Conóceme
                        </a>
                    </div>
                </div>
                <div>
                    <img src="{{ asset('images/portada.jpg') }}" alt="Percy Mamani" class="rounded-lg shadow-xl">
                </div>
            </div>
        </div>
    </section>
    
    {{-- Features Section --}}
    <section class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-4xl font-bold text-center mb-12">¿Qué ofrezco?</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-blue-50 p-8 rounded-lg hover:shadow-lg transition">
                    <i class="fas fa-balance-scale text-4xl text-blue-900 mb-4"></i>
                    <h3 class="text-2xl font-bold mb-3">Asesoría Legal</h3>
                    <p class="text-gray-700">Orientación profesional en temas legales y administrativos para ciudadanos de Carabaya.</p>
                </div>
                <div class="bg-blue-50 p-8 rounded-lg hover:shadow-lg transition">
                    <i class="fas fa-handshake text-4xl text-blue-900 mb-4"></i>
                    <h3 class="text-2xl font-bold mb-3">Defensa de Derechos</h3>
                    <p class="text-gray-700">Protección de tus derechos fundamentales con dedicación y compromiso.</p>
                </div>
                <div class="bg-blue-50 p-8 rounded-lg hover:shadow-lg transition">
                    <i class="fas fa-users text-4xl text-blue-900 mb-4"></i>
                    <h3 class="text-2xl font-bold mb-3">Liderazgo Social</h3>
                    <p class="text-gray-700">Trabaja conmigo por un cambio positivo en nuestras comunidades.</p>
                </div>
            </div>
        </div>
    </section>
    
    {{-- Call to Action --}}
    <section class="bg-blue-900 text-white py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-4xl font-bold mb-4">¿Necesitas asesoramiento?</h2>
            <p class="text-xl text-blue-100 mb-8">Estoy aquí para ayudarte. Agenda una cita hoy mismo.</p>
            <a href="{{ route('citas.index') }}" class="bg-white text-blue-900 px-8 py-4 rounded font-bold hover:bg-blue-50 transition inline-block">
                <i class="fas fa-calendar-check mr-2"></i>Agendar Cita Gratuita
            </a>
        </div>
    </section>
    
    @include('include.footer')
</div>
