<?php

namespace App\Http\Controllers;

use App\Models\Contacto;
use Illuminate\Http\Request;

class ContactoController extends Controller
{
    // Listar todos los mensajes de contacto
    public function index(Request $request)
    {
        $query = Contacto::query();

        // Filtrar por estado
        if ($request->has('estado')) {
            $query->where('estado', $request->estado);
        }

        return response()->json($query->orderBy('created_at', 'desc')->paginate(15));
    }

    // Ver un mensaje de contacto específico
    public function show($id)
    {
        $contacto = Contacto::find($id);

        if (!$contacto) {
            return response()->json(['message' => 'Mensaje no encontrado'], 404);
        }

        return response()->json($contacto);
    }

    // Registrar mensaje de contacto
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'asunto' => 'required|string|max:255',
            'mensaje' => 'required|string',
            'telefono' => 'nullable|string|max:20',
        ]);

        $validated['estado'] = 'nuevo';
        $contacto = Contacto::create($validated);

        return response()->json($contacto, 201);
    }

    // Actualizar un mensaje de contacto
    public function update(Request $request, $id)
    {
        $contacto = Contacto::find($id);

        if (!$contacto) {
            return response()->json(['message' => 'Mensaje no encontrado'], 404);
        }

        $validated = $request->validate([
            'nombre' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'asunto' => 'nullable|string|max:255',
            'mensaje' => 'nullable|string',
            'telefono' => 'nullable|string|max:20',
            'estado' => 'nullable|in:nuevo,respondido,manejado,cerrado',
            'respuesta' => 'nullable|string',
        ]);

        $contacto->update($validated);

        return response()->json($contacto);
    }

    // Eliminar un mensaje de contacto
    public function destroy($id)
    {
        $contacto = Contacto::find($id);

        if (!$contacto) {
            return response()->json(['message' => 'Mensaje no encontrado'], 404);
        }

        $contacto->delete();

        return response()->json(['message' => 'Mensaje eliminado correctamente']);
    }

    // Responder a un mensaje de contacto
    public function responder(Request $request, $id)
    {
        $contacto = Contacto::find($id);

        if (!$contacto) {
            return response()->json(['message' => 'Mensaje no encontrado'], 404);
        }

        $validated = $request->validate([
            'respuesta_admin' => 'required|string',
        ]);

        $contacto->update([
            'estado' => 'respondido',
            'respuesta_admin' => $validated['respuesta_admin'],
            'fecha_respuesta' => now(),
        ]);

        return response()->json($contacto);
    }
}

