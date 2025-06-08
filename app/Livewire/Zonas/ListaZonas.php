<?php

namespace App\Livewire\Zonas;

use App\Models\Zona;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Str;
use App\Models\EnlaceTemporal;

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


    // para compartir
    public $currentInvitationId = null;
    public $shareModalIsOpen = false;
    public $shareLink = '';
    public $shareExpiry = '';

    public $shareValidityDays = 7;

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

    public function abrirCompartirZona($zonaId) {
        $this->selectedId = $zonaId;
        $this->shareLink = '';
        $this->shareExpiry = '';
        $this->shareValidityDays = 1;
        $this->currentInvitationId = null;

        $this->generarEnlaceZona();

        $this->shareModalIsOpen = true;
    }

    public function generarEnlaceZona()
    {
        // Si ya existe, lo recuperamos
        if ($this->currentInvitationId) {
            $inv = EnlaceTemporal::findOrFail($this->currentInvitationId);
            $inv->update([
                'expira_en' => now()->addDays($this->shareValidityDays),
                'usado' => false,
            ]);
        } else {
            $token = Str::random(40);

            $inv = EnlaceTemporal::create([
                'zona_id' => $this->selectedId,
                'token' => $token,
                'expira_en' => now()->addDays($this->shareValidityDays),
                'usado' => false,
            ]);

            $this->currentInvitationId = $inv->id;
        }

        $this->shareLink = route('zonas.invitar.aceptar', $inv->token);
        $this->shareExpiry = $inv->expira_en->format('d/m/Y H:i');
    }

    public function incrementarDias()
    {
        $this->shareValidityDays = min(10, $this->shareValidityDays + 1);
        $this->generarEnlaceZona();
    }

    public function decrementarDias()
    {
        $this->shareValidityDays = max(1, $this->shareValidityDays - 1);
        $this->generarEnlaceZona();
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

    public function getSolicitudesPendientesProperty() {
        return Zona::where('user_id', Auth::id())
            ->whereHas('usuarios', fn($q) => $q->where('estado', 'pendiente'))
            ->with(['usuarios' => fn($q) => $q->where('estado', 'pendiente')])
            ->get();
    }

    public function responderSolicitud($zonaId, $userId, $respuesta)
    {
        $zona = Zona::findOrFail($zonaId);
        $this->authorize('update', $zona);

        if ($respuesta === 'rechazado') {
            $zona->usuarios()->detach($userId);
        } else {
            $zona->usuarios()->updateExistingPivot($userId, [
                'estado' => 'aceptado',
                'fecha_respuesta' => now(),
            ]);
        }
    }

    public function salirZona(int $zonaId)
    {
        $zona = Zona::findOrFail($zonaId);

        $this->authorize('view', $zona);

        $zona->usuarios()->detach(Auth::id());
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

        $solicitudesPendientes = Zona::where('user_id', $usuario->id)
            ->whereHas('usuarios', fn($q) => $q->where('estado', 'pendiente'))
            ->with(['usuarios' => fn($q) => $q->where('estado', 'pendiente')])
            ->paginate(3);


        return view('livewire.zonas.lista-zonas', [
            'zonasCreadas' => $zonasCreadas,
            'zonasCompartidas' => $zonasCompartidas,
            'solicitudesPendientes' => $solicitudesPendientes,
        ]);
    }
}
