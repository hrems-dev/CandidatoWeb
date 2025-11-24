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

    // Propiedades del formulario
    public $titulo = '';
    public $slug = '';
    public $resumen = '';
    public $contenido = '';
    public $tipo = '';
    public $categoria = '';
    public $estado = 'borrador';
    public $imagen;
    public $imagen_preview = '';

    // Control de modal y edición
    public $showModal = false;
    public $editingId = null;
    public $noticias = [];

    // Búsqueda y filtrado
    public $search = '';
    public $filterEstado = '';
    public $filterTipo = '';

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
        $this->showModal = true;
    }

    public function save()
    {
        $this->validate([
            'titulo' => 'required|string|max:255',
            'resumen' => 'required|string|max:500',
            'contenido' => 'required|string',
            'tipo' => 'required|string|in:noticia,actividad,evento',
            'categoria' => 'nullable|string|max:100',
            'estado' => 'required|string|in:borrador,publicado',
            'imagen' => 'nullable|image|max:5120', // 5MB
        ]);

        try {
            $data = [
                'titulo' => $this->titulo,
                'slug' => Str::slug($this->titulo . '-' . time()),
                'resumen' => $this->resumen,
                'contenido' => $this->contenido,
                'tipo' => $this->tipo,
                'categoria' => $this->categoria,
                'estado' => $this->estado,
                'fecha_publicacion' => $this->estado === 'publicado' ? now() : null,
            ];

            // Manejo de imagen
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

            if ($this->editingId) {
                // Actualizar
                $noticia = Noticia::findOrFail($this->editingId);
                $noticia->update($data);
                $this->dispatch('notify', ['message' => 'Noticia actualizada correctamente', 'type' => 'success']);
            } else {
                // Crear
                $noticia = Noticia::create($data);

                // Disparar eventos
                NoticiaCreada::dispatch($noticia);
                if ($noticia->estado === 'publicado') {
                    NoticiaPublicada::dispatch($noticia);
                }

                $this->dispatch('notify', ['message' => 'Noticia creada correctamente', 'type' => 'success']);
            }

            $this->closeModal();
            $this->cargarNoticias();
        } catch (\Exception $e) {
            $this->dispatch('notify', ['message' => 'Error: ' . $e->getMessage(), 'type' => 'error']);
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
