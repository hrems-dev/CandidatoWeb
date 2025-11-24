<?php

namespace App\Livewire;

use App\Models\Cita;
use App\Events\CitaActualizada;
use Livewire\Component;

class Citas extends Component
{
    // Propiedades del formulario
    public $nombre = '';
    public $email = '';
    public $telefono = '';
    public $tipo_consulta = '';
    public $descripcion = '';
    public $ubicacion = '';
    public $documento_identidad = '';
    public $fecha_cita = '';
    public $hora_cita = '';
    public $motivo_rechazo = '';

    // Control de modal y edición
    public $showModal = false;
    public $showReprogramarModal = false;
    public $showAceptarModal = false;
    public $showRechazarModal = false;
    public $editingId = null;
    public $citas = [];

    // Búsqueda y filtrado
    public $search = '';
    public $filterEstado = '';

    public $estados = ['pendiente', 'aceptada', 'rechazada', 'completada', 'cancelada', 'reprogramada'];
    public $tipos = ['asesoría legal', 'trámite administrativo', 'defensa penal', 'derechos laborales', 'familia', 'otro'];

    public function mount()
    {
        $this->cargarCitas();
    }

    public function render()
    {
        return view('livewire.citas');
    }

    public function cargarCitas()
    {
        $query = Cita::query();

        if ($this->search) {
            $query->where('nombre', 'like', '%' . $this->search . '%')
                  ->orWhere('email', 'like', '%' . $this->search . '%')
                  ->orWhere('descripcion', 'like', '%' . $this->search . '%');
        }

        if ($this->filterEstado) {
            $query->where('estado', $this->filterEstado);
        }

        $this->citas = $query->orderBy('created_at', 'desc')->get()->toArray();
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
        $this->telefono = '';
        $this->tipo_consulta = '';
        $this->descripcion = '';
        $this->ubicacion = '';
        $this->documento_identidad = '';
        $this->fecha_cita = '';
        $this->hora_cita = '';
        $this->motivo_rechazo = '';
        $this->editingId = null;
    }

    public function edit(Cita $cita)
    {
        $this->editingId = $cita->id;
        $this->nombre = $cita->nombre;
        $this->email = $cita->email;
        $this->telefono = $cita->telefono;
        $this->tipo_consulta = $cita->tipo_consulta;
        $this->descripcion = $cita->descripcion;
        $this->ubicacion = $cita->ubicacion;
        $this->documento_identidad = $cita->documento_identidad;
        $this->fecha_cita = $cita->fecha_cita?->format('Y-m-d') ?? '';
        $this->hora_cita = $cita->hora_cita ?? '';
        $this->showModal = true;
    }

    public function save()
    {
        $this->validate([
            'nombre' => 'required|string|max:255',
            'email' => 'required|email',
            'telefono' => 'required|string|max:20',
            'tipo_consulta' => 'required|string',
            'descripcion' => 'required|string',
            'ubicacion' => 'nullable|string|max:255',
            'documento_identidad' => 'nullable|string|max:50',
        ]);

        try {
            $data = [
                'nombre' => $this->nombre,
                'email' => $this->email,
                'telefono' => $this->telefono,
                'tipo_consulta' => $this->tipo_consulta,
                'descripcion' => $this->descripcion,
                'ubicacion' => $this->ubicacion,
                'documento_identidad' => $this->documento_identidad,
                'estado' => 'pendiente',
            ];

            if ($this->editingId) {
                $cita = Cita::findOrFail($this->editingId);
                $cita->update($data);
                $this->dispatch('notify', ['message' => 'Cita actualizada correctamente', 'type' => 'success']);
            } else {
                Cita::create($data);
                $this->dispatch('notify', ['message' => 'Cita creada correctamente', 'type' => 'success']);
            }

            $this->closeModal();
            $this->cargarCitas();
        } catch (\Exception $e) {
            $this->dispatch('notify', ['message' => 'Error: ' . $e->getMessage(), 'type' => 'error']);
        }
    }

