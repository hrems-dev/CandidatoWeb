<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contacto extends Model
{
    use SoftDeletes;

    protected $table = 'contactos';

    protected $fillable = [
        'nombre',
        'email',
        'telefono',
        'asunto',
        'mensaje',
        'estado',
        'respuesta_admin',
        'admin_id',
        'fecha_respuesta',
        'fecha_leida',
    ];

    protected $casts = [
        'fecha_respuesta' => 'datetime',
        'fecha_leida' => 'datetime',
    ];

    public function scopeNuevos($query)
    {
        return $query->where('estado', 'nuevo');
    }

    public function scopeRespondidos($query)
    {
        return $query->where('estado', 'respondido');
    }

    public function responder($respuesta)
    {
        $this->update([
            'estado' => 'respondido',
            'respuesta_admin' => $respuesta,
            'fecha_respuesta' => now(),
        ]);
    }
}
