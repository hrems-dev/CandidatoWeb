<?php

namespace App\Livewire;

use App\Models\Contacto;
use Livewire\Component;

class Contactos extends Component
{
    // Propiedades del formulario
    public $nombre = '';
    public $email = '';
    public $asunto = '';
    public $mensaje = '';
    public $telefono = '';
    public $respuesta_admin = '';

    // Control de modal y edición
    public $showModal = false;
    public $showResponderModal = false;
    public $editingId = null;
    public $contactos = [];

    // Búsqueda y filtrado
    public $search = '';
    public $filterEstado = '';

    public $estados = ['nuevo', 'respondido', 'manejado'];

    public function mount()
    {
        $this->cargarContactos();
    }

    public function render()
    {
        return view('livewire.contactos');
    }

    public function cargarContactos()
    {
        $query = Contacto::query();

        if ($this->search) {
            $query->where('nombre', 'like', '%' . $this->search . '%')
                  ->orWhere('email', 'like', '%' . $this->search . '%')
                  ->orWhere('asunto', 'like', '%' . $this->search . '%')
                  ->orWhere('mensaje', 'like', '%' . $this->search . '%');
        }

        if ($this->filterEstado) {
            $query->where('estado', $this->filterEstado);
        }

        $this->contactos = $query->orderBy('created_at', 'desc')->get();
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

    public function openResponderModal(Contacto $contacto)
    {
        $this->editingId = $contacto->id;
        $this->respuesta_admin = '';
        $this->showResponderModal = true;
    }

    public function closeResponderModal()
    {
        $this->showResponderModal = false;
        $this->respuesta_admin = '';
        $this->editingId = null;
    }

    public function resetForm()
    {
        $this->nombre = '';
        $this->email = '';
        $this->asunto = '';
        $this->mensaje = '';
        $this->telefono = '';
        $this->editingId = null;
    }

    public function edit(Contacto $contacto)
    {
        $this->editingId = $contacto->id;
        $this->nombre = $contacto->nombre;
        $this->email = $contacto->email;
        $this->asunto = $contacto->asunto;
        $this->mensaje = $contacto->mensaje;
        $this->telefono = $contacto->telefono;
        $this->showModal = true;
    }

    public function save()
    {
        $this->validate([
            'nombre' => 'required|string|max:255',
            'email' => 'required|email',
            'asunto' => 'required|string|max:255',
            'mensaje' => 'required|string',
            'telefono' => 'nullable|string|max:20',
        ]);

        try {
            $data = [
                'nombre' => $this->nombre,
                'email' => $this->email,
                'asunto' => $this->asunto,
                'mensaje' => $this->mensaje,
                'telefono' => $this->telefono,
            ];

            if ($this->editingId) {
                $contacto = Contacto::findOrFail($this->editingId);
                $contacto->update($data);
                $this->dispatch('notify', ['message' => 'Contacto actualizado correctamente', 'type' => 'success']);
            } else {
                Contacto::create($data);
                $this->dispatch('notify', ['message' => 'Contacto creado correctamente', 'type' => 'success']);
            }

            $this->closeModal();
            $this->cargarContactos();
        } catch (\Exception $e) {
            $this->dispatch('notify', ['message' => 'Error: ' . $e->getMessage(), 'type' => 'error']);
        }
    }

    public function responder()
    {
        $this->validate([
            'respuesta_admin' => 'required|string',
        ]);

        try {
            $contacto = Contacto::findOrFail($this->editingId);
            $contacto->update([
                'estado' => 'respondido',
                'respuesta_admin' => $this->respuesta_admin,
            ]);

            $this->dispatch('notify', ['message' => 'Respuesta enviada correctamente', 'type' => 'success']);
            $this->closeResponderModal();
            $this->cargarContactos();
        } catch (\Exception $e) {
            $this->dispatch('notify', ['message' => 'Error: ' . $e->getMessage(), 'type' => 'error']);
        }
    }

    public function marcarManejado(Contacto $contacto)
    {
        try {
            $contacto->update(['estado' => 'manejado']);
            $this->dispatch('notify', ['message' => 'Contacto marcado como manejado', 'type' => 'success']);
            $this->cargarContactos();
        } catch (\Exception $e) {
            $this->dispatch('notify', ['message' => 'Error: ' . $e->getMessage(), 'type' => 'error']);
        }
    }

    public function delete(Contacto $contacto)
    {
        try {
            $contacto->delete();
            $this->dispatch('notify', ['message' => 'Contacto eliminado correctamente', 'type' => 'success']);
            $this->cargarContactos();
        } catch (\Exception $e) {
            $this->dispatch('notify', ['message' => 'Error al eliminar: ' . $e->getMessage(), 'type' => 'error']);
        }
    }

    public function updatedSearch()
    {
        $this->cargarContactos();
    }

    public function updatedFilterEstado()
    {
        $this->cargarContactos();
    }
}