    public function delete(Cita $cita)
    {
        try {
            $cita->delete();
            $this->dispatch('notify', ['message' => 'Cita eliminada correctamente', 'type' => 'success']);
            $this->cargarCitas();
        } catch (\Exception $e) {
            $this->dispatch('notify', ['message' => 'Error al eliminar: ' . $e->getMessage(), 'type' => 'error']);
        }
    }

    public function aceptarCita(Cita $cita)
    {
        try {
            $this->validate([
                'fecha_cita' => 'required|date',
                'hora_cita' => 'required|date_format:H:i',
            ]);

            $cita->update([
                'estado' => 'aceptada',
                'fecha_cita' => $this->fecha_cita,
                'hora_cita' => $this->hora_cita,
                'fecha_respuesta_admin' => now(),
            ]);

            CitaActualizada::dispatch($cita, 'aceptada');
            $this->dispatch('notify', ['message' => '✓ Cita aceptada correctamente', 'type' => 'success']);
            $this->cargarCitas();
            $this->closeAceptarModal();
        } catch (\Exception $e) {
            $this->dispatch('notify', ['message' => 'Error: ' . $e->getMessage(), 'type' => 'error']);
        }
    }

    public function abrirAceptarModal(Cita $cita)
    {
        $this->editingId = $cita->id;
        $this->fecha_cita = '';
        $this->hora_cita = '';
        $this->showAceptarModal = true;
    }

    public function closeAceptarModal()
    {
        $this->showAceptarModal = false;
        $this->resetForm();
    }

    public function rechazarCita(Cita $cita)
    {
        try {
            $this->validate([
                'motivo_rechazo' => 'required|string',
            ]);

            $cita->update([
                'estado' => 'rechazada',
                'motivo_rechazo' => $this->motivo_rechazo,
                'fecha_respuesta_admin' => now(),
            ]);

            CitaActualizada::dispatch($cita, 'rechazada');
            $this->dispatch('notify', ['message' => '✗ Cita rechazada', 'type' => 'warning']);
            $this->cargarCitas();
            $this->closeRechazarModal();
        } catch (\Exception $e) {
            $this->dispatch('notify', ['message' => 'Error: ' . $e->getMessage(), 'type' => 'error']);
        }
    }

    public function abrirRechazarModal(Cita $cita)
    {
        $this->editingId = $cita->id;
        $this->motivo_rechazo = '';
        $this->showRechazarModal = true;
    }

    public function closeRechazarModal()
    {
        $this->showRechazarModal = false;
        $this->resetForm();
    }

    public function abrirReprogramarModal(Cita $cita)
    {
        $this->editingId = $cita->id;
        $this->fecha_cita = $cita->fecha_cita?->format('Y-m-d') ?? '';
        $this->hora_cita = $cita->hora_cita ?? '';
        $this->showReprogramarModal = true;
    }

    public function reprogramarCita(Cita $cita)
    {
        try {
            $this->validate([
                'fecha_cita' => 'required|date',
                'hora_cita' => 'required|date_format:H:i',
            ]);

            // Guardar datos anteriores
            $datosAnteriores = [
                'fecha_anterior' => $cita->fecha_cita?->format('Y-m-d'),
                'hora_anterior' => $cita->hora_cita,
                'fecha_reprogramacion' => now()->format('Y-m-d H:i:s'),
            ];

            $datosReprogramacion = is_array($cita->datos_reprogramacion) ? $cita->datos_reprogramacion : [];
            $datosReprogramacion[] = $datosAnteriores;

            $cita->update([
                'estado' => 'reprogramada',
                'fecha_cita' => $this->fecha_cita,
                'hora_cita' => $this->hora_cita,
                'datos_reprogramacion' => $datosReprogramacion,
            ]);

            CitaActualizada::dispatch($cita, 'reprogramada');
            $this->dispatch('notify', ['message' => 'Cita reprogramada correctamente', 'type' => 'success']);
            $this->showReprogramarModal = false;
            $this->cargarCitas();
        } catch (\Exception $e) {
            $this->dispatch('notify', ['message' => 'Error: ' . $e->getMessage(), 'type' => 'error']);
        }
    }

    public function updatedSearch()
    {
        $this->cargarCitas();
    }

    public function updatedFilterEstado()
    {
        $this->cargarCitas();
    }
}
