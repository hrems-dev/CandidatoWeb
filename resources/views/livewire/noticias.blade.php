<div class="space-y-6">
    {{-- ESTADÍSTICAS --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        {{-- Total de Noticias --}}
        <div class="bg-gradient-to-br from-blue-500 to-blue-700 text-white p-6 rounded-lg shadow-lg">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-blue-100 text-sm font-medium">Total de Noticias</p>
                    <p class="text-4xl font-bold mt-2">{{ $totalNoticias }}</p>
                </div>
                <i class="fas fa-newspaper text-blue-300 text-4xl opacity-50"></i>
            </div>
        </div>

        {{-- Noticias Publicadas --}}
        <div class="bg-gradient-to-br from-green-500 to-green-700 text-white p-6 rounded-lg shadow-lg">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-green-100 text-sm font-medium">Publicadas</p>
                    <p class="text-4xl font-bold mt-2">{{ $noticiasPublicadas }}</p>
                </div>
                <i class="fas fa-check-circle text-green-300 text-4xl opacity-50"></i>
            </div>
        </div>

        {{-- Borradores --}}
        <div class="bg-gradient-to-br from-yellow-500 to-yellow-700 text-white p-6 rounded-lg shadow-lg">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-yellow-100 text-sm font-medium">En Borrador</p>
                    <p class="text-4xl font-bold mt-2">{{ $noticiasBorrador }}</p>
                </div>
                <i class="fas fa-file-alt text-yellow-300 text-4xl opacity-50"></i>
            </div>
        </div>
    </div>

    {{-- BÚSQUEDA Y CONTROLES --}}
    <div class="bg-white p-6 rounded-lg shadow-md">
        <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
            {{-- Búsqueda --}}
            <div class="md:col-span-2">
                <label class="block text-gray-700 font-semibold mb-2 text-sm">Buscar</label>
                <input
                    type="text"
                    placeholder="Búscar por título..."
                    wire:model.live="search"
                    class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-600 transition"
                >
            </div>

            {{-- Filtro Estado --}}
            <div>
                <label class="block text-gray-700 font-semibold mb-2 text-sm">Estado</label>
                <select
                    wire:model.live="filterEstado"
                    class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-600 transition"
                >
                    <option value="">Todos</option>
                    <option value="borrador">Borrador</option>
                    <option value="publicado">Publicado</option>
                </select>
            </div>

            {{-- Filtro Tipo --}}
            <div>
                <label class="block text-gray-700 font-semibold mb-2 text-sm">Tipo</label>
                <select
                    wire:model.live="filterTipo"
                    class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-600 transition"
                >
                    <option value="">Todos</option>
                    <option value="noticia">Noticia</option>
                    <option value="actividad">Actividad</option>
                    <option value="evento">Evento</option>
                </select>
            </div>

            {{-- Botón Nueva Noticia --}}
            <div class="flex items-end">
                <button
                    wire:click="openModal"
                    class="w-full bg-blue-900 text-white px-6 py-2 rounded hover:bg-blue-800 transition font-semibold flex items-center justify-center gap-2"
                >
                    <i class="fas fa-plus"></i>Nueva Noticia
                </button>
            </div>
        </div>
    </div>

    {{-- TABLA DE NOTICIAS --}}
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-100 border-b">
                    <tr>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Imagen</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Título</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Tipo</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Estado</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Publicación</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Vistas</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($noticias as $noticia)
                        <tr class="border-b hover:bg-blue-50 transition">
                            {{-- Imagen --}}
                            <td class="px-6 py-4">
                                @if($noticia['imagen'] ?? null)
                                    <img src="{{ asset('storage/' . $noticia['imagen']) }}"
                                         alt="{{ $noticia['titulo'] }}"
                                         class="h-12 w-12 object-cover rounded border border-gray-200">
                                @else
                                    <div class="h-12 w-12 bg-gray-200 rounded flex items-center justify-center">
                                        <i class="fas fa-image text-gray-400"></i>
                                    </div>
                                @endif
                            </td>

                            {{-- Título y Resumen --}}
                            <td class="px-6 py-4">
                                <div class="font-semibold text-gray-900 truncate max-w-xs">
                                    {{ $noticia['titulo'] }}
                                </div>
                                <div class="text-sm text-gray-500 truncate max-w-xs">
                                    {{ substr($noticia['resumen'], 0, 60) }}...
                                </div>
                            </td>

                            {{-- Tipo --}}
                            <td class="px-6 py-4">
                                @php
                                    $tipoColor = match($noticia['tipo']) {
                                        'noticia' => 'bg-blue-100 text-blue-800',
                                        'actividad' => 'bg-purple-100 text-purple-800',
                                        'evento' => 'bg-orange-100 text-orange-800',
                                        default => 'bg-gray-100 text-gray-800'
                                    };
                                @endphp
                                <span class="px-3 py-1 {{ $tipoColor }} rounded-full text-xs font-semibold">
                                    {{ ucfirst($noticia['tipo']) }}
                                </span>
                            </td>

                            {{-- Estado --}}
                            <td class="px-6 py-4">
                                @if($noticia['estado'] === 'publicado')
                                    <span class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-xs font-semibold flex items-center gap-1 w-fit">
                                        <i class="fas fa-circle text-green-500 text-xs"></i>Publicado
                                    </span>
                                @else
                                    <span class="px-3 py-1 bg-yellow-100 text-yellow-800 rounded-full text-xs font-semibold flex items-center gap-1 w-fit">
                                        <i class="fas fa-circle text-yellow-500 text-xs"></i>Borrador
                                    </span>
                                @endif
                            </td>

                            {{-- Fecha de Publicación --}}
                            <td class="px-6 py-4 text-sm text-gray-600">
                                @if($noticia['fecha_publicacion'])
                                    {{ \Carbon\Carbon::parse($noticia['fecha_publicacion'])->format('d/m/Y H:i') }}
                                @else
                                    <span class="text-gray-400">No publicado</span>
                                @endif
                            </td>

                            {{-- Vistas --}}
                            <td class="px-6 py-4 text-sm text-center font-semibold text-gray-700">
                                <span class="flex items-center justify-center gap-1">
                                    <i class="fas fa-eye text-blue-600"></i>
                                    {{ $noticia['vistas'] ?? 0 }}
                                </span>
                            </td>

                            {{-- Acciones --}}
                            <td class="px-6 py-4 text-sm space-x-2 flex gap-2">
                                <button
                                    wire:click="edit({{ $noticia['id'] }})"
                                    class="text-blue-600 hover:text-blue-900 hover:bg-blue-50 px-3 py-2 rounded transition font-semibold flex items-center gap-1"
                                    title="Editar"
                                >
                                    <i class="fas fa-edit"></i>Editar
                                </button>
                                <button
                                    wire:click="delete({{ $noticia['id'] }})"
                                    wire:confirm="¿Estás seguro de eliminar esta noticia?"
                                    class="text-red-600 hover:text-red-900 hover:bg-red-50 px-3 py-2 rounded transition font-semibold flex items-center gap-1"
                                    title="Eliminar"
                                >
                                    <i class="fas fa-trash"></i>Eliminar
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center text-gray-500">
                                <div class="flex flex-col items-center justify-center gap-3">
                                    <i class="fas fa-inbox text-6xl opacity-30"></i>
                                    <div>
                                        <p class="font-semibold">No hay noticias disponibles</p>
                                        <p class="text-sm">Crea una nueva noticia para comenzar</p>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- MODAL CREAR/EDITAR --}}
    @if($showModal)
        <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4">
            <div class="bg-white rounded-lg shadow-2xl max-w-4xl w-full max-h-screen overflow-y-auto">
                {{-- Header --}}
                <div class="sticky top-0 bg-gradient-to-r from-blue-600 to-blue-800 text-white border-b p-6 flex justify-between items-center">
                    <h2 class="text-2xl font-bold">
                        @if($editingId)
                            <i class="fas fa-edit mr-2"></i>Editar Noticia
                        @else
                            <i class="fas fa-plus mr-2"></i>Nueva Noticia
                        @endif
                    </h2>
                    <button
                        wire:click="closeModal"
                        class="text-white hover:bg-blue-700 rounded-full p-2 transition"
                    >
                        <i class="fas fa-times text-2xl"></i>
                    </button>
                </div>

                {{-- Contenido del Modal --}}
                <form wire:submit="save" class="p-8 space-y-6">
                    {{-- ROW 1: Título y Tipo --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        {{-- Título --}}
                        <div>
                            <label class="block text-gray-700 font-semibold mb-2">
                                <i class="fas fa-heading mr-2 text-blue-600"></i>Título <span class="text-red-500">*</span>
                            </label>
                            <input
                                type="text"
                                wire:model.lazy="titulo"
                                placeholder="Ej: Nueva sentencia en caso importante"
                                class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-600 focus:ring-1 focus:ring-blue-500"
                                required
                            >
                            @error('titulo') <span class="text-red-600 text-sm mt-1 block"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</span> @enderror
                        </div>

                        {{-- Tipo --}}
                        <div>
                            <label class="block text-gray-700 font-semibold mb-2">
                                <i class="fas fa-tag mr-2 text-blue-600"></i>Tipo <span class="text-red-500">*</span>
                            </label>
                            <select
                                wire:model.lazy="tipo"
                                class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-600"
                                required
                            >
                                <option value="">Selecciona un tipo</option>
                                <option value="noticia">📰 Noticia</option>
                                <option value="actividad">🎯 Actividad</option>
                                <option value="evento">🎪 Evento</option>
                            </select>
                            @error('tipo') <span class="text-red-600 text-sm mt-1 block"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</span> @enderror
                        </div>
                    </div>

                    {{-- ROW 2: Categoría y Estado --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        {{-- Categoría --}}
                        <div>
                            <label class="block text-gray-700 font-semibold mb-2">
                                <i class="fas fa-folder mr-2 text-blue-600"></i>Categoría
                            </label>
                            <input
                                type="text"
                                wire:model.lazy="categoria"
                                placeholder="Ej: Jurisprudencia, Eventos, etc"
                                class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-600"
                            >
                        </div>

                        {{-- Estado --}}
                        <div>
                            <label class="block text-gray-700 font-semibold mb-2">
                                <i class="fas fa-toggle-on mr-2 text-blue-600"></i>Estado <span class="text-red-500">*</span>
                            </label>
                            <select
                                wire:model.lazy="estado"
                                class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-600"
                                required
                            >
                                <option value="borrador">📝 Borrador</option>
                                <option value="publicado">✅ Publicado</option>
                            </select>
                            @error('estado') <span class="text-red-600 text-sm mt-1 block"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</span> @enderror
                        </div>
                    </div>

                    {{-- Resumen --}}
                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">
                            <i class="fas fa-align-left mr-2 text-blue-600"></i>Resumen <span class="text-red-500">*</span>
                        </label>
                        <textarea
                            wire:model.lazy="resumen"
                            placeholder="Resumen breve de la noticia (máx 500 caracteres)"
                            rows="3"
                            maxlength="500"
                            class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-600"
                            required
                        ></textarea>
                        <div class="text-sm text-gray-500 mt-1">{{ strlen($resumen) }}/500 caracteres</div>
                        @error('resumen') <span class="text-red-600 text-sm mt-1 block"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</span> @enderror
                    </div>

                    {{-- Contenido --}}
                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">
                            <i class="fas fa-file-alt mr-2 text-blue-600"></i>Contenido <span class="text-red-500">*</span>
                        </label>
                        <textarea
                            wire:model.lazy="contenido"
                            placeholder="Contenido completo de la noticia"
                            rows="10"
                            class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-600 font-mono"
                            required
                        ></textarea>
                        <div class="text-sm text-gray-500 mt-1">{{ strlen($contenido) }} caracteres</div>
                        @error('contenido') <span class="text-red-600 text-sm mt-1 block"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</span> @enderror
                    </div>

                    {{-- Imagen --}}
                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">
                            <i class="fas fa-image mr-2 text-blue-600"></i>Imagen (JPG, PNG - máx 5MB)
                        </label>

                        {{-- Vista previa --}}
                        @if($imagen_preview)
                            <div class="mb-4 relative">
                                <img src="{{ $imagen_preview }}" alt="Preview" class="h-48 w-full object-cover rounded border-2 border-blue-200">
                                <button
                                    type="button"
                                    wire:click="$set('imagen_preview', '')"
                                    class="absolute top-2 right-2 bg-red-600 text-white p-2 rounded-full hover:bg-red-700 transition shadow-lg"
                                    title="Eliminar imagen"
                                >
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        @endif

                        {{-- Input de archivo --}}
                        <input
                            type="file"
                            wire:model.lazy="imagen"
                            accept="image/*"
                            class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-600"
                        >

                        @if($imagen)
                            <p class="text-sm text-green-600 mt-2">
                                <i class="fas fa-check-circle mr-1"></i>Imagen lista para cargar
                            </p>
                        @endif

                        @error('imagen') <span class="text-red-600 text-sm mt-1 block"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</span> @enderror
                    </div>

                    {{-- BOTONES DE ACCIÓN --}}
                    <div class="flex gap-4 pt-6 border-t">
                        <button
                            type="submit"
                            class="flex-1 bg-blue-600 text-white px-6 py-3 rounded hover:bg-blue-700 transition font-semibold flex items-center justify-center gap-2 shadow-md"
                        >
                            <i class="fas fa-save"></i>
                            @if($editingId)
                                Guardar Cambios
                            @else
                                Crear Noticia
                            @endif
                        </button>
                        <button
                            type="button"
                            wire:click="closeModal"
                            class="flex-1 bg-gray-300 text-gray-700 px-6 py-3 rounded hover:bg-gray-400 transition font-semibold flex items-center justify-center gap-2"
                        >
                            <i class="fas fa-times"></i>Cancelar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>
