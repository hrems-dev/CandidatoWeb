<?php

namespace App\Http\Controllers;

use App\Models\Noticia;
use Illuminate\Http\Request;

class NoticiaController extends Controller
{
    // Listar todas las noticias publicadas
    public function index(Request $request)
    {
        $query = Noticia::query();

        // Filtrar por estado
        if ($request->has('estado')) {
            $query->where('estado', $request->estado);
        }

        // Filtrar por tipo
        if ($request->has('tipo')) {
            $query->where('tipo', $request->tipo);
        }

        // Solo noticias publicadas si no es admin
        if (!auth()->check()) {
            $query->where('estado', 'publicado');
        }

        return response()->json($query->orderBy('fecha_publicacion', 'desc')->paginate(10));
    }

    // Ver una noticia específica
    public function show($id)
    {
        $noticia = Noticia::find($id);

        if (!$noticia) {
            return response()->json(['message' => 'Noticia no encontrada'], 404);
        }

        // Incrementar vistas
        $noticia->incrementarVistas();

        return response()->json($noticia);
    }

    // Crear una noticia (solo admin)
    public function store(Request $request)
    {
        $validated = $request->validate([
            'titulo' => 'required|string|max:255|unique:noticias',
            'contenido' => 'required|string',
            'imagen' => 'nullable|string',
            'tipo' => 'required|in:noticia,actividad,evento',
            'estado' => 'required|in:borrador,publicado,archivado',
            'fecha_publicacion' => 'nullable|date_format:Y-m-d H:i:s',
        ]);

        $noticia = Noticia::create($validated);

        return response()->json($noticia, 201);
    }

    // Actualizar una noticia (solo admin)
    public function update(Request $request, $id)
    {
        $noticia = Noticia::find($id);

        if (!$noticia) {
            return response()->json(['message' => 'Noticia no encontrada'], 404);
        }

        $validated = $request->validate([
            'titulo' => 'nullable|string|max:255|unique:noticias,titulo,' . $id,
            'contenido' => 'nullable|string',
            'imagen' => 'nullable|string',
            'tipo' => 'nullable|in:noticia,actividad,evento',
            'estado' => 'nullable|in:borrador,publicado,archivado',
            'fecha_publicacion' => 'nullable|date_format:Y-m-d H:i:s',
        ]);

        $noticia->update($validated);

        return response()->json($noticia);
    }

    // Eliminar una noticia (solo admin)
    public function destroy($id)
    {
        $noticia = Noticia::find($id);

        if (!$noticia) {
            return response()->json(['message' => 'Noticia no encontrada'], 404);
        }

        $noticia->delete();

        return response()->json(['message' => 'Noticia eliminada correctamente']);
    }
}
