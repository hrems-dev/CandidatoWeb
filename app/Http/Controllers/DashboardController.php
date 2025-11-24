<?php

namespace App\Http\Controllers;

use App\Models\Cita;
use App\Models\Contacto;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Estadísticas
        $citasPendientes = Cita::where('estado', 'pendiente')->count();
        $contactosNuevos = Contacto::where('estado', 'nuevo')->count();
        $totalCitas = Cita::count();

        // Obtener últimas citas pendientes
        $citas = Cita::where('estado', 'pendiente')
            ->orderBy('fecha_solicitud', 'desc')
            ->get();

        // Obtener últimos contactos nuevos
        $contactos = Contacto::where('estado', 'nuevo')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('dashboard', compact(
            'citasPendientes',
            'contactosNuevos',
            'totalCitas',
            'citas',
            'contactos'
        ));
    }
}
