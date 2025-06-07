<?php

namespace App\Livewire\Zonas;

use App\Models\Zona;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ListaZonas extends Component
{
    use WithPagination;
    use AuthorizesRequests;

    protected $paginationTheme = 'simple-tailwind';

    public $showModal = false;

    public $zonaId = null;
    public $nombreZona = '';
    public $requiereVerificacion = false;

    // para eliminar
    public $selectedId = null;
    public $warningModal = false;

    protected $rules = [
        'nombreZona' => 'required|string|max:50',
        'requiereVerificacion' => 'required|boolean',
    ];

    protected $listeners = [
        'open-modal-zona' => 'abrirModal',
    ];

    public function abrirCrearZona()
    {
        $this->resetForm();
        $this->showModal = true;
    }

    public function crearZona()
    {
        $this->validate();

        Zona::create([
            'nombre' => $this->nombreZona,
            'requiere_verificacion' => $this->requiereVerificacion,
            'user_id' => Auth::id(),
        ]);

        $this->resetForm();
        $this->showModal = false;
    }

    public function editarZona($id)
    {
        $zona = Zona::findOrFail($id);

        // asegurarnos de que el usuario puede editarla
        $this->authorize('update', $zona);

        $this->zonaId = $zona->id;
        $this->nombreZona = $zona->nombre;
        $this->requiereVerificacion = $zona->requiere_verificacion;

        $this->showModal = true;
    }

    public function actualizarZona()
    {
        $this->validate();

        $zona = Zona::findOrFail($this->zonaId);
        $this->authorize('update', $zona);

        $zona->update([
            'nombre' => $this->nombreZona,
            'requiere_verificacion' => $this->requiereVerificacion,
        ]);

        $this->resetForm();
        $this->showModal = false;
    }

    public function eliminarZona($zonaId) {
        $zona = Zona::findOrFail($zonaId);
        $this->authorize('delete', $zona);

        $zona->delete();

        $this->selectedId = null;
    }

    private function resetForm()
    {
        $this->zonaId = null;
        $this->nombreZona = '';
        $this->requiereVerificacion = false;
    }

    public function render()
    {
        $usuario = Auth::user();

        $zonasCreadas = Zona::where('user_id', $usuario->id)
            ->orderBy('created_at', 'desc')
            ->paginate(3);

        $zonasCompartidas = $usuario->zonas()
            ->wherePivot('estado', 'aceptado')
            ->orderByPivot('updated_at', 'desc')
            ->paginate(3);

        return view('livewire.zonas.lista-zonas', [
            'zonasCreadas' => $zonasCreadas,
            'zonasCompartidas' => $zonasCompartidas,
        ]);
    }
}
