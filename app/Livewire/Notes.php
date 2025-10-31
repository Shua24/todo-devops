<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\Note;

class Notes extends Component
{
    public $notes;
    public $title;
    public $content;
    public $editId = null;
    public $showDeleteModal = false;
    public $noteToDelete;

    protected $rules = [
        'content' => 'required|string|max:1000',
        'title' => 'nullable|string|max:255',
    ];

    public function mount()
    {
        $this->loadNotes();
    }

    public function loadNotes()
    {
        // Load only the authenticated user's notes
        $this->notes = Auth::user()->notes()->latest()->get();
    }

    public function saveNote()
    {
        $this->validate();

        if ($this->editId) {
            $note = Auth::user()->notes()->findOrFail($this->editId);
            $note->update([
                'title' => $this->title,
                'content' => $this->content,
            ]);
            $this->editId = null;
        } else {
            // Create a new note for the authenticated user
            Auth::user()->notes()->create([
                'title' => $this->title,
                'content' => $this->content,
            ]);
        }

        $this->title = '';
        $this->content = '';
        $this->loadNotes();
    }

    public function editNote(int $id)
    {
        $note = Note::findOrFail($id);
        $this->authorize('update', $note);

        $this->editId = $note->id;
        $this->title = $note->title;
        $this->content = $note->content;
    }

    public function cancelDelete()
    {
        $this->noteToDelete = null;
        $this->dispatch('close-modal', id: 'confirm-note-deletion');
    }


    public function deleteNote(int $id)
    {
        $noteToDelete = Note::findOrFail($id);
        $this->authorize('delete', $noteToDelete);

        $noteToDelete->delete();
        $this->sanitize();
        $this->loadNotes();
    }

    public function confirmDelete($id)
    {
        $this->noteToDelete = $id;
        $this->showDeleteModal = true;
        $this->sanitize();
    }

    public function sanitize()
    {
        $this->noteToDelete = null;
        $this->showDeleteModal = false;
    }

    public function goToEdit($id)
    {
        return redirect()->route('notes.edit', $id);
    }

    public function render()
    {
        return view('livewire.notes')->layout('layouts.app');
    }
}
