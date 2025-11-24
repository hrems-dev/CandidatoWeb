// ============================================
// MIGRACIONES LARAVEL
// ============================================

// database/migrations/2024_01_01_000001_create_usuarios_table.php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('usuarios', function (Blueprint $table) {
            $table->id();
            $table->string('nombre_usuario', 100)->unique();
            $table->string('password');
            $table->string('email', 150)->unique()->nullable();
            $table->enum('rol', ['admin', 'candidato', 'usuario'])->default('usuario');
            $table->timestamp('ultimo_acceso')->nullable();
            $table->unsignedTinyInteger('intentos_fallidos')->default(0);
            $table->boolean('estado')->default(true);
            $table->timestamps();
            $table->softDeletes();

            $table->index('nombre_usuario');
            $table->index('email');
            $table->index('rol');
            $table->index('estado');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('usuarios');
    }
};

// database/migrations/2024_01_01_000002_create_personas_table.php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('personas', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 150);
            $table->string('apellido', 150)->nullable();
            $table->string('email', 150)->nullable();
            $table->string('telefono', 20)->nullable();
            $table->boolean('estado')->default(true);
            $table->timestamps();
            $table->softDeletes();

            $table->index('nombre');
            $table->index('email');
            $table->index('estado');
            $table->fullText(['nombre', 'apellido']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('personas');
    }
};

// database/migrations/2024_01_01_000003_create_info_candidatos_table.php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('info_candidatos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 100);
            $table->string('apellido', 100);
            $table->foreignId('usuario_id')->constrained('usuarios')->onDelete('cascade');
            $table->string('profesion', 150);
            $table->string('correo', 150)->unique();
            $table->string('telefono', 20)->nullable();
            $table->string('celular', 20)->nullable();
            $table->string('direccion', 250)->nullable();
            $table->string('ciudad', 100)->nullable();
            $table->string('pais', 100)->default('Perú');
            $table->date('fecha_nacimiento')->nullable();
            $table->string('num_colegiatura', 50)->nullable();
            $table->unsignedTinyInteger('anos_experiencia')->nullable();
            $table->text('biografia')->nullable();
            $table->string('foto_perfil', 500)->nullable();
            $table->string('linkedin', 250)->nullable();
            $table->string('sitio_web', 250)->nullable();
            $table->text('horario_atencion')->nullable()->comment('JSON: {dia: {inicio, fin}}');
            $table->decimal('tarifa_consulta', 10, 2)->nullable();
            $table->decimal('calificacion_promedio', 3, 2)->default(0.00);
            $table->unsignedBigInteger('total_consultas')->default(0);
            $table->boolean('estado')->default(true);
            $table->timestamps();
            $table->softDeletes();

            $table->index('usuario_id');
            $table->index('correo');
            $table->index('ciudad');
            $table->index('calificacion_promedio');
            $table->index('estado');
            $table->fullText(['nombre', 'apellido', 'profesion', 'biografia']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('info_candidatos');
    }
};

