<?php

namespace App\Http\Controllers;

use App\Events\NoticiaCreada;
use App\Events\NoticiaPublicada;
use App\Models\Noticia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class NoticiaController extends Controller
{
    // Listar todas las noticias publicadas
    public function index(Request $request)
    {
        $query = Noticia::query();

        // Filtrar por estado
        if ($request->has('estado')) {
            $query->where('estado', $request->estado);
        }

        // Filtrar por tipo
        if ($request->has('tipo')) {
            $query->where('tipo', $request->tipo);
        }

        // Solo noticias publicadas si no es admin
        if (!auth('web')->check()) {
            $query->where('estado', 'publicado');
        }

        return response()->json($query->orderBy('fecha_publicacion', 'desc')->paginate(10));
    }

    // Ver una noticia específica
    public function show($id)
    {
        $noticia = Noticia::find($id);

        if (!$noticia) {
            return response()->json(['message' => 'Noticia no encontrada'], 404);
        }

        // Incrementar vistas
        $noticia->incrementarVistas();

        return response()->json($noticia);
    }

    // Crear una noticia (solo admin)
    public function store(Request $request)
    {
        $validated = $request->validate([
            'titulo' => 'required|string|max:255',
            'contenido' => 'required|string',
            'resumen' => 'nullable|string|max:500',
            'categoria' => 'nullable|string|max:100',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
            'tipo' => 'required|in:noticia,actividad,evento',
            'estado' => 'required|in:borrador,publicado',
            'fecha_publicacion' => 'nullable|date_format:Y-m-d H:i:s',
        ]);

        try {
            // Generar slug
            $validated['slug'] = Str::slug($validated['titulo'] . '-' . time());

            // Manejo de carga de imagen
            if ($request->hasFile('imagen')) {
                $validated['imagen'] = $request->file('imagen')->store('noticias', 'public');
            }

            // Establecer fecha de publicación si se publica
            if ($validated['estado'] === 'publicado' && !isset($validated['fecha_publicacion'])) {
                $validated['fecha_publicacion'] = now();
            }

            $noticia = Noticia::create($validated);

            // Disparar evento de creación
            NoticiaCreada::dispatch($noticia);

            // Disparar evento de publicación si corresponde
            if ($noticia->estado === 'publicado') {
                NoticiaPublicada::dispatch($noticia);
            }

            return response()->json([
                'success' => true,
                'message' => 'Noticia creada correctamente',
                'data' => $noticia
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al crear la noticia: ' . $e->getMessage()
            ], 500);
        }
    }

    // Actualizar una noticia (solo admin)
    public function update(Request $request, $id)
    {
        $noticia = Noticia::find($id);

        if (!$noticia) {
            return response()->json(['message' => 'Noticia no encontrada'], 404);
        }

        $validated = $request->validate([
            'titulo' => 'nullable|string|max:255',
            'contenido' => 'nullable|string',
            'resumen' => 'nullable|string|max:500',
            'categoria' => 'nullable|string|max:100',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
            'tipo' => 'nullable|in:noticia,actividad,evento',
            'estado' => 'nullable|in:borrador,publicado',
            'fecha_publicacion' => 'nullable|date_format:Y-m-d H:i:s',
        ]);

        try {
            // Generar slug si hay cambio de título
            if (isset($validated['titulo'])) {
                $validated['slug'] = Str::slug($validated['titulo'] . '-' . time());
            }

            // Manejo de carga de imagen
            if ($request->hasFile('imagen')) {
                // Eliminar imagen anterior si existe
                if ($noticia->imagen) {
                    Storage::disk('public')->delete($noticia->imagen);
                }
                $validated['imagen'] = $request->file('imagen')->store('noticias', 'public');
            }

            // Actualizar fecha de publicación si cambia a publicado
            $estaba_publicada = $noticia->estado === 'publicado';
            if (isset($validated['estado']) && $validated['estado'] === 'publicado' && !$noticia->fecha_publicacion) {
                $validated['fecha_publicacion'] = now();
            }

            $noticia->update($validated);

            // Disparar evento de publicación si cambió de estado
            if (!$estaba_publicada && $noticia->estado === 'publicado') {
                NoticiaPublicada::dispatch($noticia);
            }

            return response()->json([
                'success' => true,
                'message' => 'Noticia actualizada correctamente',
                'data' => $noticia
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar la noticia: ' . $e->getMessage()
            ], 500);
        }
    }

    // Eliminar una noticia (solo admin)
    public function destroy($id)
    {
        $noticia = Noticia::find($id);

        if (!$noticia) {
            return response()->json(['message' => 'Noticia no encontrada'], 404);
        }

        try {
            // Eliminar imagen si existe
            if ($noticia->imagen) {
                Storage::disk('public')->delete($noticia->imagen);
            }

            $noticia->delete();

            return response()->json([
                'success' => true,
                'message' => 'Noticia eliminada correctamente'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar la noticia: ' . $e->getMessage()
            ], 500);
        }
    }

    // Buscar noticia por slug (público)
    public function showBySlug($slug)
    {
        $noticia = Noticia::where('slug', $slug)->first();

        if (!$noticia) {
            return response()->json(['message' => 'Noticia no encontrada'], 404);
        }

        // Incrementar vistas
        $noticia->incrementarVistas();

        return response()->json($noticia);
    }
}
