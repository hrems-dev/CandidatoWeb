<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Interaccion extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'interacciones';

    protected $fillable = [
        'tipo_entidad',
        'entidad_id',
        'tipo_accion',
        'ip_address',
        'user_agent',
        'fecha_interaccion',
        'estado',
    ];

    protected $casts = [
        'fecha_interaccion' => 'datetime',
        'estado' => 'boolean',
    ];

    // Scopes
    public function scopeActivos($query)
    {
        return $query->where('estado', true);
    }

    public function scopePorTipoEntidad($query, $tipo)
    {
        return $query->where('tipo_entidad', $tipo);
    }

    public function scopePorTipoAccion($query, $tipo)
    {
        return $query->where('tipo_accion', $tipo);
    }

    public function scopeHoy($query)
    {
        return $query->whereDate('fecha_interaccion', now()->toDateString());
    }

    public function scopeUltimos30Dias($query)
    {
        return $query->where('fecha_interaccion', '>=', now()->subDays(30));
    }
}
