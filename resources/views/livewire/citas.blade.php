<div class="space-y-6">
    {{-- Header y Búsqueda --}}
    <div class="bg-gradient-to-r from-blue-900 to-blue-700 text-white p-8 rounded-lg shadow-lg">
        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-4xl font-bold mb-2">Gestión de Citas</h1>
                <p class="text-blue-100">Administra todas las solicitudes de citas de los usuarios</p>
            </div>
            <button
                wire:click="openModal"
                class="bg-white text-blue-900 px-8 py-3 rounded-lg hover:bg-blue-50 transition font-bold flex items-center gap-2"
            >
                <i class="fas fa-plus"></i>Nueva Cita
            </button>
        </div>

        {{-- Búsqueda y Filtros --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="relative">
                <i class="fas fa-search absolute left-3 top-3 text-blue-300"></i>
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

            <div class="text-right text-blue-100">
                <p class="text-sm">Total: <span class="font-bold text-lg text-white">{{ count($citas) }}</span> citas</p>
            </div>
        </div>
    </div>

    {{-- Tabla de Citas Mejorada --}}
    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gradient-to-r from-gray-800 to-gray-700 text-white">
                    <tr>
                        <th class="px-6 py-4 text-left text-sm font-bold">Solicitante</th>
                        <th class="px-6 py-4 text-left text-sm font-bold">Tipo de Consulta</th>
                        <th class="px-6 py-4 text-left text-sm font-bold">Descripción</th>
                        <th class="px-6 py-4 text-center text-sm font-bold">Estado</th>
                        <th class="px-6 py-4 text-center text-sm font-bold">Programada</th>
                        <th class="px-6 py-4 text-center text-sm font-bold">Solicitud</th>
                        <th class="px-6 py-4 text-right text-sm font-bold">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @forelse($citas as $cita)
                        <tr class="hover:bg-blue-50 transition">
                            {{-- Solicitante --}}
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-full bg-gradient-to-r from-blue-500 to-blue-600 text-white flex items-center justify-center font-bold">
                                        {{ strtoupper(substr($cita['nombre'], 0, 1)) }}
                                    </div>
                                    <div>
                                        <p class="font-semibold text-gray-900">{{ $cita['nombre'] }}</p>
                                        <p class="text-xs text-gray-500">{{ $cita['email'] }}</p>
                                        <p class="text-xs text-gray-500">{{ $cita['telefono'] }}</p>
                                    </div>
                                </div>
                            </td>

                            {{-- Tipo de Consulta --}}
                            <td class="px-6 py-4">
                                <span class="inline-block px-3 py-1 bg-purple-100 text-purple-800 rounded-full text-xs font-semibold">
                                    <i class="fas fa-folder mr-1"></i>{{ ucfirst(substr($cita['tipo_consulta'], 0, 18)) }}
                                </span>
                            </td>

                            {{-- Descripción --}}
                            <td class="px-6 py-4">
                                <p class="text-sm text-gray-700 max-w-xs truncate" title="{{ $cita['descripcion'] }}">
                                    {{ substr($cita['descripcion'], 0, 50) }}{{ strlen($cita['descripcion']) > 50 ? '...' : '' }}
                                </p>
                            </td>

                            {{-- Estado --}}
                            <td class="px-6 py-4 text-center">
                                @if($cita['estado'] === 'pendiente')
                                    <span class="inline-flex items-center gap-1 px-3 py-1 bg-yellow-100 text-yellow-800 rounded-full text-xs font-bold">
                                        <i class="fas fa-hourglass-half"></i>Pendiente
                                    </span>
                                @elseif($cita['estado'] === 'aceptada')
                                    <span class="inline-flex items-center gap-1 px-3 py-1 bg-green-100 text-green-800 rounded-full text-xs font-bold">
                                        <i class="fas fa-check-circle"></i>Aceptada
                                    </span>
                                @elseif($cita['estado'] === 'rechazada')
                                    <span class="inline-flex items-center gap-1 px-3 py-1 bg-red-100 text-red-800 rounded-full text-xs font-bold">
                                        <i class="fas fa-times-circle"></i>Rechazada
                                    </span>
                                @elseif($cita['estado'] === 'completada')
                                    <span class="inline-flex items-center gap-1 px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-xs font-bold">
                                        <i class="fas fa-check"></i>Completada
                                    </span>
                                @elseif($cita['estado'] === 'reprogramada')
                                    <span class="inline-flex items-center gap-1 px-3 py-1 bg-indigo-100 text-indigo-800 rounded-full text-xs font-bold">
                                        <i class="fas fa-sync"></i>Reprogramada
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 px-3 py-1 bg-gray-100 text-gray-800 rounded-full text-xs font-bold">
                                        {{ ucfirst($cita['estado']) }}
                                    </span>
                                @endif
                            </td>

                            {{-- Fecha Programada --}}
                            <td class="px-6 py-4 text-center">
                                @if($cita['fecha_cita'] && $cita['hora_cita'])
                                    <div class="text-sm">
                                        <p class="font-semibold text-gray-900">
                                            <i class="fas fa-calendar text-blue-600 mr-1"></i>{{ \Carbon\Carbon::parse($cita['fecha_cita'])->format('d/m/Y') }}
                                        </p>
                                        <p class="text-gray-600 text-xs">
                                            <i class="fas fa-clock text-blue-600 mr-1"></i>{{ $cita['hora_cita'] }}
                                        </p>
                                    </div>
                                @else
                                    <span class="text-gray-400 text-sm italic">Sin programar</span>
                                @endif
                            </td>

                            {{-- Fecha de Solicitud --}}
                            <td class="px-6 py-4 text-center">
                                <p class="text-sm text-gray-600">
                                    {{ \Carbon\Carbon::parse($cita['created_at'])->format('d/m/Y') }}
                                </p>
                                <p class="text-xs text-gray-500">
                                    {{ \Carbon\Carbon::parse($cita['created_at'])->diffForHumans() }}
                                </p>
                            </td>

                            {{-- Acciones --}}
                            <td class="px-6 py-4 text-right">
                                <div class="flex justify-end gap-2 flex-wrap">
                                    @if($cita['estado'] === 'pendiente')
                                        <button
                                            wire:click="abrirAceptarModal({{ $cita['id'] }})"
                                            class="bg-green-600 text-white px-3 py-1 rounded text-xs font-bold hover:bg-green-700 transition flex items-center gap-1"
                                            title="Aceptar y programar cita"
                                        >
                                            <i class="fas fa-check"></i>Aceptar
                                        </button>
                                        <button
                                            wire:click="abrirRechazarModal({{ $cita['id'] }})"
                                            class="bg-red-600 text-white px-3 py-1 rounded text-xs font-bold hover:bg-red-700 transition flex items-center gap-1"
                                            title="Rechazar cita"
                                        >
                                            <i class="fas fa-times"></i>Rechazar
                                        </button>
                                    @endif

                                    @if($cita['estado'] === 'aceptada' || $cita['estado'] === 'reprogramada')
                                        <button
                                            wire:click="abrirReprogramarModal({{ $cita['id'] }})"
                                            class="bg-blue-600 text-white px-3 py-1 rounded text-xs font-bold hover:bg-blue-700 transition flex items-center gap-1"
                                            title="Reprogramar cita"
                                        >
                                            <i class="fas fa-sync"></i>Reprogramar
                                        </button>
                                    @endif

                                    <button
                                        wire:click="edit({{ $cita['id'] }})"
                                        class="bg-gray-600 text-white px-3 py-1 rounded text-xs font-bold hover:bg-gray-700 transition flex items-center gap-1"
                                        title="Editar detalles"
                                    >
                                        <i class="fas fa-edit"></i>Ver
                                    </button>

                                    <button
                                        wire:click="delete({{ $cita['id'] }})"
                                        wire:confirm="¿Estás seguro de que deseas eliminar esta cita?"
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
                            <td colspan="7" class="px-6 py-12 text-center">
                                <i class="fas fa-inbox text-5xl text-gray-300 mb-4 block"></i>
                                <p class="text-gray-500 font-semibold">No hay citas disponibles</p>
                                <p class="text-gray-400 text-sm">Los usuarios verán aquí sus solicitudes de citas</p>
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
                            Editar Cita
                        @else
                            Nueva Cita
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
                            <label class="block text-gray-700 font-semibold mb-2">Teléfono *</label>
                            <input
                                type="tel"
                                wire:model.lazy="telefono"
                                placeholder="+591 72345678"
                                class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-600"
                                required
                            >
                            @error('telefono') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    {{-- Tipo de Consulta --}}
                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">Tipo de Consulta *</label>
                        <select
                            wire:model.lazy="tipo_consulta"
                            class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-600"
                            required
                        >
                            <option value="">Selecciona un tipo</option>
                            @foreach($tipos as $tipo)
                                <option value="{{ $tipo }}">{{ ucfirst($tipo) }}</option>
                            @endforeach
                        </select>
                        @error('tipo_consulta') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                    </div>

                    {{-- Descripción --}}
                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">Descripción *</label>
                        <textarea
                            wire:model.lazy="descripcion"
                            placeholder="Describe el motivo de tu consulta"
                            rows="4"
                            class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-600"
                            required
                        ></textarea>
                        @error('descripcion') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                    </div>

                    {{-- Ubicación y Documento --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-gray-700 font-semibold mb-2">Ubicación</label>
                            <input
                                type="text"
                                wire:model.lazy="ubicacion"
                                placeholder="Ciudad, Departamento"
                                class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-600"
                            >
                            @error('ubicacion') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-gray-700 font-semibold mb-2">Documento de Identidad</label>
                            <input
                                type="text"
                                wire:model.lazy="documento_identidad"
                                placeholder="CI, Pasaporte, etc."
                                class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-600"
                            >
                            @error('documento_identidad') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                        </div>
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
                                Crear Cita
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

    {{-- Modal Aceptar Cita --}}
    @if($showAceptarModal)
        <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
            <div class="bg-white rounded-lg shadow-lg max-w-md w-full mx-4">
                <div class="bg-gradient-to-r from-green-600 to-green-700 text-white p-6 rounded-t-lg">
                    <h2 class="text-2xl font-bold flex items-center gap-2">
                        <i class="fas fa-check-circle"></i>Aceptar Cita
                    </h2>
                    <p class="text-green-100 text-sm mt-2">Programa una fecha y hora para la cita</p>
                </div>

                <form wire:submit="aceptarCita({{ $editingId }})" class="p-6 space-y-4">
                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">
                            <i class="fas fa-calendar text-blue-600 mr-2"></i>Fecha de la Cita *
                        </label>
                        <input
                            type="date"
                            wire:model="fecha_cita"
                            class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:border-green-600"
                            required
                        >
                        @error('fecha_cita') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">
                            <i class="fas fa-clock text-blue-600 mr-2"></i>Hora de la Cita *
                        </label>
                        <input
                            type="time"
                            wire:model="hora_cita"
                            class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:border-green-600"
                            required
                        >
                        @error('hora_cita') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div class="bg-blue-50 border border-blue-200 p-3 rounded text-sm text-gray-700">
                        <i class="fas fa-info-circle text-blue-600 mr-2"></i>
                        <strong>Nota:</strong> El usuario recibirá notificación con los detalles de su cita programada.
                    </div>

                    <div class="flex gap-3 pt-4">
                        <button
                            type="submit"
                            class="flex-1 bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 transition font-semibold flex items-center justify-center gap-2"
                        >
                            <i class="fas fa-check"></i>Confirmar Aceptación
                        </button>
                        <button
                            type="button"
                            wire:click="closeAceptarModal"
                            class="flex-1 bg-gray-300 text-gray-700 px-4 py-2 rounded hover:bg-gray-400 transition font-semibold"
                        >
                            Cancelar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    {{-- Modal Rechazar Cita --}}
    @if($showRechazarModal)
        <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
            <div class="bg-white rounded-lg shadow-lg max-w-md w-full mx-4">
                <div class="bg-gradient-to-r from-red-600 to-red-700 text-white p-6 rounded-t-lg">
                    <h2 class="text-2xl font-bold flex items-center gap-2">
                        <i class="fas fa-times-circle"></i>Rechazar Cita
                    </h2>
                    <p class="text-red-100 text-sm mt-2">Indica el motivo del rechazo</p>
                </div>

                <form wire:submit="rechazarCita({{ $editingId }})" class="p-6 space-y-4">
                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">
                            <i class="fas fa-comment text-red-600 mr-2"></i>Motivo del Rechazo *
                        </label>
                        <textarea
                            wire:model="motivo_rechazo"
                            placeholder="Explica brevemente por qué se rechaza esta cita..."
                            rows="4"
                            class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:border-red-600"
                            required
                        ></textarea>
                        @error('motivo_rechazo') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div class="bg-red-50 border border-red-200 p-3 rounded text-sm text-gray-700">
                        <i class="fas fa-warning text-red-600 mr-2"></i>
                        <strong>Advertencia:</strong> El usuario recibirá notificación del rechazo con el motivo indicado.
                    </div>

                    <div class="flex gap-3 pt-4">
                        <button
                            type="submit"
                            class="flex-1 bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700 transition font-semibold flex items-center justify-center gap-2"
                        >
                            <i class="fas fa-times"></i>Confirmar Rechazo
                        </button>
                        <button
                            type="button"
                            wire:click="closeRechazarModal"
                            class="flex-1 bg-gray-300 text-gray-700 px-4 py-2 rounded hover:bg-gray-400 transition font-semibold"
                        >
                            Cancelar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    {{-- Modal Reprogramar Cita --}}
    @if($showReprogramarModal)
        <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
            <div class="bg-white rounded-lg shadow-lg max-w-md w-full mx-4">
                <div class="bg-gradient-to-r from-blue-600 to-blue-700 text-white p-6 rounded-t-lg">
                    <h2 class="text-2xl font-bold flex items-center gap-2">
                        <i class="fas fa-sync"></i>Reprogramar Cita
                    </h2>
                    <p class="text-blue-100 text-sm mt-2">Cambia la fecha y hora programada</p>
                </div>

                <form wire:submit="reprogramarCita({{ $editingId }})" class="p-6 space-y-4">
                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">
                            <i class="fas fa-calendar text-blue-600 mr-2"></i>Nueva Fecha *
                        </label>
                        <input
                            type="date"
                            wire:model="fecha_cita"
                            class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-600"
                            required
                        >
                        @error('fecha_cita') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">
                            <i class="fas fa-clock text-blue-600 mr-2"></i>Nueva Hora *
                        </label>
                        <input
                            type="time"
                            wire:model="hora_cita"
                            class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-600"
                            required
                        >
                        @error('hora_cita') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div class="bg-blue-50 border border-blue-200 p-3 rounded text-sm text-gray-700">
                        <i class="fas fa-info-circle text-blue-600 mr-2"></i>
                        <strong>Nota:</strong> Se guardará el historial de cambios y el usuario será notificado.
                    </div>

                    <div class="flex gap-3 pt-4">
                        <button
                            type="submit"
                            class="flex-1 bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition font-semibold flex items-center justify-center gap-2"
                        >
                            <i class="fas fa-sync"></i>Reprogramar
                        </button>
                        <button
                            type="button"
                            wire:click="closeModal"
                            class="flex-1 bg-gray-300 text-gray-700 px-4 py-2 rounded hover:bg-gray-400 transition font-semibold"
                        >
                            Cancelar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>
