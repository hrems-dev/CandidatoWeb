# 📋 ESTRUCTURA DE COMPONENTES - CANDIDATO WEB

## ✅ COMPONENTES ACTIVOS (En uso)

### 1. **SECCIÓN: CITAS** 
**Ubicación:** `/admin/citas`
- **Componente Livewire:** `app/Livewire/Citas.php`
- **Vista:** `resources/views/livewire/citas.blade.php`
- **Uso:** `@livewire('citas')` en `admin/citas/index.blade.php`
- **Funcionalidad:** Gestión completa de citas (CRUD, búsqueda, filtros)

---

### 2. **SECCIÓN: NOTICIAS (Admin)**
**Ubicación:** `/admin/noticias`
- **Componente Livewire:** `app/Livewire/Noticias.php`
- **Vista:** `resources/views/livewire/noticias.blade.php`
- **Uso:** `@livewire('Noticias')` en `admin/noticias/index.blade.php`
- **Funcionalidad:** Gestión de noticias en admin (crear, editar, eliminar)

---

### 3. **SECCIÓN: CONTACTOS**
**Ubicación:** `/admin/contactos`
- **Componente Livewire:** `app/Livewire/Contactos.php`
- **Vista:** `resources/views/livewire/contactos.blade.php`
- **Uso:** `@livewire('Contactos')` en dashboard
- **Funcionalidad:** Gestión de contactos recibidos

---

### 4. **SECCIÓN: COMENTARIOS (Admin)**
**Ubicación:** `/admin/comentarios`
- **Componente Livewire:** `app/Livewire/ComentariosAdmin.php`
- **Vista:** `resources/views/livewire/comentarios-admin.blade.php`
- **Uso:** `@livewire('comentarios-admin')` en `admin/comentarios/index.blade.php`
- **Funcionalidad:** Moderar comentarios (aprobar, rechazar, eliminar)

---

## 📄 VISTAS PÚBLICAS (Controllers)

### 1. **NOTICIAS PÚBLICAS**
**Ruta:** `/noticias`, `/noticias/{slug}`, `/noticias/buscar`, `/noticias/tipo/{tipo}`
- **Controlador:** `app/Http/Controllers/NoticiaPublicaController.php`
- **Vistas:**
  - `resources/views/noticias/index.blade.php` - Listado con búsqueda y filtros
  - `resources/views/noticias/show.blade.php` - Detalle individual
- **No es Livewire** - Usa Controller + Blade tradicional
- **Funcionalidad:** Ver noticias, búsqueda, filtrado por tipo, contar vistas

---

### 2. **COMENTARIOS PÚBLICOS**
**Ruta:** `/comentarios`, `/comentarios (POST)`, `/comentarios/{id}/like (POST)`
- **Controlador:** `app/Http/Controllers/ComentarioPublicoController.php`
- **Vista:** `resources/views/comentarios/index.blade.php`
- **No es Livewire** - Usa Controller + Blade tradicional
- **Funcionalidad:** Ver comentarios, enviar comentarios nuevos, dar likes

---

## 🗑️ COMPONENTES ELIMINADOS (Relleno)

Estos componentes **NO SE USABAN EN NINGÚN LADO** y fueron eliminados:

| Componente | Archivo | Vista | Razón |
|-----------|---------|-------|-------|
| `Cita` | `app/Livewire/Cita.php` | `resources/views/livewire/cita.blade.php` | Duplicado/Innecesario |
| `Comentarios` | `app/Livewire/Comentarios.php` | `resources/views/livewire/comentarios.blade.php` | Reemplazado por Controller |
| `Publicacion` | `app/Livewire/Publicacion.php` | `resources/views/livewire/publicacion.blade.php` | Sin usar nunca |

---

## 📊 RESUMEN VISUAL

```
CANDIDATO WEB
│
├── ADMIN (Protected Routes)
│   ├── /admin/citas
│   │   └── @livewire('citas') ✅
│   ├── /admin/noticias
│   │   └── @livewire('Noticias') ✅
│   ├── /admin/comentarios
│   │   └── @livewire('comentarios-admin') ✅
│   ├── /admin/contactos (en dashboard)
│   │   └── @livewire('Contactos') ✅
│   └── /admin/dashboard
│       ├── @livewire('Citas')
│       ├── @livewire('Noticias')
│       └── @livewire('Contactos')
│
└── PÚBLICO (Public Routes)
    ├── /noticias
    │   ├── NoticiaPublicaController@index
    │   ├── NoticiaPublicaController@show
    │   ├── NoticiaPublicaController@buscar
    │   └── NoticiaPublicaController@porTipo
    └── /comentarios
        ├── ComentarioPublicoController@index
        ├── ComentarioPublicoController@store
        └── ComentarioPublicoController@like
```

---

## 🎯 FLUJO POR SECCIÓN

### **CITAS**
1. Admin entra a `/admin/citas`
2. Ve componente `citas` (Livewire)
3. Puede: crear, editar, eliminar citas
4. Público no interactúa directamente

### **NOTICIAS**
- **Admin:** `/admin/noticias` → Livewire component `Noticias`
- **Público:** `/noticias` → Controller `NoticiaPublicaController`
  - Ver listado (index)
  - Ver individual (show)
  - Buscar (buscar)
  - Filtrar por tipo (porTipo)

### **COMENTARIOS**
- **Admin:** `/admin/comentarios` → Livewire component `comentarios-admin`
  - Aprobar/rechazar pendientes
  - Ver todos los comentarios
  - Editar y eliminar
- **Público:** `/comentarios` → Controller `ComentarioPublicoController`
  - Ver comentarios publicados
  - Enviar nuevo comentario
  - Dar likes

### **CONTACTOS**
- **Admin:** Solo en dashboard
- Livewire component `Contactos` en view

---

## ✨ ARQUITECTURA FINAL

✅ **Limpia** - Solo componentes necesarios
✅ **Organizada** - Separación claro entre admin y público
✅ **Escalable** - Fácil agregar nuevas secciones
✅ **Eficiente** - Sin código duplicado

