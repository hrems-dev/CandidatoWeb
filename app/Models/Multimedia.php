<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Multimedia extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'multimedias';

    protected $fillable = [
        'tipo',
        'nombre',
        'direccion',
        'tamanio',
        'mime_type',
        'publicacion_id',
        'orden',
        'estado',
    ];

    protected $casts = [
        'tamanio' => 'integer',
        'orden' => 'integer',
        'estado' => 'boolean',
    ];

    // Relaciones
    public function publicacion()
    {
        return $this->belongsTo(Publicacion::class, 'publicacion_id');
    }

    // Scopes
    public function scopeActivos($query)
    {
        return $query->where('estado', true);
    }

    public function scopePorTipo($query, $tipo)
    {
        return $query->where('tipo', $tipo);
    }

    public function scopeOrdenados($query)
    {
        return $query->orderBy('orden');
    }

    // Accessors
    public function getUrlAttribute()
    {
        return asset('storage/' . $this->direccion);
    }

    public function getTamanioFormateadoAttribute()
    {
        if (!$this->tamanio) return null;
        
        $bytes = $this->tamanio;
        if ($bytes >= 1073741824) {
            return number_format($bytes / 1073741824, 2) . ' GB';
        } elseif ($bytes >= 1048576) {
            return number_format($bytes / 1048576, 2) . ' MB';
        } elseif ($bytes >= 1024) {
            return number_format($bytes / 1024, 2) . ' KB';
        } else {
            return $bytes . ' bytes';
        }
    }
}
