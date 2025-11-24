<?php

namespace App\Livewire;

use App\Models\Comentario;
use Livewire\Component;

class ComentariosAdmin extends Component
{
    // Propiedades del formulario
    public $nombre = '';
    public $email = '';
    public $ubicacion = '';
    public $contenido = '';
    public $calificacion = 5;

    // Control de modal y edición
    public $showModal = false;
    public $editingId = null;
    public $comentarios = [];

    // Búsqueda y filtrado
    public $search = '';
    public $filterEstado = '';

    public $estados = ['pendiente', 'publicado', 'rechazado'];

    public function mount()
    {
        $this->cargarComentarios();
    }

    public function render()
    {
        return view('livewire.comentarios-admin');
    }

    public function cargarComentarios()
    {
        $query = Comentario::query();

        if ($this->search) {
            $query->where('nombre', 'like', '%' . $this->search . '%')
                  ->orWhere('email', 'like', '%' . $this->search . '%')
                  ->orWhere('contenido', 'like', '%' . $this->search . '%');
        }

        if ($this->filterEstado) {
            $query->where('estado', $this->filterEstado);
        }

        $this->comentarios = $query->orderBy('created_at', 'desc')->get()->toArray();
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
        $this->nombre = '';
        $this->email = '';
        $this->ubicacion = '';
        $this->contenido = '';
        $this->calificacion = 5;
        $this->editingId = null;
    }

    public function edit(Comentario $comentario)
    {
        $this->editingId = $comentario->id;
        $this->nombre = $comentario->nombre;
        $this->email = $comentario->email;
        $this->ubicacion = $comentario->ubicacion;
        $this->contenido = $comentario->contenido;
        $this->calificacion = $comentario->calificacion;
        $this->showModal = true;
    }

    public function save()
    {
        $this->validate([
            'nombre' => 'required|string|max:255',
            'email' => 'required|email',
            'ubicacion' => 'nullable|string|max:255',
            'contenido' => 'required|string|min:10',
            'calificacion' => 'required|integer|min:1|max:5',
        ]);

        try {
            $data = [
                'nombre' => $this->nombre,
                'email' => $this->email,
                'ubicacion' => $this->ubicacion,
                'contenido' => $this->contenido,
                'calificacion' => $this->calificacion,
                'estado' => 'pendiente',
            ];

            if ($this->editingId) {
                $comentario = Comentario::findOrFail($this->editingId);
                $comentario->update($data);
                $this->dispatch('notify', ['message' => 'Comentario actualizado', 'type' => 'success']);
            } else {
                Comentario::create($data);
                $this->dispatch('notify', ['message' => 'Comentario creado', 'type' => 'success']);
            }

            $this->closeModal();
            $this->cargarComentarios();
        } catch (\Exception $e) {
            $this->dispatch('notify', ['message' => 'Error: ' . $e->getMessage(), 'type' => 'error']);
        }
    }

    public function aprobar(Comentario $comentario)
    {
        try {
            $comentario->update([
                'estado' => 'publicado',
                'verificado' => true,
            ]);
            $this->dispatch('notify', ['message' => 'Comentario aprobado', 'type' => 'success']);
            $this->cargarComentarios();
        } catch (\Exception $e) {
            $this->dispatch('notify', ['message' => 'Error: ' . $e->getMessage(), 'type' => 'error']);
        }
    }

    public function rechazar(Comentario $comentario)
    {
        try {
            $comentario->update([
                'estado' => 'rechazado',
                'verificado' => false,
            ]);
            $this->dispatch('notify', ['message' => 'Comentario rechazado', 'type' => 'warning']);
            $this->cargarComentarios();
        } catch (\Exception $e) {
            $this->dispatch('notify', ['message' => 'Error: ' . $e->getMessage(), 'type' => 'error']);
        }
    }

    public function delete(Comentario $comentario)
    {
        try {
            $comentario->delete();
            $this->dispatch('notify', ['message' => 'Comentario eliminado', 'type' => 'success']);
            $this->cargarComentarios();
        } catch (\Exception $e) {
            $this->dispatch('notify', ['message' => 'Error: ' . $e->getMessage(), 'type' => 'error']);
        }
    }

    public function updatedSearch()
    {
        $this->cargarComentarios();
    }

    public function updatedFilterEstado()
    {
        $this->cargarComentarios();
    }
}