// database/migrations/2024_01_01_000004_create_especialidades_table.php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('especialidades', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 150)->unique();
            $table->text('descripcion')->nullable();
            $table->string('icono', 100)->nullable()->comment('Nombre del icono o clase CSS');
            $table->string('slug', 150)->unique();
            $table->boolean('estado')->default(true);
            $table->timestamps();
            $table->softDeletes();

            $table->index('slug');
            $table->index('estado');
        });

        // Insertar especialidades iniciales
        DB::table('especialidades')->insert([
            ['nombre' => 'Derecho Civil', 'descripcion' => 'Contratos, propiedad, familia, sucesiones y responsabilidad civil', 'slug' => 'derecho-civil', 'estado' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Derecho Penal', 'descripcion' => 'Defensa penal, delitos, procedimientos judiciales penales', 'slug' => 'derecho-penal', 'estado' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Derecho Laboral', 'descripcion' => 'Relaciones laborales, despidos, beneficios sociales', 'slug' => 'derecho-laboral', 'estado' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Derecho Corporativo', 'descripcion' => 'Constitución de empresas, fusiones, adquisiciones', 'slug' => 'derecho-corporativo', 'estado' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Derecho Tributario', 'descripcion' => 'Impuestos, fiscalización, planificación tributaria', 'slug' => 'derecho-tributario', 'estado' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Derecho de Familia', 'descripcion' => 'Divorcio, alimentos, tenencia, adopción', 'slug' => 'derecho-familia', 'estado' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Derecho Administrativo', 'descripcion' => 'Contrataciones del estado, procedimientos administrativos', 'slug' => 'derecho-administrativo', 'estado' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Derecho Inmobiliario', 'descripcion' => 'Compraventa, arrendamiento, propiedad horizontal', 'slug' => 'derecho-inmobiliario', 'estado' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Derecho Constitucional', 'descripcion' => 'Amparo, habeas corpus, derechos fundamentales', 'slug' => 'derecho-constitucional', 'estado' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Derecho Comercial', 'descripcion' => 'Empresas, sociedades, comercio', 'slug' => 'derecho-comercial', 'estado' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Propiedad Intelectual', 'descripcion' => 'Marcas, patentes, derechos de autor', 'slug' => 'propiedad-intelectual', 'estado' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Derecho Ambiental', 'descripcion' => 'Protección ambiental, recursos naturales', 'slug' => 'derecho-ambiental', 'estado' => true, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('especialidades');
    }
};

// database/migrations/2024_01_01_000005_create_candidato_especialidad_table.php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('candidato_especialidad', function (Blueprint $table) {
            $table->id();
            $table->foreignId('info_candidato_id')->constrained('info_candidatos')->onDelete('cascade');
            $table->foreignId('especialidad_id')->constrained('especialidades')->onDelete('cascade');
            $table->enum('nivel_experiencia', ['junior', 'intermedio', 'senior', 'experto'])->default('intermedio');
            $table->unsignedTinyInteger('anos_experiencia')->default(0);
            $table->text('certificaciones')->nullable()->comment('JSON array de certificaciones');
            $table->text('descripcion')->nullable()->comment('Descripción específica de su experiencia en esta especialidad');
            $table->boolean('es_principal')->default(false)->comment('Indica si es la especialidad principal del candidato');
            $table->boolean('estado')->default(true);
            $table->timestamps();

            $table->unique(['info_candidato_id', 'especialidad_id'], 'unique_candidato_especialidad');
            $table->index('especialidad_id');
            $table->index('nivel_experiencia');
            $table->index('es_principal');
            $table->index('estado');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('candidato_especialidad');
    }
};

// database/migrations/2024_01_01_000006_create_areas_legales_table.php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('areas_legales', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 150);
            $table->text('descripcion')->nullable();
            $table->foreignId('info_candidato_id')->constrained('info_candidatos')->onDelete('cascade');
            $table->unsignedTinyInteger('orden')->default(0);
            $table->boolean('estado')->default(true);
            $table->timestamps();
            $table->softDeletes();

            $table->index('info_candidato_id');
            $table->index('orden');
            $table->index('estado');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('areas_legales');
    }
};

// database/migrations/2024_01_01_000007_create_comentarios_table.php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('comentarios', function (Blueprint $table) {
            $table->id();
            $table->text('mensaje');
            $table->foreignId('persona_id')->constrained('personas')->onDelete('cascade');
            $table->unsignedTinyInteger('calificacion')->nullable();
            $table->timestamp('fecha_comentario')->useCurrent();
            $table->boolean('estado')->default(true);
            $table->timestamps();
            $table->softDeletes();

            $table->index('persona_id');
            $table->index('calificacion');
            $table->index('estado');
            $table->index('fecha_comentario');
            $table->fullText('mensaje');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('comentarios');
    }
};

// database/migrations/2024_01_01_000008_create_publicaciones_table.php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('publicaciones', function (Blueprint $table) {
            $table->id();
            $table->string('titulo', 250);
            $table->text('descripcion');
            $table->string('slug', 250)->unique();
            $table->string('extracto', 500)->nullable();
            $table->timestamp('fecha_publicacion')->useCurrent();
            $table->unsignedBigInteger('vistas')->default(0);
            $table->unsignedBigInteger('me_gusta')->default(0);
            $table->unsignedBigInteger('compartidos')->default(0);
            $table->foreignId('info_candidato_id')->constrained('info_candidatos')->onDelete('cascade');
            $table->boolean('destacado')->default(false);
            $table->boolean('estado')->default(true);
            $table->timestamps();
            $table->softDeletes();

            $table->index('info_candidato_id');
            $table->index('slug');
            $table->index('destacado');
            $table->index('estado');
            $table->index('fecha_publicacion');
            $table->index('vistas');
            $table->fullText(['titulo', 'descripcion', 'extracto']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('publicaciones');
    }
};

