<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Publicacion extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'publicaciones';

    protected $fillable = [
        'titulo',
        'descripcion',
        'slug',
        'extracto',
        'fecha_publicacion',
        'vistas',
        'me_gusta',
        'compartidos',
        'info_candidato_id',
        'destacado',
        'estado',
    ];

    protected $casts = [
        'fecha_publicacion' => 'datetime',
        'vistas' => 'integer',
        'me_gusta' => 'integer',
        'compartidos' => 'integer',
        'destacado' => 'boolean',
        'estado' => 'boolean',
    ];

    // Boot
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($publicacion) {
            if (empty($publicacion->slug)) {
                $publicacion->slug = Str::slug($publicacion->titulo);
            }
            if (empty($publicacion->extracto)) {
                $publicacion->extracto = Str::limit(strip_tags($publicacion->descripcion), 200);
            }
        });
    }

    // Relaciones
    public function infoCandidato()
    {
        return $this->belongsTo(InfoCandidato::class, 'info_candidato_id');
    }

    public function comentarios()
    {
        return $this->belongsToMany(Comentario::class, 'comentario_publicacion', 'publicacion_id', 'comentario_id')
                    ->withPivot('fecha_comentario', 'estado')
                    ->withTimestamps();
    }

    public function multimedias()
    {
        return $this->hasMany(Multimedia::class, 'publicacion_id');
    }

    // Scopes
    public function scopeActivos($query)
    {
        return $query->where('estado', true);
    }

    public function scopeDestacados($query)
    {
        return $query->where('destacado', true);
    }

    public function scopeRecientes($query)
    {
        return $query->orderBy('fecha_publicacion', 'desc');
    }

    public function scopePopulares($query)
    {
        return $query->orderBy('vistas', 'desc');
    }

    public function scopePorSlug($query, $slug)
    {
        return $query->where('slug', $slug);
    }

    // Métodos
    public function incrementarVistas()
    {
        $this->increment('vistas');
    }

    public function darMeGusta()
    {
        $this->increment('me_gusta');
    }

    public function compartir()
    {
        $this->increment('compartidos');
    }
}
