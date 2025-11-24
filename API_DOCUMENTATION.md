# 📚 Documentación API - CandidatoWeb

## ✅ Estado del Proyecto

Tu proyecto **CandidatoWeb** ha sido completamente configurado y conectado. Aquí te muestro todo lo que se ha hecho:

---

## 🗄️ Base de Datos

### Estado: ✅ COMPLETADO
- **BD**: `dbweb` en MySQL
- **Migraciones**: Todas ejecutadas correctamente
- **Tablas creadas**: 24 tablas principales + tablas de pivot
- **Datos de prueba**: Insertados y listos para testing

### Tablas principales:
- `users` - Usuarios del sistema (Laravel Fortify)
- `usuarios` - Usuarios personalizados (admin, candidato, usuario)
- `personas` - Personas en el sistema
- `info_candidatos` - Información detallada de candidatos
- `noticias` - Artículos de noticias
- `comentarios` - Comentarios del sistema
- `citas` - Solicitudes de citas
- `contactos` - Mensajes de contacto
- `publicaciones` - Publicaciones de candidatos
- `multimedia` - Archivos multimedia
- `especialidades` - Especialidades profesionales
- Y más...

---

## 🌐 Endpoints API

### Base URL
```
http://127.0.0.1:8000/api/v1
```

### 📰 NOTICIAS

#### Públicas (sin autenticación)
- `GET /noticias` - Listar todas las noticias
  ```
  Parámetros query:
  - estado: borrador|publicado|archivado
  - tipo: noticia|actividad|evento
  ```
- `GET /noticias/{id}` - Ver noticia específica

#### Protegidas (requieren autenticación)
- `POST /noticias` - Crear noticia
  ```json
  {
    "titulo": "string|required",
    "contenido": "string|required",
    "imagen": "string|nullable",
    "tipo": "noticia|actividad|evento|required",
    "estado": "borrador|publicado|archivado|required",
    "fecha_publicacion": "YYYY-MM-DD HH:mm:ss|nullable"
  }
  ```
- `PUT /noticias/{id}` - Actualizar noticia
- `DELETE /noticias/{id}` - Eliminar noticia

---

### 📅 CITAS

#### Públicas
- `GET /citas` - Listar citas
  ```
  Parámetros query:
  - estado: pendiente|aceptada|rechazada|completada|cancelada
  - tipo_consulta: asesoría legal|trámite administrativo|...
  ```
- `GET /citas/{id}` - Ver cita específica
- `POST /citas` - Crear nueva cita (público)
  ```json
  {
    "nombre": "string|required",
    "email": "email|required",
    "telefono": "string|required",
    "tipo_consulta": "asesoría legal|...|required",
    "descripcion": "string|required",
    "documento_identidad": "string|nullable",
    "ubicacion": "string|nullable"
  }
  ```

#### Protegidas (Admin)
- `PUT /citas/{id}` - Actualizar cita
- `DELETE /citas/{id}` - Eliminar cita
- `POST /citas/{id}/aceptar` - Aceptar cita
  ```json
  {
    "fecha_cita": "YYYY-MM-DD|required",
    "hora_cita": "HH:mm|required"
  }
  ```
- `POST /citas/{id}/rechazar` - Rechazar cita
  ```json
  {
    "motivo_rechazo": "string|required"
  }
  ```

---

### 📧 CONTACTOS

#### Públicas
- `GET /contactos` - Listar mensajes
- `POST /contactos` - Enviar mensaje
  ```json
  {
    "nombre": "string|required",
    "email": "email|required",
    "asunto": "string|required",
    "mensaje": "string|required",
    "telefono": "string|nullable"
  }
  ```

#### Protegidas (Admin)
- `PUT /contactos/{id}` - Actualizar mensaje
- `DELETE /contactos/{id}` - Eliminar mensaje
- `POST /contactos/{id}/responder` - Responder mensaje
  ```json
  {
    "respuesta_admin": "string|required"
  }
  ```

---

### 💬 COMENTARIOS

#### Públicas
- `GET /comentarios` - Listar comentarios
  ```
  Parámetros query:
  - estado: pendiente|aprobado|rechazado
  - persona_id: integer
  ```
- `GET /comentarios/{id}` - Ver comentario específico

#### Protegidas
- `POST /comentarios` - Crear comentario
  ```json
  {
    "mensaje": "string|required",
    "persona_id": "integer|required|exists:personas",
    "estado": "pendiente|aprobado|rechazado|nullable"
  }
  ```
