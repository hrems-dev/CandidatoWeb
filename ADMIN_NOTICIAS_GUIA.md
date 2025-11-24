# 📰 GUÍA COMPLETA DEL ADMIN DE NOTICIAS

## 📋 TABLA DE CONTENIDOS

1. [Introducción](#introducción)
2. [Acceso al Panel](#acceso-al-panel)
3. [Entender la Interfaz](#entender-la-interfaz)
4. [Crear una Noticia](#crear-una-noticia)
5. [Editar una Noticia](#editar-una-noticia)
6. [Buscar y Filtrar](#buscar-y-filtrar)
7. [Sincronización con Base de Datos](#sincronización-con-base-de-datos)
8. [Sincronización con Página Pública](#sincronización-con-página-pública)

---

## 🎯 INTRODUCCIÓN

El **Admin de Noticias** es un panel completo que permite al administrador gestionar todas las noticias de la página. Funciona en **tiempo real** con la base de datos y se sincroniza automáticamente con la página pública.

### ¿Qué puedes hacer?
✅ Crear noticias  
✅ Editar noticias  
✅ Eliminar noticias  
✅ Buscar noticias  
✅ Filtrar por estado y tipo  
✅ Ver estadísticas  
✅ Subir imágenes  

---

## 🚪 ACCESO AL PANEL

```
URL: http://localhost:8000/admin/noticias
O desde el dashboard: Admin → Noticias
```

**Requisitos:**
- Estar autenticado como administrador
- Tener permiso de acceso al admin

---

## 👁️ ENTENDER LA INTERFAZ

### 1. ESTADÍSTICAS (En la parte superior)

```
┌─────────────────────────────────────────────────────────┐
│  📰 Total: 5  │  ✅ Publicadas: 3  │  📝 Borradores: 2  │
└─────────────────────────────────────────────────────────┘
```

- **Total de Noticias:** Cuenta todas las noticias (publicadas + borradores)
- **Publicadas:** Solo las que están visibles en la página pública
- **En Borrador:** Las que solo tú ves en el admin

Estas estadísticas **se actualizan automáticamente** cuando creas, editas o eliminas.

---

### 2. BUSCADOR Y FILTROS

```
┌─────────────────────────────────────────────────────────┐
│ 🔍 Buscar... │ 🏷️ Estado │ 📂 Tipo │ ✨ [Nueva Noticia] │
└─────────────────────────────────────────────────────────┘
```

**Búsqueda en tiempo real:**
- Escribe en "Buscar" para filtrar por título
- Se actualiza al escribir (sin necesidad de presionar botón)
- Busca en título, contenido y resumen

**Filtro por Estado:**
- `Todos` - Muestra todas las noticias
- `Borrador` - Solo noticias no publicadas
- `Publicado` - Solo noticias visibles públicamente

**Filtro por Tipo:**
- `Todos` - Todos los tipos
- `📰 Noticia` - Contenido general
- `🎯 Actividad` - Eventos de la oficina
- `🎪 Evento` - Eventos especiales

---

### 3. TABLA DE NOTICIAS

```
┌────┬──────────────┬────────┬──────────┬──────────┬───────┬─────────┐
│IMG │   TÍTULO     │ TIPO   │ ESTADO   │PUBLICAC. │VISTAS │ACCIONES │
├────┼──────────────┼────────┼──────────┼──────────┼───────┼─────────┤
│🖼️ │ Nueva ley... │Noticia │Publicado │24/11/2025│  245  │ ✏️ 🗑️  │
└────┴──────────────┴────────┴──────────┴──────────┴───────┴─────────┘
```

**Columnas:**
- **Imagen:** Miniatura de la imagen adjunta (o placeholder)
- **Título:** Nombre de la noticia
- **Tipo:** Noticia, Actividad o Evento
- **Estado:** Publicado (verde) o Borrador (amarillo)
- **Publicación:** Fecha y hora de publicación (o "No publicado")
- **Vistas:** Cuántas personas la han visto
- **Acciones:** Editar o Eliminar

---

## ✨ CREAR UNA NOTICIA

### Paso 1: Abrir el Modal
Presiona el botón **"✨ Nueva Noticia"** en la esquina superior derecha.

### Paso 2: Llenar los Campos

#### **Título** (Obligatorio)
```
📝 Ej: "Nueva sentencia en caso de derecho familiar"
- Máximo 255 caracteres
- Será único en la base de datos
```

#### **Tipo** (Obligatorio)
```
Opciones:
- 📰 Noticia (contenido general)
- 🎯 Actividad (eventos de la oficina)
- 🎪 Evento (eventos públicos)
```

#### **Categoría** (Opcional)
```
📁 Ej: "Jurisprudencia", "Noticias Laborales", "Capacitaciones"
- Útil para organizar mejor
- Máximo 100 caracteres
```

#### **Estado** (Obligatorio)
```
Opciones:
- 📝 Borrador (solo visible para ti en admin)
- ✅ Publicado (visible en página pública)
```

#### **Resumen** (Obligatorio)
```
📄 Descripción breve de la noticia
- Máximo 500 caracteres
- Aparecerá en el listado público
- Se muestra en las tarjetas
- Contador de caracteres en tiempo real
```

#### **Contenido** (Obligatorio)
```
📋 Texto completo de la noticia
- Sin límite de caracteres
- Se muestra en la página detalle
- Soporta saltos de línea y formatos
- Contador de caracteres
```

#### **Imagen** (Opcional)
```
🖼️ Foto de la noticia
- Formatos: JPG, PNG
- Tamaño máximo: 5 MB
- Se mostrará en:
  * Tabla del admin (miniatura)
  * Listado público (card grande)
  * Página detalle (hero image)
```

**Cómo subir imagen:**
1. Click en "Seleccionar archivo"
2. Elige una imagen de tu computadora
3. Verás un preview antes de guardar
4. Al guardar, se sube automáticamente a la carpeta `storage/noticias/`

### Paso 3: Guardar

Presiona **"💾 Crear Noticia"**

```
✅ Si todo está correcto:
   → Se guarda en la base de datos
   → Se muestra en la tabla
   → Si estado=publicado, aparece en página pública
   → Modal se cierra automáticamente
   → Ves un mensaje de éxito

❌ Si hay error:
   → Se muestra el mensaje de error
   → Los datos se mantienen en el formulario
   → Puedes corregir y intentar de nuevo
```

---

## ✏️ EDITAR UNA NOTICIA

### Paso 1: Seleccionar Noticia
En la tabla, busca la noticia y presiona el botón **"✏️ Editar"**

### Paso 2: Modificar
El modal se abre con los datos actuales. Puedes cambiar:
- Título
- Tipo
- Estado
- Resumen
- Contenido
- Imagen
- Categoría

### Paso 3: Guardar Cambios
Presiona **"💾 Guardar Cambios"**

```
✅ La noticia se actualiza inmediatamente en:
   → Base de datos
   → Tabla del admin
   → Página pública (si es publicado)

Ejemplo de cambios en tiempo real:
ANTES: Estado = Borrador, Vistas = 0
DESPUÉS DE PUBLICAR: Estado = Publicado, ahora aparece en /noticias
```

---

## 🔍 BUSCAR Y FILTRAR

### Búsqueda Rápida
```
Escribe en el campo "Buscar"
↓
Se filtra mientras escribes (sin necesidad de presionar Enter)
↓
Busca en:
  - Título
  - Contenido
  - Resumen
```

**Ejemplo:**
```
Escribes: "sentencia"
↓
Muestra solo noticias que contengan "sentencia" en title, contenido o resumen
```

### Filtrar por Estado
```
Selecciona en dropdown "Estado"
↓
Opciones:
  - Todos (muestra todo)
  - Borrador (solo no publicadas)
  - Publicado (solo publicadas)
```

### Filtrar por Tipo
```
Selecciona en dropdown "Tipo"
↓
Opciones:
  - Todos
  - Noticia
  - Actividad
  - Evento
```

### Combinar Filtros
```
🔍 Búsqueda: "evento"
🏷️ Estado: "Publicado"
📂 Tipo: "Evento"

↓ Resultado:
Solo muestra eventos publicados que contengan "evento" en el texto
```

---

## 💾 SINCRONIZACIÓN CON BASE DE DATOS

### ¿Cómo funciona?

```
ADMIN (Livewire Component)
    ↓ wire:click="save()"
    ↓
BACKEND (PHP - Noticias.php)
    ↓ Validación
    ↓
DATABASE (MySQL - tabla 'noticias')
    ↓ INSERT o UPDATE
    ↓
ADMIN (Se actualiza automáticamente)
    ↓ cargarNoticias()
    ↓
TABLA SE ACTUALIZA (sin recargar página)
```

### Código Detrás de Escenas

**1. Usuario presiona "Guardar"**
```blade
<button type="submit" wire:submit="save">
```

**2. Livewire ejecuta save()**
```php
public function save()
{
    // Validar datos
    $this->validate([
        'titulo' => 'required|string|max:255',
        'contenido' => 'required|string',
        // etc...
    ]);

    // Guardar en BD
    $data = [
        'titulo' => $this->titulo,
        'contenido' => $this->contenido,
        // etc...
    ];

    if ($this->editingId) {
        // ACTUALIZAR
        Noticia::findOrFail($this->editingId)->update($data);
    } else {
        // CREAR
        Noticia::create($data);
    }

    // Recargar lista
    $this->cargarNoticias();
    
    // Cerrar modal y mostrar éxito
    $this->closeModal();
    $this->dispatch('notify', ['message' => 'Guardado', 'type' => 'success']);
}
```

**3. Base de datos se actualiza**
```sql
-- Si es CREAR:
INSERT INTO noticias (titulo, contenido, estado, created_at, updated_at)
VALUES ('Nuevo título', 'contenido...', 'borrador', NOW(), NOW());

-- Si es ACTUALIZAR:
UPDATE noticias 
SET titulo = 'Nuevo título', 
    contenido = 'contenido...', 
    updated_at = NOW()
WHERE id = 5;
```

**4. Admin se actualiza automáticamente**
```php
public function cargarNoticias()
{
    // Obtiene noticias del DB
    $this->noticias = Noticia::query()->get();
    
    // Actualiza estadísticas
    $this->totalNoticias = Noticia::count();
    $this->noticiasPublicadas = Noticia::where('estado', 'publicado')->count();
    // etc...
}
```

### Resultado
```
✅ Tabla se refresca SIN recargar página
✅ Estadísticas se actualizan automáticamente
✅ Búsqueda y filtros siguen funcionando
✅ Modal se cierra
✅ Usuario ve mensaje de éxito
```

---

## 🌍 SINCRONIZACIÓN CON PÁGINA PÚBLICA

### El Flujo Completo

```
1️⃣ ADMIN CREA/PUBLICA NOTICIA
   └─ Estado = "publicado"
   └─ Fecha publicación = now()

     ↓

2️⃣ DATOS VAN A BASE DE DATOS
   └─ INSERT/UPDATE en tabla 'noticias'

     ↓

3️⃣ PÁGINA PÚBLICA CONSULTA BASE DE DATOS
   └─ /noticias (índice)
       └─ SELECT * FROM noticias WHERE estado='publicado'
   
   └─ /noticias/{slug} (detalle)
       └─ SELECT * FROM noticias WHERE slug='...' AND estado='publicado'

     ↓

4️⃣ USUARIO ACCEDE A PÁGINA PÚBLICA
   └─ Ve la noticia recién creada
   └─ Automáticamente (sin refrescar admin)
```

### Ejemplo Práctico

```
13:45 - Admin crea noticia "Nueva Ley Laboral" con estado PUBLICADO
  ↓
  BD: INSERT INTO noticias (titulo, estado, fecha_publicacion, ...)

13:46 - Un usuario entra a /noticias
  ↓
  PHP: SELECT * FROM noticias WHERE estado='publicado'
  ↓
  ¡La noticia aparece en el listado!

13:47 - Usuario hace click en la noticia
  ↓
  PHP: SELECT * FROM noticias WHERE slug='nueva-ley-laboral'
  ↓
  ¡Ve el contenido completo!

14:00 - Admin edita el contenido
  ↓
  BD: UPDATE noticias SET contenido='...' WHERE id=1

14:01 - Usuario recarga la página
  ↓
  Ve los cambios inmediatamente (porque lee del DB en tiempo real)
```

---

## 🔄 ESTADO DE LA NOTICIA Y VISIBILIDAD

### ESTADO: BORRADOR

```
Estado en BD: estado = 'borrador'
Visible en Admin: ✅ Sí (en tabla)
Visible en /noticias: ❌ No
Visible en /noticias/{slug}: ❌ No
Contador vistas: No incrementa
```

**Cuándo usar:**
- Estás redactando y no quieres que se vea
- Quieres revisar antes de publicar
- Aún no está lista

---

### ESTADO: PUBLICADO

```
Estado en BD: estado = 'publicado'
Fecha publicación: fecha_publicacion = NOW()
Visible en Admin: ✅ Sí (en tabla)
Visible en /noticias: ✅ Sí (en listado)
Visible en /noticias/{slug}: ✅ Sí (página completa)
Contador vistas: ✅ Se incrementa con cada visita
```

**Cuándo usar:**
- La noticia está lista
- Quieres que todos la vean
- Ya fue revisada

---

## 📊 EJEMPLO COMPLETO: CREAR Y PUBLICAR UNA NOTICIA

### 1. CREAR LA NOTICIA

```
Hago click en "✨ Nueva Noticia"
↓
Se abre un modal

COMPLETO LOS CAMPOS:

Título: "Jornada sobre Derechos Laborales"
Tipo: 🎯 Actividad
Categoría: Capacitaciones
Estado: 📝 Borrador
Resumen: "Sesión informativa sobre derechos y obligaciones laborales"
Contenido: "El próximo viernes realizaremos una jornada..."
Imagen: (subo una imagen)

Presiono "💾 Crear Noticia"
```

### 2. REVISO EN EL ADMIN

```
Modal se cierra
↓
Tabla se actualiza
↓
Veo la noticia en la tabla
│ Estado: 📝 Borrador (amarillo)
│ Vistas: 0
│ No aparecerá en la página pública

Estadísticas se actualizan:
│ Total: +1
│ Borradores: +1
```

### 3. EDITO ANTES DE PUBLICAR

```
Presiono "✏️ Editar"
↓
Cambio el contenido un poco
↓
Presiono "💾 Guardar Cambios"
↓
La noticia se actualiza en BD
↓
Tabla se refresca
```

### 4. PUBLICO LA NOTICIA

```
Presiono "✏️ Editar" de nuevo
↓
Cambio Estado de "📝 Borrador" a "✅ Publicado"
↓
Presiono "💾 Guardar Cambios"
↓
Estado en BD: estado = 'publicado'
↓
Fecha en BD: fecha_publicacion = '2025-11-24 14:35:00'

En la tabla:
│ Estado: ✅ Publicado (verde)
│ Publicación: 24/11/2025 14:35

Estadísticas:
│ Borradores: -1
│ Publicadas: +1
```

### 5. USUARIO LA VE EN LA PÁGINA PÚBLICA

```
Usuario entra a: /noticias
↓
PHP ejecuta:
  SELECT * FROM noticias WHERE estado='publicado'
↓
¡La noticia aparece en el listado!
│ Muestra imagen
│ Muestra título
│ Muestra resumen (primeros 100 caracteres)
│ Muestra tipo (Actividad)
│ Muestra fecha de publicación
│ Botón "Leer más"

Usuario hace click en "Leer más"
↓
Va a: /noticias/jornada-sobre-derechos-laborales
↓
Ve la página completa con:
│ Imagen hero
│ Título
│ Tipo
│ Fecha
│ Contenido completo
│ Noticias relacionadas (mismo tipo)
│ Contador de vistas (incrementa a 1)
```

### 6. ESTADÍSTICAS SE ACTUALIZAN

```
En el Admin:
│ Total: 1
│ Publicadas: 1
│ Borradores: 0
│ Vistas: 1 (porque el usuario la vio)

En la página /noticias:
│ Muestra 1 resultado

Si buscas por tipo:
│ /noticias/tipo/actividad
│ Muestra 1 resultado
```

---

## 🆘 TROUBLESHOOTING

### Problema: Los cambios no aparecen en la tabla

**Solución:**
```
1. Recarga la página (F5)
2. Verifica que no haya errores en la consola
3. Asegúrate de estar autenticado
4. Intenta de nuevo
```

### Problema: Noticia no aparece en página pública

**Verificar:**
```
☑ ¿Estado es "Publicado"?
☑ ¿Fecha de publicación es hoy o antes?
☑ ¿Recargaste la página pública (F5)?
☑ ¿Estás viendo la URL correcta (/noticias)?
```

### Problema: Imagen no se ve

**Solución:**
```
1. Asegúrate de subir una imagen válida (JPG, PNG)
2. Debe ser menor a 5 MB
3. Recarga el admin (F5)
4. Intenta subir de nuevo
```

### Problema: Error de validación

**Qué significa:**
```
"El campo titulo es obligatorio"
  → Olvidaste llenar el Título

"El campo contenido es obligatorio"
  → Olvidaste llenar el Contenido

"El titulo ya existe"
  → Ya existe una noticia con ese título
  → Cambia el título
```

---

## 🎓 RESUMEN

```
ADMIN DE NOTICIAS
│
├─ 📊 ESTADÍSTICAS (se actualizan automáticamente)
│  └─ Total, Publicadas, Borradores
│
├─ 🔍 BUSCAR Y FILTRAR (tiempo real)
│  └─ Búsqueda por texto
│  └─ Filtro por estado
│  └─ Filtro por tipo
│
├─ ✨ CREAR
│  ├─ Presionar botón "Nueva"
│  ├─ Llenar formulario
│  └─ Guardar → Base de datos
│
├─ ✏️ EDITAR
│  ├─ Presionar "Editar"
│  ├─ Cambiar datos
│  └─ Guardar → Base de datos
│
├─ 🗑️ ELIMINAR
│  ├─ Presionar "Eliminar"
│  ├─ Confirmar
│  └─ Soft delete → Base de datos
│
└─ 🌍 SINCRONIZACIÓN
   ├─ BD ↔ Admin (automática)
   └─ BD ↔ Página Pública (automática)

FLUJO:
Admin (crear/editar) → Base de datos → Tabla admin (actualiza) → Página pública (sincroniza)
```

¡Eso es todo! El sistema es completamente funcional y está sincronizado en tiempo real. 🚀