// database/migrations/2024_01_01_000009_create_comentario_publicacion_table.php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('comentario_publicacion', function (Blueprint $table) {
            $table->id();
            $table->foreignId('comentario_id')->constrained('comentarios')->onDelete('cascade');
            $table->foreignId('publicacion_id')->constrained('publicaciones')->onDelete('cascade');
            $table->timestamp('fecha_comentario')->useCurrent();
            $table->boolean('estado')->default(true);
            $table->timestamps();

            $table->unique(['comentario_id', 'publicacion_id'], 'unique_comentario_publicacion');
            $table->index('publicacion_id');
            $table->index('fecha_comentario');
            $table->index('estado');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('comentario_publicacion');
    }
};

// database/migrations/2024_01_01_000010_create_multimedias_table.php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('multimedias', function (Blueprint $table) {
            $table->id();
            $table->enum('tipo', ['imagen', 'video', 'documento', 'audio'])->default('imagen');
            $table->string('nombre', 250);
            $table->string('direccion', 500);
            $table->unsignedBigInteger('tamanio')->nullable()->comment('Tamaño en bytes');
            $table->string('mime_type', 100)->nullable();
            $table->foreignId('publicacion_id')->constrained('publicaciones')->onDelete('cascade');
            $table->unsignedTinyInteger('orden')->default(0);
            $table->boolean('estado')->default(true);
            $table->timestamps();
            $table->softDeletes();

            $table->index('publicacion_id');
            $table->index('tipo');
            $table->index('orden');
            $table->index('estado');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('multimedias');
    }
};

// database/migrations/2024_01_01_000011_create_citas_table.php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('citas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('info_candidato_id')->nullable()->constrained('info_candidatos')->onDelete('set null');
            $table->text('mensaje');
            $table->unsignedSmallInteger('duracion_minutos')->default(60);
            $table->boolean('estado')->default(true);
            $table->timestamps();
            $table->softDeletes();

            $table->index('info_candidato_id');
            $table->index('estado');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('citas');
    }
};

// database/migrations/2024_01_01_000012_create_reserva_citas_table.php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reserva_citas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cita_id')->constrained('citas')->onDelete('cascade');
            $table->foreignId('persona_id')->nullable()->constrained('personas')->onDelete('set null');
            $table->string('nombre_persona', 150);
            $table->string('email', 150)->nullable();
            $table->date('fecha_cita');
            $table->time('hora_cita');
            $table->string('nro_celular', 20);
            $table->text('motivo_consulta')->nullable();
            $table->text('notas_adicionales')->nullable();
            $table->enum('tipo_consulta', ['presencial', 'virtual', 'telefonica'])->default('presencial');
            $table->decimal('costo', 10, 2)->nullable();
            $table->enum('estado', ['pendiente', 'confirmada', 'cancelada', 'completada', 'no_asistio'])->default('pendiente');
            $table->timestamp('fecha_confirmacion')->nullable();
            $table->timestamp('fecha_cancelacion')->nullable();
            $table->text('motivo_cancelacion')->nullable();
            $table->boolean('recordatorio_enviado')->default(false);
            $table->timestamps();
            $table->softDeletes();

            $table->index('cita_id');
            $table->index('persona_id');
            $table->index('fecha_cita');
            $table->index('hora_cita');
            $table->index('estado');
            $table->index('tipo_consulta');
            $table->index('nro_celular');
            $table->index('email');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reserva_citas');
    }
};

// database/migrations/2024_01_01_000013_create_interacciones_table.php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('interacciones', function (Blueprint $table) {
            $table->id();
            $table->enum('tipo_entidad', ['publicacion', 'candidato', 'pagina']);
            $table->unsignedBigInteger('entidad_id')->nullable();
            $table->enum('tipo_accion', ['vista', 'click', 'me_gusta', 'compartir', 'descarga']);
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->timestamp('fecha_interaccion')->useCurrent();
            $table->boolean('estado')->default(true);
            $table->timestamps();
            $table->softDeletes();

            $table->index('tipo_entidad');
            $table->index('entidad_id');
            $table->index('tipo_accion');
            $table->index('fecha_interaccion');
            $table->index('estado');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('interacciones');
    }
};

