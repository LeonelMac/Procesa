<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    // Nombre de la tabla, por si acaso
    protected $table = 'events'; 

    // Campos asignables en la base de datos
    protected $fillable = [
        'title',
        'description',
        'location',
        'start',
        'end',
        'all_day',
        'backgroundColor',
        'repetition_id',
        'repetition_type',
    ];

    /**
     * Relación opcional si un evento tiene eventos relacionados por repetición.
     */
    public function parentEvent()
    {
        return $this->belongsTo(Event::class, 'repetition_id');
    }

    public function childEvents()
    {
        return $this->hasMany(Event::class, 'repetition_id');
    }
}
