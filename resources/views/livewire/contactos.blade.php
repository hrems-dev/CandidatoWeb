<div class="space-y-6">
    {{-- Búsqueda y Filtros --}}
    <div class="bg-white p-6 rounded-lg shadow-md">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <input
                    type="text"
                    placeholder="Buscar por nombre, email o asunto..."
                    wire:model.live="search"
                    class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-600"
                >
            </div>

            <div>
                <select
                    wire:model.live="filterEstado"
                    class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-600"
                >
                    <option value="">Todos los estados</option>
                    @foreach($estados as $estado)
                        <option value="{{ $estado }}">{{ ucfirst($estado) }}</option>
                    @endforeach
                </select>
            </div>

            <button
                wire:click="openModal"
                class="bg-blue-900 text-white px-6 py-2 rounded hover:bg-blue-800 transition font-semibold"
            >
                <i class="fas fa-plus mr-2"></i>Nuevo Contacto
            </button>
        </div>
    </div>

    {{-- Tabla de Contactos --}}
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <table class="w-full">
            <thead class="bg-gray-100 border-b">
                <tr>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Nombre</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Email</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Asunto</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Estado</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Fecha</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($contactos as $contacto)
                    <tr class="border-b hover:bg-gray-50 transition">
                        <td class="px-6 py-4 font-semibold text-gray-900">{{ $contacto->nombre }}</td>
                        <td class="px-6 py-4 text-sm text-gray-600">{{ $contacto->email }}</td>
                        <td class="px-6 py-4 text-sm">
                            <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-xs font-semibold truncate">
                                {{ substr($contacto->asunto, 0, 30) }}...
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            @if($contacto->estado === 'nuevo')
                                <span class="px-3 py-1 bg-yellow-100 text-yellow-800 rounded-full text-xs font-semibold">
                                    <i class="fas fa-star mr-1"></i>Nuevo
                                </span>
                            @elseif($contacto->estado === 'respondido')
                                <span class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-xs font-semibold">
                                    <i class="fas fa-reply mr-1"></i>Respondido
                                </span>
                            @elseif($contacto->estado === 'manejado')
                                <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-xs font-semibold">
                                    <i class="fas fa-check-circle mr-1"></i>Manejado
                                </span>
                            @else
                                <span class="px-3 py-1 bg-gray-100 text-gray-800 rounded-full text-xs font-semibold">
                                    {{ ucfirst($contacto->estado) }}
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600">
                            {{ $contacto->created_at->format('d/m/Y H:i') }}
                        </td>
                        <td class="px-6 py-4 text-sm space-x-2 flex flex-wrap gap-2">
                            <button
                                wire:click="edit({{ $contacto->id }})"
                                class="text-blue-600 hover:text-blue-900 hover:underline font-semibold"
                                title="Editar"
                            >
                                <i class="fas fa-edit"></i>
                            </button>
                            @if($contacto->estado === 'nuevo')
                                <button
                                    wire:click="openResponderModal({{ $contacto->id }})"
                                    class="text-green-600 hover:text-green-900 hover:underline font-semibold"
                                    title="Responder"
                                >
                                    <i class="fas fa-reply"></i>
                                </button>
                            @endif
                            @if($contacto->estado !== 'manejado')
                                <button
                                    wire:click="marcarManejado({{ $contacto->id }})"
                                    class="text-gray-600 hover:text-gray-900 hover:underline font-semibold"
                                    title="Marcar como manejado"
                                >
                                    <i class="fas fa-check"></i>
                                </button>
                            @endif
                            <button
                                wire:click="delete({{ $contacto->id }})"
                                wire:confirm="¿Estás seguro de que deseas eliminar este contacto?"
                                class="text-red-600 hover:text-red-900 hover:underline font-semibold"
                                title="Eliminar"
                            >
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-8 text-center text-gray-500">
                            <i class="fas fa-inbox text-4xl mb-4 block opacity-50"></i>
                            <p>No hay contactos disponibles</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Modal de Crear/Editar --}}
    @if($showModal)
        <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
            <div class="bg-white rounded-lg shadow-lg max-w-2xl w-full mx-4 max-h-screen overflow-y-auto">
                <div class="sticky top-0 bg-gray-50 border-b p-6 flex justify-between items-center">
                    <h2 class="text-2xl font-bold text-gray-800">
                        @if($editingId)
                            Editar Contacto
                        @else
                            Nuevo Contacto
                        @endif
                    </h2>
                    <button
                        wire:click="closeModal"
                        class="text-gray-500 hover:text-gray-700 text-2xl"
                    >
                        ✕
                    </button>
                </div>

                <form wire:submit="save" class="p-6 space-y-6">
                    {{-- Nombre --}}
                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">Nombre *</label>
                        <input
                            type="text"
                            wire:model.lazy="nombre"
                            placeholder="Nombre completo"
                            class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-600"
                            required
                        >
                        @error('nombre') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                    </div>

                    {{-- Email y Teléfono --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-gray-700 font-semibold mb-2">Email *</label>
                            <input
                                type="email"
                                wire:model.lazy="email"
                                placeholder="correo@ejemplo.com"
                                class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-600"
                                required
                            >
                            @error('email') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-gray-700 font-semibold mb-2">Teléfono</label>
                            <input
                                type="tel"
                                wire:model.lazy="telefono"
                                placeholder="+591 72345678"
                                class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-600"
                            >
                            @error('telefono') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    {{-- Asunto --}}
                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">Asunto *</label>
                        <input
                            type="text"
                            wire:model.lazy="asunto"
                            placeholder="Asunto del mensaje"
                            class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-600"
                            required
                        >
                        @error('asunto') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                    </div>

                    {{-- Mensaje --}}
                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">Mensaje *</label>
                        <textarea
                            wire:model.lazy="mensaje"
                            placeholder="Escribe tu mensaje"
                            rows="6"
                            class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-600"
                            required
                        ></textarea>
                        @error('mensaje') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                    </div>

                    {{-- Botones --}}
                    <div class="flex gap-4 pt-4">
                        <button
                            type="submit"
                            class="flex-1 bg-blue-900 text-white px-6 py-3 rounded hover:bg-blue-800 transition font-semibold"
                        >
                            <i class="fas fa-save mr-2"></i>
                            @if($editingId)
                                Guardar Cambios
                            @else
                                Crear Contacto
                            @endif
                        </button>
                        <button
                            type="button"
                            wire:click="closeModal"
                            class="flex-1 bg-gray-300 text-gray-700 px-6 py-3 rounded hover:bg-gray-400 transition font-semibold"
                        >
                            Cancelar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    {{-- Modal de Responder --}}
    @if($showResponderModal)
        <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
            <div class="bg-white rounded-lg shadow-lg max-w-2xl w-full mx-4">
                <div class="bg-gray-50 border-b p-6 flex justify-between items-center">
                    <h2 class="text-2xl font-bold text-gray-800">Responder Mensaje</h2>
                    <button
                        wire:click="closeResponderModal"
                        class="text-gray-500 hover:text-gray-700 text-2xl"
                    >
                        ✕
                    </button>
                </div>

                <form wire:submit="responder" class="p-6 space-y-6">
                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">Tu Respuesta *</label>
                        <textarea
                            wire:model.lazy="respuesta_admin"
                            placeholder="Escribe tu respuesta aquí"
                            rows="6"
                            class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-600"
                            required
                        ></textarea>
                        @error('respuesta_admin') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div class="flex gap-4">
                        <button
                            type="submit"
                            class="flex-1 bg-green-600 text-white px-6 py-3 rounded hover:bg-green-700 transition font-semibold"
                        >
                            <i class="fas fa-paper-plane mr-2"></i>Enviar Respuesta
                        </button>
                        <button
                            type="button"
                            wire:click="closeResponderModal"
                            class="flex-1 bg-gray-300 text-gray-700 px-6 py-3 rounded hover:bg-gray-400 transition font-semibold"
                        >
                            Cancelar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>