// database/migrations/2024_01_01_000014_create_notificaciones_table.php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('notificaciones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('usuario_id')->nullable()->constrained('usuarios')->onDelete('cascade');
            $table->enum('tipo', ['cita', 'comentario', 'publicacion', 'sistema', 'recordatorio'])->default('sistema');
            $table->string('titulo', 250);
            $table->text('descripcion');
            $table->string('enlace', 500)->nullable();
            $table->boolean('leida')->default(false);
            $table->timestamp('fecha_notificacion')->useCurrent();
            $table->timestamp('fecha_leida')->nullable();
            $table->boolean('estado')->default(true);
            $table->timestamps();
            $table->softDeletes();

            $table->index('usuario_id');
            $table->index('tipo');
            $table->index('leida');
            $table->index('estado');
            $table->index('fecha_notificacion');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notificaciones');
    }
};

// ============================================
// MODELOS ELOQUENT
// ============================================

// app/Models/Usuario.php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Usuario extends Authenticatable
{
    use HasFactory, SoftDeletes, Notifiable;

    protected $table = 'usuarios';

    protected $fillable = [
        'nombre_usuario',
        'password',
        'email',
        'rol',
        'ultimo_acceso',
        'intentos_fallidos',
        'estado',
    ];

    protected $hidden = [
        'password',
    ];

    protected $casts = [
        'ultimo_acceso' => 'datetime',
        'estado' => 'boolean',
        'intentos_fallidos' => 'integer',
    ];

    // Relaciones
    public function infoCandidato()
    {
        return $this->hasOne(InfoCandidato::class, 'usuario_id');
    }

    public function notificaciones()
    {
        return $this->hasMany(Notificacion::class, 'usuario_id');
    }

    // Scopes
    public function scopeActivos($query)
    {
        return $query->where('estado', true);
    }

    public function scopePorRol($query, $rol)
    {
        return $query->where('rol', $rol);
    }

    // Accessors
    public function getEsAdminAttribute()
    {
        return $this->rol === 'admin';
    }

    public function getEsCandidatoAttribute()
    {
        return $this->rol === 'candidato';
    }
}

// app/Models/Persona.php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Persona extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'personas';

    protected $fillable = [
        'nombre',
        'apellido',
        'email',
        'telefono',
        'estado',
    ];

    protected $casts = [
        'estado' => 'boolean',
    ];

    // Relaciones
    public function comentarios()
    {
        return $this->hasMany(Comentario::class, 'persona_id');
    }

    public function reservaCitas()
    {
        return $this->hasMany(ReservaCita::class, 'persona_id');
    }

    // Scopes
    public function scopeActivos($query)
    {
        return $query->where('estado', true);
    }

    public function scopeBuscar($query, $termino)
    {
        return $query->where(function($q) use ($termino) {
            $q->where('nombre', 'like', "%{$termino}%")
              ->orWhere('apellido', 'like', "%{$termino}%")
              ->orWhere('email', 'like', "%{$termino}%");
        });
    }

    // Accessors
    public function getNombreCompletoAttribute()
    {
        return trim("{$this->nombre} {$this->apellido}");
    }
}

