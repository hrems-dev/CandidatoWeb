<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ReservaCita extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'reserva_citas';

    protected $fillable = [
        'cita_id',
        'persona_id',
        'nombre_persona',
        'email',
        'fecha_cita',
        'hora_cita',
        'nro_celular',
        'motivo_consulta',
        'notas_adicionales',
        'tipo_consulta',
        'costo',
        'estado',
        'fecha_confirmacion',
        'fecha_cancelacion',
        'motivo_cancelacion',
        'recordatorio_enviado',
    ];

    protected $casts = [
        'fecha_cita' => 'date',
        'hora_cita' => 'datetime',
        'costo' => 'decimal:2',
        'fecha_confirmacion' => 'datetime',
        'fecha_cancelacion' => 'datetime',
        'recordatorio_enviado' => 'boolean',
    ];

    // Relaciones
    public function cita()
    {
        return $this->belongsTo(Cita::class, 'cita_id');
    }

    public function persona()
    {
        return $this->belongsTo(Persona::class, 'persona_id');
    }

    // Scopes
    public function scopePendientes($query)
    {
        return $query->where('estado', 'pendiente');
    }

    public function scopeConfirmadas($query)
    {
        return $query->where('estado', 'confirmada');
    }

    public function scopeProximas($query)
    {
        return $query->where('fecha_cita', '>=', now()->toDateString())
                     ->orderBy('fecha_cita')
                     ->orderBy('hora_cita');
    }

    public function scopeHoy($query)
    {
        return $query->where('fecha_cita', now()->toDateString());
    }

    // Métodos
    public function confirmar()
    {
        $this->update([
            'estado' => 'confirmada',
            'fecha_confirmacion' => now(),
        ]);
    }

    public function cancelar($motivo = null)
    {
        $this->update([
            'estado' => 'cancelada',
            'fecha_cancelacion' => now(),
            'motivo_cancelacion' => $motivo,
        ]);
    }

    public function completar()
    {
        $this->update(['estado' => 'completada']);
    }

    public function marcarNoAsistio()
    {
        $this->update(['estado' => 'no_asistio']);
    }
}
