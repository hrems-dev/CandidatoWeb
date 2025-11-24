# 📚 EXPLICACIÓN COMPLETA DEL PROYECTO CANDIDATO WEB

## 🎯 ¿QUÉ ES CANDIDATO WEB?

Es una **plataforma web completa** para gestionar candidatos en procesos legales. Permite:
- 📋 Agendar citas legales
- 📰 Publicar y gestionar noticias
- 💬 Recolectar comentarios de usuarios
- 📧 Recibir contactos
- 👤 Dashboard de administración

---

# 🏗️ ARQUITECTURA GENERAL DEL PROYECTO

```
CANDIDATO WEB
│
├─ FRONTEND (Lo que ve el usuario)
│  ├─ Vistas Públicas (/noticias, /comentarios, /citas, /contacto)
│  └─ Vistas de Admin (/admin/citas, /admin/noticias, etc)
│
├─ BACKEND (La lógica que procesa datos)
│  ├─ Controllers (Procesamiento de peticiones)
│  ├─ Livewire Components (Componentes interactivos)
│  ├─ Models (Acceso a base de datos)
│  └─ Routes (Rutas/direcciones del sitio)
│
└─ DATABASE (Base de datos MySQL)
   ├─ tabla: citas
   ├─ tabla: noticias
   ├─ tabla: comentarios
   ├─ tabla: contactos
   └─ tabla: usuarios
```

---

# 🔌 FLUJO GENERAL: FRONTEND → BACKEND → DATABASE

```
┌─────────────────┐
│  USUARIO        │
│  (Browser)      │
└────────┬────────┘
         │
         │ 1️⃣ Usuario llena formulario y presiona "Enviar"
         │
         ▼
┌─────────────────┐
│  FRONTEND       │
│  (HTML/Blade)   │ ← resources/views/
└────────┬────────┘
         │
         │ 2️⃣ Envía datos al servidor (POST/GET)
         │
         ▼
┌─────────────────────┐
│ ROUTES (web.php)    │ ← Detecta el URL y dirige a:
│ Ej: /citas.store    │   - Controller
│                     │   - Livewire Component
└────────┬────────────┘
         │
         │ 3️⃣ Dirige a la clase correcta
         │
         ▼
┌──────────────────────┐
│ CONTROLLER o         │
│ LIVEWIRE COMPONENT   │
│ (app/Http/Controllers/, app/Livewire/) │
│                      │
│ - Valida datos       │
│ - Procesa lógica     │
│ - Llama al Model     │
└────────┬─────────────┘
         │
         │ 4️⃣ Solicita datos al Model
         │
         ▼
┌──────────────────────┐
│ MODEL                │
│ (app/Models/)        │
│                      │
│ - Accede a BD        │
│ - Guarda datos       │
│ - Obtiene datos      │
└────────┬─────────────┘
         │
         │ 5️⃣ Ejecuta query SQL en:
         │
         ▼
┌──────────────────────┐
│ DATABASE (MySQL)     │
│ (Tablas)             │
│                      │
│ - Procesa query      │
│ - Guarda/obtiene     │
│ - Devuelve resultado │
└────────┬─────────────┘
         │
         │ 6️⃣ Resultado regresa al Controller/Livewire
         │
         ▼
┌──────────────────────┐
│ CONTROLLER/LIVEWIRE  │
│                      │
│ - Procesa resultado  │
│ - Prepara respuesta  │
└────────┬─────────────┘
         │
         │ 7️⃣ Regresa al Frontend (Reload page o actualiza)
         │
         ▼
┌─────────────────────┐
│ FRONTEND            │
│ (Se actualiza)      │
└────────┬────────────┘
         │
         │ 8️⃣ Usuario ve los cambios
         │
         ▼
┌─────────────────┐
│  USUARIO        │
│  (Actualizado)  │
└─────────────────┘
```

---

# 📍 ESTRUCTURA DE CARPETAS

