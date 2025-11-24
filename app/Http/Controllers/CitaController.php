<?php

namespace App\Http\Controllers;

use App\Models\Cita;
use Illuminate\Http\Request;

class CitaController extends Controller
{
    // Registrar una nueva cita desde el público
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string',
            'correo' => 'required|email',
            'telefono' => 'nullable|string',
            'fecha_solicitada' => 'required|date',
            'hora_solicitada' => 'required',
            'mensaje' => 'nullable|string'
        ]);

        Cita::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Tu solicitud de cita fue enviada correctamente.',
        ]);
    }

    // Listar citas en el panel admin
    public function index()
    {
        return Cita::orderBy('created_at', 'desc')->get();
    }

    // Actualizar estado de una cita (aceptar, rechazar, pendiente)
    public function update(Request $request, $id)
    {
        $cita = Cita::findOrFail($id);

        $cita->update([
            'estado' => $request->estado,
            'respuesta_admin' => $request->respuesta_admin,
            'fecha_respuesta' => now()
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Cita actualizada correctamente.'
        ]);
    }
}
