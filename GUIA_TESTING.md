# 🧪 GUÍA DE TESTING - Sistema CandidatoWeb Completado

## 📋 Checklist de Funcionalidades

### 1. **Admin Dashboard**
- [ ] Acceder a `http://127.0.0.1:8000/admin/dashboard`
- [ ] Ver 4 cards de estadísticas (Citas Pendientes, Noticias, Comentarios, Contactos)
- [ ] Ver 3 secciones principales: Citas, Noticias, Contactos

### 2. **Gestión de Noticias**
#### Admin Panel
- [ ] Clickear "Crear Noticia"
- [ ] Completar formulario:
  - Título: "Primera Noticia de Prueba"
  - Resumen: "Este es un resumen corto"
  - Contenido: "Contenido detallado de la noticia"
  - Categoría: "Política"
  - Tipo: "noticia"
  - Estado: "publicado"
  - Subir imagen
- [ ] Verificar que se crea con slug autogenerado
- [ ] Buscar por título
- [ ] Filtrar por estado
- [ ] Filtrar por tipo
- [ ] Editar noticia
- [ ] Eliminar noticia (soft delete)

#### Página Pública
- [ ] Ir a `http://127.0.0.1:8000/noticias`
- [ ] Ver listado de noticias publicadas
- [ ] Búsqueda funciona
- [ ] Filtros funcionan
- [ ] Paginación funciona
- [ ] Clickear en noticia
- [ ] Modal detalle muestra toda la información
- [ ] Verificar que vistas incrementan

### 3. **Gestión de Citas**
#### Admin Panel
- [ ] Ver todas las citas en admin/dashboard
- [ ] Filtrar por estado
- [ ] Aceptar cita: seleccionar fecha y hora
- [ ] Rechazar cita: ingresar motivo
- [ ] **✨ NUEVO** Reprogramar cita: cambiar fecha/hora
- [ ] Eliminar cita

#### Formulario Público
- [ ] Ir a `http://127.0.0.1:8000/citas`
- [ ] Completar formulario:
  - Nombre: "Juan Pérez"
  - Email: "juan@example.com"
  - Teléfono: "987654321"
  - Tipo: "asesoría legal"
  - Descripción: "Necesito asesoría sobre..."
- [ ] Enviar formulario
- [ ] Verificar que aparece en admin como "pendiente"
- [ ] Admin acepta y establece fecha
- [ ] Verificar que estado cambió a "aceptada"

### 4. **Gestión de Contactos**
#### Admin Panel
- [ ] Ver todos los contactos
- [ ] Filtrar por estado
- [ ] Responder a contacto
- [ ] Archivar contacto

#### Formulario Público
- [ ] Ir a `http://127.0.0.1:8000/contacto`
- [ ] Completar:
  - Nombre: "Pedro García"
  - Email: "pedro@example.com"
  - Teléfono: "987654321"
  - Asunto: "Consulta sobre..."
  - Mensaje: "Quería preguntar..."
- [ ] Enviar formulario
- [ ] Verificar que aparece en admin como "nuevo"
- [ ] Admin responde mensaje
- [ ] Verificar que estado cambió a "respondido"

### 5. **API RESTful**
#### Listar Noticias
```bash
curl "http://127.0.0.1:8000/api/v1/noticias"
curl "http://127.0.0.1:8000/api/v1/noticias?page=1&per_page=10"
```

#### Buscar Noticia por Slug
```bash
curl "http://127.0.0.1:8000/api/v1/noticias/slug/primera-noticia-de-prueba-1234567890"
```

#### Crear Cita (JSON)
```bash
curl -X POST http://127.0.0.1:8000/api/v1/citas \
  -H "Content-Type: application/json" \
  -d '{
    "nombre": "Ana López",
    "email": "ana@example.com",
    "telefono": "912345678",
    "tipo_consulta": "asesoría legal",
    "descripcion": "Necesito consultar sobre..."
  }'
```

#### Crear Contacto (JSON)
```bash
curl -X POST http://127.0.0.1:8000/api/v1/contactos \
  -H "Content-Type: application/json" \
  -d '{
    "nombre": "Marco Ruiz",
    "email": "marco@example.com",
    "asunto": "Consulta general",
    "mensaje": "Quería saber..."
  }'
```