// app/Models/InfoCandidato.php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InfoCandidato extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'info_candidatos';

    protected $fillable = [
        'nombre',
        'apellido',
        'usuario_id',
        'profesion',
        'correo',
        'telefono',
        'celular',
        'direccion',
        'ciudad',
        'pais',
        'fecha_nacimiento',
        'num_colegiatura',
        'anos_experiencia',
        'biografia',
        'foto_perfil',
        'linkedin',
        'sitio_web',
        'horario_atencion',
        'tarifa_consulta',
        'calificacion_promedio',
        'total_consultas',
        'estado',
    ];

    protected $casts = [
        'fecha_nacimiento' => 'date',
        'horario_atencion' => 'array',
        'tarifa_consulta' => 'decimal:2',
        'calificacion_promedio' => 'decimal:2',
        'total_consultas' => 'integer',
        'anos_experiencia' => 'integer',
        'estado' => 'boolean',
    ];

    // Relaciones
    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'usuario_id');
    }

    public function especialidades()
    {
        return $this->belongsToMany(Especialidad::class, 'candidato_especialidad', 'info_candidato_id', 'especialidad_id')
                    ->withPivot('nivel_experiencia', 'anos_experiencia', 'certificaciones', 'descripcion', 'es_principal', 'estado')
                    ->withTimestamps();
    }

    public function especialidadPrincipal()
    {
        return $this->especialidades()->wherePivot('es_principal', true)->first();
    }

    public function areasLegales()
    {
        return $this->hasMany(AreaLegal::class, 'info_candidato_id');
    }

    public function publicaciones()
    {
        return $this->hasMany(Publicacion::class, 'info_candidato_id');
    }

    public function citas()
    {
        return $this->hasMany(Cita::class, 'info_candidato_id');
    }

    // Scopes
    public function scopeActivos($query)
    {
        return $query->where('estado', true);
    }

    public function scopePorCiudad($query, $ciudad)
    {
        return $query->where('ciudad', $ciudad);
    }

    public function scopeConEspecialidad($query, $especialidadId)
    {
        return $query->whereHas('especialidades', function($q) use ($especialidadId) {
            $q->where('especialidades.id', $especialidadId);
        });
    }

    public function scopeMejorCalificados($query)
    {
        return $query->orderBy('calificacion_promedio', 'desc');
    }

    // Accessors
    public function getNombreCompletoAttribute()
    {
        return trim("{$this->nombre} {$this->apellido}");
    }

    public function getEdadAttribute()
    {
        return $this->fecha_nacimiento ? $this->fecha_nacimiento->age : null;
    }

    public function getFotoPerfilUrlAttribute()
    {
        return $this->foto_perfil ? asset('storage/' . $this->foto_perfil) : asset('images/default-avatar.png');
    }
}

// app/Models/Especialidad.php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Especialidad extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'especialidades';

    protected $fillable = [
        'nombre',
        'descripcion',
        'icono',
        'slug',
        'estado',
    ];

    protected $casts = [
        'estado' => 'boolean',
    ];

    // Relaciones
    public function candidatos()
    {
        return $this->belongsToMany(InfoCandidato::class, 'candidato_especialidad', 'especialidad_id', 'info_candidato_id')
                    ->withPivot('nivel_experiencia', 'anos_experiencia', 'certificaciones', 'descripcion', 'es_principal', 'estado')
                    ->withTimestamps();
    }

    // Scopes
    public function scopeActivos($query)
    {
        return $query->where('estado', true);
    }

    public function scopePorSlug($query, $slug)
    {
        return $query->where('slug', $slug);
    }
}

// app/Models/AreaLegal.php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AreaLegal extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'areas_legales';

    protected $fillable = [
        'nombre',
        'descripcion',
        'info_candidato_id',
        'orden',
        'estado',
    ];

    protected $casts = [
        'orden' => 'integer',
        'estado' => 'boolean',
    ];

    // Relaciones
    public function infoCandidato()
    {
        return $this->belongsTo(InfoCandidato::class, 'info_candidato_id');
    }

    // Scopes
    public function scopeActivos($query)
    {
        return $query->where('estado', true);
    }

    public function scopeOrdenados($query)
    {
        return $query->orderBy('orden');
    }
}

// app/Models/Comentario.php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comentario extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'comentarios';

    protected $fillable = [
        'mensaje',
        'persona_id',
        'calificacion',
        'fecha_comentario',
        'estado',
    ];

    protected $casts = [
        'fecha_comentario' => 'datetime',
        'calificacion' => 'integer',
        'estado' => 'boolean',
    ];

    // Relaciones
    public function persona()
    {
        return $this->belongsTo(Persona::class, 'persona_id');
    }

    public function publicaciones()
    {
        return $this->belongsToMany(Publicacion::class, 'comentario_publicacion', 'comentario_id', 'publicacion_id')
                    ->withPivot('fecha_comentario', 'estado')
                    ->withTimestamps();
    }

    // Scopes
    public function scopeActivos($query)
    {
        return $query->where('estado', true);
    }

    public function scopeRecientes($query)
    {
        return $query->orderBy('fecha_comentario', 'desc');
    }

    public function scopeConCalificacion($query)
    {
        return $query->whereNotNull('calificacion');
    }
}