```
CandidatoWeb/
│
├─ app/
│  ├─ Http/Controllers/       ← Lógica de negocio
│  │  ├─ CitaController.php
│  │  ├─ NoticiaController.php
│  │  ├─ ComentarioPublicoController.php
│  │  └─ ... (más controladores)
│  │
│  ├─ Livewire/              ← Componentes interactivos
│  │  ├─ Citas.php           ← Gestión de citas (Admin)
│  │  ├─ Noticias.php        ← Gestión de noticias (Admin)
│  │  ├─ ComentariosAdmin.php ← Moderación de comentarios
│  │  ├─ Contactos.php       ← Gestión de contactos
│  │  └─ ... (más componentes)
│  │
│  └─ Models/                 ← Acceso a Base de Datos
│     ├─ Cita.php
│     ├─ Noticia.php
│     ├─ Comentario.php
│     └─ ... (más modelos)
│
├─ routes/
│  └─ web.php                ← Todas las rutas/URLs
│
├─ resources/views/
│  ├─ citas/                 ← Vistas públicas
│  │  └─ index.blade.php
│  ├─ noticias/              ← Vistas públicas
│  │  ├─ index.blade.php
│  │  └─ show.blade.php
│  ├─ comentarios/           ← Vistas públicas
│  │  └─ index.blade.php
│  ├─ admin/                 ← Vistas de Admin
│  │  ├─ citas/
│  │  ├─ noticias/
│  │  ├─ comentarios/
│  │  └─ dashboard.blade.php
│  └─ livewire/              ← Vistas de Componentes
│     ├─ citas.blade.php
│     ├─ noticias.blade.php
│     ├─ comentarios-admin.blade.php
│     └─ ... (más vistas)
│
├─ database/
│  ├─ migrations/            ← Esquema de la BD
│  │  └─ crear_tabla_citas.php
│  └─ seeders/               ← Datos iniciales (si existen)
│
└─ config/
   └─ database.php           ← Configuración de BD
```

---

# 🚀 EJEMPLO PRÁCTICO: SISTEMA DE CITAS

## ¿Cómo se conectan Frontend, Backend y Database?

### **PASO 1: Usuario llena formulario en el Frontend**

**Archivo:** `resources/views/citas/index.blade.php`

```html
<!-- Usuario ve este formulario -->
<form method="POST" action="{{ route('citas.store') }}">
    <input type="text" name="nombre" placeholder="Tu nombre">
    <input type="email" name="email" placeholder="Tu email">
    <input type="tel" name="telefono" placeholder="Tu teléfono">
    <select name="tipo_consulta">
        <option>Asesoría Legal</option>
        <option>Defensa Penal</option>
    </select>
    <textarea name="descripcion"></textarea>
    <button type="submit">Enviar Cita</button>
</form>
```

✅ **Qué pasa aquí:**
- Usuario ve un formulario HTML
- `action="{{ route('citas.store') }}"` = URL a donde enviar datos
- `method="POST"` = Envía datos al servidor


### **PASO 2: Routing - Detectar la petición**

**Archivo:** `routes/web.php`

```php
// Detecta cuando el usuario presiona "Enviar" en /citas
Route::post('/citas', [\App\Http\Controllers\CitaController::class, 'store'])
    ->name('citas.store');
```

✅ **Qué pasa aquí:**
- Laravel detecta `POST /citas`
- Dirige automáticamente a `CitaController` clase, método `store()`
- `->name('citas.store')` = Es el nombre de la ruta (usado en formularios)


### **PASO 3: Backend - Procesar datos (Controller)**

**Archivo:** `app/Http/Controllers/CitaController.php`

```php
class CitaController extends Controller
{
    public function store(Request $request)
    {
        // 1️⃣ Validar datos que vienen del formulario
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'telefono' => 'required|string|max:20',
            'tipo_consulta' => 'required|string',
            'descripcion' => 'required|string',
        ]);

        // 2️⃣ Crear nueva cita en la BD
        $cita = Cita::create([
            'nombre' => $validated['nombre'],
            'email' => $validated['email'],
            'telefono' => $validated['telefono'],
            'tipo_consulta' => $validated['tipo_consulta'],
            'descripcion' => $validated['descripcion'],
            'estado' => 'pendiente',  ← Estados: pendiente/aceptada/rechazada
            'fecha_solicitud' => now(),
        ]);

        // 3️⃣ Disparar evento (notifica al admin)
        CitaCreada::dispatch($cita);

        // 4️⃣ Responder al usuario
        return redirect()->back()->with('success', '✓ Cita enviada correctamente!');
    }
}
```

