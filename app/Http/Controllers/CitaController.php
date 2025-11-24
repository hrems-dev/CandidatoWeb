<?php

namespace App\Http\Controllers;

use App\Models\Cita;
use Illuminate\Http\Request;

class CitaController extends Controller
{
    // Listar todas las citas
    public function index(Request $request)
    {
        $query = Cita::query();

        // Filtrar por estado
        if ($request->has('estado')) {
            $query->where('estado', $request->estado);
        }

        // Filtrar por tipo de consulta
        if ($request->has('tipo_consulta')) {
            $query->where('tipo_consulta', $request->tipo_consulta);
        }

        return response()->json($query->orderBy('fecha_solicitud', 'desc')->paginate(10));
    }

    // Ver una cita específica
    public function show($id)
    {
        $cita = Cita::find($id);

        if (!$cita) {
            return response()->json(['message' => 'Cita no encontrada'], 404);
        }

        return response()->json($cita);
    }

    // Registrar una nueva cita desde el público
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'telefono' => 'required|string|max:20',
            'tipo_consulta' => 'required|in:asesoría legal,trámite administrativo,defensa penal,derechos laborales,familia,otro',
            'descripcion' => 'required|string',
            'documento_identidad' => 'nullable|string|max:50',
            'ubicacion' => 'nullable|string|max:255',
        ]);

        $validated['fecha_solicitud'] = now();
        $validated['estado'] = 'pendiente';

        $cita = Cita::create($validated);

        return response()->json($cita, 201);
    }

    // Actualizar una cita
    public function update(Request $request, $id)
    {
        $cita = Cita::find($id);

        if (!$cita) {
            return response()->json(['message' => 'Cita no encontrada'], 404);
        }

        $validated = $request->validate([
            'nombre' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'telefono' => 'nullable|string|max:20',
            'tipo_consulta' => 'nullable|in:asesoría legal,trámite administrativo,defensa penal,derechos laborales,familia,otro',
            'descripcion' => 'nullable|string',
            'estado' => 'nullable|in:pendiente,aceptada,rechazada,completada,cancelada',
            'motivo_rechazo' => 'nullable|string',
            'ubicacion' => 'nullable|string|max:255',
            'documento_identidad' => 'nullable|string|max:50',
        ]);

        $cita->update($validated);

        return response()->json($cita);
    }

    // Eliminar una cita
    public function destroy($id)
    {
        $cita = Cita::find($id);

        if (!$cita) {
            return response()->json(['message' => 'Cita no encontrada'], 404);
        }

        $cita->delete();

        return response()->json(['message' => 'Cita eliminada correctamente']);
    }

    // Aceptar una cita
    public function aceptar(Request $request, $id)
    {
        $cita = Cita::find($id);

        if (!$cita) {
            return response()->json(['message' => 'Cita no encontrada'], 404);
        }

        $validated = $request->validate([
            'fecha_cita' => 'required|date',
            'hora_cita' => 'required|date_format:H:i',
        ]);

        $cita->update([
            'estado' => 'aceptada',
            'fecha_cita' => $validated['fecha_cita'],
            'hora_cita' => $validated['hora_cita'],
        ]);

        return response()->json($cita);
    }

    // Rechazar una cita
    public function rechazar(Request $request, $id)
    {
        $cita = Cita::find($id);

        if (!$cita) {
            return response()->json(['message' => 'Cita no encontrada'], 404);
        }

        $validated = $request->validate([
            'motivo_rechazo' => 'required|string',
        ]);

        $cita->update([
            'estado' => 'rechazada',
            'motivo_rechazo' => $validated['motivo_rechazo'],
        ]);

        return response()->json($cita);
    }
}
