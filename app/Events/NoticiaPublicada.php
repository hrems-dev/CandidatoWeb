<?php

namespace App\Events;

use App\Models\Noticia;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithBroadcasting;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NoticiaPublicada implements ShouldBroadcast
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
        return 'noticia-publicada';
    }

    public function broadcastWith(): array
    {
        return [
            'id' => $this->noticia->id,
            'titulo' => $this->noticia->titulo,
            'slug' => $this->noticia->slug,
            'resumen' => $this->noticia->resumen,
            'imagen' => $this->noticia->imagen,
            'tipo' => $this->noticia->tipo,
            'fecha_publicacion' => $this->noticia->fecha_publicacion?->format('d/m/Y H:i'),
        ];
    }
}
