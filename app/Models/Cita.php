<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cita extends Model
{
    use SoftDeletes;

    protected $table = 'citas';

    protected $fillable = [
        'nombre',
        'email',
        'telefono',
        'tipo_consulta',
        'descripcion',
        'fecha_solicitud',
        'fecha_cita',
        'hora_cita',
        'estado',
        'motivo_rechazo',
        'ubicacion',
        'documento_identidad',
    ];

    protected $casts = [
        'fecha_solicitud' => 'datetime',
        'fecha_cita' => 'datetime',
    ];

    /**
     * Scopes
     */
    public function scopePendientes($query)
    {
        return $query->where('estado', 'pendiente');
    }

    public function scopeAceptadas($query)
    {
        return $query->where('estado', 'aceptada');
    }

    public function scopeRechazadas($query)
    {
        return $query->where('estado', 'rechazada');
    }

    /**
     * Mutadores
     */
    public function aceptar($fecha, $hora)
    {
        $this->update([
            'estado' => 'aceptada',
            'fecha_cita' => $fecha,
            'hora_cita' => $hora,
        ]);
    }

    public function rechazar($motivo)
    {
        $this->update([
            'estado' => 'rechazada',
            'motivo_rechazo' => $motivo,
        ]);
    }
}