✅ **Qué pasa aquí:**
- `Request $request` = Recibe todos los datos del formulario
- `$request->validate()` = Verifica que los datos sean válidos
- `Cita::create()` = Crea un nuevo registro en la BD
- `CitaCreada::dispatch()` = Notifica al admin por email
- `redirect()->back()` = Regresa a la página anterior


### **PASO 4: Model - Acceso a Base de Datos**

**Archivo:** `app/Models/Cita.php`

```php
class Cita extends Model
{
    protected $table = 'citas';  ← Nombre de la tabla en BD

    protected $fillable = [      ← Campos que se pueden llenar
        'nombre',
        'email',
        'telefono',
        'tipo_consulta',
        'descripcion',
        'estado',
        'fecha_solicitud',
        'fecha_cita',
        'hora_cita',
        // ... más campos
    ];

    protected $casts = [         ← Convertir tipos de datos
        'fecha_solicitud' => 'datetime',
        'fecha_cita' => 'datetime',
    ];
}
```

✅ **Qué pasa aquí:**
- Define la tabla `citas` en la BD
- Especifica qué campos se pueden llenar (protección contra injecciones)
- Convierte fechas a objetos DateTime automáticamente


### **PASO 5: Database - Guardar en la BD (MySQL)**

**La tabla `citas` se ve así:**

```
┌────┬──────────┬──────────────┬───────────┬────────────────┬──────────┬─────────────────┐
│ id │  nombre  │    email     │ telefono  │  tipo_consulta │  estado  │ fecha_solicitud │
├────┼──────────┼──────────────┼───────────┼────────────────┼──────────┼─────────────────┤
│ 1  │ Juan     │ juan@mail.com│ 987654321 │ Asesoría Legal │ pendiente│ 2024-11-24 10am │
│ 2  │ María    │ maria@mail.. │ 987111111 │ Defensa Penal  │ pendiente│ 2024-11-24 2pm  │
│ 3  │ Pedro    │ pedro@mail.. │ 987222222 │ Familia        │ aceptada │ 2024-11-24 3pm  │
└────┴──────────┴──────────────┴───────────┴────────────────┴──────────┴─────────────────┘
```

✅ **Qué pasa aquí:**
- Los datos del formulario se guardan en esta tabla
- Cada fila es una cita diferente
- El `estado` indica si es: `pendiente`, `aceptada`, `rechazada`, etc.


---

## 🎮 SISTEMA DE CITAS - FLUJO COMPLETO

### **Parte 1: Usuario público agenda cita**

```
Usuario escribe en /citas
        ↓
Llena formulario (nombre, email, teléfono, etc)
        ↓
Presiona "Enviar Cita"
        ↓
POST /citas → CitaController@store()
        ↓
Valida datos
        ↓
Cita::create() → Guarda en tabla 'citas'
        ↓
Estado = 'pendiente'
        ↓
Despliega mensaje: "✓ Cita enviada!"
```


### **Parte 2: Admin revisa y gestiona cita**

**Archivo:** `resources/views/admin/citas/index.blade.php`

```html
@livewire('citas')  ← Carga el componente Livewire
```

**Archivo:** `app/Livewire/Citas.php`

