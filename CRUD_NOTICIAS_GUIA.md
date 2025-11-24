# 📰 CRUD DE NOTICIAS - GUÍA DE ADMINISTRACIÓN

## Descripción General

Se ha implementado un sistema completo de CRUD (Crear, Leer, Actualizar, Eliminar) de noticias con gestión de imágenes para el panel de administrador. El sistema utiliza **Livewire** para una experiencia interactiva sin recargar la página.

## 📍 Ubicación en el Dashboard

- **Ruta:** `/admin/noticias`
- **Acceso:** Solo administradores autenticados
- **Panel:** Menú lateral izquierdo → Noticias

## ✨ Características Principales

### 1. **Visualización de Noticias**
   - Tabla interactiva con todas las noticias
   - Miniatura de imagen en cada fila
   - Información: Título, tipo, estado, fecha, vistas
   - Búsqueda en tiempo real por título o contenido
   - Filtros por estado (Borrador/Publicado)
   - Filtros por tipo (Noticia/Actividad/Evento)

### 2. **Crear Nueva Noticia**
   - Botón "+ Nueva Noticia" en la barra superior
   - Modal interactivo con formulario completo
   - Campos:
     - **Título** (requerido): Máximo 255 caracteres
     - **Tipo** (requerido): Noticia, Actividad o Evento
     - **Estado** (requerido): Borrador o Publicado
     - **Contenido** (requerido): Texto largo con soporte para múltiples párrafos
     - **Imagen** (opcional): JPG, PNG o GIF. Máximo 5MB

### 3. **Editar Noticia**
   - Botón "Editar" en cada fila de la tabla
   - Abre modal con los datos prefigurados
   - Vista previa de imagen actual
   - Opción de cambiar imagen
   - Guarda cambios sin recargar página

### 4. **Eliminar Noticia**
   - Botón "Eliminar" en cada fila
   - Confirmación de seguridad (modal de confirmación)
   - Elimina automáticamente la imagen asociada
   - Utiliza soft delete (datos no se pierden completamente)

### 5. **Gestión de Imágenes**
   - Carga de imágenes JPG, PNG o GIF
   - Máximo tamaño: 5MB
   - Se almacenan en: `storage/app/public/noticias/`
   - Vista previa antes de guardar
   - Se eliminan automáticamente al editar con nueva imagen
   - Se eliminan al eliminar la noticia

## 🔧 Estructura de Archivos Creados/Modificados

### Nuevos Archivos:
1. **`app/Livewire/Noticias.php`**
   - Componente Livewire principal
   - Lógica CRUD completa
   - Manejo de imágenes
   - Búsqueda y filtros

2. **`resources/views/livewire/noticias.blade.php`**
   - Vista Livewire con tabla interactiva
   - Modal de crear/editar
   - Búsqueda y filtros en tiempo real

### Archivos Modificados:
1. **`app/Http/Controllers/NoticiaController.php`**
   - Mejorado con soporte para carga de archivos
   - Manejo de almacenamiento de imágenes
   - Gestión automática de eliminación de imágenes

2. **`resources/views/admin/noticias/index.blade.php`**
   - Reemplazado contenido estático por componente Livewire
   - Mantiene la estructura de layout (sidebar, topbar)

## 📡 API Endpoints Disponibles

### Públicos:
```
GET  /api/v1/noticias              - Listar todas las noticias
GET  /api/v1/noticias/{id}         - Obtener detalle de noticia
```

### Protegidos (requieren autenticación):
```
POST   /api/v1/noticias            - Crear nueva noticia
PUT    /api/v1/noticias/{id}       - Actualizar noticia
DELETE /api/v1/noticias/{id}       - Eliminar noticia
```

## 🎨 Estados y Tipos

### Estados:
- **Borrador**: La noticia no es visible públicamente
- **Publicado**: La noticia es visible y se registra la fecha de publicación

### Tipos:
- **Noticia**: Información general
- **Actividad**: Actividades realizadas
- **Evento**: Próximos eventos

## 📊 Campos de la Base de Datos

```php
- id                    // ID único
- titulo               // Título de la noticia
- contenido            // Contenido completo
- imagen               // Ruta del archivo de imagen
- tipo                 // noticia, actividad o evento
- estado               // borrador o publicado
- fecha_publicacion    // Fecha de publicación (auto)
- vistas               // Contador de visualizaciones
- created_at           // Fecha de creación
- updated_at           // Última actualización
- deleted_at           // Soft delete
```

## 🔐 Control de Acceso

- El CRUD está protegido por middleware de autenticación (`auth` y `verified`)
- Solo usuarios autenticados pueden acceder a `/admin/noticias`
- Recomendación: Agregar middleware adicional para solo admins

## 💡 Ejemplos de Uso

### Crear una noticia desde el Admin:
1. Ir a `/admin/noticias`
2. Click en "+ Nueva Noticia"
3. Completar formulario
4. Cargar imagen (opcional)
5. Seleccionar estado
6. Click "Crear Noticia"

### Editar una noticia:
1. Encontrar la noticia en la tabla
2. Click en "Editar"
3. Realizar cambios
4. Click "Guardar Cambios"

### Cambiar imagen:
1. En el modal de editar, hacer click sobre la imagen actual
2. Seleccionar nueva imagen
3. Ver vista previa
4. Guardar cambios

## 🚀 Próximas Mejoras Sugeridas

1. Agregar validación de permisos (solo admin)
2. Implementar paginación en la tabla
3. Agregar exportación a PDF
4. Implementar drag & drop para imágenes
5. Agregar categorías adicionales
6. Soporte para múltiples imágenes por noticia

## ⚙️ Requisitos del Sistema

- PHP 8.2+
- Laravel 12.0+
- Livewire 2.x
- Storage público configurado: `php artisan storage:link`

## 📝 Notas Importantes

- Asegúrate de ejecutar `php artisan storage:link` si aún no lo has hecho
- Las imágenes se almacenan en `storage/app/public/noticias/`
- El componente Livewire maneja automáticamente la reactividad en tiempo real
- Los cambios se guardan sin necesidad de recargar la página
