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
