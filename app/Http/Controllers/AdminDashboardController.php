<?php

namespace App\Http\Controllers;

use App\Models\Cita;
use App\Models\Contacto;

class AdminDashboardController extends Controller
{
    public function index()
    {
        return view('admin.dashboard', [
            'total_citas' => Cita::count(),
            'citas_pendientes' => Cita::where('estado', 'pendiente')->count(),
            'total_mensajes' => Contacto::count(),
        ]);
    }
}
