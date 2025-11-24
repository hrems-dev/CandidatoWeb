# 🔄 FLUJO DE SINCRONIZACIÓN: ADMIN ↔ BASE DE DATOS ↔ PÁGINA PÚBLICA

## 🎯 OBJETIVO

Explicar en detalle cómo los datos fluyen desde que creas/editas una noticia en el admin, hasta que aparece en la página pública, manteniendo todo sincronizado en tiempo real.

---

## 📊 DIAGRAMA COMPLETO

```
┌─────────────────────────────────────────────────────────────────────────────┐
│                            ADMIN PANEL                                      │
│                    (/admin/noticias)                                        │
│                                                                             │
│  ┌──────────────────────────────────────────────────────────────────────┐  │
│  │  Usuario Admin                                                       │  │
│  │  - Ve tabla con noticias                                            │  │
│  │  - Busca/filtra en tiempo real                                      │  │
│  │  - Presiona botón "Nueva Noticia"                                   │  │
│  │  - Se abre modal con formulario                                     │  │
│  └──────────────────────────────────────────────────────────────────────┘  │
│                                 │                                           │
│                                 ▼                                           │
│  ┌──────────────────────────────────────────────────────────────────────┐  │
│  │  Livewire Component (app/Livewire/Noticias.php)                    │  │
│  │  - Propiedades reactivas (titulo, contenido, etc)                  │  │
│  │  - wire:model.lazy vinculado a inputs                              │  │
│  │  - wire:submit="save" en formulario                                │  │
│  └──────────────────────────────────────────────────────────────────────┘  │
│                                 │                                           │
│                                 ▼                                           │
│  ┌──────────────────────────────────────────────────────────────────────┐  │
│  │  Validación (rules)                                                │  │
│  │  - titulo: required, string, max:255                              │  │
│  │  - contenido: required, string                                    │  │
│  │  - tipo: required, in:noticia,actividad,evento                   │  │
│  │  - imagen: nullable, image, max:5120                             │  │
│  │  ... etc                                                           │  │
│  │                                                                   │  │
│  │  ✅ Si válido → continúa                                         │  │
│  │  ❌ Si inválido → muestra errores en modal                       │  │
│  └──────────────────────────────────────────────────────────────────────┘  │
│                                 │                                           │
└─────────────────────────────────┼───────────────────────────────────────────┘
                                  │
                                  ▼
        ┌─────────────────────────────────────────────┐
        │     BACKEND (Laravel)                       │
        │     app/Livewire/Noticias.php              │
        │                                             │
        │  public function save() {                   │
        │    // Datos validados                       │
        │    $data = [                                │
        │      'titulo' => $this->titulo,             │
        │      'contenido' => $this->contenido,       │
        │      'estado' => $this->estado,             │
        │      'fecha_publicacion' => now(),          │
        │      'slug' => Str::slug(...),              │
        │      'imagen' => $path,                     │
        │    ];                                       │
        │                                             │
        │    if ($this->editingId) {                  │
        │      // ACTUALIZAR                          │
        │      Noticia::find($id)->update($data);     │
        │    } else {                                 │
        │      // CREAR                               │
        │      Noticia::create($data);                │
        │    }                                        │
        │  }                                          │
        └─────────────────────────────────────────────┘
                          │
                          ▼
        ┌─────────────────────────────────────────────┐
        │     MODELO (Eloquent)                       │
        │     app/Models/Noticia.php                  │
        │                                             │
        │  protected $fillable = [                    │
        │    'titulo',                                │
        │    'slug',                                  │
        │    'contenido',                             │
        │    'resumen',                               │
        │    'imagen',                                │
        │    'tipo',                                  │
        │    'estado',                                │
        │    'fecha_publicacion',                     │
        │    'vistas',                                │
        │    ...                                      │
        │  ];                                         │
        └─────────────────────────────────────────────┘
                          │
                          ▼
        ┌─────────────────────────────────────────────┐
        │     COMANDO SQL (MySQL)                     │
        │                                             │
        │  SI ES CREAR:                               │
        │  INSERT INTO noticias                       │
        │    (titulo, contenido, estado, ...)         │
        │  VALUES                                     │
        │    ('Nueva Ley', 'Contenido...', 'pub', ...) │
        │                                             │
        │  SI ES ACTUALIZAR:                          │
        │  UPDATE noticias                            │
        │  SET                                        │
        │    titulo = 'Nueva Ley',                    │
        │    contenido = 'Contenido...',              │
        │    updated_at = NOW()                       │
        │  WHERE id = 5;                              │
        └─────────────────────────────────────────────┘
                          │
                          ▼
        ┌─────────────────────────────────────────────┐
        │     BASE DE DATOS (MySQL)                   │
        │                                             │
        │  Tabla: noticias                            │
        │  ┌───┬────────────────┬─────────┬──────┐   │
        │  │id │ titulo         │estado   │vistas│   │
        │  ├───┼────────────────┼─────────┼──────┤   │
        │  │1  │ Nueva Ley...   │publicado│  245 │   │
        │  │2  │ Sentencia...   │borrador │    0 │   │
        │  │3  │ Jornada...     │publicado│   12 │   │
        │  └───┴────────────────┴─────────┴──────┘   │
        │                                             │
        │  ✅ Dato guardado exitosamente              │
        └─────────────────────────────────────────────┘
                          │
                          ▼
        ┌─────────────────────────────────────────────┐
        │  RESPUESTA LIVEWIRE                         │
        │  (Vuelve al frontend)                       │
        │                                             │
        │  this->closeModal();                        │
        │  this->cargarNoticias();                    │
        │  this->dispatch('notify', [                 │
        │    'message' => '✅ Guardado',              │
        │    'type' => 'success'                      │
        │  ]);                                        │
        └─────────────────────────────────────────────┘
                          │
                          ▼
┌─────────────────────────────────────────────────────────────────────────────┐
│                            ADMIN PANEL                                      │
│                    (/admin/noticias)                                        │
│                                                                             │
│  ┌──────────────────────────────────────────────────────────────────────┐  │
│  │  ACTUALIZACIÓN AUTOMÁTICA (Sin recargar página)                     │  │
│  │                                                                      │  │
│  │  1. Modal se cierra                                                │  │
│  │  2. Tabla se refresca con nuevos datos                            │  │
│  │  3. Estadísticas se actualizan                                    │  │
│  │  4. Toast de éxito aparece                                        │  │
│  │  5. Búsqueda y filtros siguen funcionando                         │  │
│  │                                                                      │  │
│  │  ✅ Puedes crear otra noticia inmediatamente                      │  │
│  └──────────────────────────────────────────────────────────────────────┘  │
│                                                                             │
└─────────────────────────────────────────────────────────────────────────────┘
                          │
                          ├─────────────────────────────────────┐
                          │                                     │
                          ▼                                     ▼
        ┌──────────────────────────┐      ┌──────────────────────────┐
        │   SI ESTADO = BORRADOR   │      │ SI ESTADO = PUBLICADO    │
        │                          │      │                          │
        │ ❌ NO aparece en:        │      │ ✅ APARECE en:           │
        │  /noticias               │      │  /noticias               │
        │  /noticias/{slug}        │      │  /noticias/{slug}        │
        │  /noticias/tipo/{tipo}   │      │  /noticias/tipo/{tipo}   │
        │                          │      │                          │
        │ ✅ APARECE en:           │      │ ✅ APARECE en:           │
        │  /admin/noticias         │      │  /admin/noticias         │
        │  (filtro: Borrador)      │      │  (filtro: Publicado)     │
        │                          │      │                          │
        └──────────────────────────┘      └──────────────────────────┘
                          │                         │
                          │                         ▼
                          │            ┌────────────────────────────────┐
                          │            │  PÁGINA PÚBLICA (/noticias)   │
                          │            │                                │
                          │            │  Controllers:                  │
                          │            │  NoticiaPublicaController      │
                          │            │                                │
                          │            │  public function index() {     │
                          │            │    $noticias = Noticia::where( │
                          │            │      'estado',                 │
                          │            │      'publicado'               │
                          │            │    )->paginate(9);             │
                          │            │                                │
                          │            │    return view('noticias...    │
                          │            │      ['noticias' => $noticias] │
                          │            │    );                          │
                          │            │  }                             │
                          │            └────────────────────────────────┘
                          │                         │
                          │                         ▼
                          │            ┌────────────────────────────────┐
                          │            │  VISTA BLADE                   │
                          │            │  resources/views/noticias/...  │
                          │            │                                │
                          │            │  @forelse($noticias as $n)     │
                          │            │    <div class="card">          │
                          │            │      <img src="...">           │
                          │            │      <h3>{{ $n->titulo }}</h3> │
                          │            │      <p>{{ $n->resumen }}</p>  │
                          │            │      <a href="/noticias/...">  │
                          │            │        Leer más                │
                          │            │      </a>                      │
                          │            │    </div>                      │
                          │            │  @endforelse                   │
                          │            └────────────────────────────────┘
                          │                         │
                          │                         ▼
                          │            ┌────────────────────────────────┐
                          │            │  USUARIO FINAL VE:            │
                          │            │  - Noticia en listado          │
                          │            │  - Puede hacer click           │
                          │            │  - Ve página detalle           │
                          │            │  - Contador de vistas sube     │
                          │            │  - Comparte en redes           │
                          │            └────────────────────────────────┘
                          │
                          └─ Sin hacer nada más, ¡sincronizado!
```

