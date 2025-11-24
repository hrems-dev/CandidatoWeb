<div class="space-y-6">
    {{-- Búsqueda y Filtros --}}
    <div class="bg-white p-6 rounded-lg shadow-md">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <input
                    type="text"
                    placeholder="Buscar noticias..."
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
                    <option value="borrador">Borrador</option>
                    <option value="publicado">Publicado</option>
                </select>
            </div>

            <div>
                <select
                    wire:model.live="filterTipo"
                    class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-600"
                >
                    <option value="">Todos los tipos</option>
                    <option value="noticia">Noticia</option>
                    <option value="actividad">Actividad</option>
                    <option value="evento">Evento</option>
                </select>
            </div>

            <button
                wire:click="openModal"
                class="bg-blue-900 text-white px-6 py-2 rounded hover:bg-blue-800 transition font-semibold"
            >
                <i class="fas fa-plus mr-2"></i>Nueva Noticia
            </button>
        </div>
    </div>

    {{-- Tabla de Noticias --}}
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <table class="w-full">
            <thead class="bg-gray-100 border-b">
                <tr>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Imagen</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Título</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Tipo</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Estado</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Fecha</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Vistas</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($noticias as $noticia)
                    <tr class="border-b hover:bg-gray-50 transition">
                        <td class="px-6 py-4">
                            @if($noticia->imagen)
                                <img src="{{ asset('storage/' . $noticia->imagen) }}"
                                     alt="{{ $noticia->titulo }}"
                                     class="h-12 w-12 object-cover rounded">
                            @else
                                <div class="h-12 w-12 bg-gray-200 rounded flex items-center justify-center">
                                    <i class="fas fa-image text-gray-400"></i>
                                </div>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <div class="font-semibold text-gray-900">{{ $noticia->titulo }}</div>
                            <div class="text-sm text-gray-500 truncate">{{ substr($noticia->contenido, 0, 50) }}...</div>
                        </td>
                        <td class="px-6 py-4 text-sm">
                            <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-xs font-semibold">
                                {{ ucfirst($noticia->tipo) }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            @if($noticia->estado === 'publicado')
                                <span class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-xs font-semibold">
                                    Publicado
                                </span>
                            @else
                                <span class="px-3 py-1 bg-yellow-100 text-yellow-800 rounded-full text-xs font-semibold">
                                    Borrador
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600">
                            {{ $noticia->fecha_publicacion ? $noticia->fecha_publicacion->format('d/m/Y') : 'No publicado' }}
                        </td>
                        <td class="px-6 py-4 text-sm text-center text-gray-600">
                            {{ $noticia->vistas ?? 0 }}
                        </td>
                        <td class="px-6 py-4 text-sm space-x-2">
                            <button
                                wire:click="edit({{ $noticia->id }})"
                                class="text-blue-600 hover:text-blue-900 hover:underline font-semibold"
                            >
                                <i class="fas fa-edit mr-1"></i>Editar
                            </button>
                            <button
                                wire:click="delete({{ $noticia->id }})"
                                wire:confirm="¿Estás seguro de que deseas eliminar esta noticia?"
                                class="text-red-600 hover:text-red-900 hover:underline font-semibold"
                            >
                                <i class="fas fa-trash mr-1"></i>Eliminar
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-6 py-8 text-center text-gray-500">
                            <i class="fas fa-inbox text-4xl mb-4 block opacity-50"></i>
                            <p>No hay noticias disponibles</p>
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
                            Editar Noticia
                        @else
                            Nueva Noticia
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
                    {{-- Título --}}
                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">Título *</label>
                        <input
                            type="text"
                            wire:model.lazy="titulo"
                            placeholder="Ingresa el título de la noticia"
                            class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-600"
                            required
                        >
                        @error('titulo') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                    </div>

                    {{-- Tipo y Estado --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-gray-700 font-semibold mb-2">Tipo *</label>
                            <select
                                wire:model.lazy="tipo"
                                class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-600"
                                required
                            >
                                <option value="">Selecciona un tipo</option>
                                <option value="noticia">Noticia</option>
                                <option value="actividad">Actividad</option>
                                <option value="evento">Evento</option>
                            </select>
                            @error('tipo') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-gray-700 font-semibold mb-2">Estado *</label>
                            <select
                                wire:model.lazy="estado"
                                class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-600"
                                required
                            >
                                <option value="borrador">Borrador</option>
                                <option value="publicado">Publicado</option>
                            </select>
                            @error('estado') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    {{-- Contenido --}}
                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">Contenido *</label>
                        <textarea
                            wire:model.lazy="contenido"
                            placeholder="Escribe el contenido de la noticia"
                            rows="6"
                            class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-600"
                            required
                        ></textarea>
                        @error('contenido') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                    </div>

                    {{-- Imagen --}}
                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">Imagen (JPG, PNG - máx 5MB)</label>

                        {{-- Vista previa de imagen actual o cargada --}}
                        @if($imagen_preview)
                            <div class="mb-4 relative">
                                <img src="{{ $imagen_preview }}" alt="Preview" class="h-48 w-full object-cover rounded">
                                <button
                                    type="button"
                                    wire:click="$set('imagen_preview', '')"
                                    class="absolute top-2 right-2 bg-red-600 text-white p-2 rounded-full hover:bg-red-700"
                                >
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        @endif

                        <input
                            type="file"
                            wire:model.lazy="imagen"
                            accept="image/*"
                            class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-600"
                        >
                        @error('imagen') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror

                        @if($imagen)
                            <p class="text-sm text-green-600 mt-2">
                                <i class="fas fa-check-circle mr-1"></i>Imagen lista para cargar
                            </p>
                        @endif
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
                                Crear Noticia
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
