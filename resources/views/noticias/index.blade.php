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
                <button class="px-4 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300">Noticias</button>
            </div>
        </div>

        {{-- News Grid --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            {{-- News Card Template --}}
            <article class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition">
                <a href="https://www.camarapuno.org/publicaciones/noticias/camara-de-comercio-impulsa-la-formalizacion-empresarial-con-la-gran-caravana-mype-en-carabaya"  target="blank" ><img src="imagen/caravaya.png" alt="Noticia" class="w-full h-48 object-cover"></a>
                <div class="p-6">
                    <span class="text-sm text-blue-900 font-semibold">Noticia</span>
                    <h3 class="text-xl font-bold mt-2 mb-3">Enfoque en el Impulso de Desarrollo</h3>
                    <p class="text-gray-700 text-sm mb-4">CÁMARA DE COMERCIO IMPULSA LA FORMALIZACIÓN EMPRESARIAL CON LA GRAN CARAVANA MYPE EN CARABAYA</p>
                    <div class="flex justify-between items-center text-sm text-gray-500">
                        <span><i class="far fa-calendar mr-2"></i>Fecha</span>
                        <span><i class="far fa-eye mr-2"></i>123 vistas</span>
                    </div>
                </div>
            </article>
                        <article class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition">
                <a href="https://www.diresapuno.gob.pe/reunion-de-directores-descentralizado-se-realizo-en-carabaya-con-presencia-del-titular-de-diresa-puno/" target="blank"><img src="imagen/abogados.jpg" alt="Noticia" class="w-full h-48 object-cover"></a>
                <div class="p-6">
                    <span class="text-sm text-blue-900 font-semibold">Noticia</span>
                    <h3 class="text-xl font-bold mt-2 mb-3">Enfoque en Servicios Esenciales y Derechos</h3>
                    <p class="text-gray-700 text-sm mb-4">Concentracion del partido para proponer normas para el impuslso de ayuda a la gente</p>
                    <div class="flex justify-between items-center text-sm text-gray-500">
                        <span><i class="far fa-calendar mr-2"></i>Fecha</span>
                        <span><i class="far fa-eye mr-2"></i>100 vistas</span>
                    </div>
                </div>
            </article>
                        <article class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition">
                <a href="https://www.youtube.com/watch?v=DcJZSPp1Kcg" target="blank"><img src="imagen/ayuda.webp" alt="Noticia" class="w-full h-48 object-cover"></a>
                <div class="p-6">
                    <span class="text-sm text-blue-900 font-semibold">Noticia</span>
                    <h3 class="text-xl font-bold mt-2 mb-3">Ayuda Social a Caravaya</h3>
                    <p class="text-gray-700 text-sm mb-4">El Gobierno acercó programas sociales y servicios esenciales a la población de Macusani, a más de 4500 m s. n. m., mediante la 15.ª edición de Ponle Punche y Ganamos Todos. Con módulos de orientación</p>
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
