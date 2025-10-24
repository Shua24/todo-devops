<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\todo;

class Analytics extends Component
{

    public $totalTodos;
    public $completedTodos;
    public $incompleteTodos;
    public $completionRate;

    public function mount()
    {
        $this->totalTodos = todo::count();
        $this->completedTodos = todo::where('is_completed', true)->count();
        $this->incompleteTodos = todo::where('is_completed', false)->count();

        $this->completionRate = $this->totalTodos > 0 ?
            round(($this->completedTodos / $this->totalTodos) * 100, 2) : 0;
    }

    public function render()
    {
        return view('livewire.analytics')->layout('layouts.app');
    }
}
