<?php

namespace App\Events;

use App\Models\Contacto;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithBroadcasting;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ContactoCreado implements ShouldBroadcast
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
        return 'contacto-creado';
    }

    public function broadcastWith(): array
    {
        return [
            'id' => $this->contacto->id,
            'nombre' => $this->contacto->nombre,
            'email' => $this->contacto->email,
            'asunto' => $this->contacto->asunto,
            'fecha_creacion' => $this->contacto->created_at->format('d/m/Y H:i'),
            'estado' => $this->contacto->estado,
        ];
    }
}
