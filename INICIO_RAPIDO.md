# 🚀 INICIO RÁPIDO - CandidatoWeb

## ⚡ 5 Minutos para Empezar

### 1. Instalar Dependencias
```bash
cd d:\LP2\CandidatoWeb

# Dependencias PHP
composer install

# Dependencias Node (si no están instaladas)
npm install
```

### 2. Configurar .env
```bash
# Copiar archivo ejemplo
cp .env.example .env

# Generar key
php artisan key:generate
```

### 3. Base de Datos
```bash
# Crear base de datos en MySQL (si no existe)
mysql -u root -p
CREATE DATABASE dbweb CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
EXIT;

# Ejecutar migraciones
php artisan migrate:reset --force
php artisan migrate

# (Opcional) Ejecutar seeders
php artisan db:seed
```

### 4. Limpiar Caches
```bash
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
```

### 5. Iniciar Servidor
```bash
# Terminal 1: Servidor Laravel
php artisan serve

# Terminal 2: Compilar assets (Vite)
npm run dev
```

### 6. Acceder al Sistema
```
Aplicación Principal:    http://127.0.0.1:8000
Admin Dashboard:         http://127.0.0.1:8000/admin/dashboard
Formulario Citas:        http://127.0.0.1:8000/citas
Formulario Contacto:     http://127.0.0.1:8000/contacto
Noticias Públicas:       http://127.0.0.1:8000/noticias
```

---

## 👤 Credenciales de Admin

### Opción 1: Usar Fortify
```
Email:    admin@candidatoweb.local
Password: (Ejecutar: php artisan tinker > User::first())
```

### Opción 2: Crear Usuario
```bash
php artisan tinker

>>> User::create([
    'email' => 'admin@test.com',
    'password' => bcrypt('password123'),
    'email_verified_at' => now(),
    'name' => 'Admin',
])
>>> exit
```

Luego login en: `http://127.0.0.1:8000/login`

---

## 📋 Funcionalidades por URL

### **ADMIN** (Require autenticación)
| URL | Función |
|-----|---------|
| `/admin/dashboard` | Dashboard con Citas, Noticias, Contactos |
| `/admin/citas` | Gestión de citas |
| `/admin/noticias` | CRUD de noticias |
| `/admin/contactos` | Gestión de contactos |

### **PÚBLICO** (Sin autenticación)
| URL | Función |
|-----|---------|
| `/` | Home page |
| `/citas` | Formulario solicitud de cita |
| `/contacto` | Formulario de contacto |
| `/noticias` | Listado y detalle de noticias |
| `/candidato` | Información del candidato |

### **API** (JSON)
| Método | URL | Función |
|--------|-----|---------|
| GET | `/api/v1/noticias` | Listar noticias |
| GET | `/api/v1/noticias/{id}` | Detalle noticia |
| GET | `/api/v1/noticias/slug/{slug}` | Noticia por slug |
| POST | `/api/v1/citas` | Crear cita |
| GET | `/api/v1/citas` | Listar citas |
| POST | `/api/v1/contactos` | Crear contacto |
| GET | `/api/v1/contactos` | Listar contactos |

---

## 🧪 Testeo Rápido

### Test 1: Crear Noticia
```
1. Ir a http://127.0.0.1:8000/admin/dashboard
2. Click "Crear Noticia"
3. Llenar: Título, Resumen, Contenido, Categoría
4. Seleccionar imagen
5. Cambiar estado a "publicado"
6. Click Guardar
7. Ir a /noticias → Debe aparecer
```

### Test 2: Solicitar Cita
```
1. Ir a http://127.0.0.1:8000/citas
2. Llenar formulario:
   - Nombre: "Juan"
   - Email: "juan@test.com"
   - Teléfono: "987654321"
   - Tipo: "asesoría legal"
   - Descripción: "Necesito ayuda"
3. Click Solicitar
4. Ir a admin/dashboard → Debe aparecer como "pendiente"
```

### Test 3: Enviar Contacto
```
1. Ir a http://127.0.0.1:8000/contacto
2. Llenar formulario
3. Click Enviar
4. Ir a admin/dashboard → Debe aparecer como "nuevo"
5. Admin responde desde modal
6. Contacto cambio a "respondido"
```

### Test 4: API
```bash
# Listar noticias
curl http://127.0.0.1:8000/api/v1/noticias

# Crear cita
curl -X POST http://127.0.0.1:8000/api/v1/citas \
  -H "Content-Type: application/json" \
  -d '{"nombre":"Test","email":"test@test.com","telefono":"123","tipo_consulta":"otro","descripcion":"test"}'

# Ver noticia por slug
curl http://127.0.0.1:8000/api/v1/noticias/slug/mi-noticia
```

---

## 📁 Estructura de Directorios

