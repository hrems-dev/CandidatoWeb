<?php

namespace App\Http\Controllers;

use App\Models\Noticia;
use Illuminate\Http\Request;

class NoticiaPublicaController extends Controller
{
    /**
     * Mostrar todas las noticias públicas
     */
    public function index()
    {
        $noticias = Noticia::where('estado', 'publicado')
            ->orderBy('fecha_publicacion', 'desc')
            ->paginate(9);

        return view('noticias.index', compact('noticias'));
    }

    /**
     * Mostrar detalle de una noticia
     */
    public function show($slug)
    {
        $noticia = Noticia::where('slug', $slug)
            ->where('estado', 'publicado')
            ->firstOrFail();

        // Incrementar contador de vistas
        $noticia->increment('vistas');

        // Obtener noticias relacionadas (mismo tipo)
        $relacionadas = Noticia::where('tipo', $noticia->tipo)
            ->where('id', '!=', $noticia->id)
            ->where('estado', 'publicado')
            ->limit(3)
            ->get();

        return view('noticias.show', compact('noticia', 'relacionadas'));
    }

    /**
     * Buscar noticias
     */
    public function buscar(Request $request)
    {
        $query = $request->input('q');

        $noticias = Noticia::where('estado', 'publicado')
            ->where(function ($q) use ($query) {
                $q->where('titulo', 'like', "%{$query}%")
                    ->orWhere('contenido', 'like', "%{$query}%")
                    ->orWhere('resumen', 'like', "%{$query}%");
            })
            ->orderBy('fecha_publicacion', 'desc')
            ->paginate(9);

        return view('noticias.index', compact('noticias', 'query'));
    }

    /**
     * Filtrar noticias por tipo
     */
    public function porTipo($tipo)
    {
        $noticias = Noticia::where('tipo', $tipo)
            ->where('estado', 'publicado')
            ->orderBy('fecha_publicacion', 'desc')
            ->paginate(9);

        return view('noticias.index', compact('noticias', 'tipo'));
    }
}
