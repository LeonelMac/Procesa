<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

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
}