// app/Models/Publicacion.php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Publicacion extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'publicaciones';

    protected $fillable = [
        'titulo',
        'descripcion',
        'slug',
        'extracto',
        'fecha_publicacion',
        'vistas',
        'me_gusta',
        'compartidos',
        'info_candidato_id',
        'destacado',
        'estado',
    ];

    protected $casts = [
        'fecha_publicacion' => 'datetime',
        'vistas' => 'integer',
        'me_gusta' => 'integer',
        'compartidos' => 'integer',
        'destacado' => 'boolean',
        'estado' => 'boolean',
    ];

    // Boot
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($publicacion) {
            if (empty($publicacion->slug)) {
                $publicacion->slug = Str::slug($publicacion->titulo);
            }
            if (empty($publicacion->extracto)) {
                $publicacion->extracto = Str::limit(strip_tags($publicacion->descripcion), 200);
            }
        });
    }

    // Relaciones
    public function infoCandidato()
    {
        return $this->belongsTo(InfoCandidato::class, 'info_candidato_id');
    }

    public function comentarios()
    {
        return $this->belongsToMany(Comentario::class, 'comentario_publicacion', 'publicacion_id', 'comentario_id')
                    ->withPivot('fecha_comentario', 'estado')
                    ->withTimestamps();
    }

    public function multimedias()
    {
        return $this->hasMany(Multimedia::class, 'publicacion_id');
    }

    // Scopes
    public function scopeActivos($query)
    {
        return $query->where('estado', true);
    }

    public function scopeDestacados($query)
    {
        return $query->where('destacado', true);
    }

    public function scopeRecientes($query)
    {
        return $query->orderBy('fecha_publicacion', 'desc');
    }

    public function scopePopulares($query)
    {
        return $query->orderBy('vistas', 'desc');
    }

    public function scopePorSlug($query, $slug)
    {
        return $query->where('slug', $slug);
    }

    // Métodos
    public function incrementarVistas()
    {
        $this->increment('vistas');
    }

    public function darMeGusta()
    {
        $this->increment('me_gusta');
    }

    public function compartir()
    {
        $this->increment('compartidos');
    }
}

// app/Models/Multimedia.php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Multimedia extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'multimedias';

    protected $fillable = [
        'tipo',
        'nombre',
        'direccion',
        'tamanio',
        'mime_type',
        'publicacion_id',
        'orden',
        'estado',
    ];

    protected $casts = [
        'tamanio' => 'integer',
        'orden' => 'integer',
        'estado' => 'boolean',
    ];

    // Relaciones
    public function publicacion()
    {
        return $this->belongsTo(Publicacion::class, 'publicacion_id');
    }

    // Scopes
    public function scopeActivos($query)
    {
        return $query->where('estado', true);
    }

    public function scopePorTipo($query, $tipo)
    {
        return $query->where('tipo', $tipo);
    }

    public function scopeOrdenados($query)
    {
        return $query->orderBy('orden');
    }

    // Accessors
    public function getUrlAttribute()
    {
        return asset('storage/' . $this->direccion);
    }

    public function getTamanioFormateadoAttribute()
    {
        if (!$this->tamanio) return null;
        
        $bytes = $this->tamanio;
        if ($bytes >= 1073741824) {
            return number_format($bytes / 1073741824, 2) . ' GB';
        } elseif ($bytes >= 1048576) {
            return number_format($bytes / 1048576, 2) . ' MB';
        } elseif ($bytes >= 1024) {
            return number_format($bytes / 1024, 2) . ' KB';
        } else {
            return $bytes . ' bytes';
        }
    }
}

// app/Models/Cita.php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cita extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'citas';

    protected $fillable = [
        'info_candidato_id',
        'mensaje',
        'duracion_minutos',
        'estado',
    ];

    protected $casts = [
        'duracion_minutos' => 'integer',
        'estado' => 'boolean',
    ];

    // Relaciones
    public function infoCandidato()
    {
        return $this->belongsTo(InfoCandidato::class, 'info_candidato_id');
    }

    public function reservas()
    {
        return $this->hasMany(ReservaCita::class, 'cita_id');
    }

    // Scopes
    public function scopeActivos($query)
    {
        return $query->where('estado', true);
    }
}