```php
class Citas extends Component
{
    public $citas = [];        ← Array con las citas
    public $search = '';       ← Búsqueda en tiempo real
    public $filterEstado = ''; ← Filtro por estado

    public function mount()    ← Se ejecuta cuando se carga el componente
    {
        $this->cargarCitas();
    }

    public function cargarCitas()  ← Obtiene citas de la BD
    {
        // Busca y filtra citas
        $query = Cita::query();

        if ($this->search) {
            $query->where('nombre', 'like', '%' . $this->search . '%')
                  ->orWhere('email', 'like', '%' . $this->search . '%');
        }

        if ($this->filterEstado) {
            $query->where('estado', $this->filterEstado);
        }

        // Obtiene del DB y ordena por más reciente
        $this->citas = $query->orderBy('created_at', 'desc')->get()->toArray();
    }

    // ACEPTAR CITA
    public function aceptarCita(Cita $cita)
    {
        // Valida fecha y hora
        $this->validate([
            'fecha_cita' => 'required|date',
            'hora_cita' => 'required|date_format:H:i',
        ]);

        // Actualiza en BD
        $cita->update([
            'estado' => 'aceptada',        ← Cambia estado
            'fecha_cita' => $this->fecha_cita,
            'hora_cita' => $this->hora_cita,
            'fecha_respuesta_admin' => now(),  ← Marca cuando el admin respondió
        ]);

        // Dispara evento para enviar email al usuario
        CitaActualizada::dispatch($cita, 'aceptada');

        // Notifica al admin
        $this->dispatch('notify', ['message' => '✓ Cita aceptada', 'type' => 'success']);

        // Recarga la lista
        $this->cargarCitas();
    }

    // RECHAZAR CITA
    public function rechazarCita(Cita $cita)
    {
        $cita->update([
            'estado' => 'rechazada',
            'motivo_rechazo' => $this->motivo_rechazo,
            'fecha_respuesta_admin' => now(),
        ]);

        CitaActualizada::dispatch($cita, 'rechazada');
        $this->cargarCitas();
    }

    // REPROGRAMAR CITA
    public function reprogramarCita(Cita $cita)
    {
        $cita->update([
            'estado' => 'reprogramada',
            'datos_reprogramacion' => [
                'fecha_anterior' => $cita->fecha_cita,
                'fecha_nueva' => $this->fecha_cita,
                'motivo' => $this->motivo_reprogramacion,
            ],
        ]);

        CitaActualizada::dispatch($cita, 'reprogramada');
        $this->cargarCitas();
    }
}
```

✅ **Qué pasa aquí:**
- Admin entra a `/admin/citas`
- Ve un Livewire component que carga todas las citas del DB
- Puede buscar: `Buscar por nombre o email` (en tiempo real)
- Puede filtrar: `Por estado (pendiente, aceptada, rechazada, etc)`
- Acciones disponibles:
  - ✅ **Aceptar:** Cambia estado a `aceptada` y asigna fecha/hora
  - ❌ **Rechazar:** Cambia estado a `rechazada` y agrega motivo
  - 🔄 **Reprogramar:** Cambia estado a `reprogramada` con nueva fecha
  - 🗑️ **Eliminar:** Elimina la cita del DB


### **Parte 3: Livewire - Interactividad en tiempo real**

**Archivo:** `resources/views/livewire/citas.blade.php`

```blade
{{-- Búsqueda en tiempo real --}}
<input
    type="text"
    placeholder="Buscar por nombre o email..."
    wire:model.live="search"  ← Actualiza en tiempo real
    class="w-full px-4 py-2..."
>

{{-- Filtro por estado --}}
<select wire:model.live="filterEstado" class="...">
    <option value="">Todos los estados</option>
    @foreach($estados as $estado)
        <option value="{{ $estado }}">{{ ucfirst($estado) }}</option>
    @endforeach
</select>

{{-- Tabla con citas --}}
<table class="w-full">
    <tbody>
        @foreach($citas as $cita)
            <tr>
                <td>{{ $cita['nombre'] }}</td>
                <td>{{ $cita['email'] }}</td>
                <td>
                    {{-- Badge de estado --}}
                    @if($cita['estado'] == 'pendiente')
                        <span class="bg-yellow-100 text-yellow-800">Pendiente</span>
                    @elseif($cita['estado'] == 'aceptada')
                        <span class="bg-green-100 text-green-800">Aceptada</span>
                    @elseif($cita['estado'] == 'rechazada')
                        <span class="bg-red-100 text-red-800">Rechazada</span>
                    @endif
                </td>
                <td>
                    {{-- Botones de acciones --}}
                    @if($cita['estado'] == 'pendiente')
                        <button wire:click="abrirAceptarModal({{ $cita['id'] }})">
                            ✅ Aceptar
                        </button>
                        <button wire:click="abrirRechazarModal({{ $cita['id'] }})">
                            ❌ Rechazar
                        </button>
                    @endif

                    @if($cita['estado'] == 'aceptada')
                        <button wire:click="abrirReprogramarModal({{ $cita['id'] }})">
                            🔄 Reprogramar
                        </button>
                    @endif

                    <button wire:click="delete({{ $cita['id'] }})">
                        🗑️ Eliminar
                    </button>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
```

✅ **Qué pasa aquí:**
- `wire:model.live="search"` = Actualiza búsqueda en tiempo real (sin recargar página)
- `wire:click="aceptarCita()"` = Ejecuta método del component cuando se hace clic
- `@if($cita['estado'] == 'pendiente')` = Muestra botones solo si la cita está pendiente
- Badges de color según el estado


