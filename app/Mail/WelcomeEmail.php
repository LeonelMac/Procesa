<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class WelcomeEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $usuario;
    public $password;

    /**
     * Create a new message instance.
     *
     * @param  \App\Models\User  $usuario
     * @param  string  $password
     * @return void
     */
    public function __construct($usuario, $password)
    {
        $this->usuario = $usuario;
        $this->password = $password;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.welcome')
                    ->subject('Bienvenido a la Plataforma')
                    ->with([
                        'usuario' => $this->usuario,
                        'password' => $this->password,
                    ]);
    }
}

