@include('include.head')

<div class="flex h-screen bg-gray-100">
    {{-- Sidebar Admin --}}
    <div class="w-64 bg-gray-900 text-white p-6 shadow-lg">
        <div class="mb-8">
            <h2 class="text-2xl font-bold">
                <i class="fas fa-lock mr-2"></i>Admin
            </h2>
            <p class="text-gray-400 text-sm mt-1">Percy Mamani</p>
        </div>
        
        <nav class="space-y-4">
            <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 rounded hover:bg-gray-800 transition">
                <i class="fas fa-chart-line mr-2"></i>Dashboard
            </a>
            <a href="{{ route('admin.citas.index') }}" class="block px-4 py-2 rounded bg-blue-600">
                <i class="fas fa-calendar mr-2"></i>Citas
            </a>
            <a href="{{ route('admin.noticias.index') }}" class="block px-4 py-2 rounded hover:bg-gray-800 transition">
                <i class="fas fa-newspaper mr-2"></i>Noticias
            </a>
            <a href="{{ route('admin.comentarios.index') }}" class="block px-4 py-2 rounded hover:bg-gray-800 transition">
                <i class="fas fa-comments mr-2"></i>Comentarios
            </a>
            <a href="{{ route('admin.contactos.index') }}" class="block px-4 py-2 rounded hover:bg-gray-800 transition">
                <i class="fas fa-envelope mr-2"></i>Contactos
            </a>
        </nav>
    </div>
    
    {{-- Main Content --}}
    <div class="flex-1 overflow-auto">
        {{-- Top Bar --}}
        <div class="bg-white border-b border-gray-200 p-6 flex justify-between items-center">
            <div>
                <a href="{{ route('admin.citas.index') }}" class="text-blue-600 hover:underline text-sm">
                    <i class="fas fa-arrow-left mr-2"></i>Volver
                </a>
                <h1 class="text-3xl font-bold text-gray-800">Detalles de Cita #{{ $id }}</h1>
            </div>
        </div>
        
        {{-- Content --}}
        <div class="p-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                {{-- Main Info --}}
                <div class="lg:col-span-2">
                    <div class="bg-white p-8 rounded-lg shadow-md mb-6">
                        <h2 class="text-2xl font-bold mb-6">Información de la Cita</h2>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <div>
                                <p class="text-gray-600 text-sm font-semibold">NOMBRE</p>
                                <p class="text-lg font-bold">Juan Pérez</p>
                            </div>
                            <div>
                                <p class="text-gray-600 text-sm font-semibold">CORREO</p>
                                <p class="text-lg font-bold">juan@example.com</p>
                            </div>
                            <div>
                                <p class="text-gray-600 text-sm font-semibold">TELÉFONO</p>
                                <p class="text-lg font-bold">+51 987 654 321</p>
                            </div>
                            <div>
                                <p class="text-gray-600 text-sm font-semibold">TIPO DE CONSULTA</p>
                                <p class="text-lg font-bold">Asesoría Legal</p>
                            </div>
                        </div>
                        
                        <div class="mb-6">
                            <p class="text-gray-600 text-sm font-semibold mb-2">DESCRIPCIÓN</p>
                            <p class="text-gray-700">Necesito asesoramiento sobre un tema legal...</p>
                        </div>
                    </div>
                    
                    <div class="bg-white p-8 rounded-lg shadow-md">
                        <h2 class="text-2xl font-bold mb-6">Acciones Sobre la Cita</h2>
                        
                        <div class="space-y-4">
                            <div>
                                <label class="block text-gray-700 font-semibold mb-2">Fecha de Cita</label>
                                <input type="date" class="w-full px-4 py-2 border border-gray-300 rounded">
                            </div>
                            
                            <div>
                                <label class="block text-gray-700 font-semibold mb-2">Hora de Cita</label>
                                <input type="time" class="w-full px-4 py-2 border border-gray-300 rounded">
                            </div>
                            
                            <div>
                                <label class="block text-gray-700 font-semibold mb-2">Motivo de Rechazo (si aplica)</label>
                                <textarea rows="3" class="w-full px-4 py-2 border border-gray-300 rounded"></textarea>
                            </div>
                            
                            <div class="flex gap-4 pt-4">
                                <button class="bg-green-500 text-white px-6 py-2 rounded hover:bg-green-600">
                                    <i class="fas fa-check mr-2"></i>Aceptar
                                </button>
                                <button class="bg-red-500 text-white px-6 py-2 rounded hover:bg-red-600">
                                    <i class="fas fa-times mr-2"></i>Rechazar
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                
                {{-- Sidebar --}}
                <div>
                    <div class="bg-white p-6 rounded-lg shadow-md">
                        <h3 class="font-bold mb-4">Estado Actual</h3>
                        <span class="px-4 py-2 bg-yellow-100 text-yellow-800 rounded-full font-semibold block text-center">Pendiente</span>
                        
                        <hr class="my-6">
                        
                        <h3 class="font-bold mb-4">Información Adicional</h3>
                        <ul class="space-y-2 text-sm text-gray-600">
                            <li><strong>Solicitud:</strong> 2025-11-23</li>
                            <li><strong>Documento:</strong> No proporcionado</li>
                            <li><strong>Ubicación:</strong> Carabaya</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
