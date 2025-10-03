<?php

use Livewire\Volt\Component;
use App\Models\todo;
use Illuminate\Support\Facades\Auth;

new class extends Component {
    public todo $todo;
    public string $todoName = '';

    public function createTodo()
    {
        $this->validate([
            'todoName' => 'required|min:3',
        ]);

        Auth::user()
            ->todos()
            ->create([
                'name' => $this->pull('todoName'),
            ]);
    }

    public function deleteTodo(int $id)
    {
        $todo = Todo::find($id);
        $this->authorize('delete', $todo);
        $todo->delete();
    }

    public function with()
    {
        return [
            'todos' => Todo::all(),
        ];
    }
}; ?>

<div>
    <form wire:submit="createTodo" class="mb-4 flex gap-2">
        <x-text-input wire:model="todoName"/>
        <x-primary-button type="submit">Tambah</x-primary-button>
        <x-input-error :messages="$errors->get('todoName')" class="mt-3"/>
    </form>
    @foreach ($todos as $todo)
        <div wire:key='{{ $todo->id }}' class="flex items-center space-x-4 space-y-4" >
            {{ $todo->name }}
        </div>
        <div>
            <button wire:click="deleteTodo({{ $todo->id }})" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                Hapus
        </div>
    @endforeach
</div>