---

## ⚡ TIMELINE DE UN EJEMPLO COMPLETO

### Minuto 10:35

```
Admin: Click en "Nueva Noticia"
```

### Minuto 10:36

```
Admin: Llena formulario
  - Título: "Reforma Laboral 2025"
  - Tipo: Noticia
  - Estado: Publicado
  - Contenido: "El Congreso aprobó..."
  - Imagen: reforma.jpg
Admin: Click en "Crear Noticia"
```

### Minuto 10:36:05

```
FRONTEND (Livewire):
  wire:submit="save" se dispara
  │
  Validación en JavaScript (opcional)
  │
  ▼
LIVEWIRE EVENT: save() se ejecuta
  - Valida campos (backend)
  - Si hay error, devuelve errores
  - Si es válido, continúa...
```

### Minuto 10:36:10

```
BACKEND:
  Noticia::create([
    'titulo' => 'Reforma Laboral 2025',
    'slug' => 'reforma-laboral-2025-1234567890',
    'contenido' => 'El Congreso...',
    'estado' => 'publicado',
    'fecha_publicacion' => '2025-11-24 10:36:10',
    'imagen' => 'noticias/reforma.jpg',
    'vistas' => 0,
    'created_at' => '2025-11-24 10:36:10',
    'updated_at' => '2025-11-24 10:36:10'
  ])
```

