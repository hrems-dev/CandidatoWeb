<?php

namespace App\Http\Controllers;

use App\Models\Comentario;
use Illuminate\Http\Request;

class ComentarioPublicoController extends Controller
{
    /**
     * Mostrar todos los comentarios públicos
     */
    public function index()
    {
        $comentarios = Comentario::where('estado', 'publicado')
            ->where('verificado', true)
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        // Estadísticas
        $total = Comentario::where('estado', 'publicado')->where('verificado', true)->count();
        $calificacionPromedio = Comentario::where('estado', 'publicado')
            ->where('verificado', true)
            ->avg('calificacion');

        return view('comentarios.index', compact('comentarios', 'total', 'calificacionPromedio'));
    }

    /**
     * Crear un nuevo comentario
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'ubicacion' => 'nullable|string|max:255',
            'contenido' => 'required|string|min:10|max:1000',
            'calificacion' => 'required|integer|min:1|max:5',
        ]);

        $comentario = Comentario::create([
            'nombre' => $validated['nombre'],
            'email' => $validated['email'],
            'ubicacion' => $validated['ubicacion'] ?? null,
            'contenido' => $validated['contenido'],
            'calificacion' => $validated['calificacion'],
            'estado' => 'pendiente', // Requiere aprobación del admin
            'verificado' => false,
        ]);

        return back()->with('success', '¡Gracias por tu comentario! Será revisado y publicado pronto.');
    }

    /**
     * Dar like a un comentario
     */
    public function like($id)
    {
        $comentario = Comentario::findOrFail($id);
        $comentario->increment('likes');

        return back()->with('success', 'Me gusta registrado');
    }
}