---

# 🎯 RESUMEN: CITAS (De principio a fin)

## **Flujo Usuario Público:**

```
1. Va a /citas
2. Ve formulario
3. Llena: nombre, email, teléfono, tipo, descripción
4. Presiona "Enviar"
5. POST → CitaController@store()
6. Datos validados y guardados en tabla 'citas' con estado='pendiente'
7. Email de confirmación enviado al usuario
8. Mensaje: "✓ Tu cita ha sido enviada"
```

## **Flujo Admin:**

```
1. Entra a /admin/citas
2. Ve Livewire component que carga todas las citas
3. Puede BUSCAR por nombre/email (tiempo real)
4. Puede FILTRAR por estado (pendiente, aceptada, etc)
5. Acciones:
   - ACEPTAR: Asigna fecha/hora, envía email al usuario
   - RECHAZAR: Asigna motivo, avisa al usuario
   - REPROGRAMAR: Cambia fecha, avisa al usuario
   - ELIMINAR: Borra de la BD
6. Cada cambio se refleja en la tabla automáticamente
7. Usuario recibe email automáticamente
```

---

# 📊 ARQUITECTURA LIVEWIRE

**¿Por qué Livewire es tan poderoso?**

```
SIN LIVEWIRE:
Usuario → Formulario → Submit → Recarga página → Procesa → Muestra resultado

CON LIVEWIRE:
Usuario → Input → En tiempo real se actualiza → Procesa en servidor → Actualiza HTML sin recargar
```

**Ejemplo:**

```blade
<!-- Sin Livewire (Blade tradicional) -->
<form method="POST" action="/buscar">
    <input type="text" name="busqueda">
    <button>Buscar</button>
</form>
<!-- Requiere recargar página -->

<!-- Con Livewire (Interactivo) -->
<input wire:model.live="search" placeholder="Buscar...">
<!-- Actualiza mientras escribes, SIN recargar -->
```

---

# 🗄️ TODAS LAS TABLAS EN LA BASE DE DATOS

```
┌─────────────────────────────────────────┐
│         TABLA: citas                    │
├─────────────────────────────────────────┤
│ id (INT)                                │
│ nombre (VARCHAR)                        │
│ email (VARCHAR)                         │
│ telefono (VARCHAR)                      │
│ tipo_consulta (VARCHAR)                 │
│ descripcion (TEXT)                      │
│ estado (VARCHAR) → pendiente/aceptada   │
│ fecha_cita (DATE)                       │
│ hora_cita (TIME)                        │
│ fecha_solicitud (DATETIME)              │
│ fecha_respuesta_admin (DATETIME)        │
│ motivo_rechazo (TEXT)                   │
│ datos_reprogramacion (JSON)             │
└─────────────────────────────────────────┘

┌─────────────────────────────────────────┐
│      TABLA: noticias                    │
├─────────────────────────────────────────┤
│ id (INT)                                │
│ titulo (VARCHAR)                        │
│ slug (VARCHAR)                          │
│ contenido (TEXT)                        │
│ resumen (TEXT)                          │
│ imagen (VARCHAR)                        │
│ categoria (VARCHAR)                     │
│ tipo (VARCHAR) → noticia/evento/etc     │
│ estado (VARCHAR)  → publicado            │
│ vistas (INT)                            │
│ fecha_publicacion (DATETIME)            │
└─────────────────────────────────────────┘

┌─────────────────────────────────────────┐
│    TABLA: comentarios                   │
├─────────────────────────────────────────┤
│ id (INT)                                │
│ nombre (VARCHAR)                        │
│ email (VARCHAR)                         │
│ ubicacion (VARCHAR)                     │
│ contenido (TEXT)                        │
│ calificacion (INT) → 1-5 estrellas      │
│ estado (VARCHAR) → pendiente/publicado  │
│ verificado (BOOLEAN)                    │
│ likes (INT)                             │
│ fecha (DATETIME)                        │
└─────────────────────────────────────────┘

┌─────────────────────────────────────────┐
│    TABLA: contactos                     │
├─────────────────────────────────────────┤
│ id (INT)                                │
│ nombre (VARCHAR)                        │
│ email (VARCHAR)                         │
│ telefono (VARCHAR)                      │
│ asunto (VARCHAR)                        │
│ mensaje (TEXT)                          │
│ estado (VARCHAR) → pendiente/respondido │
│ fecha (DATETIME)                        │
└─────────────────────────────────────────┘
```