### Minuto 10:36:15

```
DATABASE:
  INSERT INTO noticias (
    titulo, slug, contenido, estado, fecha_publicacion, imagen, vistas, created_at, updated_at
  ) VALUES (
    'Reforma Laboral 2025',
    'reforma-laboral-2025-1234567890',
    'El Congreso...',
    'publicado',
    '2025-11-24 10:36:10',
    'noticias/reforma.jpg',
    0,
    '2025-11-24 10:36:10',
    '2025-11-24 10:36:10'
  );
  
  ID GENERADO AUTOMÁTICAMENTE: 47
```

### Minuto 10:36:20

```
LIVEWIRE RESPONSE:
  this->cargarNoticias();
  ├─ SELECT * FROM noticias WHERE ... ORDER BY created_at DESC
  │ ├─ Obtiene las 10 más recientes
  │ └─ Las guarda en $this->noticias (array)
  │
  this->totalNoticias = Noticia::count(); // 47
  this->noticiasPublicadas = Noticia::where('estado', 'publicado')->count(); // 35
  this->noticiasBorrador = Noticia::where('estado', 'borrador')->count(); // 12
  
  this->closeModal();
  │ └─ $this->showModal = false;
  │
  this->dispatch('notify', ['message' => '✅ Noticia creada', 'type' => 'success']);
```

### Minuto 10:36:25

```
ADMIN PANEL SE ACTUALIZA (Sin recargar):
  ✅ Modal se cierra
  ✅ Tabla se refresca
  ✅ Nueva noticia aparece en la primera fila
  ✅ Estadísticas se actualizan
      Total: 46 → 47
      Publicadas: 34 → 35
  ✅ Toast verde dice "Noticia creada"
  ✅ Admin puede crear otra inmediatamente
```

### Minuto 10:36:30

```
PÁGINA PÚBLICA (/noticias):
  Los datos aún no están en caché (si hubiera caché)
  
  Un usuario entra a /noticias
  ├─ Laravel ejecuta: Noticia::where('estado', 'publicado')->get()
  ├─ Base de datos devuelve 35 noticias
  ├─ Nota: "Reforma Laboral 2025" está incluida ✅
  ├─ Vista las renderiza como cards
  ├─ HTML se envía al navegador
  └─ Usuario ve la noticia recién creada
```

