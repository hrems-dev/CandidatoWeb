<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Candidato extends Model
{
    use SoftDeletes;

    protected $table = 'candidatos';

    protected $fillable = [
        'nombre',
        'cargo',
        'biografia',
        'foto',
        'vision',
        'mision',
        'propuestas',
        'estudios',
        'experiencia',
    ];

    protected $casts = [
        'propuestas' => 'array',
        'estudios' => 'array',
        'experiencia' => 'array',
    ];

    /**
     * Scopes
     */
    public function scopeActivo($query)
    {
        return $query->where('activo', true);
    }
}
