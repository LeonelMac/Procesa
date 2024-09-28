<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Builder;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;
    protected $fillable = [
        'email',
        'password',
        'password_restaurada',
        'nombres',
        'apellidoP',
        'apellidoM',
        'rol',
        'municipio',
        'direccion',
        'telefono',
        'lockout_time',
        'login_attempts'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'lockout_time' => 'datetime',
    ];

    // public function setPasswordAttribute($value)
    // {
    //     if (!Hash::needsRehash($value)) {
    //         $this->attributes['password'] = Hash::make($value);
    //     }
    // }

    public function setPasswordAttribute($value)
    {
        if (!Hash::needsRehash($value)) {
            $this->attributes['password'] = $value;
        } else {
            $this->attributes['password'] = Hash::make($value);
        }
    }

    /**
     * Scope a query to search for a term in specified columns.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  array|string  $columns
     * @param  string  $term
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSearch(Builder $query, $columns, $term)
    {
        if (is_array($columns)) {
            $columns = implode(',', $columns);
        }

        return $query->where(function ($query) use ($columns, $term) {
            foreach (explode(',', $columns) as $column) {
                $query->orWhere(trim($column), 'like', "%{$term}%");
            }
        });
    }

    public function rol()
    {
        return $this->belongsTo(Rol::class, 'rol', 'id_rolusuarios');
    }

    public function municipio()
    {
        return $this->belongsTo(Municipio::class, 'municipio', 'idmunicipio');
    }
}
