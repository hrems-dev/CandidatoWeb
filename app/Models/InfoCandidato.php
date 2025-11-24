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
