<?php

namespace App\Events;

use App\Models\Cita;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithBroadcasting;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CitaActualizada implements ShouldBroadcast
{
    use Dispatchable, InteractsWithBroadcasting, SerializesModels;

    public function __construct(
        public Cita $cita,
        public string $accion = 'actualizado' // 'aceptada', 'rechazada', 'reprogramada', etc.
    ) {
    }

    public function broadcastOn(): array
    {
        return [
            new Channel('citas'),
        ];
    }

    public function broadcastAs(): string
    {
        return 'cita-actualizada';
    }

    public function broadcastWith(): array
    {
        return [
            'id' => $this->cita->id,
            'nombre' => $this->cita->nombre,
            'accion' => $this->accion,
            'estado' => $this->cita->estado,
            'fecha_cita' => $this->cita->fecha_cita?->format('d/m/Y'),
            'hora_cita' => $this->cita->hora_cita,
        ];
    }
}
