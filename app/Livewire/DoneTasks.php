<?php

namespace App\Livewire;

use Livewire\Component;

class DoneTasks extends Component
{
    public function render()
    {
        return view('livewire.done-tasks', [
            'todos' => auth()->user()->todos()->where('is_completed', 1)->get(),
        ])->layout('layouts.app');
    }
}
