<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Notificacion extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'notificaciones';

    protected $fillable = [
        'usuario_id',
        'tipo',
        'titulo',
        'descripcion',
        'enlace',
        'leida',
        'fecha_notificacion',
        'fecha_leida',
        'estado',
    ];

    protected $casts = [
        'leida' => 'boolean',
        'fecha_notificacion' => 'datetime',
        'fecha_leida' => 'datetime',
        'estado' => 'boolean',
    ];

    // Relaciones
    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'usuario_id');
    }

    // Scopes
    public function scopeActivos($query)
    {
        return $query->where('estado', true);
    }

    public function scopeNoLeidas($query)
    {
        return $query->where('leida', false);
    }

    public function scopeLeidas($query)
    {
        return $query->where('leida', true);
    }

    public function scopePorTipo($query, $tipo)
    {
        return $query->where('tipo', $tipo);
    }

    public function scopeRecientes($query)
    {
        return $query->orderBy('fecha_notificacion', 'desc');
    }

    // Métodos
    public function marcarComoLeida()
    {
        $this->update([
            'leida' => true,
            'fecha_leida' => now(),
        ]);
    }
}
