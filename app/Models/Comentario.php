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