```
d:\LP2\CandidatoWeb\
├── app/
│   ├── Events/           ← Eventos broadcasting
│   ├── Http/Controllers/ ← Controladores
│   ├── Livewire/        ← Componentes interactivos
│   ├── Models/          ← Modelos Eloquent
│   └── Providers/       ← Service providers
├── config/              ← Configuración
├── database/
│   ├── migrations/      ← Migraciones (mejoradas)
│   ├── factories/       ← Factory de tests
│   └── seeders/         ← Seeders
├── public/              ← Archivos públicos
│   ├── storage/         ← Imágenes subidas
│   └── index.php        ← Entry point
├── resources/
│   ├── views/           ← Plantillas Blade
│   │   ├── admin/
│   │   ├── citas/       ← Formulario citas
│   │   ├── contactos/   ← Formulario contacto
│   │   ├── noticias/    ← Página noticias
│   │   └── livewire/    ← Componentes Livewire
│   ├── css/
│   └── js/
├── routes/
│   ├── api.php          ← API routes (mejoradas)
│   └── web.php          ← Web routes (mejoradas)
├── storage/             ← Logs, cache
├── tests/               ← Tests
├── RESUMEN_FINAL.md     ← 📖 Documentación
├── IMPLEMENTACION_COMPLETADA.md
├── GUIA_TESTING.md
└── composer.json
```

---

## 🛠️ Troubleshooting

### Error: "Base de datos no existe"
```bash
mysql -u root -p
CREATE DATABASE dbweb;
EXIT;
php artisan migrate
```

### Error: "No puedo subir imágenes"
```bash
# Crear link de storage
php artisan storage:link

# Verificar permisos
chmod -R 755 storage/
chmod -R 755 bootstrap/cache/
```

### Error: "Livewire no funciona"
```bash
# Limpiar y recache
php artisan cache:clear
php artisan view:clear
php artisan config:clear

# Reimport assets
npm run build
```

### Error: "CSRF token mismatch"
```bash
# Regenerar key
php artisan key:generate

# Limpiar session
php artisan cache:clear
php artisan session:clear
```

### Error: "Class not found"
```bash
# Regenerar autoload
composer dump-autoload
```

---

## 📊 Base de Datos - Verificación

```bash
# Conectar a MySQL
mysql -u root -p dbweb

# Ver tablas
SHOW TABLES;

# Ver estructura de noticias
DESCRIBE noticias;

# Ver estructura de citas
DESCRIBE citas;

# Ver estructura de contactos
DESCRIBE contactos;

# Contar registros
SELECT COUNT(*) FROM noticias;
SELECT COUNT(*) FROM citas;
SELECT COUNT(*) FROM contactos;
```

---

## 🔐 Configuración Seguridad

### .env Recomendado
```env
APP_NAME="CandidatoWeb"
APP_ENV=local
APP_DEBUG=true
APP_URL=http://127.0.0.1:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=dbweb
DB_USERNAME=root
DB_PASSWORD=

BROADCAST_DRIVER=log
CACHE_DRIVER=file
SESSION_DRIVER=file
QUEUE_DRIVER=sync

MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=465
MAIL_USERNAME=your_username
MAIL_PASSWORD=your_password
MAIL_ENCRYPTION=tls
MAIL_FROM_NAME="CandidatoWeb"
```

---

## 🎯 Comandos Útiles

```bash
# Cache
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Database
php artisan migrate               # Ejecutar migraciones
php artisan migrate:rollback      # Revertir última migración
php artisan migrate:reset         # Revertir todas
php artisan db:seed               # Ejecutar seeders

# Tinker (REPL)
php artisan tinker                # Entrar en consola interactiva

# Storage
php artisan storage:link          # Link de storage público

# Queue
php artisan queue:work            # Procesar jobs (si usa colas)

# Modo mantenimiento
php artisan down                  # Poner en mantenimiento
php artisan up                    # Levantar mantenimiento
```

---

## 📈 Performance

### Optimización
```bash
# Cache de rutas
php artisan route:cache

# Cache de config
php artisan config:cache

# Optimizar autoload
composer install --optimize-autoloader

# Minificar assets
npm run build
```

### Monitoreo
```bash
# Ver logs
tail -f storage/logs/laravel.log

# Ver queries (agregar a .env)
DEBUGBAR_ENABLED=true
```

---

## 🌐 Desplegar en Producción

```bash
# 1. Clone repo
git clone <repo> candidatoweb
cd candidatoweb

# 2. Instalar
composer install --no-dev
npm install && npm run build

# 3. Configurar
cp .env.example .env
php artisan key:generate

# 4. Base de datos
php artisan migrate --force
php artisan db:seed --force

# 5. Optimizar
php artisan config:cache
php artisan route:cache
php artisan view:cache

# 6. Permisos
chmod -R 755 storage/ bootstrap/cache/
chown -R www-data:www-data .

# 7. Servidor Web (Nginx)
# Configurar virtual host con raíz en public/
```

---

## ✅ Checklist Final

- [ ] PHP 8.2+ instalado
- [ ] MySQL 8.0+ instalado
- [ ] Composer instalado
- [ ] Node/npm instalado
- [ ] Git instalado (opcional)
- [ ] Visual Studio Code instalado
- [ ] .env configurado
- [ ] Base de datos creada
- [ ] Migraciones ejecutadas
- [ ] npm dependencies instaladas
- [ ] Servidor PHP ejecutándose
- [ ] Vite dev server ejecutándose
- [ ] Acceso a admin dashboard ✓

---

**¡Listo! Tu sistema CandidatoWeb está funcionando.**

Si tienes preguntas o problemas, revisa:
1. RESUMEN_FINAL.md
2. GUIA_TESTING.md
3. API_DOCUMENTATION.md

¡Bienvenido al proyecto! 🎉
