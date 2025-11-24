<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Usuario extends Authenticatable
{
    use HasFactory, SoftDeletes, Notifiable;

    protected $table = 'usuarios';

    protected $fillable = [
        'nombre_usuario',
        'password',
        'email',
        'rol',
        'ultimo_acceso',
        'intentos_fallidos',
        'estado',
    ];

    protected $hidden = [
        'password',
    ];

    protected $casts = [
        'ultimo_acceso' => 'datetime',
        'estado' => 'boolean',
        'intentos_fallidos' => 'integer',
    ];

    // Relaciones
    public function infoCandidato()
    {
        return $this->hasOne(InfoCandidato::class, 'usuario_id');
    }

    public function notificaciones()
    {
        return $this->hasMany(Notificacion::class, 'usuario_id');
    }

    // Scopes
    public function scopeActivos($query)
    {
        return $query->where('estado', true);
    }

    public function scopePorRol($query, $rol)
    {
        return $query->where('rol', $rol);
    }

    // Accessors
    public function getEsAdminAttribute()
    {
        return $this->rol === 'admin';
    }

    public function getEsCandidatoAttribute()
    {
        return $this->rol === 'candidato';
    }
}
