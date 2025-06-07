<?php

namespace App\Livewire\Zonas;

use Livewire\Component;
use App\Models\Zona;
use Illuminate\Support\Facades\Auth;

class DetalleZona extends Component
{
    public $zona;

    protected $listeners = [
        'zonaActualizada' => '$refresh',
    ];

    /**
     * Recibe la instancia de Zona inyectada desde la vista.
     */
    public function mount(Zona $zona)
    {
        $this->zona = $zona;
    }

    /**
     * Método que ejecuta la "solicitud de acceso":
     * Si el usuario no estaba en el pivote, lo añade con estado 'pendiente' y fecha_solicitud = now().
     */
    public function solicitarAcceso()
    {
        $user = Auth::user();

        // si ya existe un registro pivote (pendiente o denegado), no hacemos nada
        if ($this->zona->usuarios()->where('user_id', $user->id)->exists()) {
            return;
        }

        $this->zona->usuarios()->attach($user->id, [
            'estado' => 'pendiente',
            'fecha_solicitud' => now(),
        ]);

        $this->zona->refresh();

        $this->dispatch('zonaActualizada');
    }

    public function render()
    {
        $this->zona->load('creador', 'usuarios');

        return view('livewire.zonas.detalle-zona', [
            'zona' => $this->zona,
        ]);
    }
}
