<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Hash; // Importa Hash para encriptar contraseñas

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    /**
     * Los atributos que se pueden asignar masivamente.
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * Los atributos que deben ocultarse para los arrays.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Los atributos que deben ser mutados a tipos nativos.
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Mutator para encriptar la contraseña automáticamente.
     */
    public function setPasswordAttribute($value)
    {
        // Solo encripta si el valor no está ya encriptado
        if (!Hash::needsRehash($value)) {
            $this->attributes['password'] = Hash::make($value);
        }
    }
}
