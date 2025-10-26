<?php

namespace App\Livewire;

use Livewire\Component;

class TodoDetails extends Component
{
    public $todo;
    public $name;
    public $description;
    public $deadline;
    public $is_completed;

    public $editing = false; // toggle edit mode

    public function mount($id)
    {
        // Only fetch todo owned by logged-in user
        $this->todo = auth()->user()->todos()->findOrFail($id);

        // preload values
        $this->name = $this->todo->name;
        $this->description = $this->todo->description;
        $this->deadline = $this->todo->deadline;
        $this->is_completed = $this->todo->is_completed;
    }

    public function enableEdit()
    {
        $this->editing = true;
    }

    public function cancelEdit()
    {
        $this->editing = false;
    }

    public function save()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'deadline' => 'nullable|date',
            'is_completed' => 'boolean',
        ]);

        $this->todo->update([
            'name' => $this->name,
            'description' => $this->description,
            'deadline' => $this->deadline,
            'is_completed' => $this->is_completed,
        ]);

        $this->editing = false;

        session()->flash('message', 'Todo updated successfully!');
    }

    public function render()
    {
        return view('livewire.todo-details')
            ->layout('layouts.app');
    }
}
