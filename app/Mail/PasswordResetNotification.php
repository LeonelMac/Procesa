<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PasswordResetNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $usuario;
    public $nuevaPassword;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($usuario, $nuevaPassword)
    {
        $this->usuario = $usuario;
        $this->nuevaPassword = $nuevaPassword;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Su contraseña ha sido restablecida')
                    ->view('emails.password_reset_notification');
    }
}
