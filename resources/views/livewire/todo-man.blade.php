<?php

use Livewire\Volt\Component;
use App\Models\todo;
use Illuminate\Support\Facades\Auth;

new class extends Component {
    public todo $todo;
    public string $todoName = '';
    public string $deadline = '';

    public function createTodo()
    {
        $this->validate([
            'todoName' => 'required|min:3',
            'deadline' => 'required|date|after:today',
        ]);

        Auth::user()->todos()->create([
                'name' => $this->pull('todoName'),
                'deadline' => $this->pull('deadline'),
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
            'todos' => Auth::user()->todos()->get(),
        ];
    }
}; ?>

<div>
    <form wire:submit="createTodo" class="mb-4 flex gap-2">
        <x-text-input wire:model="todoName"/>
        <x-text-input type="date" wire:model="deadline"/>
        <x-primary-button type="submit">Tambah</x-primary-button>
        <x-input-error :messages="$errors->get('todoName')" class="mt-3"/>
        <x-input-error :messages="$errors->get('deadline')" class="mt-3"/>
    </form>
    <table class="min-w-full divide-y divide-gray-200">
        <thead>
            <tr>
                <th class="px-4 py-2 text-left">Nama Todo</th>
                <th class="px-4 py-2 text-left">Deadline</th>
                <th class="px-4 py-2 text-left">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($todos as $todo)
                <tr wire:key="{{ $todo->id }}">
                    <td class="px-4 py-2">{{ $todo->name }}</td>
                    <td class="px-4 py-2">
                        {{ \Carbon\Carbon::parse($todo->deadline)->format('d-m-Y') }}
                    </td>
                    <td class="px-4 py-2">
                        <button wire:click="deleteTodo({{ $todo->id }})" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                            Hapus
                        </button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