### Minuto 10:37

```
USUARIO HACE CLICK EN "LEER MÁS":
  /noticias/reforma-laboral-2025-1234567890
  ├─ Controlador: NoticiaPublicaController@show('reforma-laboral-2025-1234567890')
  ├─ SELECT * FROM noticias WHERE slug = '...'
  ├─ Ejecuta: $noticia->incrementarVistas() // vistas = 0 → 1
  ├─ UPDATE noticias SET vistas = 1 WHERE id = 47
  ├─ Vista renderiza página completa
  └─ Usuario ve: imagen, título, contenido completo, fecha, vistas = 1
```

### Minuto 10:37:30

```
ADMIN REFRESCA TABLA:
  Presiona F5 (o busca/filtra)
  ├─ Livewire recarga
  ├─ cargarNoticias() ejecuta
  ├─ SELECT * FROM noticias ...
  ├─ Nota: Reforma Laboral ahora tiene vistas = 1 ✅
  └─ La tabla se actualiza
```

### Minuto 10:45

```
ADMIN EDITA LA NOTICIA:
  Click en "Editar" de la noticia
  ├─ Modal se abre con datos actuales
  ├─ Admin cambia: contenido = "El Congreso aprobó... (detalles)"
  ├─ Admin cambia: estado = "borrador" (para revisión)
  ├─ Click en "Guardar Cambios"
  │
  ├─ BACKEND:
  │  Noticia::find(47)->update([
  │    'contenido' => 'El Congreso... (detalles)',
  │    'estado' => 'borrador',
  │    'updated_at' => NOW()
  │  ])
  │
  ├─ DATABASE:
  │  UPDATE noticias SET
  │    contenido = 'El Congreso... (detalles)',
  │    estado = 'borrador',
  │    updated_at = '2025-11-24 10:45:00'
  │  WHERE id = 47
  │
  └─ ADMIN: Tabla se refresca, noticia ahora muestra estado "Borrador" (amarillo)
```

### Minuto 10:46

```
PÁGINA PÚBLICA:
  Un usuario intenta entrar a /noticias/reforma-laboral-2025-1234567890
  ├─ Controlador ejecuta: Noticia::where('slug', '...')->first()
  ├─ Base de datos encuentra la noticia
  ├─ Pero su estado es 'borrador'
  ├─ El controlador devuelve 404
  └─ Usuario ve: Página no encontrada

O si va a /noticias:
  ├─ WHERE estado = 'publicado'
  ├─ La noticia NO aparece (porque es borrador)
  ├─ El listado ahora tiene 34 noticias (no 35)
  └─ La noticia desaparece de la vista pública automáticamente ✅
```

---

## 🔐 SINCRONIZACIÓN DE SEGURIDAD

### Estado en Admin (solo admin ve)

```
┌─ Borrador
│  └─ Visible en: /admin/noticias (siempre)
│  └─ Visible en público: NO
│  └─ Acceso directo: 404
└─ Publicado
   └─ Visible en: /admin/noticias (siempre)
   └─ Visible en público: SÍ
   └─ Acceso directo: OK
```

### Código de Seguridad (en controlador público)

```php
public function show($slug)
{
    // ⚠️ Solo obtiene noticias PUBLICADAS
    $noticia = Noticia::where('slug', $slug)
                      ->where('estado', 'publicado')  // ← IMPORTANTE
                      ->firstOrFail();
    
    // Si no existe o no está publicada
    // → Lanza 404 automáticamente
}

public function index()
{
    // ⚠️ Solo muestra noticias PUBLICADAS
    $noticias = Noticia::where('estado', 'publicado')  // ← IMPORTANTE
                       ->paginate(9);
}
```

---

## 📱 RESUMEN VISUAL

```
ADMIN CREA/EDITA
        ↓
  LIVEWIRE VALIDA
        ↓
   BACKEND PROCESA
        ↓
  BD SE ACTUALIZA
        ↓
ADMIN SE REFRESCA
        ↓
PÁGINA PÚBLICA SINCRONIZA
        ↓
   USUARIO FINAL VE
```

**TODO EN TIEMPO REAL, SIN RECARGAR PÁGINA** 🚀

