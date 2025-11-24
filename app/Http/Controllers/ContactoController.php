<?php

namespace App\Http\Controllers;

use App\Models\Contacto;
use Illuminate\Http\Request;

class ContactoController extends Controller
{
    // Registrar mensaje de contacto
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string',
            'correo' => 'required|email',
            'asunto' => 'required|string',
            'mensaje' => 'required|string',
        ]);

        Contacto::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Tu mensaje fue enviado correctamente.'
        ]);
    }

    // Listar mensajes para el admin
    public function index()
    {
        return Contacto::orderBy('created_at', 'desc')->get();
    }
}

