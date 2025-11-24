<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AreaLegal extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'areas_legales';

    protected $fillable = [
        'nombre',
        'descripcion',
        'info_candidato_id',
        'orden',
        'estado',
    ];

    protected $casts = [
        'orden' => 'integer',
        'estado' => 'boolean',
    ];

    // Relaciones
    public function infoCandidato()
    {
        return $this->belongsTo(InfoCandidato::class, 'info_candidato_id');
    }

    // Scopes
    public function scopeActivos($query)
    {
        return $query->where('estado', true);
    }

    public function scopeOrdenados($query)
    {
        return $query->orderBy('orden');
    }
}
