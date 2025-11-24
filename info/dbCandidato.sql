-- ============================================
-- SCHEMA SQL OPTIMIZADO - SISTEMA LEGAL
-- MySQL 8.0+
-- ============================================

SET FOREIGN_KEY_CHECKS = 0;
DROP TABLE IF EXISTS comentario_publicacion;
DROP TABLE IF EXISTS multimedias;
DROP TABLE IF EXISTS publicaciones;
DROP TABLE IF EXISTS areas_legales;
DROP TABLE IF EXISTS candidato_especialidad;
DROP TABLE IF EXISTS especialidades;
DROP TABLE IF EXISTS info_candidatos;
DROP TABLE IF EXISTS comentarios;
DROP TABLE IF EXISTS personas;
DROP TABLE IF EXISTS reserva_citas;
DROP TABLE IF EXISTS citas;
DROP TABLE IF EXISTS interacciones;
DROP TABLE IF EXISTS notificaciones;
DROP TABLE IF EXISTS usuarios;
SET FOREIGN_KEY_CHECKS = 1;

-- ============================================
-- TABLAS PRINCIPALES
-- ============================================

-- Tabla: usuarios
CREATE TABLE usuarios (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nombre_usuario VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(150) UNIQUE NULL,
    rol ENUM('admin', 'candidato', 'usuario') DEFAULT 'usuario',
    ultimo_acceso TIMESTAMP NULL,
    intentos_fallidos TINYINT UNSIGNED DEFAULT 0,
    estado BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    deleted_at TIMESTAMP NULL,
    INDEX idx_nombre_usuario (nombre_usuario),
    INDEX idx_email (email),
    INDEX idx_rol (rol),
    INDEX idx_estado (estado)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabla: personas
CREATE TABLE personas (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(150) NOT NULL,
    apellido VARCHAR(150) NULL,
    email VARCHAR(150) NULL,
    telefono VARCHAR(20) NULL,
    estado BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    deleted_at TIMESTAMP NULL,
    INDEX idx_nombre (nombre),
    INDEX idx_email (email),
    INDEX idx_estado (estado),
    FULLTEXT idx_fulltext_nombre (nombre, apellido)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabla: info_candidatos
CREATE TABLE info_candidatos (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    apellido VARCHAR(100) NOT NULL,
    usuario_id BIGINT UNSIGNED NOT NULL,
    profesion VARCHAR(150) NOT NULL,
    correo VARCHAR(150) UNIQUE NOT NULL,
    telefono VARCHAR(20) NULL,
    celular VARCHAR(20) NULL,
    direccion VARCHAR(250) NULL,
    ciudad VARCHAR(100) NULL,
    pais VARCHAR(100) DEFAULT 'Perú',
    fecha_nacimiento DATE NULL,
    num_colegiatura VARCHAR(50) NULL,
    anos_experiencia TINYINT UNSIGNED NULL,
    biografia TEXT NULL,
    foto_perfil VARCHAR(500) NULL,
    linkedin VARCHAR(250) NULL,
    sitio_web VARCHAR(250) NULL,
    horario_atencion TEXT NULL COMMENT 'JSON: {dia: {inicio, fin}}',
    tarifa_consulta DECIMAL(10,2) NULL,
    calificacion_promedio DECIMAL(3,2) DEFAULT 0.00,
    total_consultas BIGINT UNSIGNED DEFAULT 0,
    estado BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    deleted_at TIMESTAMP NULL,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE,
    INDEX idx_usuario_id (usuario_id),
    INDEX idx_correo (correo),
    INDEX idx_ciudad (ciudad),
    INDEX idx_calificacion (calificacion_promedio),
    INDEX idx_estado (estado),
    FULLTEXT idx_fulltext_candidato (nombre, apellido, profesion, biografia)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabla: especialidades (NUEVA)
CREATE TABLE especialidades (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(150) UNIQUE NOT NULL,
    descripcion TEXT NULL,
    icono VARCHAR(100) NULL COMMENT 'Nombre del icono o clase CSS',
    slug VARCHAR(150) UNIQUE NOT NULL,
    estado BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    deleted_at TIMESTAMP NULL,
    INDEX idx_slug (slug),
    INDEX idx_estado (estado)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabla pivote: candidato_especialidad (NUEVA)
CREATE TABLE candidato_especialidad (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    info_candidato_id BIGINT UNSIGNED NOT NULL,
    especialidad_id BIGINT UNSIGNED NOT NULL,
    nivel_experiencia ENUM('junior', 'intermedio', 'senior', 'experto') DEFAULT 'intermedio',
    anos_experiencia TINYINT UNSIGNED DEFAULT 0,
    certificaciones TEXT NULL COMMENT 'JSON array de certificaciones',
    descripcion TEXT NULL COMMENT 'Descripción específica de su experiencia en esta especialidad',
    es_principal BOOLEAN DEFAULT FALSE COMMENT 'Indica si es la especialidad principal del candidato',
    estado BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (info_candidato_id) REFERENCES info_candidatos(id) ON DELETE CASCADE,
    FOREIGN KEY (especialidad_id) REFERENCES especialidades(id) ON DELETE CASCADE,
    UNIQUE KEY unique_candidato_especialidad (info_candidato_id, especialidad_id),
    INDEX idx_especialidad_id (especialidad_id),
    INDEX idx_nivel_experiencia (nivel_experiencia),
    INDEX idx_es_principal (es_principal),
    INDEX idx_estado (estado)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabla: areas_legales (mantiene relación con info_candidatos)
CREATE TABLE areas_legales (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(150) NOT NULL,
    descripcion TEXT NULL,
    info_candidato_id BIGINT UNSIGNED NOT NULL,
    orden TINYINT UNSIGNED DEFAULT 0,
    estado BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    deleted_at TIMESTAMP NULL,
    FOREIGN KEY (info_candidato_id) REFERENCES info_candidatos(id) ON DELETE CASCADE,
    INDEX idx_info_candidato_id (info_candidato_id),
    INDEX idx_orden (orden),
    INDEX idx_estado (estado)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- COMENTARIOS Y PUBLICACIONES
-- ============================================

-- Tabla: comentarios
CREATE TABLE comentarios (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    mensaje TEXT NOT NULL,
    persona_id BIGINT UNSIGNED NOT NULL,
    calificacion TINYINT UNSIGNED NULL CHECK (calificacion BETWEEN 1 AND 5),
    fecha_comentario TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    estado BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    deleted_at TIMESTAMP NULL,
    FOREIGN KEY (persona_id) REFERENCES personas(id) ON DELETE CASCADE,
    INDEX idx_persona_id (persona_id),
    INDEX idx_calificacion (calificacion),
    INDEX idx_estado (estado),
    INDEX idx_fecha_comentario (fecha_comentario),
    FULLTEXT idx_fulltext_mensaje (mensaje)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabla: publicaciones
CREATE TABLE publicaciones (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(250) NOT NULL,
    descripcion TEXT NOT NULL,
    slug VARCHAR(250) UNIQUE NOT NULL,
    extracto VARCHAR(500) NULL,
    fecha_publicacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    vistas BIGINT UNSIGNED DEFAULT 0,
    me_gusta BIGINT UNSIGNED DEFAULT 0,
    compartidos BIGINT UNSIGNED DEFAULT 0,
    info_candidato_id BIGINT UNSIGNED NOT NULL,
    destacado BOOLEAN DEFAULT FALSE,
    estado BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    deleted_at TIMESTAMP NULL,
    FOREIGN KEY (info_candidato_id) REFERENCES info_candidatos(id) ON DELETE CASCADE,
    INDEX idx_info_candidato_id (info_candidato_id),
    INDEX idx_slug (slug),
    INDEX idx_destacado (destacado),
    INDEX idx_estado (estado),
    INDEX idx_fecha_publicacion (fecha_publicacion),
    INDEX idx_vistas (vistas),
    FULLTEXT idx_fulltext_publicacion (titulo, descripcion, extracto)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabla pivote: comentario_publicacion
CREATE TABLE comentario_publicacion (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    comentario_id BIGINT UNSIGNED NOT NULL,
    publicacion_id BIGINT UNSIGNED NOT NULL,
    fecha_comentario TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    estado BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (comentario_id) REFERENCES comentarios(id) ON DELETE CASCADE,
    FOREIGN KEY (publicacion_id) REFERENCES publicaciones(id) ON DELETE CASCADE,
    UNIQUE KEY unique_comentario_publicacion (comentario_id, publicacion_id),
    INDEX idx_publicacion_id (publicacion_id),
    INDEX idx_fecha_comentario (fecha_comentario),
    INDEX idx_estado (estado)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabla: multimedias
CREATE TABLE multimedias (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    tipo ENUM('imagen', 'video', 'documento', 'audio') DEFAULT 'imagen',
    nombre VARCHAR(250) NOT NULL,
    direccion VARCHAR(500) NOT NULL,
    tamanio BIGINT UNSIGNED NULL COMMENT 'Tamaño en bytes',
    mime_type VARCHAR(100) NULL,
    publicacion_id BIGINT UNSIGNED NOT NULL,
    orden TINYINT UNSIGNED DEFAULT 0,
    estado BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    deleted_at TIMESTAMP NULL,
    FOREIGN KEY (publicacion_id) REFERENCES publicaciones(id) ON DELETE CASCADE,
    INDEX idx_publicacion_id (publicacion_id),
    INDEX idx_tipo (tipo),
    INDEX idx_orden (orden),
    INDEX idx_estado (estado)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- CITAS Y RESERVAS
-- ============================================

-- Tabla: citas
CREATE TABLE citas (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    info_candidato_id BIGINT UNSIGNED NULL COMMENT 'Abogado relacionado con la cita',
    mensaje TEXT NOT NULL,
    duracion_minutos SMALLINT UNSIGNED DEFAULT 60,
    estado BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    deleted_at TIMESTAMP NULL,
    FOREIGN KEY (info_candidato_id) REFERENCES info_candidatos(id) ON DELETE SET NULL,
    INDEX idx_info_candidato_id (info_candidato_id),
    INDEX idx_estado (estado)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabla: reserva_citas
CREATE TABLE reserva_citas (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    cita_id BIGINT UNSIGNED NOT NULL,
    persona_id BIGINT UNSIGNED NULL COMMENT 'Relación opcional con personas registradas',
    nombre_persona VARCHAR(150) NOT NULL,
    email VARCHAR(150) NULL,
    fecha_cita DATE NOT NULL,
    hora_cita TIME NOT NULL,
    nro_celular VARCHAR(20) NOT NULL,
    motivo_consulta TEXT NULL,
    notas_adicionales TEXT NULL,
    tipo_consulta ENUM('presencial', 'virtual', 'telefonica') DEFAULT 'presencial',
    costo DECIMAL(10,2) NULL,
    estado ENUM('pendiente', 'confirmada', 'cancelada', 'completada', 'no_asistio') DEFAULT 'pendiente',
    fecha_confirmacion TIMESTAMP NULL,
    fecha_cancelacion TIMESTAMP NULL,
    motivo_cancelacion TEXT NULL,
    recordatorio_enviado BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    deleted_at TIMESTAMP NULL,
    FOREIGN KEY (cita_id) REFERENCES citas(id) ON DELETE CASCADE,
    FOREIGN KEY (persona_id) REFERENCES personas(id) ON DELETE SET NULL,
    INDEX idx_cita_id (cita_id),
    INDEX idx_persona_id (persona_id),
    INDEX idx_fecha_cita (fecha_cita),
    INDEX idx_hora_cita (hora_cita),
    INDEX idx_estado (estado),
    INDEX idx_tipo_consulta (tipo_consulta),
    INDEX idx_nro_celular (nro_celular),
    INDEX idx_email (email)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- SISTEMA DE TRACKING Y NOTIFICACIONES
-- ============================================

-- Tabla: interacciones
CREATE TABLE interacciones (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    tipo_entidad ENUM('publicacion', 'candidato', 'pagina') NOT NULL,
    entidad_id BIGINT UNSIGNED NULL,
    tipo_accion ENUM('vista', 'click', 'me_gusta', 'compartir', 'descarga') NOT NULL,
    ip_address VARCHAR(45) NULL,
    user_agent TEXT NULL,
    fecha_interaccion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    estado BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    deleted_at TIMESTAMP NULL,
    INDEX idx_tipo_entidad (tipo_entidad),
    INDEX idx_entidad_id (entidad_id),
    INDEX idx_tipo_accion (tipo_accion),
    INDEX idx_fecha_interaccion (fecha_interaccion),
    INDEX idx_estado (estado)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabla: notificaciones
CREATE TABLE notificaciones (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    usuario_id BIGINT UNSIGNED NULL,
    tipo ENUM('cita', 'comentario', 'publicacion', 'sistema', 'recordatorio') DEFAULT 'sistema',
    titulo VARCHAR(250) NOT NULL,
    descripcion TEXT NOT NULL,
    enlace VARCHAR(500) NULL,
    leida BOOLEAN DEFAULT FALSE,
    fecha_notificacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    fecha_leida TIMESTAMP NULL,
    estado BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    deleted_at TIMESTAMP NULL,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE,
    INDEX idx_usuario_id (usuario_id),
    INDEX idx_tipo (tipo),
    INDEX idx_leida (leida),
    INDEX idx_estado (estado),
    INDEX idx_fecha_notificacion (fecha_notificacion)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- DATOS INICIALES - ESPECIALIDADES
-- ============================================

INSERT INTO especialidades (nombre, descripcion, slug, estado) VALUES
('Derecho Civil', 'Contratos, propiedad, familia, sucesiones y responsabilidad civil', 'derecho-civil', TRUE),
('Derecho Penal', 'Defensa penal, delitos, procedimientos judiciales penales', 'derecho-penal', TRUE),
('Derecho Laboral', 'Relaciones laborales, despidos, beneficios sociales', 'derecho-laboral', TRUE),
('Derecho Corporativo', 'Constitución de empresas, fusiones, adquisiciones', 'derecho-corporativo', TRUE),
('Derecho Tributario', 'Impuestos, fiscalización, planificación tributaria', 'derecho-tributario', TRUE),
('Derecho de Familia', 'Divorcio, alimentos, tenencia, adopción', 'derecho-familia', TRUE),
('Derecho Administrativo', 'Contrataciones del estado, procedimientos administrativos', 'derecho-administrativo', TRUE),
('Derecho Inmobiliario', 'Compraventa, arrendamiento, propiedad horizontal', 'derecho-inmobiliario', TRUE),
('Derecho Constitucional', 'Amparo, habeas corpus, derechos fundamentales', 'derecho-constitucional', TRUE),
('Derecho Comercial', 'Empresas, sociedades, comercio', 'derecho-comercial', TRUE),
('Propiedad Intelectual', 'Marcas, patentes, derechos de autor', 'propiedad-intelectual', TRUE),
('Derecho Ambiental', 'Protección ambiental, recursos naturales', 'derecho-ambiental', TRUE);

-- ============================================
-- COMENTARIOS Y DOCUMENTACIÓN
-- ============================================

/*
MEJORAS IMPLEMENTADAS:

1. ESPECIALIDADES:
   - Nueva tabla 'especialidades' para gestionar áreas legales de forma normalizada
   - Tabla pivote 'candidato_especialidad' con campos adicionales:
     * nivel_experiencia
     * años_experiencia específicos
     * certificaciones
     * es_principal (para destacar especialidad principal)

2. INFO_CANDIDATOS MEJORADO:
   - Campos adicionales: teléfono, celular, dirección, ciudad, país
   - fecha_nacimiento, num_colegiatura, años_experiencia
   - biografía, foto_perfil, redes sociales
   - horario_atencion (JSON), tarifa_consulta
   - calificacion_promedio, total_consultas
   - FULLTEXT index para búsquedas avanzadas

3. PUBLICACIONES MEJORADAS:
   - slug para URLs amigables
   - extracto para previsualizaciones
   - campos de engagement: me_gusta, compartidos
   - campo destacado para publicaciones importantes
   - FULLTEXT index para búsquedas

4. CITAS MEJORADAS:
   - Relación con info_candidatos
   - duracion_minutos
   - reserva_citas con más campos:
     * tipo_consulta (presencial, virtual, telefónica)
     * motivo_consulta, notas_adicionales
     * costo, recordatorio_enviado
     * fechas de confirmación/cancelación

5. INTERACCIONES MEJORADAS:
   - Tracking detallado por tipo de entidad
   - Tipos de acción específicos
   - IP y user_agent para analytics

6. NOTIFICACIONES MEJORADAS:
   - Relación con usuarios
   - Tipos específicos de notificación
   - Control de lectura
   - Campo de enlace para redirección

7. OPTIMIZACIONES MYSQL:
   - AUTO_INCREMENT para todas las PKs
   - Timestamps con DEFAULT CURRENT_TIMESTAMP
   - FULLTEXT indexes para búsquedas de texto
   - Índices compuestos estratégicos
   - Comentarios en campos importantes
   - Datos iniciales de especialidades incluidos

RELACIONES PRINCIPALES:
- usuarios → info_candidatos (1:1)
- info_candidatos ← candidato_especialidad → especialidades (N:M)
- info_candidatos → areas_legales (1:N)
- info_candidatos → publicaciones (1:N)
- info_candidatos → citas (1:N)
- publicaciones → multimedias (1:N)
- publicaciones ← comentario_publicacion → comentarios (N:M)
- personas → comentarios (1:N)
- citas → reserva_citas (1:N)
*/