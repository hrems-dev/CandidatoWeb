<div class="w-full max-w-5xl mx-auto mb-10">

    <!-- Banner (imagen + texto) -->
    <div class="relative w-full h-80 md:h-[420px] rounded-2xl overflow-hidden">

        <!-- Imagen -->
        <img src="{{ asset('img/photo.jpg') }}" class="w-full h-full object-cover">

        <!-- Oscurecer solo en móvil -->
        <div class="absolute inset-0 bg-black/40 md:hidden"></div>

        <!-- Texto superpuesto en móvil -->
        <div class="absolute bottom-4 left-4 md:hidden text-white">
            <h1 class="text-3xl font-bold">Percy Mamani</h1>
            <p class="text-sm text-gray-200">Abogado</p>
        </div>

        <!-- Tarjeta en escritorio -->
        <div class="hidden md:flex absolute right-6 top-1/2 -translate-y-1/2
                    bg-white/90 backdrop-blur-md p-6 rounded-2xl shadow-lg
                    w-80 flex-col space-y-4">

            <div>
                <h1 class="text-3xl font-bold text-gray-900">Percy Mamani</h1>
                <p class="text-gray-600">Abogado</p>
            </div>

            <p class="text-gray-700 text-sm leading-relaxed">
                Esta es la sección de inicio donde puedes encontrar información relevante
                sobre nuestros servicios y novedades.
            </p>

            <p class="text-gray-700 text-sm leading-relaxed">
                Explora nuestras áreas legales, publicaciones y medios de contacto.
            </p>
        </div>

    </div>

    <!-- ESPECIALIDADES (SIEMPRE DEBAJO DEL BANNER) -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-6">

        <!-- Especialidad 1 -->
        <div class="flex items-start space-x-3 bg-white p-5 rounded-xl shadow">
            <div class="flex-shrink-0 bg-blue-600/10 p-3 rounded-lg">
                <i class="fa-solid fa-gavel text-blue-700 text-xl"></i>
            </div>
            <div>
                <h4 class="text-lg font-semibold text-gray-900">Derecho Civil</h4>
                <p class="text-sm text-gray-600 leading-snug">
                    Contratos, responsabilidad civil, sucesiones y derecho de familia.
                </p>
            </div>
        </div>

        <!-- Especialidad 2 -->
        <div class="flex items-start space-x-3 bg-white p-5 rounded-xl shadow">
            <div class="flex-shrink-0 bg-green-600/10 p-3 rounded-lg">
                <i class="fa-solid fa-scale-balanced text-green-700 text-xl"></i>
            </div>
            <div>
                <h4 class="text-lg font-semibold text-gray-900">Derecho Penal</h4>
                <p class="text-sm text-gray-600 leading-snug">
                    Defensa técnica en procesos penales y asesoría en diligencias fiscales.
                </p>
            </div>
        </div>

    </div>

</div>
