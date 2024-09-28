<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Juzgado extends Model
{
    use HasFactory;
    protected $table = 'juzgados';
    protected $primaryKey = 'idjuzgados';
    protected $fillable = ['idjuzgados', 'juzgados', 'distrito'];

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

    public function distrito()
    {
        return $this->belongsTo(Distrito::class, 'distrito', 'iddistrito');
    }
}