---

# 🔗 TODOS LOS CONTROLLERS Y SUS FUNCIONES

## **CitaController** (app/Http/Controllers/CitaController.php)
- `store()` → Recibe cita del público, la guarda, envía email al admin
- `index()` → Lista todas las citas (API)
- `show()` → Muestra una cita específica (API)

## **NoticiaController** (app/Http/Controllers/NoticiaController.php)
- `store()` → Crea noticia desde admin
- `update()` → Edita noticia
- `destroy()` → Elimina noticia

## **NoticiaPublicaController** (app/Http/Controllers/NoticiaPublicaController.php)
- `index()` → Muestra todas las noticias públicas
- `show()` → Muestra una noticia en detalle
- `buscar()` → Busca noticias por texto
- `porTipo()` → Filtra por tipo (noticia, evento, etc)

## **ComentarioPublicoController** (app/Http/Controllers/ComentarioPublicoController.php)
- `index()` → Muestra comentarios publicados
- `store()` → Guarda comentario nuevo del usuario
- `like()` → Incrementa likes en un comentario

## **ContactoController** (app/Http/Controllers/ContactoController.php)
- `store()` → Guarda contacto/formulario de contacto

---

# 📱 SECCIONES DEL PROYECTO

```
┌─────────────────────────────────────────────────┐
│              CANDIDATO WEB SITEMAP              │
├─────────────────────────────────────────────────┤
│                                                 │
│  PÚBLICA (Todos pueden acceder)                │
│  ├─ / (Welcome)                               │
│  ├─ /candidato                                │
│  ├─ /citas                    (Form)          │
│  ├─ /noticias                 (List + Search) │
│  ├─ /noticias/{slug}          (Detail)        │
│  ├─ /comentarios              (Form + List)   │
│  └─ /contacto                 (Form)          │
│                                                 │
│  ADMIN (Solo usuarios autenticados)            │
│  ├─ /admin/dashboard          (Home)          │
│  ├─ /admin/citas              (CRUD + Livewire)│
│  ├─ /admin/noticias           (CRUD + Livewire)│
│  ├─ /admin/comentarios        (Moderation)    │
│  ├─ /admin/contactos          (List)          │
│  └─ /admin/settings           (Perfil, Pass)  │
│                                                 │
└─────────────────────────────────────────────────┘
```

---

# ✨ TECNOLOGÍAS UTILIZADAS

```
🔴 BACKEND:
   ├─ PHP 8.1+
   ├─ Laravel 11 (Framework)
   ├─ Livewire 3 (Componentes interactivos)
   ├─ MySQL 8 (Base de datos)
   └─ Fortify (Autenticación)

🟦 FRONTEND:
   ├─ HTML5
   ├─ Blade (Template engine de Laravel)
   ├─ Tailwind CSS (Estilos)
   ├─ Alpine.js (Interactividad ligera)
   └─ Font Awesome (Iconos)

🔧 HERRAMIENTAS:
   ├─ Composer (Gestor de paquetes PHP)
   ├─ Git (Control de versiones)
   ├─ VS Code (Editor)
   └─ Docker (Opcional, para BD)
```

---

## 🎓 CONCLUSIÓN

**Candidato Web es un sistema completo de 3 capas:**

1. **PRESENTACIÓN (Frontend)** → Lo que ves (HTML, Blade, Tailwind)
2. **LÓGICA (Backend)** → Controllers, Livewire, Validación
3. **DATOS (Database)** → MySQL, Models, Queries

**El flujo es siempre:**
```
Usuario interactúa → Frontend → Routes → Controller → Model → Database → Respuesta
```

**Cada sección funciona independientemente:**
- 🎫 **Citas:** Usuarios agendaban, admin gestiona
- 📰 **Noticias:** Admin publica, usuarios ven
- 💬 **Comentarios:** Usuarios comentan, admin modera
- 📧 **Contactos:** Usuarios contactan, admin ve

¡Todo conectado y funcionando! 🚀
