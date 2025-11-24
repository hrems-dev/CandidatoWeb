<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Auditoria extends Model
{
    protected $table = 'auditorias';

    public $timestamps = false;

    protected $fillable = [
        'usuario',
        'tabla',
        'registro_id',
        'accion',
        'datos_anterior',
        'datos_nuevo',
        'direccion_ip',
        'navegador',
        'created_at',
    ];

    protected $casts = [
        'datos_anterior' => 'array',
        'datos_nuevo' => 'array',
        'created_at' => 'datetime',
    ];

    /**
     * Scopes
     */
    public function scopePorTabla($query, $tabla)
    {
        return $query->where('tabla', $tabla);
    }

    public function scopePorUsuario($query, $usuario)
    {
        return $query->where('usuario', $usuario);
    }

    public function scopePorAccion($query, $accion)
    {
        return $query->where('accion', $accion);
    }

    /**
     * Mutadores
     */
    protected static function booted()
    {
        static::creating(function ($model) {
            if (!$model->created_at) {
                $model->created_at = now();
            }
        });
    }
}
