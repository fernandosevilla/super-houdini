<?php

namespace App\Livewire\Inicio;

use App\Models\Zona;
use App\Models\Credencial;
use App\Models\Rotacion;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Resumen extends Component
{
    public $totalZonas;
    public $totalZonasCompartidas;
    public $totalCredenciales;
    // public $totalRotaciones;

    public function mount()
    {
        $this->totalZonas = Zona::where('user_id', Auth::id())->count();

        $this->totalZonasCompartidas = Zona::where('user_id', '!=', Auth::id())
            ->whereHas('usuarios', function ($q) {
                $q->where('user_id', Auth::id());
            })
            ->count();

        $this->totalCredenciales = Credencial::where(function ($query) {
            $query->where('user_id', Auth::id())
                ->orWhereHas('zona', function ($q) {
                    $q->where('user_id', Auth::id());
                })
                ->orWhereHas('zona.usuarios', function ($q) {
                    $q->where('user_id', Auth::id());
                });
        })->count();
        // $this->totalRotaciones = Rotacion::count();
    }

    public function render()
    {
        return view('livewire.inicio.resumen');
    }
}
