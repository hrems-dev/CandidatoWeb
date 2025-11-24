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
        <h1 class="text-5xl font-bold mb-12">Lo que dicen de mi labor</h1>

        {{-- Comments Grid --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            {{-- Comment Card Template --}}
            <div class="bg-white p-6 rounded-lg shadow-md border-l-4 border-blue-900">
                <div class="flex items-center mb-4">
                    <div class="flex-1">
                        <h3 class="font-bold text-lg">Nombre Completo</h3>
                        <p class="text-sm text-gray-600">Ubicación</p>
                    </div>
                    <span class="bg-green-100 text-green-800 px-3 py-1 rounded text-sm font-semibold">Verificado</span>
                </div>

                {{-- Stars --}}
                <div class="flex gap-1 mb-4">
                    <i class="fas fa-star text-yellow-400"></i>
                    <i class="fas fa-star text-yellow-400"></i>
                    <i class="fas fa-star text-yellow-400"></i>
                    <i class="fas fa-star text-yellow-400"></i>
                    <i class="fas fa-star text-yellow-400"></i>
                </div>

                <p class="text-gray-700 mb-4">Comentario del usuario...</p>

                <div class="flex justify-between items-center text-sm text-gray-500">
                    <span><i class="far fa-calendar mr-2"></i>Fecha</span>
                    <span><i class="fas fa-thumbs-up mr-2"></i>123 likes</span>
                </div>
            </div>

             <div class="bg-white p-6 rounded-lg shadow-md border-l-4 border-blue-900">
                <div class="flex items-center mb-4">
                    <div class="flex-1">
                        <h3 class="font-bold text-lg">Nombre Completo</h3>
                        <p class="text-sm text-gray-600">Ubicación</p>
                    </div>
                    <span class="bg-green-100 text-green-800 px-3 py-1 rounded text-sm font-semibold">Verificado</span>
                </div>

                {{-- Stars --}}
                <div class="flex gap-1 mb-4">
                    <i class="fas fa-star text-yellow-400"></i>
                    <i class="fas fa-star text-yellow-400"></i>
                    <i class="fas fa-star text-yellow-400"></i>
                    <i class="fas fa-star text-yellow-400"></i>
                    <i class="fas fa-star text-yellow-400"></i>
                </div>

                <p class="text-gray-700 mb-4">Comentario del usuario...</p>

                <div class="flex justify-between items-center text-sm text-gray-500">
                    <span><i class="far fa-calendar mr-2"></i>Fecha</span>
                    <span><i class="fas fa-thumbs-up mr-2"></i>123 likes</span>
                </div>
            </div>

             <div class="bg-white p-6 rounded-lg shadow-md border-l-4 border-blue-900">
                <div class="flex items-center mb-4">
                    <div class="flex-1">
                        <h3 class="font-bold text-lg">Nombre Completo</h3>
                        <p class="text-sm text-gray-600">Ubicación</p>
                    </div>
                    <span class="bg-green-100 text-green-800 px-3 py-1 rounded text-sm font-semibold">Verificado</span>
                </div>

                {{-- Stars --}}
                <div class="flex gap-1 mb-4">
                    <i class="fas fa-star text-yellow-400"></i>
                    <i class="fas fa-star text-yellow-400"></i>
                    <i class="fas fa-star text-yellow-400"></i>
                    <i class="fas fa-star text-yellow-400"></i>
                    <i class="fas fa-star text-yellow-400"></i>
                </div>

                <p class="text-gray-700 mb-4">Comentario del usuario...</p>

                <div class="flex justify-between items-center text-sm text-gray-500">
                    <span><i class="far fa-calendar mr-2"></i>Fecha</span>
                    <span><i class="fas fa-thumbs-up mr-2"></i>123 likes</span>
                </div>
            </div>
             <div class="bg-white p-6 rounded-lg shadow-md border-l-4 border-blue-900">
                <div class="flex items-center mb-4">
                    <div class="flex-1">
                        <h3 class="font-bold text-lg">Juan Diego</h3>
                        <p class="text-sm text-gray-600">Ubicación</p>
                    </div>
                    <span class="bg-green-100 text-green-800 px-3 py-1 rounded text-sm font-semibold">Verificado</span>
                </div>

                {{-- Stars --}}
                <div class="flex gap-1 mb-4">
                    <i class="fas fa-star text-yellow-400"></i>
                    <i class="fas fa-star text-yellow-400"></i>
                    <i class="fas fa-star text-yellow-400"></i>
                    <i class="fas fa-star text-yellow-400"></i>
                    <i class="fas fa-star text-yellow-400"></i>
                </div>

                <p class="text-gray-700 mb-4">Percy fue de gran ayuda, gracias a su asesoria gratiuita pude ganar mis problemas legale!</p>

                <div class="flex justify-between items-center text-sm text-gray-500">
                    <span><i class="far fa-calendar mr-2"></i>Fecha</span>
                    <span><i class="fas fa-thumbs-up mr-2"></i>123 likes</span>
                </div>
            </div>
        </div>
    </div>

    @include('include.footer')
</div>
