# Dashboard Admin - Guía Completa

## 📊 Descripción General

El panel de administración proporciona un interfaz completa para gestionar:
- **Citas**: Aceptar, rechazar y programar citas de clientes
- **Contactos**: Responder y gestionar mensajes de contacto
- **Estadísticas**: Visión general de actividad pendiente

## 🔐 Acceso al Dashboard

1. Ve a: `http://localhost:8000/login`
2. Usa las credenciales del admin:
   - **Email**: `admin@candidatoweb.local` (o la que hayas creado)
   - **Contraseña**: Depende de tu configuración

3. Una vez autenticado, accede a: `http://localhost:8000/dashboard`

## 📈 Secciones del Dashboard

### 1. Tarjetas de Estadísticas (Top)
Muestra en tiempo real:
- **Citas Pendientes**: Número de citas que requieren acción
- **Mensajes Nuevos**: Contactos sin responder
- **Total de Citas**: Suma de todas las citas registradas

### 2. Gestión de Citas

#### Tabla de Citas
Muestra todas las citas pendientes con:
- Nombre del cliente
- Email
- Tipo de consulta
- Fecha de solicitud
- Estado actual

#### Acciones disponibles:

**Ver** (Botón ojo)
- Abre los detalles completos de la cita
- Incluye: nombre, email, teléfono, tipo, descripción, estado

**Aceptar** (Botón verde, solo si está pendiente)
- Marca la cita como aceptada
- Notifica al cliente por email
- La cita se mueve al historial

**Rechazar** (Botón rojo, solo si está pendiente)
- Te pide un motivo de rechazo
- Envía email de rechazo al cliente
- Guarda el motivo en el sistema

### 3. Gestión de Contactos

#### Tabla de Contactos
Muestra todos los mensajes con:
- Nombre del remitente
- Email
- Asunto
- Fecha de recepción
- Estado actual

#### Acciones disponibles:

**Ver** (Botón ojo)
- Abre el mensaje completo
- Muestra: nombre, email, teléfono, asunto, mensaje completo, estado

**Responder** (Botón verde, solo si está nuevo)
- Abre un campo para escribir tu respuesta
- Envía la respuesta por email al cliente
- Marca automáticamente como "Respondido"

**Manejado** (Botón gris)
- Marca el contacto como procesado
- Útil para mantener organizados los mensajes

## 🎨 Diseño y Estilos

El dashboard mantiene coherencia con el sitio web principal:
- **Colores**: Gradiente azul (blue-900 a blue-800)
- **Tipografía**: Consistente con el frontend
- **Responsive**: Funciona en desktop, tablet y móvil
- **Iconos**: FontAwesome para mejor UX

## 🔧 Información Técnica

### Rutas

**Dashboard Principal**
```
GET /dashboard
```
Requiere autenticación y email verificado

### API Endpoints (Usados internamente)

```
GET    /api/citas/{id}          - Ver detalles de cita
PUT    /api/citas/{id}          - Actualizar estado de cita
GET    /api/contactos/{id}      - Ver detalles de contacto
PUT    /api/contactos/{id}      - Actualizar estado/responder
```

### Controlador

**DashboardController@index**
- Obtiene conteos de estadísticas
- Filtra citas pendientes
- Filtra contactos nuevos
- Pasa datos a la vista

## 📝 Flujos de Trabajo

### Procesar una Cita Pendiente

1. Ve al dashboard
2. En la sección "Gestión de Citas", busca la cita
3. Haz clic en "Ver" para revisar detalles
4. Elige:
   - **Aceptar**: Cliente recibe confirmación
   - **Rechazar**: Cliente recibe motivo del rechazo

### Responder un Mensaje

1. Ve al dashboard
2. En la sección "Gestión de Contactos", busca el mensaje
3. Haz clic en "Ver" para leer el contenido completo
4. Haz clic en "Responder"
5. Escribe tu respuesta
6. El sistema envía email automáticamente

### Marcar como Manejado

1. Después de procesar, haz clic en "Manejado"
2. El mensaje se marca como completado
3. Aparecerá con estado "Manejado" en futuras búsquedas

## 🚀 Características Destacadas

✅ **Carga rápida**: Optimizado para rendimiento
✅ **Interfaz intuitiva**: Acciones claramente etiquetadas
✅ **Notificaciones por email**: Automatizadas para clientes
✅ **Historial completo**: Todos los cambios se guardan
✅ **Responsive design**: Funciona en todos los dispositivos
✅ **Estados visuales**: Colores que indican el estado actual

## 📞 Consideraciones Importantes

- Las estadísticas se actualizan en tiempo real
- Los emails se envían automáticamente al aceptar/rechazar/responder
- Todos los cambios son registrados en la base de datos
- Los contactos "nuevos" tienen prioridad visual

## 🐛 Troubleshooting

Si no ves datos en el dashboard:
1. Verifica que hay citas/contactos en la base de datos
2. Confirma que estás autenticado
3. Recarga la página (F5)

Si los botones no funcionan:
1. Abre la consola del navegador (F12)
2. Busca mensajes de error
3. Verifica la conexión a la API

---

**Última actualización**: 24 de noviembre de 2025
**Versión**: 1.0
**Estado**: ✅ Producción lista
