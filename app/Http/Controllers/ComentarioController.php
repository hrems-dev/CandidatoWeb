<?php

namespace App\Http\Controllers;

use App\Models\Comentario;
use Illuminate\Http\Request;

class ComentarioController extends Controller
{
    // Listar todos los comentarios
    public function index(Request $request)
    {
        $query = Comentario::query();

        // Filtrar por estado
        if ($request->has('estado')) {
            $query->where('estado', $request->estado);
        }

        // Filtrar por persona
        if ($request->has('persona_id')) {
            $query->where('persona_id', $request->persona_id);
        }

        return response()->json($query->orderBy('created_at', 'desc')->paginate(15));
    }

    // Ver un comentario específico
    public function show($id)
    {
        $comentario = Comentario::find($id);

        if (!$comentario) {
            return response()->json(['message' => 'Comentario no encontrado'], 404);
        }

        return response()->json($comentario);
    }

    // Crear un comentario
    public function store(Request $request)
    {
        $validated = $request->validate([
            'mensaje' => 'required|string',
            'persona_id' => 'required|integer|exists:personas,id',
            'estado' => 'nullable|in:pendiente,aprobado,rechazado',
        ]);

        $validated['estado'] = $validated['estado'] ?? 'pendiente';
        $comentario = Comentario::create($validated);

        return response()->json($comentario, 201);
    }

    // Actualizar un comentario
    public function update(Request $request, $id)
    {
        $comentario = Comentario::find($id);

        if (!$comentario) {
            return response()->json(['message' => 'Comentario no encontrado'], 404);
        }

        $validated = $request->validate([
            'mensaje' => 'nullable|string',
            'estado' => 'nullable|in:pendiente,aprobado,rechazado',
        ]);

        $comentario->update($validated);

        return response()->json($comentario);
    }

    // Eliminar un comentario
    public function destroy($id)
    {
        $comentario = Comentario::find($id);

        if (!$comentario) {
            return response()->json(['message' => 'Comentario no encontrado'], 404);
        }

        $comentario->delete();

        return response()->json(['message' => 'Comentario eliminado correctamente']);
    }
}
