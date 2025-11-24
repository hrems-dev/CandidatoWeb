# 🎫 SISTEMA DE CITAS - GUÍA DETALLADA

## 📋 TABLA DE CONTENIDOS

1. [Flujo Completo](#flujo-completo)
2. [Código del Frontend](#código-del-frontend)
3. [Código del Backend](#código-del-backend)
4. [Código del Livewire](#código-del-livewire)
5. [Base de Datos](#base-de-datos)
6. [Eventos y Emails](#eventos-y-emails)
7. [Diagrama de Estados](#diagrama-de-estados)

---

## 🔄 FLUJO COMPLETO

```
┌─────────────────────────────────────────────────────────────────────────┐
│                         1️⃣ USUARIO PÚBLICA                             │
│                                                                         │
│  Usuario entra a: http://localhost:8000/citas                          │
│  Ve un formulario HTML:                                               │
│    - Nombre Completo                                                   │
│    - Email                                                            │
│    - Teléfono                                                         │
│    - Tipo de Consulta (Radio buttons: Legal, Penal, Familia, etc)    │
│    - Descripción del motivo                                           │
│    - Botón: "Enviar Cita"                                            │
│                                                                         │
└─────────────────────────────────────────────────────────────────────────┘
                                    ↓
┌─────────────────────────────────────────────────────────────────────────┐
│                    2️⃣ ENVÍO DE DATOS AL SERVIDOR                       │
│                                                                         │
│  Cuando el usuario presiona "Enviar Cita":                             │
│                                                                         │
│  POST /citas HTTP/1.1                                                 │
│  Content-Type: application/x-www-form-urlencoded                      │
│                                                                         │
│  nombre=Juan&email=juan@mail.com&telefono=987654321&...              │
│                                                                         │
│  El navegador ENVÍA estos datos al servidor                            │
│                                                                         │
└─────────────────────────────────────────────────────────────────────────┘
                                    ↓
┌─────────────────────────────────────────────────────────────────────────┐
│                     3️⃣ ROUTING - DETECTAR LA RUTA                       │
│                                                                         │
│  Laravel detecta:  POST /citas                                         │
│  y busca en routes/web.php:                                           │
│                                                                         │
│  Route::post('/citas', [CitaController::class, 'store'])             │
│       └─→ Ejecuta: CitaController->store()                            │
│                                                                         │
└─────────────────────────────────────────────────────────────────────────┘
                                    ↓
┌─────────────────────────────────────────────────────────────────────────┐
│                4️⃣ CONTROLLER - PROCESAR Y VALIDAR                       │
│                                                                         │
│  CitaController@store() recibe Request con los datos                   │
│                                                                         │
│  1. VALIDA:                                                            │
│     - nombre: requerido, string, máx 255 caracteres                   │
│     - email: requerido, email válido                                  │
│     - telefono: requerido, string                                     │
│     - tipo_consulta: requerido                                        │
│     - descripcion: requerido                                          │
│                                                                         │
│  Si hay error → Devuelve errores al usuario                           │
│  Si es válido → Continúa...                                           │
│                                                                         │
│  2. CREA CITA:                                                         │
│     Cita::create([                                                     │
│         'nombre' => 'Juan',                                           │
│         'email' => 'juan@mail.com',                                   │
│         'estado' => 'pendiente',  ← IMPORTANTE                        │
│         'fecha_solicitud' => now(),                                   │
│         ...                                                           │
│     ])                                                                │
│                                                                         │
│  3. DISPARA EVENTO:                                                    │
│     CitaCreada::dispatch($cita)  ← Notifica al admin                 │
│                                                                         │
│  4. RESPONDE AL USUARIO:                                              │
│     ✓ Cita enviada correctamente                                      │
│                                                                         │
└─────────────────────────────────────────────────────────────────────────┘
                                    ↓
┌─────────────────────────────────────────────────────────────────────────┐
│            5️⃣ MODEL - INSERTA EN BASE DE DATOS                         │
│                                                                         │
│  Cita::create() usa el Model Cita:                                     │
│                                                                         │
│  class Cita extends Model {                                           │
│      protected $table = 'citas';  ← Tabla a usar                     │
│      protected $fillable = [      ← Campos permitidos                │
│          'nombre', 'email', 'estado', ...                            │
│      ];                                                               │
│  }                                                                     │
│                                                                         │
│  INSERT INTO citas                                                     │
│    (nombre, email, telefono, tipo_consulta, estado, created_at)      │
│  VALUES                                                                │
│    ('Juan', 'juan@mail.com', '987654321', 'Asesoría', 'pendiente', NOW())
│                                                                         │
└─────────────────────────────────────────────────────────────────────────┘
                                    ↓
┌─────────────────────────────────────────────────────────────────────────┐
│          6️⃣ DATABASE - GUARDA DATO EN LA TABLA                         │
│                                                                         │
│  Tabla 'citas' ahora tiene:                                            │
│                                                                         │
│  ┌────┬──────┬──────────────┬──────────────┬──────────────┐           │
│  │ id │ name │ email        │ estado       │ created_at   │           │
│  ├────┼──────┼──────────────┼──────────────┼──────────────┤           │
│  │ 1  │ Juan │ juan@mail... │ pendiente    │ 2024-11-24.. │           │
│  └────┴──────┴──────────────┴──────────────┴──────────────┘           │
│                                                                         │
│  ✅ Dato guardado exitosamente                                        │
│                                                                         │
└─────────────────────────────────────────────────────────────────────────┘
                                    ↓
┌─────────────────────────────────────────────────────────────────────────┐
│         7️⃣ ADMIN - REVISA Y GESTIONA LA CITA (Livewire)              │
│                                                                         │
│  Admin entra a: /admin/citas                                          │
│                                                                         │
│  Ve Livewire component que:                                           │
│  1. Carga todas las citas del DB                                      │
│  2. Muestra en tabla con campos:                                      │
│     - Nombre del solicitante                                          │
│     - Email                                                           │
│     - Tipo de consulta                                                │
│     - Estado (badge amarillo = pendiente)                             │
│     - Botones: Aceptar, Rechazar, Eliminar                            │
│                                                                         │
│  Admin puede:                                                          │
│                                                                         │
│  a) ACEPTAR CITA:                                                     │
│     - Presiona botón "Aceptar"                                        │
│     - Abre modal con:                                                 │
│       • Fecha de la cita (date picker)                                │
│       • Hora de la cita (time picker)                                 │
│     - Presiona "Confirmar"                                            │
│     - UPDATE citas SET                                                │
│         estado = 'aceptada',                                          │
│         fecha_cita = '2024-12-10',                                    │
│         hora_cita = '10:00',                                          │
│         fecha_respuesta_admin = NOW()                                 │
│       WHERE id = 1                                                    │
│     - Dispara evento: CitaActualizada                                 │
│     - Usuario recibe EMAIL de confirmación                            │
│                                                                         │
│  b) RECHAZAR CITA:                                                    │
│     - Presiona botón "Rechazar"                                       │
│     - Abre modal con:                                                 │
│       • Motivo del rechazo (textarea)                                 │
│     - UPDATE citas SET                                                │
│         estado = 'rechazada',                                         │
│         motivo_rechazo = 'Falta documentación'                        │
│       WHERE id = 1                                                    │
│     - Usuario recibe EMAIL de rechazo                                 │
│                                                                         │
│  c) REPROGRAMAR CITA:                                                 │
│     - Solo si ya fue aceptada                                         │
│     - Abre modal con nueva fecha/hora                                 │
│     - UPDATE citas SET                                                │
│         estado = 'reprogramada',                                      │
│         datos_reprogramacion = {fecha_anterior, fecha_nueva, motivo}  │
│       WHERE id = 1                                                    │
│                                                                         │
│  d) ELIMINAR CITA:                                                    │
│     - Presiona botón "Eliminar"                                       │
│     - Pide confirmación                                               │
│     - DELETE FROM citas WHERE id = 1                                  │
│     - O usa soft delete (marca como deleted_at)                       │
│                                                                         │
└─────────────────────────────────────────────────────────────────────────┘
                                    ↓
┌─────────────────────────────────────────────────────────────────────────┐
│     8️⃣ USUARIO RECIBE NOTIFICACIÓN POR EMAIL                          │
│                                                                         │
│  Cuando admin acepta, rechaza o reprograma:                            │
│  Se ejecuta: CitaActualizada::dispatch($cita, $accion)                │
│                                                                         │
│  Esto DISPARA un evento que envía EMAIL:                              │
│                                                                         │
│  ASUNTO: Tu cita legal ha sido aceptada                               │
│  DE: admin@candidato.com                                              │
│  PARA: juan@mail.com                                                  │
│                                                                         │
│  CONTENIDO:                                                            │
│  "Hola Juan,                                                           │
│   Tu solicitud ha sido aceptada.                                       │
│   Fecha: 10 de Diciembre de 2024                                       │
│   Hora: 10:00 AM                                                      │
│   Ubicación: [Dirección del despacho]                                 │
│   Gracias por confiar en nuestros servicios."                         │
│                                                                         │
│  ✅ Usuario ve que su cita fue aceptada                               │
│                                                                         │
└─────────────────────────────────────────────────────────────────────────┘
```

---

## 💻 CÓDIGO DEL FRONTEND

### **Archivo: `resources/views/citas/index.blade.php`**

Este es el formulario que ve el usuario público.

```blade
@include('include.head')  ← Incluye head, estilos, navbar

<div class="container mx-auto">
    {{-- Breadcrumb --}}
    <div class="bg-gray-100 py-4">
        <nav class="text-sm text-gray-600">
            <a href="{{ route('welcome') }}">Inicio</a> / Agendar Cita
        </nav>
    </div>

    {{-- Main Content --}}
    <div class="max-w-4xl mx-auto px-4 py-12">
        <h1 class="text-5xl font-bold mb-4">Agendar Cita Legal</h1>
        <p class="text-xl text-gray-700">Completa el formulario para solicitar una cita</p>

        {{-- Mostrar errores si los hay --}}
        @if ($errors->any())
            <div class="mb-6 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Mostrar mensaje de éxito --}}
        @if (session('success'))
            <div class="mb-6 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                {{ session('success') }}
            </div>
        @endif

        {{-- FORMULARIO --}}
        <form method="POST" action="{{ route('citas.store') }}" class="space-y-6">
            @csrf  ← Token de seguridad CSRF

            {{-- INFORMACIÓN PERSONAL --}}
            <fieldset>
                <legend class="text-2xl font-bold mb-4">Información Personal</legend>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    {{-- Nombre --}}
                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">
                            Nombre Completo <span class="text-red-500">*</span>
                        </label>
                        <input 
                            type="text" 
                            name="nombre" 
                            required
                            value="{{ old('nombre') }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded 
                                   focus:outline-none focus:border-blue-900 
                                   @error('nombre') border-red-500 @enderror"
                            placeholder="Tu nombre completo"
                        >
                        @error('nombre')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Email --}}
                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">
                            Correo Electrónico <span class="text-red-500">*</span>
                        </label>
                        <input 
                            type="email" 
                            name="email" 
                            required
                            value="{{ old('email') }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded 
                                   @error('email') border-red-500 @enderror"
                            placeholder="tu@email.com"
                        >
                        @error('email')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Teléfono --}}
                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">
                            Teléfono <span class="text-red-500">*</span>
                        </label>
                        <input 
                            type="tel" 
                            name="telefono" 
                            required
                            value="{{ old('telefono') }}"
                            placeholder="987654321"
                        >
                    </div>

                    {{-- Documento --}}
                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">
                            Documento de Identidad
                        </label>
                        <input 
                            type="text" 
                            name="documento_identidad"
                            value="{{ old('documento_identidad') }}"
                            placeholder="Ej: 12345678"
                        >
                    </div>
                </div>
            </fieldset>

            {{-- TIPO DE CONSULTA --}}
            <fieldset>
                <legend class="text-2xl font-bold mb-4">Tipo de Consulta</legend>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    {{-- Radio buttons --}}
                    @foreach(['asesoría legal' => 'Asesoría Legal', 
                              'defensa penal' => 'Defensa Penal',
                              'familia' => 'Derecho Familiar'] as $value => $label)
                        <label class="flex items-center cursor-pointer">
                            <input 
                                type="radio" 
                                name="tipo_consulta" 
                                value="{{ $value }}"
                                required
                                {{ old('tipo_consulta') == $value ? 'checked' : '' }}
                                class="mr-3 w-4 h-4 cursor-pointer"
                            >
                            <span>{{ $label }}</span>
                        </label>
                    @endforeach
                </div>
                
                @error('tipo_consulta')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </fieldset>

            {{-- DESCRIPCIÓN --}}
            <fieldset>
                <legend class="text-2xl font-bold mb-4">Cuéntanos tu caso</legend>
                <textarea 
                    name="descripcion" 
                    required
                    class="w-full px-4 py-2 border border-gray-300 rounded 
                           @error('descripcion') border-red-500 @enderror"
                    rows="6"
                    placeholder="Describe brevemente tu caso..."
                ></textarea>
                @error('descripcion')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </fieldset>

            {{-- BOTÓN ENVÍO --}}
            <div class="flex gap-4">
                <button 
                    type="submit" 
                    class="px-8 py-3 bg-blue-900 text-white rounded 
                           hover:bg-blue-800 transition font-bold"
                >
                    ✓ Enviar Cita
                </button>
                <a 
                    href="{{ route('welcome') }}" 
                    class="px-8 py-3 bg-gray-300 text-gray-800 rounded 
                           hover:bg-gray-400 transition"
                >
                    Cancelar
                </a>
            </div>
        </form>
    </div>
</div>

@include('include.footer')
```

**¿Qué pasa en este código?**

1. ✅ `@include('include.head')` - Carga estilos y navbar
2. ✅ `@csrf` - Token de seguridad (previene ataques)
3. ✅ `action="{{ route('citas.store') }}"` - URL donde enviar datos
4. ✅ `value="{{ old('nombre') }}"` - Mantiene datos si hay error
5. ✅ `@error('nombre')` - Muestra errores de validación
6. ✅ Radio buttons para tipo de consulta
7. ✅ Textarea para la descripción
8. ✅ Botón submit que envía al servidor

---

## 🔧 CÓDIGO DEL BACKEND (Controller)

### **Archivo: `app/Http/Controllers/CitaController.php`**

```php
<?php

namespace App\Http\Controllers;

use App\Events\CitaCreada;
use App\Events\CitaActualizada;
use App\Models\Cita;
use Illuminate\Http\Request;

class CitaController extends Controller
{
    /**
     * REGISTRAR UNA NUEVA CITA (desde el público)
     * Recibe datos del formulario y los guarda en BD
     */
    public function store(Request $request)
    {
        // 1️⃣ VALIDAR DATOS
        //    Si algún campo no cumple, devuelve errores automáticamente
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            // ↑ Campo obligatorio, debe ser texto, máximo 255 caracteres
            
            'email' => 'required|email|max:255',
            // ↑ Campo obligatorio, debe ser email válido
            
            'telefono' => 'required|string|max:20',
            // ↑ Campo obligatorio, puede contener números y símbolos
            
            'tipo_consulta' => 'required|string',
            // ↑ Campo obligatorio
            
            'descripcion' => 'required|string',
            // ↑ Campo obligatorio, descripción del caso
            
            'ubicacion' => 'nullable|string|max:255',
            // ↑ Opcional (nullable), no es obligatorio
            
            'documento_identidad' => 'nullable|string|max:50',
            // ↑ Opcional
        ]);

        try {
            // 2️⃣ CREAR LA CITA EN LA BASE DE DATOS
            $cita = Cita::create([
                'nombre' => $validated['nombre'],
                'email' => $validated['email'],
                'telefono' => $validated['telefono'],
                'tipo_consulta' => $validated['tipo_consulta'],
                'descripcion' => $validated['descripcion'],
                'ubicacion' => $validated['ubicacion'] ?? null,
                'documento_identidad' => $validated['documento_identidad'] ?? null,
                'estado' => 'pendiente',
                // ↑ IMPORTANTE: Estado inicial es "pendiente"
                //   El admin debe aceptar o rechazar
                
                'fecha_solicitud' => now(),
                // ↑ Marca la fecha/hora en que se creó la cita
            ]);

            // 3️⃣ DISPARAR EVENTO
            //    Esto notifica al admin por email que hay una cita nueva
            CitaCreada::dispatch($cita);

            // 4️⃣ RESPONDER AL USUARIO
            return redirect()->back()
                ->with('success', '✅ ¡Cita enviada correctamente! 
                        En breve recibirás confirmación por correo');

        } catch (\Exception $e) {
            // Si hay error, mostrar mensaje de error
            return redirect()->back()
                ->with('error', 'Error al crear la cita: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * LISTAR TODAS LAS CITAS (API)
     * Used en dashboards o interfaces
     */
    public function index(Request $request)
    {
        $query = Cita::query();

        // Filtrar por estado si viene en la URL
        if ($request->has('estado')) {
            $query->where('estado', $request->estado);
        }

        // Filtrar por tipo de consulta si viene en la URL
        if ($request->has('tipo_consulta')) {
            $query->where('tipo_consulta', $request->tipo_consulta);
        }

        // Devolver en formato JSON (para APIs)
        return response()->json(
            $query->orderBy('fecha_solicitud', 'desc')->paginate(10)
        );
    }

    /**
     * VER UNA CITA ESPECÍFICA (API)
     */
    public function show($id)
    {
        $cita = Cita::find($id);

        if (!$cita) {
            return response()->json(['message' => 'Cita no encontrada'], 404);
        }

        return response()->json($cita);
    }
}
```

**Explicación de validaciones:**

```
'nombre' => 'required|string|max:255'
           ↓         ↓       ↓
        obligatorio  texto   máx 255 cars

'email' => 'required|email|max:255'
           ↓         ↓       ↓
        obligatorio  email   máx 255 cars

'ubicacion' => 'nullable|string|max:255'
               ↓         ↓       ↓
            OPCIONAL   texto   máx 255 cars

Si algún campo no cumple:
   → Se devuelve automáticamente al formulario
   → Se muestra mensaje de error
   → Los datos se mantienen en los campos (@error, old())
```

---

## 🎮 CÓDIGO DEL LIVEWIRE (Admin)

### **Archivo: `app/Livewire/Citas.php`**

Este es el componente interactivo que usa el admin.

```php
<?php

namespace App\Livewire;

use App\Models\Cita;
use App\Events\CitaActualizada;
use Livewire\Component;

class Citas extends Component
{
    // 📋 PROPIEDADES DEL FORMULARIO
    // Se usan para guardar datos temporalmente
    public $nombre = '';
    public $email = '';
    public $telefono = '';
    public $tipo_consulta = '';
    public $descripcion = '';
    public $ubicacion = '';
    public $documento_identidad = '';
    public $fecha_cita = '';
    public $hora_cita = '';
    public $motivo_rechazo = '';

    // 🎛️ CONTROL DE MODALES Y EDICIÓN
    public $showModal = false;              // Mostrar/ocultar modal crear
    public $showReprogramarModal = false;   // Mostrar/ocultar modal reprogramar
    public $showAceptarModal = false;       // Mostrar/ocultar modal aceptar
    public $showRechazarModal = false;      // Mostrar/ocultar modal rechazar
    public $editingId = null;               // ID de la cita que se está editando

    // 📊 DATOS QUE VE EL USUARIO
    public $citas = [];                     // Array con todas las citas

    // 🔍 BÚSQUEDA Y FILTRADO
    public $search = '';                    // Texto de búsqueda
    public $filterEstado = '';              // Filtro por estado

    // 📝 OPCIONES DISPONIBLES
    public $estados = [
        'pendiente',
        'aceptada',
        'rechazada',
        'completada',
        'cancelada',
        'reprogramada'
    ];

    public $tipos = [
        'asesoría legal',
        'trámite administrativo',
        'defensa penal',
        'derechos laborales',
        'familia',
        'otro'
    ];

    /**
     * MONTAR COMPONENTE
     * Se ejecuta cuando se carga la página
     */
    public function mount()
    {
        $this->cargarCitas();
        // ↑ Carga todas las citas al abrir /admin/citas
    }

    /**
     * RENDERIZAR VISTA
     * Devuelve la vista blade asociada al componente
     */
    public function render()
    {
        return view('livewire.citas');
    }

    /**
     * CARGAR TODAS LAS CITAS CON BÚSQUEDA Y FILTRADO
     * Se ejecuta cada vez que cambia la búsqueda o filtro
     */
    public function cargarCitas()
    {
        $query = Cita::query();

        // 🔍 BÚSQUEDA: por nombre o email
        if ($this->search) {
            $query->where('nombre', 'like', '%' . $this->search . '%')
                  ->orWhere('email', 'like', '%' . $this->search . '%')
                  ->orWhere('descripcion', 'like', '%' . $this->search . '%');
        }

        // 🏷️ FILTRO: por estado
        if ($this->filterEstado) {
            $query->where('estado', $this->filterEstado);
        }

        // 📋 OBTENER: ordenar por más reciente
        $this->citas = $query->orderBy('created_at', 'desc')
                            ->get()
                            ->toArray();
    }

    /**
     * ACTUALIZACIÓN EN TIEMPO REAL
     * Se dispara cuando el usuario escribe en el input de búsqueda
     */
    public function updatedSearch()
    {
        $this->cargarCitas();
        // ↑ Sin recargar página, actualiza la tabla
    }

    /**
     * ACTUALIZACIÓN EN TIEMPO REAL
     * Se dispara cuando el usuario cambia el filtro de estado
     */
    public function updatedFilterEstado()
    {
        $this->cargarCitas();
    }

    /**
     * ABRIR MODAL CREAR CITA
     */
    public function openModal()
    {
        $this->resetForm();
        $this->showModal = true;
        $this->editingId = null;
        // ↑ null = crear nueva, no editar
    }

    /**
     * CERRAR MODAL
     */
    public function closeModal()
    {
        $this->showModal = false;
        $this->resetForm();
    }

    /**
     * LIMPIAR FORMULARIO
     */
    public function resetForm()
    {
        $this->nombre = '';
        $this->email = '';
        $this->telefono = '';
        $this->tipo_consulta = '';
        $this->descripcion = '';
        $this->ubicacion = '';
        $this->documento_identidad = '';
        $this->fecha_cita = '';
        $this->hora_cita = '';
        $this->motivo_rechazo = '';
        $this->editingId = null;
    }

    /**
     * EDITAR UNA CITA
     */
    public function edit(Cita $cita)
    {
        // Cargar los datos de la cita en el formulario
        $this->editingId = $cita->id;
        $this->nombre = $cita->nombre;
        $this->email = $cita->email;
        $this->telefono = $cita->telefono;
        $this->tipo_consulta = $cita->tipo_consulta;
        $this->descripcion = $cita->descripcion;
        $this->ubicacion = $cita->ubicacion;
        $this->documento_identidad = $cita->documento_identidad;
        $this->fecha_cita = $cita->fecha_cita?->format('Y-m-d') ?? '';
        $this->hora_cita = $cita->hora_cita ?? '';
        
        // Mostrar modal
        $this->showModal = true;
    }

    /**
     * GUARDAR CITA (crear o editar)
     */
    public function save()
    {
        // ✅ VALIDAR
        $this->validate([
            'nombre' => 'required|string|max:255',
            'email' => 'required|email',
            'telefono' => 'required|string|max:20',
            'tipo_consulta' => 'required|string',
            'descripcion' => 'required|string',
            'ubicacion' => 'nullable|string|max:255',
            'documento_identidad' => 'nullable|string|max:50',
        ]);

        try {
            // 📦 PREPARAR DATOS
            $data = [
                'nombre' => $this->nombre,
                'email' => $this->email,
                'telefono' => $this->telefono,
                'tipo_consulta' => $this->tipo_consulta,
                'descripcion' => $this->descripcion,
                'ubicacion' => $this->ubicacion,
                'documento_identidad' => $this->documento_identidad,
                'estado' => 'pendiente',
            ];

            // 💾 GUARDAR
            if ($this->editingId) {
                // EDITAR cita existente
                $cita = Cita::findOrFail($this->editingId);
                $cita->update($data);
                $this->dispatch('notify', [
                    'message' => 'Cita actualizada correctamente',
                    'type' => 'success'
                ]);
            } else {
                // CREAR cita nueva
                Cita::create($data);
                $this->dispatch('notify', [
                    'message' => 'Cita creada correctamente',
                    'type' => 'success'
                ]);
            }

            // 🔄 ACTUALIZAR LISTA
            $this->closeModal();
            $this->cargarCitas();

        } catch (\Exception $e) {
            $this->dispatch('notify', [
                'message' => 'Error: ' . $e->getMessage(),
                'type' => 'error'
            ]);
        }
    }

    /**
     * ✅ ACEPTAR CITA
     * Admin asigna fecha y hora
     */
    public function aceptarCita(Cita $cita)
    {
        try {
            // Validar que fecha y hora sean válidas
            $this->validate([
                'fecha_cita' => 'required|date',
                'hora_cita' => 'required|date_format:H:i',
            ]);

            // Actualizar cita en BD
            $cita->update([
                'estado' => 'aceptada',
                'fecha_cita' => $this->fecha_cita,
                'hora_cita' => $this->hora_cita,
                'fecha_respuesta_admin' => now(),
            ]);

            // 📧 Enviar email al usuario
            CitaActualizada::dispatch($cita, 'aceptada');

            // Notificar al admin
            $this->dispatch('notify', [
                'message' => '✓ Cita aceptada correctamente',
                'type' => 'success'
            ]);

            // Actualizar tabla
            $this->cargarCitas();
            $this->closeAceptarModal();

        } catch (\Exception $e) {
            $this->dispatch('notify', [
                'message' => 'Error: ' . $e->getMessage(),
                'type' => 'error'
            ]);
        }
    }

    /**
     * ❌ RECHAZAR CITA
     */
    public function rechazarCita(Cita $cita)
    {
        try {
            $this->validate([
                'motivo_rechazo' => 'required|string|min:10',
            ]);

            $cita->update([
                'estado' => 'rechazada',
                'motivo_rechazo' => $this->motivo_rechazo,
                'fecha_respuesta_admin' => now(),
            ]);

            // 📧 Enviar email de rechazo
            CitaActualizada::dispatch($cita, 'rechazada');

            $this->dispatch('notify', [
                'message' => 'Cita rechazada',
                'type' => 'success'
            ]);

            $this->cargarCitas();
            $this->closeRechazarModal();

        } catch (\Exception $e) {
            $this->dispatch('notify', [
                'message' => 'Error: ' . $e->getMessage(),
                'type' => 'error'
            ]);
        }
    }

    /**
     * 🗑️ ELIMINAR CITA
     */
    public function delete(Cita $cita)
    {
        try {
            $cita->delete();
            $this->dispatch('notify', [
                'message' => 'Cita eliminada correctamente',
                'type' => 'success'
            ]);
            $this->cargarCitas();
        } catch (\Exception $e) {
            $this->dispatch('notify', [
                'message' => 'Error al eliminar: ' . $e->getMessage(),
                'type' => 'error'
            ]);
        }
    }
}
```

---

## 🗄️ BASE DE DATOS

### **Tabla `citas` (MySQL)**

```sql
CREATE TABLE citas (
    -- 🔑 PRIMARY KEY
    id INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,

    -- 👤 DATOS PERSONALES
    nombre VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    telefono VARCHAR(20) NOT NULL,
    documento_identidad VARCHAR(50),
    ubicacion VARCHAR(255),

    -- 📋 INFORMACIÓN DE LA CONSULTA
    tipo_consulta VARCHAR(255) NOT NULL,
    -- Valores: 'asesoría legal', 'defensa penal', 'familia', etc
    
    descripcion LONGTEXT NOT NULL,
    -- El motivo/descripción de la consulta

    -- 📅 FECHAS Y HORAS
    fecha_solicitud TIMESTAMP NOT NULL,
    -- Cuándo el usuario solicitó la cita
    
    fecha_cita DATE,
    -- Fecha asignada por el admin
    
    hora_cita TIME,
    -- Hora asignada por el admin
    
    fecha_respuesta_admin TIMESTAMP,
    -- Cuándo el admin respondió

    -- 🏷️ ESTADO DE LA CITA
    estado VARCHAR(50) NOT NULL DEFAULT 'pendiente',
    -- Valores: pendiente, aceptada, rechazada, completada, cancelada, reprogramada
    
    motivo_rechazo LONGTEXT,
    -- Si fue rechazada, el motivo

    -- 🔄 REPROGRAMACIÓN
    datos_reprogramacion JSON,
    -- Datos sobre reprogramaciones anteriores
    -- Ejemplo: {"fecha_anterior": "2024-12-10", "fecha_nueva": "2024-12-15"}

    -- 🔌 CAMPOS DEL SISTEMA
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    deleted_at TIMESTAMP NULL,  -- Para soft deletes
);
```

**Ejemplo de datos guardados:**

```
┌────┬──────────┬──────────────────┬──────────┬────────────────┬──────────────┬─────────────────┐
│ id │ nombre   │ email            │ telefono │ tipo_consulta  │ estado       │ fecha_cita      │
├────┼──────────┼──────────────────┼──────────┼────────────────┼──────────────┼─────────────────┤
│ 1  │ Juan     │ juan@mail.com    │ 98765... │ Asesoría Legal │ aceptada     │ 2024-12-10      │
│ 2  │ María    │ maria@mail.com   │ 98711... │ Defensa Penal  │ pendiente    │ NULL            │
│ 3  │ Pedro    │ pedro@mail.com   │ 98722... │ Familia        │ rechazada    │ NULL            │
│ 4  │ Ana      │ ana@mail.com     │ 98733... │ Laboral        │ reprogramada │ 2024-12-20      │
└────┴──────────┴──────────────────┴──────────┴────────────────┴──────────────┴─────────────────┘
```

---

## 📧 EVENTOS Y EMAILS

### **Archivo: `app/Events/CitaCreada.php`**

```php
<?php

namespace App\Events;

use App\Models\Cita;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CitaCreada
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $cita;

    public function __construct(Cita $cita)
    {
        $this->cita = $cita;
    }
}
```

### **Archivo: `app/Listeners/EnviarNotificacionCitaCreada.php`**

```php
<?php

namespace App\Listeners;

use App\Events\CitaCreada;
use App\Mail\CitaCreada as MailCitaCreada;
use Illuminate\Support\Facades\Mail;

class EnviarNotificacionCitaCreada
{
    public function handle(CitaCreada $event)
    {
        // 📧 Enviar email de confirmación al usuario
        Mail::to($event->cita->email)
            ->send(new MailCitaCreada($event->cita));

        // 📧 Enviar email de notificación al admin
        Mail::to(config('mail.from.address'))
            ->send(new \App\Mail\CitaCreadaAdmin($event->cita));
    }
}
```

---

## 🔄 DIAGRAMA DE ESTADOS

```
                    ┌──────────────┐
                    │  PENDIENTE   │
                    │  (Usuario    │
                    │  solicitó)   │
                    └────────┬─────┘
                             │
                    ┌────────┴────────┐
                    │                 │
                    ▼                 ▼
            ┌────────────────┐  ┌──────────────┐
            │   ACEPTADA     │  │  RECHAZADA   │
            │ (Admin aprobó) │  │ (Admin negó) │
            └────────┬───────┘  └──────────────┘
                     │
                ┌────┴──────┐
                │            │
                ▼            ▼
        ┌─────────────┐  ┌────────────────┐
        │ COMPLETADA  │  │  REPROGRAMADA  │
        │ (Cita pasó) │  │ (Nueva fecha)  │
        └─────────────┘  └────────┬───────┘
                                  │
                          ┌───────┴────────┐
                          │                │
                          ▼                ▼
                  ┌────────────────┐  ┌──────────────┐
                  │   ACEPTADA     │  │  RECHAZADA   │
                  │ (Nueva fecha)  │  │ (No hay nueva│
                  └────────┬───────┘  │    fecha)    │
                           │          └──────────────┘
                    (repite ciclo)

┌────────────┐
│ CANCELADA  │  ← Puede llegar desde cualquier estado
└────────────┘
```

---

## 🎓 RESUMEN TÉCNICO

```
FRONTEND (Usuario público):
  1. Llena formulario HTML
  2. Presiona "Enviar"
  3. POST /citas con datos
  4. Validación en frontend (opcional, JS)
  5. Envía al servidor

ROUTING (web.php):
  POST /citas → CitaController@store()

BACKEND (Controller):
  1. Recibe Request con datos
  2. Valida (required, email, string, etc)
  3. Crea registro en BD
  4. Dispara evento (CitaCreada)
  5. Devuelve respuesta al usuario

DATABASE (MySQL):
  1. Inserta row en tabla 'citas'
  2. genera id automático
  3. marca fecha_solicitud
  4. estado = 'pendiente'

EMAIL:
  1. Evento CitaCreada se dispara
  2. Listener escucha el evento
  3. Envía email de confirmación al usuario
  4. Envía notificación al admin

ADMIN (Livewire):
  1. Entra a /admin/citas
  2. Componente Citas carga del DB
  3. Admin busca/filtra
  4. Admin acepta/rechaza/reprograma
  5. Base de datos se actualiza
  6. Otro email se envía al usuario
  7. Usuario recibe confirmación
```

---

¡Eso es todo! El sistema de citas está completamente integrado desde el frontend hasta la base de datos. 🚀
