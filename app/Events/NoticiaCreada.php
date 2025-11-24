<?php

namespace App\Events;

use App\Models\Noticia;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithBroadcasting;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NoticiaCreada implements ShouldBroadcast
{
    use Dispatchable, InteractsWithBroadcasting, SerializesModels;

    public function __construct(public Noticia $noticia)
    {
    }

    public function broadcastOn(): array
    {
        return [
            new Channel('noticias'),
        ];
    }

    public function broadcastAs(): string
    {
        return 'noticia-creada';
    }

    public function broadcastWith(): array
    {
        return [
            'id' => $this->noticia->id,
            'titulo' => $this->noticia->titulo,
            'slug' => $this->noticia->slug,
            'tipo' => $this->noticia->tipo,
            'estado' => $this->noticia->estado,
        ];
    }
}
