<?php

namespace App\Http\Controllers;

use App\Models\Publicacion;
use Illuminate\Http\Request;

class PublicacionController extends Controller
{
    // Listar todas las publicaciones
    public function index(Request $request)
    {
        $query = Publicacion::query();

        // Filtrar por estado
        if ($request->has('estado')) {
            $query->where('estado', $request->estado);
        }

        // Filtrar por info_candidato_id
        if ($request->has('info_candidato_id')) {
            $query->where('info_candidato_id', $request->info_candidato_id);
        }

        // Solo publicaciones activas si no es admin
        if (!auth()->check()) {
            $query->where('estado', true);
        }

        return response()->json($query->with('infoCandidato', 'comentarios')->orderBy('fecha_publicacion', 'desc')->paginate(10));
    }

    // Ver una publicación específica
    public function show($id)
    {
        $publicacion = Publicacion::with('infoCandidato', 'comentarios')->find($id);

        if (!$publicacion) {
            return response()->json(['message' => 'Publicación no encontrada'], 404);
        }

        // Incrementar vistas
        $publicacion->increment('vistas');

        return response()->json($publicacion);
    }

    // Crear una publicación
    public function store(Request $request)
    {
        $validated = $request->validate([
            'titulo' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'info_candidato_id' => 'required|integer|exists:info_candidatos,id',
            'estado' => 'nullable|boolean',
            'destacado' => 'nullable|boolean',
        ]);

        $validated['estado'] = $validated['estado'] ?? true;
        $validated['destacado'] = $validated['destacado'] ?? false;

        $publicacion = Publicacion::create($validated);

        return response()->json($publicacion, 201);
    }

    // Actualizar una publicación
    public function update(Request $request, $id)
    {
        $publicacion = Publicacion::find($id);

        if (!$publicacion) {
            return response()->json(['message' => 'Publicación no encontrada'], 404);
        }

        $validated = $request->validate([
            'titulo' => 'nullable|string|max:255',
            'descripcion' => 'nullable|string',
            'estado' => 'nullable|boolean',
            'destacado' => 'nullable|boolean',
        ]);

        $publicacion->update($validated);

        return response()->json($publicacion);
    }

    // Eliminar una publicación
    public function destroy($id)
    {
        $publicacion = Publicacion::find($id);

        if (!$publicacion) {
            return response()->json(['message' => 'Publicación no encontrada'], 404);
        }

        $publicacion->delete();

        return response()->json(['message' => 'Publicación eliminada correctamente']);
    }
}
