<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Note;
use Illuminate\Support\Facades\Auth;

class NoteEdit extends Component
{
    public $noteId;
    public $title;
    public $content;

    protected $rules = [
        'content' => 'required|string|max:1000',
        'title' => 'nullable|string|max:255',
    ];

    public function mount($id)
    {
        // Load the note, scoped to the authenticated user
        $note = Auth::user()->notes()->findOrFail($id);

        $this->noteId = $note->id;
        $this->title = $note->title;
        $this->content = $note->content;
    }

    public function save()
    {
        $this->validate();

        $note = Auth::user()->notes()->findOrFail($this->noteId);
        $note->update([
            'title' => $this->title,
            'content' => $this->content,
        ]);

        session()->flash('message', 'Note updated successfully.');

        return redirect()->route('notes'); // redirect back to notes list
    }

    public function render()
    {
        return view('livewire.note-edit')->layout('layouts.app');
    }
}

