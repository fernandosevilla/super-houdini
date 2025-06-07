<?php

namespace App\Livewire\Credenciales;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Credencial;
use App\Models\Zona;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Gate;

class ListaCredenciales extends Component
{
    use WithPagination;

    protected $paginationTheme = 'simple-tailwind';

    // parámetro que recibe el ID de la zona desde DetalleZona
    public $zonaId;

    // campos del formulario (crear/editar)
    public $nombreSitio;
    public $nombreUsuario;
    public $contrasenia;
    public $url;
    public $notas;
    public $rotacionCadaDias = 5;

    // para distinguir si estamos creando o editando
    public $editingId = null;

    // validaciones
    protected $rules = [
        'nombreSitio' => 'required|string|max:100',
        'nombreUsuario' => 'nullable|string|max:100',
        'contrasenia' => 'required|string',
        'url' => 'nullable|url|max:255',
        'notas' => 'nullable|string',
        'rotacionCadaDias' => 'nullable|integer|min:1|max:45',
    ];

    protected $listeners = [
        'refreshCredenciales' => '$refresh',
    ];

    public function mount($zonaId)
    {
        $this->zonaId = $zonaId;
    }

    /**
     * Abre el modal para crear una nueva credencial
     */
    public function abrirModalCrear()
    {
        $this->resetValidation();
        $this->reset(['nombreSitio', 'nombreUsuario', 'contrasenia', 'url', 'notas', 'rotacionCadaDias', 'editingId']);

        $this->dispatch('open-modal-credencial');
    }

    /**
     * Abre el modal para editar una credencial existente
     */
    public function abrirModalEditar($id)
    {
        $this->resetValidation();
        $cred = Credencial::findOrFail($id);

        if (!Gate::allows('view', $cred)) {
            abort(403);
        }

        $this->editingId = $id;
        $this->nombreSitio = $cred->nombre_sitio;
        $this->nombreUsuario = $cred->nombre_usuario;
        $this->contrasenia = Crypt::decryptString($cred->contrasenia);
        $this->url = $cred->url;
        $this->notas = $cred->notas;
        $this->rotacionCadaDias = $cred->rotacion_cada_dias;

        $this->dispatch('open-modal-credencial');
    }

    /**
     * Guarda la credencial (crea o actualiza dependiendo de $editingId).
     */
    public function guardarCredencial()
    {
        $this->validate();

        $zona = Zona::findOrFail($this->zonaId);

        if (!Gate::allows('view', $zona)) {
            abort(403);
        }

        $encrypted = Crypt::encryptString($this->contrasenia);

        $data = [
            'zona_id' => $this->zonaId,
            'nombre_sitio' => $this->nombreSitio,
            'nombre_usuario' => $this->nombreUsuario,
            'contrasenia' => $encrypted,
            'url' => $this->url,
            'notas' => $this->notas,
            'rotacion_cada_dias' => $this->rotacionCadaDias,
            'ultima_consulta' => now(),
            'fecha_ultima_rotacion'=> now(),
        ];

        if ($this->editingId) {
            $cred = Credencial::findOrFail($this->editingId);

            if (!Gate::allows('update', $cred)) {
                abort(403);
            }

            $cred->update($data);
        } else {
            $data['creado_por'] = Auth::id();
            Credencial::create($data);
        }

        // cierra modal y limpia campos
        $this->dispatch('close-modal-credencial');
        $this->reset(['nombreSitio', 'nombreUsuario', 'contrasenia', 'url', 'notas', 'rotacionCadaDias', 'editingId']);

        $this->dispatch('refreshCredenciales');
    }

    /**
     * Elimina la credencial tras verificar permiso delete.
     * Luego emite internamente refreshCredenciales.
     */
    public function eliminarCredencial($id)
    {
        $cred = Credencial::findOrFail($id);

        if (!Gate::allows('delete', $cred)) {
            abort(403);
        }

        $cred->delete();

        $this->dispatch('refreshCredenciales');
    }

    public function render()
    {
        $zona = Zona::findOrFail($this->zonaId);

        if (!Gate::allows('view', $zona)) {
            abort(403);
        }

        $credenciales = Credencial::where('zona_id', $this->zonaId)
            ->orderBy('created_at', 'desc')
            ->paginate(6);

        return view('livewire.credenciales.lista-credenciales', [
            'credenciales' => $credenciales,
            'zona' => $zona,
        ]);
    }
}
