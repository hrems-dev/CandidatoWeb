<?php

namespace App\Livewire;

use App\Events\NoticiaCreada;
use App\Events\NoticiaPublicada;
use App\Models\Noticia;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Noticias extends Component
{
    use WithFileUploads;

    // 📝 PROPIEDADES DEL FORMULARIO
    public $titulo = '';
    public $slug = '';
    public $resumen = '';
    public $contenido = '';
    public $tipo = '';
    public $categoria = '';
    public $estado = 'borrador';
    public $imagen;
    public $imagen_preview = '';
    public $autor = '';
    public $fecha_publicacion = '';
    public $descripcion_corta = '';

    // 🎛️ CONTROL DE MODAL Y EDICIÓN
    public $showModal = false;
    public $editingId = null;
    public $noticias = [];

    // 🔍 BÚSQUEDA Y FILTRADO
    public $search = '';
    public $filterEstado = '';
    public $filterTipo = '';

    // 📊 ESTADÍSTICAS
    public $totalNoticias = 0;
    public $noticiasBorrador = 0;
    public $noticiasPublicadas = 0;

    public function mount()
    {
        $this->cargarNoticias();
    }

    public function render()
    {
        return view('livewire.noticias');
    }

    public function cargarNoticias()
    {
        $query = Noticia::query();

        if ($this->search) {
            $query->where('titulo', 'like', '%' . $this->search . '%')
                  ->orWhere('contenido', 'like', '%' . $this->search . '%')
                  ->orWhere('resumen', 'like', '%' . $this->search . '%');
        }

        if ($this->filterEstado) {
            $query->where('estado', $this->filterEstado);
        }

        if ($this->filterTipo) {
            $query->where('tipo', $this->filterTipo);
        }

        $this->noticias = $query->orderBy('fecha_publicacion', 'desc')
                                ->orderBy('created_at', 'desc')
                                ->get();

        // 📊 ACTUALIZAR ESTADÍSTICAS
        $this->totalNoticias = Noticia::count();
        $this->noticiasBorrador = Noticia::where('estado', 'borrador')->count();
        $this->noticiasPublicadas = Noticia::where('estado', 'publicado')->count();
    }

    public function openModal()
    {
        $this->resetForm();
        $this->showModal = true;
        $this->editingId = null;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->resetForm();
    }

    public function resetForm()
    {
        $this->titulo = '';
        $this->slug = '';
        $this->resumen = '';
        $this->contenido = '';
        $this->tipo = '';
        $this->categoria = '';
        $this->estado = 'borrador';
        $this->imagen = null;
        $this->imagen_preview = '';
        $this->fecha_publicacion = '';
        $this->descripcion_corta = '';
        $this->editingId = null;
    }

    public function edit(Noticia $noticia)
    {
        $this->editingId = $noticia->id;
        $this->titulo = $noticia->titulo;
        $this->slug = $noticia->slug;
        $this->resumen = $noticia->resumen;
        $this->contenido = $noticia->contenido;
        $this->tipo = $noticia->tipo;
        $this->categoria = $noticia->categoria;
        $this->estado = $noticia->estado;
        $this->imagen_preview = $noticia->imagen ? asset('storage/' . $noticia->imagen) : '';
        $this->fecha_publicacion = $noticia->fecha_publicacion?->format('Y-m-d H:i') ?? '';
        $this->showModal = true;
    }

    public function save()
    {
        // ✅ VALIDAR CAMPOS
        $this->validate([
            'titulo' => 'required|string|max:255|unique:noticias,titulo,' . ($this->editingId ?? 'NULL'),
            'resumen' => 'required|string|max:500',
            'contenido' => 'required|string|min:10',
            'tipo' => 'required|string|in:noticia,actividad,evento',
            'categoria' => 'nullable|string|max:100',
            'estado' => 'required|string|in:borrador,publicado',
            'imagen' => 'nullable|image|max:5120', // 5MB
        ]);

        try {
            // 📦 PREPARAR DATOS
            $data = [
                'titulo' => $this->titulo,
                'slug' => Str::slug($this->titulo . '-' . time()),
                'resumen' => $this->resumen,
                'contenido' => $this->contenido,
                'tipo' => $this->tipo,
                'categoria' => $this->categoria,
                'estado' => $this->estado,
                'fecha_publicacion' => $this->estado === 'publicado' ? now() : null,
                'vistas' => 0,
            ];

            // 📸 MANEJO DE IMAGEN
            if ($this->imagen) {
                // Guardar nueva imagen
                $path = $this->imagen->store('noticias', 'public');
                $data['imagen'] = $path;

                // Eliminar imagen anterior si existe (en edición)
                if ($this->editingId) {
                    $noticiaAnterior = Noticia::find($this->editingId);
                    if ($noticiaAnterior && $noticiaAnterior->imagen) {
                        Storage::disk('public')->delete($noticiaAnterior->imagen);
                    }
                }
            }

            // 💾 GUARDAR EN BASE DE DATOS
            if ($this->editingId) {
                // ✏️ ACTUALIZAR NOTICIA EXISTENTE
                $noticia = Noticia::findOrFail($this->editingId);

                // Si cambió de borrador a publicado, asignar fecha
                if ($noticia->estado === 'borrador' && $this->estado === 'publicado') {
                    $data['fecha_publicacion'] = now();
                }

                $noticia->update($data);

                // 📧 EVENTO: Noticia fue actualizada
                NoticiaCreada::dispatch($noticia);

                $this->dispatch('notify', [
                    'message' => '✅ Noticia actualizada correctamente',
                    'type' => 'success'
                ]);
            } else {
                // ✨ CREAR NOTICIA NUEVA
                $noticia = Noticia::create($data);

                // 📧 DISPARAR EVENTOS
                NoticiaCreada::dispatch($noticia);
                if ($noticia->estado === 'publicado') {
                    NoticiaPublicada::dispatch($noticia);
                }

                $this->dispatch('notify', [
                    'message' => '✨ Noticia creada correctamente',
                    'type' => 'success'
                ]);
            }

            // 🔄 ACTUALIZAR LISTA Y CERRAR MODAL
            $this->closeModal();
            $this->cargarNoticias();

        } catch (\Illuminate\Validation\ValidationException $e) {
            $this->dispatch('notify', [
                'message' => 'Error de validación: ' . collect($e->errors())->flatten()->first(),
                'type' => 'error'
            ]);
        } catch (\Exception $e) {
            $this->dispatch('notify', [
                'message' => '❌ Error: ' . $e->getMessage(),
                'type' => 'error'
            ]);
        }
    }

    public function delete(Noticia $noticia)
    {
        try {
            // Eliminar imagen si existe
            if ($noticia->imagen) {
                Storage::disk('public')->delete($noticia->imagen);
            }

            // Soft delete
            $noticia->delete();
            $this->dispatch('notify', ['message' => 'Noticia eliminada correctamente', 'type' => 'success']);
            $this->cargarNoticias();
        } catch (\Exception $e) {
            $this->dispatch('notify', ['message' => 'Error al eliminar: ' . $e->getMessage(), 'type' => 'error']);
        }
    }

    public function updatedSearch()
    {
        $this->cargarNoticias();
    }

    public function updatedFilterEstado()
    {
        $this->cargarNoticias();
    }

    public function updatedFilterTipo()
    {
        $this->cargarNoticias();
    }

    public function updatedImagen()
    {
        if ($this->imagen) {
            $this->validate([
                'imagen' => 'image|max:5120',
            ]);
            $this->imagen_preview = $this->imagen->temporaryUrl();
        }
    }
}
