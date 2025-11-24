<?php

namespace App\Events;

use App\Models\Contacto;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithBroadcasting;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ContactoRespondido implements ShouldBroadcast
{
    use Dispatchable, InteractsWithBroadcasting, SerializesModels;

    public function __construct(public Contacto $contacto)
    {
    }

    public function broadcastOn(): array
    {
        return [
            new Channel('contactos'),
        ];
    }

    public function broadcastAs(): string
    {
        return 'contacto-respondido';
    }

    public function broadcastWith(): array
    {
        return [
            'id' => $this->contacto->id,
            'nombre' => $this->contacto->nombre,
            'email' => $this->contacto->email,
            'asunto' => $this->contacto->asunto,
            'estado' => $this->contacto->estado,
            'fecha_respuesta' => $this->contacto->fecha_respuesta?->format('d/m/Y H:i'),
        ];
    }
}
