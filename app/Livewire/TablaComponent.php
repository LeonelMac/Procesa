<?php

namespace App\Livewire;

use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;
use Livewire\WithPagination;

abstract class TablaComponent extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $perPage = 10;

    public $page = 1;

    public $sortBy = '';

    public $sortDirection = 'asc';

    public $searchTerm = '';

    public $searchBy = '';

    public function render()
    {
        return view('livewire.tabla-component');
    }
    public abstract function query(): Builder;

    public abstract function columns(): array;

    public function sort($key)
    {
        $this->resetPage();

        if ($this->sortBy === $key) {
            $direction = $this->sortDirection === 'asc' ? 'desc' : 'asc';
            $this->sortDirection = $direction;

            return;
        }

        $this->sortBy = $key;
        $this->sortDirection = 'asc';
    }

    public function data()
    {
        $this->update();
        return $this
            ->query()
            ->when($this->sortBy !== '', function ($query) {
                $query->orderBy($this->sortBy, $this->sortDirection);
            })->search($this->searchBy, $this->searchTerm)
            ->paginate($this->perPage);
    }

    public function search()
    {
        $this->resetPage();
    }

    public function update()
    {
        $this->dispatch('update');
    }
}
