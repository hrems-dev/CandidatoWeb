<?php

namespace App\Http\Controllers;

use App\Models\InfoCandidato;
use Illuminate\Http\Request;

class InfoCandidatoController extends Controller
{
    // Listar todos los candidatos
    public function index(Request $request)
    {
        $query = InfoCandidato::with('usuario', 'especialidades');

        // Filtrar por estado
        if ($request->has('estado')) {
            $query->where('estado', $request->estado);
        }

        // Filtrar por ciudad
        if ($request->has('ciudad')) {
            $query->where('ciudad', $request->ciudad);
        }

        // Filtrar por especialidad
        if ($request->has('especialidad_id')) {
            $query->whereHas('especialidades', function($q) {
                $q->where('especialidad_id', request()->especialidad_id);
            });
        }

        return response()->json($query->orderBy('nombre')->paginate(10));
    }

    // Ver un candidato específico
    public function show($id)
    {
        $infoCandidato = InfoCandidato::with('usuario', 'especialidades', 'publicaciones')->find($id);

        if (!$infoCandidato) {
            return response()->json(['message' => 'Candidato no encontrado'], 404);
        }

        return response()->json($infoCandidato);
    }

    // Crear un nuevo candidato
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:100',
            'apellido' => 'required|string|max:100',
            'usuario_id' => 'required|integer|exists:usuarios,id',
            'profesion' => 'required|string|max:150',
            'correo' => 'required|email|max:150|unique:info_candidatos',
            'telefono' => 'nullable|string|max:20',
            'celular' => 'nullable|string|max:20',
            'direccion' => 'nullable|string|max:250',
            'ciudad' => 'nullable|string|max:100',
            'pais' => 'nullable|string|max:100',
            'fecha_nacimiento' => 'nullable|date',
            'num_colegiatura' => 'nullable|string|max:50',
            'anos_experiencia' => 'nullable|integer',
            'biografia' => 'nullable|string',
            'foto_perfil' => 'nullable|string|max:500',
            'linkedin' => 'nullable|string|max:250',
            'sitio_web' => 'nullable|string|max:250',
            'tarifa_consulta' => 'nullable|numeric',
            'estado' => 'nullable|boolean',
        ]);

        $validated['estado'] = $validated['estado'] ?? true;

        $infoCandidato = InfoCandidato::create($validated);

        return response()->json($infoCandidato, 201);
    }

    // Actualizar un candidato
    public function update(Request $request, $id)
    {
        $infoCandidato = InfoCandidato::find($id);

        if (!$infoCandidato) {
            return response()->json(['message' => 'Candidato no encontrado'], 404);
        }

        $validated = $request->validate([
            'nombre' => 'nullable|string|max:100',
            'apellido' => 'nullable|string|max:100',
            'profesion' => 'nullable|string|max:150',
            'correo' => 'nullable|email|max:150|unique:info_candidatos,correo,' . $id,
            'telefono' => 'nullable|string|max:20',
            'celular' => 'nullable|string|max:20',
            'direccion' => 'nullable|string|max:250',
            'ciudad' => 'nullable|string|max:100',
            'pais' => 'nullable|string|max:100',
            'fecha_nacimiento' => 'nullable|date',
            'num_colegiatura' => 'nullable|string|max:50',
            'anos_experiencia' => 'nullable|integer',
            'biografia' => 'nullable|string',
            'foto_perfil' => 'nullable|string|max:500',
            'linkedin' => 'nullable|string|max:250',
            'sitio_web' => 'nullable|string|max:250',
            'tarifa_consulta' => 'nullable|numeric',
            'calificacion_promedio' => 'nullable|numeric',
            'total_consultas' => 'nullable|integer',
            'estado' => 'nullable|boolean',
        ]);

        $infoCandidato->update($validated);

        return response()->json($infoCandidato);
    }

    // Eliminar un candidato
    public function destroy($id)
    {
        $infoCandidato = InfoCandidato::find($id);

        if (!$infoCandidato) {
            return response()->json(['message' => 'Candidato no encontrado'], 404);
        }

        $infoCandidato->delete();

        return response()->json(['message' => 'Candidato eliminado correctamente']);
    }
}
