# 📝 Guía de Guardado de Datos - Sistema de Citas y Contacto

## ✅ Verificación de Funcionalidad

He actualizado los formularios de **citas** y **contacto** para que guarden correctamente en la base de datos. A continuación te muestro lo que se ha hecho:

---

## 🔧 Cambios Realizados

### 1. Formulario de Citas (`/citas`)

**Ruta POST correcta:**
- Acción: `POST /citas` → `CitaController@store`
- Nombre de ruta: `citas.store`

**Campos que se guardan:**
```
- nombre (string, requerido)
- email (email, requerido)
- telefono (string, requerido)
- documento_identidad (string, opcional)
- tipo_consulta (string, requerido) - Valores:
  * asesoría legal
  * trámite administrativo
  * defensa penal
  * derechos laborales
  * familia
  * otro
- descripcion (string, requerido)
```

**Validación:** ✅ Validada en el controlador

### 2. Formulario de Contacto (`/contacto`)

**Ruta POST correcta:**
- Acción: `POST /contacto` → `ContactoController@store`
- Nombre de ruta: `contacto.store`

**Campos que se guardan:**
```
- nombre (string, requerido)
- email (email, requerido)
- telefono (string, opcional)
- asunto (string, requerido)
- mensaje (string, requerido)
```

**Validación:** ✅ Validada en el controlador

---

## 🧪 Cómo Probar

### Opción 1: Desde el Navegador

1. **Citas:**
   - Ve a `http://127.0.0.1:8000/citas`
   - Completa el formulario con todos los campos
   - Haz clic en "Solicitar Cita"
   - Deberías ver un mensaje de éxito

2. **Contacto:**
   - Ve a `http://127.0.0.1:8000/contacto`
   - Completa el formulario con todos los campos
   - Haz clic en "Enviar Mensaje"
   - Deberías ver un mensaje de éxito

### Opción 2: Verificar en Base de Datos

Después de enviar un formulario, verifica en tu base de datos:

```sql
-- Ver citas registradas
SELECT * FROM citas ORDER BY fecha_solicitud DESC LIMIT 1;

-- Ver contactos registrados
SELECT * FROM contactos ORDER BY created_at DESC LIMIT 1;
```

---

## 📊 Base de Datos

### Tabla `citas`
```
- id (INT, auto-increment)
- nombre (VARCHAR 255)
- email (VARCHAR 255)
- telefono (VARCHAR 20)
- documento_identidad (VARCHAR 50)
- tipo_consulta (VARCHAR 255)
- descripcion (TEXT)
- fecha_solicitud (TIMESTAMP)
- estado (ENUM: pendiente, aceptada, rechazada, completada, cancelada)
- datos_reprogramacion (JSON, nullable)
- fecha_respuesta_admin (TIMESTAMP, nullable)
```

### Tabla `contactos`
```
- id (INT, auto-increment)
- nombre (VARCHAR 255)
- email (VARCHAR 255)
- telefono (VARCHAR 20)
- asunto (VARCHAR 255)
- mensaje (TEXT)
- estado (ENUM: nuevo, respondido, manejado, cerrado)
- admin_id (INT, nullable)
- fecha_leida (TIMESTAMP, nullable)
- created_at (TIMESTAMP)
- updated_at (TIMESTAMP)
```

---

## 🎯 Eventos Disparados

Cuando se envía un formulario, se disparan los siguientes eventos:

### Citas
- **CitaCreada**: Se dispara cuando se crea una cita
  - Canal: `citas`
  - Evento: `cita-creada`
  - Datos: id, nombre, email, tipo_consulta

### Contactos
- **ContactoCreado**: Se dispara cuando se envía un contacto
  - Canal: `contactos`
  - Evento: `contacto-creado`
  - Datos: id, nombre, email, asunto

---

## 🛡️ Validación de Errores

Si hay un error de validación, verás:
1. Los campos con errores aparecerán con borde rojo
2. Debajo de cada campo se mostrará el mensaje de error
3. Los datos ingresados se mantienen en el formulario (old values)

Ejemplo de errores comunes:
- ❌ Email inválido
- ❌ Campos requeridos vacíos
- ❌ Teléfono en formato incorrecto

---

## 📲 Panel de Admin

Para ver y gestionar los datos en el panel de admin:

1. Dirígete a: `http://127.0.0.1:8000/dashboard`
2. Inicia sesión como administrador
3. En el Dashboard encontrarás:
   - **Citas** - Componente Livewire con tabla de citas
   - **Contactos** - Componente Livewire con tabla de contactos
   - Opciones para: Aceptar, rechazar, reprogramar, responder

---

## 🚀 Próximos Pasos

Para **publicaciones (noticias)**, actualmente se administran desde:
- Panel Admin: `/dashboard` → Sección Noticias (Livewire Component)
- No hay formulario público para crear noticias

Si deseas que los usuarios puedan enviar noticias, avísame y crearemos un formulario público.

---

## ✨ Resumen

✅ **Citas** - Guardando correctamente en BD
✅ **Contacto** - Guardando correctamente en BD
✅ **Validación** - Implementada en ambos formularios
✅ **Mensajes de éxito** - Mostrados al usuario
✅ **Eventos** - Disparados automáticamente
✅ **Panel Admin** - Listados los datos registrados

**El sistema está listo para usar. Prueba los formularios y confirma que los datos se guardan.** 🎉