---

## 🔍 Validación de Features Específicas

### Feature: Slug URL Amigable
```
✅ Slug se genera automáticamente desde título
✅ Se puede acceder vía /api/v1/noticias/slug/{slug}
✅ La URL es legible (sin caracteres especiales)
✅ Se puede compartir fácilmente
```

### Feature: Reprogramación de Citas
```
✅ Modal aparece solo para citas aceptadas
✅ Se puede cambiar fecha y hora
✅ Los cambios anteriores se almacenan en JSON
✅ Se puede ver el historial de reprogramaciones
```

### Feature: Categorización de Noticias
```
✅ Campo categoría se puede llenar al crear
✅ Se puede filtrar por categoría (cuando tenga datos)
✅ Se muestra en detalle de noticia
```

### Feature: Contador de Vistas
```
✅ Incrementa cada vez que se abre una noticia
✅ Se ve en listado y detalle
✅ Se persiste en BD
```

### Feature: Eventos Broadcasting
```
✅ CitaCreada se dispara → evento broadcast
✅ CitaActualizada se dispara → evento broadcast
✅ ContactoCreado se dispara → evento broadcast
✅ ContactoRespondido se dispara → evento broadcast
✅ NoticiaCreada se dispara → evento broadcast
✅ NoticiaPublicada se dispara → evento broadcast
```

---

## ⚠️ Casos de Error a Probar

### Validación en Formularios
- [ ] Intentar enviar cita sin email → Error
- [ ] Intentar enviar contacto sin mensaje → Error
- [ ] Intentar crear noticia sin contenido → Error
- [ ] Intentar subir imagen >5MB → Error

### Manejo de No Encontrados
- [ ] Ir a noticia que no existe → 404
- [ ] Buscar slug inexistente → Modal error
- [ ] Intentar editar recurso eliminado → Error

### Soft Deletes
- [ ] Eliminar noticia → No se ve en listado
- [ ] Eliminar cita → No se ve en admin
- [ ] Eliminar contacto → No se ve en admin

---

## 📊 Verificación de Base de Datos

```sql
-- Verificar columnas de noticias
SELECT * FROM noticias LIMIT 1;

-- Verificar columnas de citas
SELECT * FROM citas LIMIT 1;

-- Verificar columnas de contactos
SELECT * FROM contactos LIMIT 1;

-- Contar registros
SELECT COUNT(*) FROM noticias;
SELECT COUNT(*) FROM citas;
SELECT COUNT(*) FROM contactos;

-- Verificar soft deletes
SELECT * FROM noticias WHERE deleted_at IS NOT NULL;
```

---

## 🚀 Performance Checks

### Índices Verificados
```
noticias: 
  - estado
  - tipo
  - slug
  - categoria
  - fecha_publicacion

citas:
  - estado
  - tipo_consulta
  - fecha_cita
  - fecha_solicitud
  - email

contactos:
  - estado
  - created_at
  - email
```

### Búsqueda Rápida
- [ ] Buscar en noticias → <100ms
- [ ] Buscar en citas → <100ms
- [ ] Buscar en contactos → <100ms

---

## 📸 Screenshots que Verificar

### Admin Dashboard
1. Cards de estadísticas visible
2. Componentes Livewire cargan correctamente
3. Modales abren y cierran
4. Notificaciones aparecen (success/error)

### Página Pública de Noticias
1. Grid de noticias responsive
2. Filtros y búsqueda funcionan
3. Modal detalle abre
4. Imagen se muestra correctamente

### Formularios
1. Validación visual en tiempo real
2. Campos se limpian tras envío
3. Mensaje de éxito aparece

---

## ✅ Sign-off

- [ ] Todas las funcionalidades testadas
- [ ] Sin errores 500 en servidor
- [ ] Sin errores en consola browser (F12)
- [ ] Performance aceptable
- [ ] UX fluida

**Testeado por**: ________________________
**Fecha**: ________________________
**Observaciones**: 

---

**Nota**: Si encuentras algún bug durante testing, documéntalo y reporta el error exacto con los pasos para reproducirlo.
