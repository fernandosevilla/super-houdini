<?php

namespace App\Livewire;

use App\Mail\CorreoContacto;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;

class Formulario extends Component
{
    public $nombreCompleto;
    public $email;
    public $mensaje;

    protected $rules = [
        'nombreCompleto' => 'required|string|min:3|max:100',
        'email' => 'required|email|max:100',
        'mensaje' => 'required|string|min:10|max:255',
    ];


    public function enviar()
    {
        $this->validate();

        Mail::to(config('mail.from.address'))
            ->send(new CorreoContacto($this->nombreCompleto, $this->email, $this->mensaje));

        $this->reset();
    }

    public function render()
    {
        return view('livewire.formulario');
    }
}
