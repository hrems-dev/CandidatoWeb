<?php

namespace App\Http\Controllers;

use App\Models\Candidato;
use Illuminate\Http\Request;

class CandidatoController extends Controller
{
    // Listar todos los candidatos
    public function index(Request $request)
    {
        $query = Candidato::query();

        // Filtrar por estado activo
        if ($request->has('activo')) {
            $query->where('activo', $request->activo);
        }

        return response()->json($query->orderBy('nombre')->paginate(10));
    }

    // Ver un candidato específico
    public function show($id)
    {
        $candidato = Candidato::find($id);

        if (!$candidato) {
            return response()->json(['message' => 'Candidato no encontrado'], 404);
        }

        return response()->json($candidato);
    }
}