// app/Models/ReservaCita.php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ReservaCita extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'reserva_citas';

    protected $fillable = [
        'cita_id',
        'persona_id',
        'nombre_persona',
        'email',
        'fecha_cita',
        'hora_cita',
        'nro_celular',
        'motivo_consulta',
        'notas_adicionales',
        'tipo_consulta',
        'costo',
        'estado',
        'fecha_confirmacion',
        'fecha_cancelacion',
        'motivo_cancelacion',
        'recordatorio_enviado',
    ];

    protected $casts = [
        'fecha_cita' => 'date',
        'hora_cita' => 'datetime',
        'costo' => 'decimal:2',
        'fecha_confirmacion' => 'datetime',
        'fecha_cancelacion' => 'datetime',
        'recordatorio_enviado' => 'boolean',
    ];

    // Relaciones
    public function cita()
    {
        return $this->belongsTo(Cita::class, 'cita_id');
    }

    public function persona()
    {
        return $this->belongsTo(Persona::class, 'persona_id');
    }

    // Scopes
    public function scopePendientes($query)
    {
        return $query->where('estado', 'pendiente');
    }

    public function scopeConfirmadas($query)
    {
        return $query->where('estado', 'confirmada');
    }

    public function scopeProximas($query)
    {
        return $query->where('fecha_cita', '>=', now()->toDateString())
                     ->orderBy('fecha_cita')
                     ->orderBy('hora_cita');
    }

    public function scopeHoy($query)
    {
        return $query->where('fecha_cita', now()->toDateString());
    }

    // Métodos
    public function confirmar()
    {
        $this->update([
            'estado' => 'confirmada',
            'fecha_confirmacion' => now(),
        ]);
    }

    public function cancelar($motivo = null)
    {
        $this->update([
            'estado' => 'cancelada',
            'fecha_cancelacion' => now(),
            'motivo_cancelacion' => $motivo,
        ]);
    }

    public function completar()
    {
        $this->update(['estado' => 'completada']);
    }

    public function marcarNoAsistio()
    {
        $this->update(['estado' => 'no_asistio']);
    }
}

// app/Models/Interaccion.php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Interaccion extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'interacciones';

    protected $fillable = [
        'tipo_entidad',
        'entidad_id',
        'tipo_accion',
        'ip_address',
        'user_agent',
        'fecha_interaccion',
        'estado',
    ];

    protected $casts = [
        'fecha_interaccion' => 'datetime',
        'estado' => 'boolean',
    ];

    // Scopes
    public function scopeActivos($query)
    {
        return $query->where('estado', true);
    }

    public function scopePorTipoEntidad($query, $tipo)
    {
        return $query->where('tipo_entidad', $tipo);
    }

    public function scopePorTipoAccion($query, $tipo)
    {
        return $query->where('tipo_accion', $tipo);
    }

    public function scopeHoy($query)
    {
        return $query->whereDate('fecha_interaccion', now()->toDateString());
    }

    public function scopeUltimos30Dias($query)
    {
        return $query->where('fecha_interaccion', '>=', now()->subDays(30));
    }
}

// app/Models/Notificacion.php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Notificacion extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'notificaciones';

    protected $fillable = [
        'usuario_id',
        'tipo',
        'titulo',
        'descripcion',
        'enlace',
        'leida',
        'fecha_notificacion',
        'fecha_leida',
        'estado',
    ];

    protected $casts = [
        'leida' => 'boolean',
        'fecha_notificacion' => 'datetime',
        'fecha_leida' => 'datetime',
        'estado' => 'boolean',
    ];

    // Relaciones
    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'usuario_id');
    }

    // Scopes
    public function scopeActivos($query)
    {
        return $query->where('estado', true);
    }

    public function scopeNoLeidas($query)
    {
        return $query->where('leida', false);
    }

    public function scopeLeidas($query)
    {
        return $query->where('leida', true);
    }

    public function scopePorTipo($query, $tipo)
    {
        return $query->where('tipo', $tipo);
    }

    public function scopeRecientes($query)
    {
        return $query->orderBy('fecha_notificacion', 'desc');
    }

    // Métodos
    public function marcarComoLeida()
    {
        $this->update([
            'leida' => true,
            'fecha_leida' => now(),
        ]);
    }
}