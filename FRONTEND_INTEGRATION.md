# 🎨 Guía de Integración Frontend - CandidatoWeb

## 🔗 Conexión Frontend-Backend

Tu backend está completamente funcional y listo para ser consumido desde el frontend.

---

## 📡 Configuración de Axios/Fetch

### Con Axios (recomendado para Vue/Livewire)

```javascript
// resources/js/api.js
import axios from 'axios';

const API_URL = 'http://127.0.0.1:8000/api/v1';

const api = axios.create({
  baseURL: API_URL,
  headers: {
    'Content-Type': 'application/json',
    'Accept': 'application/json',
  }
});

// Agregar token de autenticación si existe
api.interceptors.request.use(config => {
  const token = localStorage.getItem('auth_token');
  if (token) {
    config.headers.Authorization = `Bearer ${token}`;
  }
  return config;
});

export default api;
```

---

## 📰 Ejemplos de Uso - NOTICIAS

### Listar Noticias
```javascript
import api from '@/api';

// Listar todas las noticias publicadas
async function getNoticias() {
  try {
    const response = await api.get('/noticias');
    return response.data;
  } catch (error) {
    console.error('Error fetching noticias:', error);
  }
}

// Listar con filtros
async function getNoticiasFiltered(estado, tipo) {
  const response = await api.get('/noticias', {
    params: { estado, tipo }
  });
  return response.data;
}
```

### Ver Noticia Específica
```javascript
async function getNoticia(id) {
  const response = await api.get(`/noticias/${id}`);
  return response.data;
}
```

### Crear Noticia (Admin)
```javascript
async function crearNoticia(datos) {
  const response = await api.post('/noticias', {
    titulo: datos.titulo,
    contenido: datos.contenido,
    imagen: datos.imagen,
    tipo: datos.tipo,
    estado: 'publicado',
    fecha_publicacion: new Date().toISOString()
  });
  return response.data;
}
```

---

## 📅 Ejemplos de Uso - CITAS

### Solicitar Cita (Público)
```javascript
async function solicitarCita(datos) {
  const response = await api.post('/citas', {
    nombre: datos.nombre,
    email: datos.email,
    telefono: datos.telefono,
    tipo_consulta: datos.tipo,
    descripcion: datos.mensaje,
    documento_identidad: datos.documento,
    ubicacion: datos.ubicacion
  });
  return response.data;
}
```

### Listar Citas (Admin)
```javascript
async function getCitas() {
  const response = await api.get('/citas');
  return response.data;
}

// Con filtros
async function getCitasFiltered(estado) {
  const response = await api.get('/citas', {
    params: { estado }
  });
  return response.data;
}
```

### Aceptar Cita (Admin)
```javascript
async function aceptarCita(id, fecha, hora) {
  const response = await api.post(`/citas/${id}/aceptar`, {
    fecha_cita: fecha,  // YYYY-MM-DD
    hora_cita: hora      // HH:mm
  });
  return response.data;
}
```

### Rechazar Cita (Admin)
```javascript
async function rechazarCita(id, motivo) {
  const response = await api.post(`/citas/${id}/rechazar`, {
    motivo_rechazo: motivo
  });
  return response.data;
}
```

---

## 📧 Ejemplos de Uso - CONTACTOS

### Enviar Mensaje (Público)
```javascript
async function enviarContacto(datos) {
  const response = await api.post('/contactos', {
    nombre: datos.nombre,
    email: datos.email,
    asunto: datos.asunto,
    mensaje: datos.mensaje,
    telefono: datos.telefono
  });
  return response.data;
}
```

### Listar Mensajes (Admin)
```javascript
async function getContactos() {
  const response = await api.get('/contactos');
  return response.data;
}
```

### Responder Mensaje (Admin)
```javascript
async function responderContacto(id, respuesta) {
  const response = await api.post(`/contactos/${id}/responder`, {
    respuesta_admin: respuesta
  });
  return response.data;
}
```

---

## 💬 Ejemplos de Uso - COMENTARIOS

### Crear Comentario
```javascript
async function crearComentario(datos) {
  const response = await api.post('/comentarios', {
    mensaje: datos.mensaje,
    persona_id: datos.persona_id,
    estado: 'pendiente'  // Será aprobado por admin
  });
  return response.data;
}
```

### Listar Comentarios
```javascript
async function getComentarios() {
  const response = await api.get('/comentarios');
  return response.data;
}

// Filtrar por estado
async function getComentariosAprobados() {
  const response = await api.get('/comentarios', {
    params: { estado: 'aprobado' }
  });
  return response.data;
}
```

---

## 📝 Ejemplos de Uso - PUBLICACIONES

### Listar Publicaciones
```javascript
async function getPublicaciones() {
  const response = await api.get('/publicaciones');
  return response.data;
}

// Por candidato
async function getPublicacionesCandidato(candidatoId) {
  const response = await api.get('/publicaciones', {
    params: { info_candidato_id: candidatoId }
  });
  return response.data;
}
```

### Ver Publicación
```javascript
async function getPublicacion(id) {
  const response = await api.get(`/publicaciones/${id}`);
  return response.data;
}
```

### Crear Publicación (Admin)
```javascript
async function crearPublicacion(datos) {
  const response = await api.post('/publicaciones', {
    titulo: datos.titulo,
    descripcion: datos.descripcion,
    info_candidato_id: datos.candidato_id,
    estado: true,
    destacado: datos.destacado
  });
  return response.data;
}
```

