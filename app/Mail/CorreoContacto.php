<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class CorreoContacto extends Mailable
{
    use Queueable, SerializesModels;

    public $nombreCompleto;
    public $email;
    public $mensaje;

    /**
     * Create a new message instance.
     */
    public function __construct($nombreCompleto, $email, $mensaje)
    {
        $this->nombreCompleto = $nombreCompleto;
        $this->email = $email;
        $this->mensaje = $mensaje;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Correo Contacto',
        );
    }

    public function build() {
        return $this->subject('Correo Contacto')
            ->markdown('emails.contacto');
    }


    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
