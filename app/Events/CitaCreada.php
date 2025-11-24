<?php

namespace App\Events;

use App\Models\Cita;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithBroadcasting;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CitaCreada implements ShouldBroadcast
{
    use Dispatchable, InteractsWithBroadcasting, SerializesModels;

    public function __construct(public Cita $cita)
    {
    }

    public function broadcastOn(): array
    {
        return [
            new Channel('citas'),
        ];
    }

    public function broadcastAs(): string
    {
        return 'cita-creada';
    }

    public function broadcastWith(): array
    {
        return [
            'id' => $this->cita->id,
            'nombre' => $this->cita->nombre,
            'email' => $this->cita->email,
            'tipo_consulta' => $this->cita->tipo_consulta,
            'fecha_solicitud' => $this->cita->fecha_solicitud->format('d/m/Y H:i'),
            'estado' => $this->cita->estado,
        ];
    }
}
