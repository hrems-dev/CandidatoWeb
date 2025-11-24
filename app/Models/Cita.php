<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cita extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'citas';

    protected $fillable = [
        'info_candidato_id',
        'mensaje',
        'duracion_minutos',
        'estado',
    ];

    protected $casts = [
        'duracion_minutos' => 'integer',
        'estado' => 'boolean',
    ];

    // Relaciones
    public function infoCandidato()
    {
        return $this->belongsTo(InfoCandidato::class, 'info_candidato_id');
    }

    public function reservas()
    {
        return $this->hasMany(ReservaCita::class, 'cita_id');
    }

    // Scopes
    public function scopeActivos($query)
    {
        return $query->where('estado', true);
    }
}
