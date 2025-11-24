@include('include.head')

<div class="container mx-auto">
    @include('include.navbar')

    {{-- Breadcrumb --}}
    <div class="bg-gray-100 py-4">
        <div class="max-w-7xl mx-auto px-4">
            <nav class="text-sm text-gray-600">
                <a href="{{ route('welcome') }}" class="hover:text-blue-900">Inicio</a>
                <span class="mx-2">/</span>
                <span class="text-blue-900 font-semibold">Candidato</span>
            </nav>
        </div>
    </div>

    {{-- Main Content --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">

        <h1 class="text-5xl font-bold mb-8">Sobre Percy Mamani</h1>

        {{-- About Section --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-12 mb-12">
            <div class="md:col-span-2">
                <h2 class="text-3xl font-bold mb-4">Biografía</h2>
                <p class="text-gray-700 mb-4">Lorem ipsum dolor sit amet...</p>
            </div>
            <div>
                <img src="{{ asset('imagen/portada.jpg') }}" alt="Percy Mamani" class="rounded-lg shadow-lg">
            </div>
        </div>

        {{-- Experience Section --}}
        <section class="mb-12">
            <h2 class="text-3xl font-bold mb-8">Experiencia Profesional</h2>
            <div class="space-y-6">
                <div class="border-l-4 border-blue-900 pl-6 py-2">
                    <h3 class="text-2xl font-bold">Cargo 1</h3>
                    <p class="text-blue-900">2020 - Presente</p>
                    <p class="text-gray-700 mt-2">Descripción de experiencia...</p>
                </div>
            </div>
        </section>

        {{-- Education Section --}}
        <section class="mb-12">
            <h2 class="text-3xl font-bold mb-8">Educación</h2>
            <div class="space-y-6">
                <div class="border-l-4 border-blue-900 pl-6 py-2">
                    <h3 class="text-2xl font-bold">Licenciado en Derecho</h3>
                    <p class="text-blue-900">Universidad</p>
                </div>
            </div>
        </section>

        {{-- Proposals Section --}}
        <section class="mb-12">
            <h2 class="text-3xl font-bold mb-8">Propuestas Principales</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-blue-50 p-6 rounded-lg">
                    <h3 class="text-xl font-bold mb-3">Propuesta 1</h3>
                    <p class="text-gray-700">Descripción de la propuesta...</p>
                </div>
            </div>
        </section>
    </div>

    @include('include.footer')
</div>