- `PUT /comentarios/{id}` - Actualizar comentario
- `DELETE /comentarios/{id}` - Eliminar comentario

---

### 📝 PUBLICACIONES

#### Públicas
- `GET /publicaciones` - Listar publicaciones
  ```
  Parámetros query:
  - estado: true|false
  - info_candidato_id: integer
  ```
- `GET /publicaciones/{id}` - Ver publicación

#### Protegidas
- `POST /publicaciones` - Crear publicación
  ```json
  {
    "titulo": "string|required",
    "descripcion": "string|required",
    "info_candidato_id": "integer|required",
    "estado": "boolean|nullable",
    "destacado": "boolean|nullable"
  }
  ```
- `PUT /publicaciones/{id}` - Actualizar publicación
- `DELETE /publicaciones/{id}` - Eliminar publicación

---

### 👤 CANDIDATOS

#### Públicas
- `GET /candidatos` - Listar candidatos
  ```
  Parámetros query:
  - activo: true|false
  ```
- `GET /candidatos/{id}` - Ver candidato

---

### 👨‍💼 INFO CANDIDATOS

#### Públicas
- `GET /info-candidatos` - Listar candidatos
  ```
  Parámetros query:
  - estado: true|false
  - ciudad: string
  - especialidad_id: integer
  ```
- `GET /info-candidatos/{id}` - Ver candidato detallado

#### Protegidas
- `POST /info-candidatos` - Crear candidato
- `PUT /info-candidatos/{id}` - Actualizar candidato
- `DELETE /info-candidatos/{id}` - Eliminar candidato

---

## 🔐 Autenticación

### Usuarios de Prueba

#### Admin User
- Email: `admin@example.com`
- Password: `password` (configurado en el seeder)

#### Test User
- Email: `test@example.com`
- Password: `password`

### Para autenticarse:
1. Usa los endpoints de Laravel Fortify para login
2. Obtén el token Sanctum
3. Incluye el token en el header:
   ```
   Authorization: Bearer {token}
   ```

---

## 📁 Estructura de Rutas

### Web Routes (`routes/web.php`)
- Rutas públicas para vistas
- Rutas protegidas con middleware auth y verified
- Panel de admin en `/admin/*`

### API Routes (`routes/api.php`)
- API pública en `/api/v1/*`
- API protegida en `/api/v1/*` (con middleware auth:sanctum)

---

## 🎯 Controladores Creados/Actualizados

1. **NoticiaController** - Gestión de noticias
2. **CitaController** - Gestión de citas
3. **ContactoController** - Gestión de contactos
4. **ComentarioController** - Gestión de comentarios
5. **PublicacionController** - Gestión de publicaciones
6. **CandidatoController** - Listado de candidatos
7. **InfoCandidatoController** - Gestión de info candidatos

---

## 🚀 Para Iniciar el Servidor

El servidor está actualmente corriendo en:
```
http://127.0.0.1:8000
```

Para reiniciarlo:
```bash
php artisan serve
```

Para construir el frontend:
```bash
npm run dev      # Desarrollo
npm run build    # Producción
```

---

## 📋 Datos de Prueba Incluidos

El seeder ha creado automáticamente:
- 2 usuarios de prueba
- 2 usuarios personalizados
- 2 personas
- 1 candidato con información completa
- 5 noticias
- 3 citas de prueba
- 3 mensajes de contacto
- 3 comentarios

---

## ✅ Checklist Final

- ✅ Base de datos creada y migrada
- ✅ Todos los endpoints API creados
- ✅ Controladores implementados
- ✅ Datos de prueba insertados
- ✅ Servidor corriendo
- ✅ Rutas API configuradas
- ✅ Modelos con relaciones correctas
- ✅ Autenticación con Laravel Fortify
- ✅ BOM UTF-8 eliminado de archivos PHP

---

## 📞 Próximos Pasos

1. **Frontend**: Conectar los componentes Vue/Livewire con los endpoints API
2. **Validación**: Implementar validación adicional si es necesario
3. **Testing**: Crear tests para los endpoints
4. **CORS**: Configurar CORS si el frontend está en un dominio diferente
5. **Seguridad**: Implementar rate limiting y otras medidas de seguridad

---

## 🔧 Configuración .env

Tu `.env` está configurado para:
- Base de datos MySQL en `127.0.0.1:3306`
- Base de datos: `dbweb`
- Usuario: `root`
- Driver: MySQL

---

**¡Tu proyecto está completamente funcional y listo para desarrollar!** 🎉
