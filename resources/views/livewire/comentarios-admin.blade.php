<div class="space-y-6">
    {{-- Header y Búsqueda --}}
    <div class="bg-gradient-to-r from-purple-900 to-purple-700 text-white p-8 rounded-lg shadow-lg">
        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-4xl font-bold mb-2">Gestión de Comentarios</h1>
                <p class="text-purple-100">Moderación y aprovación de comentarios de usuarios</p>
            </div>
            <button
                wire:click="openModal"
                class="bg-white text-purple-900 px-8 py-3 rounded-lg hover:bg-purple-50 transition font-bold flex items-center gap-2"
            >
                <i class="fas fa-plus"></i>Nuevo Comentario
            </button>
        </div>

        {{-- Búsqueda y Filtros --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="relative">
                <i class="fas fa-search absolute left-3 top-3 text-purple-300"></i>
                <input
                    type="text"
                    placeholder="Buscar por nombre o email..."
                    wire:model.live="search"
                    class="w-full pl-10 pr-4 py-2 border-0 rounded focus:outline-none focus:ring-2 focus:ring-white text-gray-800"
                >
            </div>

            <div>
                <select
                    wire:model.live="filterEstado"
                    class="w-full px-4 py-2 border-0 rounded focus:outline-none focus:ring-2 focus:ring-white text-gray-800"
                >
                    <option value="">Todos los estados</option>
                    @foreach($estados as $estado)
                        <option value="{{ $estado }}">{{ ucfirst($estado) }}</option>
                    @endforeach
                </select>
            </div>

            <div class="text-right text-purple-100">
                <p class="text-sm">Total: <span class="font-bold text-lg text-white">{{ count($comentarios) }}</span> comentarios</p>
            </div>
        </div>
    </div>

    {{-- Tabla de Comentarios --}}
    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gradient-to-r from-gray-800 to-gray-700 text-white">
                    <tr>
                        <th class="px-6 py-4 text-left text-sm font-bold">Autor</th>
                        <th class="px-6 py-4 text-left text-sm font-bold">Comentario</th>
                        <th class="px-6 py-4 text-center text-sm font-bold">Calificación</th>
                        <th class="px-6 py-4 text-center text-sm font-bold">Estado</th>
                        <th class="px-6 py-4 text-center text-sm font-bold">Fecha</th>
                        <th class="px-6 py-4 text-right text-sm font-bold">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @forelse($comentarios as $comentario)
                        <tr class="hover:bg-purple-50 transition">
                            {{-- Autor --}}
                            <td class="px-6 py-4">
                                <div>
                                    <p class="font-semibold text-gray-900">{{ $comentario['nombre'] }}</p>
                                    <p class="text-xs text-gray-500">{{ $comentario['email'] }}</p>
                                    @if($comentario['ubicacion'])
                                        <p class="text-xs text-gray-500">
                                            <i class="fas fa-map-marker-alt mr-1"></i>{{ $comentario['ubicacion'] }}
                                        </p>
                                    @endif
                                </div>
                            </td>

                            {{-- Comentario --}}
                            <td class="px-6 py-4">
                                <p class="text-sm text-gray-700 max-w-xs truncate" title="{{ $comentario['contenido'] }}">
                                    {{ substr($comentario['contenido'], 0, 60) }}{{ strlen($comentario['contenido']) > 60 ? '...' : '' }}
                                </p>
                            </td>

                            {{-- Calificación --}}
                            <td class="px-6 py-4 text-center">
                                <div class="flex justify-center gap-0.5">
                                    @for($i = 1; $i <= 5; $i++)
                                        @if($i <= $comentario['calificacion'])
                                            <i class="fas fa-star text-yellow-400"></i>
                                        @else
                                            <i class="fas fa-star text-gray-300"></i>
                                        @endif
                                    @endfor
                                </div>
                            </td>

                            {{-- Estado --}}
                            <td class="px-6 py-4 text-center">
                                @if($comentario['estado'] === 'pendiente')
                                    <span class="inline-flex items-center gap-1 px-3 py-1 bg-yellow-100 text-yellow-800 rounded-full text-xs font-bold">
                                        <i class="fas fa-hourglass-half"></i>Pendiente
                                    </span>
                                @elseif($comentario['estado'] === 'publicado')
                                    <span class="inline-flex items-center gap-1 px-3 py-1 bg-green-100 text-green-800 rounded-full text-xs font-bold">
                                        <i class="fas fa-check-circle"></i>Publicado
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 px-3 py-1 bg-red-100 text-red-800 rounded-full text-xs font-bold">
                                        <i class="fas fa-times-circle"></i>Rechazado
                                    </span>
                                @endif
                            </td>

                            {{-- Fecha --}}
                            <td class="px-6 py-4 text-center">
                                <p class="text-sm text-gray-600">
                                    {{ \Carbon\Carbon::parse($comentario['created_at'])->format('d/m/Y') }}
                                </p>
                                <p class="text-xs text-gray-500">
                                    {{ \Carbon\Carbon::parse($comentario['created_at'])->diffForHumans() }}
                                </p>
                            </td>

                            {{-- Acciones --}}
                            <td class="px-6 py-4 text-right">
                                <div class="flex justify-end gap-2 flex-wrap">
                                    @if($comentario['estado'] === 'pendiente')
                                        <button
                                            wire:click="aprobar({{ $comentario['id'] }})"
                                            class="bg-green-600 text-white px-3 py-1 rounded text-xs font-bold hover:bg-green-700 transition flex items-center gap-1"
                                            title="Aprobar comentario"
                                        >
                                            <i class="fas fa-check"></i>Aprobar
                                        </button>
                                        <button
                                            wire:click="rechazar({{ $comentario['id'] }})"
                                            class="bg-red-600 text-white px-3 py-1 rounded text-xs font-bold hover:bg-red-700 transition flex items-center gap-1"
                                            title="Rechazar comentario"
                                        >
                                            <i class="fas fa-times"></i>Rechazar
                                        </button>
                                    @endif

                                    <button
                                        wire:click="edit({{ $comentario['id'] }})"
                                        class="bg-gray-600 text-white px-3 py-1 rounded text-xs font-bold hover:bg-gray-700 transition flex items-center gap-1"
                                        title="Editar"
                                    >
                                        <i class="fas fa-edit"></i>Ver
                                    </button>

                                    <button
                                        wire:click="delete({{ $comentario['id'] }})"
                                        wire:confirm="¿Estás seguro de que deseas eliminar este comentario?"
                                        class="bg-red-500 text-white px-3 py-1 rounded text-xs font-bold hover:bg-red-600 transition flex items-center gap-1"
                                        title="Eliminar"
                                    >
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center">
                                <i class="fas fa-comments text-5xl text-gray-300 mb-4 block"></i>
                                <p class="text-gray-500 font-semibold">No hay comentarios disponibles</p>
                                <p class="text-gray-400 text-sm">Los usuarios verán aquí sus comentarios</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Modal de Crear/Editar --}}
    @if($showModal)
        <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
            <div class="bg-white rounded-lg shadow-lg max-w-2xl w-full mx-4 max-h-screen overflow-y-auto">
                <div class="sticky top-0 bg-gray-50 border-b p-6 flex justify-between items-center">
                    <h2 class="text-2xl font-bold text-gray-800">
                        @if($editingId)
                            Editar Comentario
                        @else
                            Nuevo Comentario
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
                            placeholder="Nombre del autor"
                            class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:border-purple-600"
                            required
                        >
                        @error('nombre') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                    </div>

                    {{-- Email y Ubicación --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-gray-700 font-semibold mb-2">Email *</label>
                            <input
                                type="email"
                                wire:model.lazy="email"
                                placeholder="correo@ejemplo.com"
                                class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:border-purple-600"
                                required
                            >
                            @error('email') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-gray-700 font-semibold mb-2">Ubicación</label>
                            <input
                                type="text"
                                wire:model.lazy="ubicacion"
                                placeholder="Ciudad, País"
                                class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:border-purple-600"
                            >
                            @error('ubicacion') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    {{-- Calificación --}}
                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">Calificación *</label>
                        <select
                            wire:model.lazy="calificacion"
                            class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:border-purple-600"
                            required
                        >
                            @for($i = 1; $i <= 5; $i++)
                                <option value="{{ $i }}">
                                    {{ str_repeat('⭐', $i) }} - {{ $i }} {{ $i == 1 ? 'estrella' : 'estrellas' }}
                                </option>
                            @endfor
                        </select>
                        @error('calificacion') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                    </div>

                    {{-- Contenido --}}
                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">Comentario *</label>
                        <textarea
                            wire:model.lazy="contenido"
                            placeholder="El contenido del comentario"
                            rows="5"
                            class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:border-purple-600"
                            required
                        ></textarea>
                        @error('contenido') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                    </div>

                    {{-- Botones --}}
                    <div class="flex gap-4 pt-4">
                        <button
                            type="submit"
                            class="flex-1 bg-purple-900 text-white px-6 py-3 rounded hover:bg-purple-800 transition font-semibold"
                        >
                            <i class="fas fa-save mr-2"></i>
                            @if($editingId)
                                Guardar Cambios
                            @else
                                Crear Comentario
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
</div>
