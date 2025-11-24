<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contacto extends Model
{
    use SoftDeletes;

    protected  = 'contactos';

    protected  = [
        'nombre',
        'email',
        'telefono',
        'asunto',
        'mensaje',
        'estado',
        'respuesta_admin',
        'fecha_respuesta',
    ];

    protected  = [
        'fecha_respuesta' => 'datetime',
    ];

    public function scopeNuevos()
    {
        return ->where('estado', 'nuevo');
    }

    public function scopeRespondidos()
    {
        return ->where('estado', 'respondido');
    }

    public function responder()
    {
        ->update([
            'estado' => 'respondido',
            'respuesta_admin' => ,
            'fecha_respuesta' => now(),
        ]);
    }
}
