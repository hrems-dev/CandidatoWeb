<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Noticia extends Model
{
    use SoftDeletes;

    protected $table = 'noticias';

    protected $fillable = [
        'titulo',
        'contenido',
        'imagen',
        'tipo',
        'estado',
        'fecha_publicacion',
        'vistas',
    ];

    protected $casts = [
        'fecha_publicacion' => 'datetime',
    ];

    /**
     * Scopes
     */
    public function scopePublicadas($query)
    {
        return $query->where('estado', 'publicado')
                     ->where('fecha_publicacion', '<=', now());
    }

    public function scopePorTipo($query, $tipo)
    {
        return $query->where('tipo', $tipo);
    }

    /**
     * Mutadores
     */
    public function incrementarVistas()
    {
        $this->increment('vistas');
    }
}
