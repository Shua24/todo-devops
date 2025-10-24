<?php

namespace App\Livewire;

use Livewire\Component;
use Carbon\Carbon;
use App\Models\todo;

class CloseTodo extends Component
{
    public $todos;

    public function toggleCompleted(int $id)
    {
        $todo = Todo::findOrFail($id);
        $this->authorize('update', $todo);

        $todo->is_completed = ! $todo->is_completed;
        $todo->save();

        $this->mount();
    }


    public function deleteTodo(int $id)
    {
        $todo = Todo::find($id);
        $this->authorize('delete', $todo);
        $todo->delete();

        $this->mount();
    }



    public function mount()
    {
        $today = Carbon::today();
        $aWeekLater = $today->copy()->addWeek();

        $this->todos = auth()->user()->todos()
            ->where(function($query) use ($today, $aWeekLater) {
                $query->where('deadline', '<', $today) // overdue
                      ->orWhereBetween('deadline', [$today, $aWeekLater]); // due within next week
            })
            ->orderBy('deadline', 'asc')
            ->get();
    }

    public function render()
    {
        return view('livewire.close-todo')->layout('layouts.app');
    }
}