---

## 👤 Ejemplos de Uso - CANDIDATOS

### Listar Candidatos
```javascript
async function getCandidatos() {
  const response = await api.get('/candidatos');
  return response.data;
}
```

### Listar Info Candidatos (con detalles)
```javascript
async function getInfoCandidatos() {
  const response = await api.get('/info-candidatos');
  return response.data;
}

// Filtrar por ciudad
async function getCandidatosPorCiudad(ciudad) {
  const response = await api.get('/info-candidatos', {
    params: { ciudad, estado: true }
  });
  return response.data;
}

// Filtrar por especialidad
async function getCandidatosPorEspecialidad(especialidadId) {
  const response = await api.get('/info-candidatos', {
    params: { especialidad_id: especialidadId, estado: true }
  });
  return response.data;
}
```

### Ver Candidato Detallado
```javascript
async function getCandidatoDetallado(id) {
  const response = await api.get(`/info-candidatos/${id}`);
  return response.data;
}
```

---

## 🔐 Manejo de Autenticación

### Login
```javascript
// Usar los endpoints de Fortify para login
async function login(email, password) {
  const response = await axios.post('http://127.0.0.1:8000/login', {
    email,
    password
  });
  
  // Guardar token si lo devuelve
  if (response.data.token) {
    localStorage.setItem('auth_token', response.data.token);
  }
  
  return response.data;
}
```

### Logout
```javascript
async function logout() {
  localStorage.removeItem('auth_token');
  // Redirigir a login
}
```

---

## 📱 Vue Component - Ejemplo Completo

```vue
<template>
  <div class="noticias">
    <h1>Noticias y Actividades</h1>
    
    <div v-if="loading" class="loading">Cargando...</div>
    
    <div v-if="error" class="error">{{ error }}</div>
    
    <div class="noticias-grid">
      <div v-for="noticia in noticias" :key="noticia.id" class="noticia-card">
        <h2>{{ noticia.titulo }}</h2>
        <p>{{ noticia.contenido.substring(0, 100) }}...</p>
        <small>{{ formatDate(noticia.fecha_publicacion) }}</small>
        <span class="vistas">👁️ {{ noticia.vistas }}</span>
      </div>
    </div>
  </div>
</template>

<script>
import { ref, onMounted } from 'vue';
import api from '@/api';

export default {
  setup() {
    const noticias = ref([]);
    const loading = ref(true);
    const error = ref(null);

    onMounted(async () => {
      try {
        const response = await api.get('/noticias');
        noticias.value = response.data.data; // Si usa paginación
      } catch (err) {
        error.value = err.message;
      } finally {
        loading.value = false;
      }
    });

    const formatDate = (date) => {
      return new Date(date).toLocaleDateString('es-ES');
    };

    return {
      noticias,
      loading,
      error,
      formatDate
    };
  }
};
</script>

<style scoped>
.noticias-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
  gap: 20px;
  margin-top: 20px;
}

.noticia-card {
  border: 1px solid #ddd;
  padding: 15px;
  border-radius: 8px;
  cursor: pointer;
  transition: transform 0.3s;
}

.noticia-card:hover {
  transform: translateY(-5px);
  box-shadow: 0 4px 12px rgba(0,0,0,0.1);
}

.vistas {
  display: block;
  margin-top: 10px;
  font-size: 12px;
  color: #666;
}
</style>
```

---

## ⚠️ CORS y Configuración

Si el frontend está en un puerto diferente (ej: 3000, 5173), necesitas habilitar CORS:

### Actualizar `config/cors.php`
```php
'allowed_origins' => ['http://localhost:5173', 'http://127.0.0.1:5173'],
'allowed_methods' => ['*'],
'allowed_headers' => ['*'],
```

### O usar middleware en `routes/api.php`
```php
Route::middleware('cors')->group(function () {
    // Tus rutas API
});
```

---

## 🧪 Pruebas Rápidas

Puedes probar los endpoints directamente con cURL o Postman:

```bash
# Listar noticias
curl http://127.0.0.1:8000/api/v1/noticias

# Crear cita
curl -X POST http://127.0.0.1:8000/api/v1/citas \
  -H "Content-Type: application/json" \
  -d '{
    "nombre": "Juan",
    "email": "juan@test.com",
    "telefono": "987654321",
    "tipo_consulta": "asesoría legal",
    "descripcion": "Necesito consulta",
    "documento_identidad": "12345678"
  }'
```

---

## 📊 Paginación

Algunos endpoints devuelven paginación (Laravel Paginate):

```javascript
// Respuesta paginada
{
  "data": [...],
  "links": {...},
  "meta": {
    "current_page": 1,
    "from": 1,
    "last_page": 5,
    "per_page": 10,
    "to": 10,
    "total": 50
  }
}

// Para acceder a los datos
const datos = response.data.data; // Los items
const total = response.data.meta.total; // Total de items
```

---

## 🎯 Datos de Prueba Disponibles

### Usuarios
- Admin: `admin@example.com` / `password`
- Test: `test@example.com` / `password`

### Datos en BD
- 5 Noticias
- 3 Citas
- 3 Contactos
- 3 Comentarios
- 1 Candidato con info completa

---

**¡Tu frontend está listo para conectarse con el backend! 🚀**
