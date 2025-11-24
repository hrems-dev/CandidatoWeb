<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comentario extends Model
{
    use SoftDeletes;

    protected $table = 'comentarios';

    protected $fillable = [
        'nombre',
        'email',
        'contenido',
        'calificacion',
        'estado',
        'ubicacion',
        'verificado',
    ];

    protected $casts = [
        'verificado' => 'boolean',
        'calificacion' => 'integer',
    ];

    /**
     * Scopes
     */
    public function scopeAprobados($query)
    {
        return $query->where('estado', 'aprobado');
    }

    public function scopePendientes($query)
    {
        return $query->where('estado', 'pendiente');
    }

    public function scopeVerificados($query)
    {
        return $query->where('verificado', true);
    }

    /**
     * Métodos
     */
    public function obtenerCalificacionEstrella()
    {
        return str_repeat('★', $this->calificacion) . str_repeat('☆', 5 - $this->calificacion);
    }
}
