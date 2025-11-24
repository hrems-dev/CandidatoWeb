<x-layouts.app :title="__('Dashboard Admin')">
    <div class="container mx-auto px-4 py-8">
        {{-- Header --}}
        <div class="mb-8">
            <h1 class="text-4xl font-bold text-gray-800">Panel de Administración</h1>
            <p class="text-gray-600 mt-2">Gestiona citas, contactos y contenido</p>
        </div>

        {{-- Statistics Cards --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            {{-- Citas Pendientes --}}
            <div class="bg-gradient-to-br from-blue-900 to-blue-800 text-white p-6 rounded-lg shadow-lg hover:shadow-xl transition">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-blue-100 mb-2 text-sm">Citas Pendientes</p>
                        <h3 class="text-4xl font-bold">{{ $citasPendientes ?? 0 }}</h3>
                    </div>
                    <i class="fas fa-calendar text-5xl text-blue-300 opacity-50"></i>
                </div>
                <a href="#citas-section" class="text-blue-100 hover:text-white mt-4 inline-block text-sm font-semibold">
                    Ver todas →
                </a>
            </div>

            {{-- Total Citas --}}
            <div class="bg-gradient-to-br from-purple-600 to-purple-500 text-white p-6 rounded-lg shadow-lg hover:shadow-xl transition">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-purple-100 mb-2 text-sm">Total de Citas</p>
                        <h3 class="text-4xl font-bold">{{ $totalCitas ?? 0 }}</h3>
                    </div>
                    <i class="fas fa-check-circle text-5xl text-purple-300 opacity-50"></i>
                </div>
            </div>
        </div>

        {{-- Citas Section --}}
        <div id="citas-section" class="mb-12">
            <div class="bg-white rounded-lg shadow-lg overflow-hidden border border-gray-200">
                <div class="bg-gradient-to-r from-blue-900 to-blue-800 text-white p-6">
                    <h2 class="text-2xl font-bold flex items-center">
                        <i class="fas fa-calendar mr-3"></i>Gestión de Citas
                    </h2>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead class="bg-gray-100 border-b border-gray-200">
                            <tr>
                                <th class="px-6 py-4 text-left font-semibold text-gray-700">Nombre</th>
                                <th class="px-6 py-4 text-left font-semibold text-gray-700">Email</th>
                                <th class="px-6 py-4 text-left font-semibold text-gray-700">Tipo Consulta</th>
                                <th class="px-6 py-4 text-left font-semibold text-gray-700">Fecha</th>
                                <th class="px-6 py-4 text-left font-semibold text-gray-700">Estado</th>
                                <th class="px-6 py-4 text-center font-semibold text-gray-700">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse($citas ?? [] as $cita)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="px-6 py-4 text-gray-900 font-medium">{{ $cita->nombre }}</td>
                                    <td class="px-6 py-4 text-gray-600">{{ $cita->email }}</td>
                                    <td class="px-6 py-4 text-gray-700">
                                        <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded text-xs font-semibold">
                                            {{ Str::limit($cita->tipo_consulta, 20) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-gray-600">
                                        @if($cita->fecha_solicitud)
                                            {{ $cita->fecha_solicitud->format('d/m/Y H:i') }}
                                        @else
                                            N/A
                                        @endif
                                    </td>
                                    <td class="px-6 py-4">
                                        @if($cita->estado === 'pendiente')
                                            <span class="bg-yellow-100 text-yellow-800 px-3 py-1 rounded text-xs font-semibold inline-block">
                                                <i class="fas fa-clock mr-1"></i>Pendiente
                                            </span>
                                        @elseif($cita->estado === 'aceptada')
                                            <span class="bg-green-100 text-green-800 px-3 py-1 rounded text-xs font-semibold inline-block">
                                                <i class="fas fa-check mr-1"></i>Aceptada
                                            </span>
                                        @elseif($cita->estado === 'rechazada')
                                            <span class="bg-red-100 text-red-800 px-3 py-1 rounded text-xs font-semibold inline-block">
                                                <i class="fas fa-times mr-1"></i>Rechazada
                                            </span>
                                        @else
                                            <span class="bg-gray-100 text-gray-800 px-3 py-1 rounded text-xs font-semibold inline-block">
                                                {{ ucfirst($cita->estado) }}
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <div class="flex justify-center gap-2 flex-wrap">
                                            <button onclick="verDetallesCita({{ $cita->id }})" class="bg-blue-900 text-white px-3 py-1 rounded text-xs font-semibold hover:bg-blue-800 transition">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            @if($cita->estado === 'pendiente')
                                                <button onclick="aceptarCita({{ $cita->id }})" class="bg-green-600 text-white px-3 py-1 rounded text-xs font-semibold hover:bg-green-700 transition">
                                                    <i class="fas fa-check"></i>
                                                </button>
                                                <button onclick="rechazarCita({{ $cita->id }})" class="bg-red-600 text-white px-3 py-1 rounded text-xs font-semibold hover:bg-red-700 transition">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                                        <i class="fas fa-inbox text-4xl mb-3 block opacity-30"></i>
                                        <p class="font-medium">No hay citas pendientes</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- Contactos Section --}}
        <div id="contactos-section">
            <div class="bg-white rounded-lg shadow-lg overflow-hidden border border-gray-200">
                <div class="bg-gradient-to-r from-blue-900 to-blue-800 text-white p-6">
                    <h2 class="text-2xl font-bold flex items-center">
                        <i class="fas fa-envelope mr-3"></i>Gestión de Contactos
                    </h2>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead class="bg-gray-100 border-b border-gray-200">
                            <tr>
                                <th class="px-6 py-4 text-left font-semibold text-gray-700">Nombre</th>
                                <th class="px-6 py-4 text-left font-semibold text-gray-700">Email</th>
                                <th class="px-6 py-4 text-left font-semibold text-gray-700">Asunto</th>
                                <th class="px-6 py-4 text-left font-semibold text-gray-700">Fecha</th>
                                <th class="px-6 py-4 text-left font-semibold text-gray-700">Estado</th>
                                <th class="px-6 py-4 text-center font-semibold text-gray-700">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse($contactos ?? [] as $contacto)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="px-6 py-4 text-gray-900 font-medium">{{ $contacto->nombre }}</td>
                                    <td class="px-6 py-4 text-gray-600">{{ $contacto->email }}</td>
                                    <td class="px-6 py-4 text-gray-700">
                                        <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded text-xs font-semibold">
                                            {{ Str::limit($contacto->asunto, 25) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-gray-600">
                                        @if($contacto->created_at)
                                            {{ $contacto->created_at->format('d/m/Y H:i') }}
                                        @else
                                            N/A
                                        @endif
                                    </td>
                                    <td class="px-6 py-4">
                                        @if($contacto->estado === 'nuevo')
                                            <span class="bg-yellow-100 text-yellow-800 px-3 py-1 rounded text-xs font-semibold inline-block">
                                                <i class="fas fa-star mr-1"></i>Nuevo
                                            </span>
                                        @elseif($contacto->estado === 'respondido')
                                            <span class="bg-green-100 text-green-800 px-3 py-1 rounded text-xs font-semibold inline-block">
                                                <i class="fas fa-reply mr-1"></i>Respondido
                                            </span>
                                        @elseif($contacto->estado === 'manejado')
                                            <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded text-xs font-semibold inline-block">
                                                <i class="fas fa-check-circle mr-1"></i>Manejado
                                            </span>
                                        @else
                                            <span class="bg-gray-100 text-gray-800 px-3 py-1 rounded text-xs font-semibold inline-block">
                                                {{ ucfirst($contacto->estado) }}
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <div class="flex justify-center gap-2 flex-wrap">
                                            <button onclick="verDetallesContacto({{ $contacto->id }})" class="bg-blue-900 text-white px-3 py-1 rounded text-xs font-semibold hover:bg-blue-800 transition">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            @if($contacto->estado === 'nuevo')
                                                <button onclick="responderContacto({{ $contacto->id }})" class="bg-green-600 text-white px-3 py-1 rounded text-xs font-semibold hover:bg-green-700 transition">
                                                    <i class="fas fa-reply"></i>
                                                </button>
                                            @endif
                                            <button onclick="marcarManejado({{ $contacto->id }})" class="bg-gray-600 text-white px-3 py-1 rounded text-xs font-semibold hover:bg-gray-700 transition">
                                                <i class="fas fa-check"></i>
                                            </button>
                                        </div>
                                    </td>
                </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- Scripts para manejo de acciones --}}
    <script>
        function verDetallesCita(citaId) {
            fetch(`/api/citas/${citaId}`)
                .then(response => response.json())
                .then(data => {
                    const detalles = `
CITA #${data.id}
━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
Nombre: ${data.nombre}
Email: ${data.email}
Teléfono: ${data.telefono || 'N/A'}
Tipo de Consulta: ${data.tipo_consulta}
Descripción: ${data.descripcion}
Estado: ${data.estado}
Fecha de Solicitud: ${new Date(data.fecha_solicitud).toLocaleDateString('es-ES')}
━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
                    `;
                    alert(detalles);
                })
                .catch(err => alert('Error al cargar los detalles'));
        }

        function aceptarCita(citaId) {
            if (confirm('¿Deseas aceptar esta cita?')) {
                fetch(`/api/citas/${citaId}`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    },
                    body: JSON.stringify({ estado: 'aceptada' })
                })
                .then(response => {
                    if (!response.ok) throw new Error('Error al actualizar');
                    return response.json();
                })
                .then(() => {
                    alert('✓ Cita aceptada. Se ha enviado un email de confirmación.');
                    location.reload();
                })
                .catch(err => alert('Error: ' + err.message));
            }
        }

        function rechazarCita(citaId) {
            const motivo = prompt('Escribe el motivo del rechazo:');
            if (motivo) {
                fetch(`/api/citas/${citaId}`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    },
                    body: JSON.stringify({
                        estado: 'rechazada',
                        motivo_rechazo: motivo
                    })
                })
                .then(response => {
                    if (!response.ok) throw new Error('Error al actualizar');
                    return response.json();
                })
                .then(() => {
                    alert('✓ Cita rechazada. Se ha enviado un email de notificación.');
                    location.reload();
                })
                .catch(err => alert('Error: ' + err.message));
            }
        }
    </script>
</x-layouts.app>
