<?php

use App\Models\User;
use App\Models\Note;
use App\Livewire\Notes;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;

uses(RefreshDatabase::class);

test('shows the user notes on the notes page', function () {
    $user = User::factory()
        ->has(Note::factory()->count(3))
        ->create();

    $this->actingAs($user)
        ->get('/notes')
        ->assertOk()
        ->assertSee($user->notes->first()->title)
        ->assertSee($user->notes->last()->title);
});

test('lets a user create a note via Livewire', function () {
    $user = User::factory()->create();

    $this->actingAs($user);

    Livewire::test(Notes::class)
        ->set('title', 'My first note')
        ->set('content', 'This is a test note.')
        ->call('saveNote');

    expect(Note::where('title', 'My first note')->exists())->toBeTrue();
});

test('lets a user edit their note via Livewire', function () {
    $user = User::factory()->create();
    $note = Note::factory()->for($user)->create([
        'title' => 'Old title',
        'content' => 'Old content',
    ]);

    $this->actingAs($user);

    Livewire::test(Notes::class)
        ->call('editNote', $note->id)
        ->set('title', 'Updated title')
        ->set('content', 'Updated content')
        ->call('saveNote')
        ->assertHasNoErrors();

    $updatedNote = Note::find($note->id);

    expect($updatedNote->title)->toBe('Updated title');
    expect($updatedNote->content)->toBe('Updated content');
});

test('prevents a user from editing someone else’s note', function () {
    $user = User::factory()->create();
    $otherUser = User::factory()->create();
    $note = Note::factory()->for($otherUser)->create();

    $this->actingAs($user);

    Livewire::test(Notes::class)
        ->call('editNote', $note->id)
        ->assertForbidden();
});


test('lets a user delete their note via Livewire', function () {
    $user = User::factory()->create();
    $note = Note::factory()->for($user)->create();

    $this->actingAs($user);

    Livewire::test(Notes::class)
        ->call('deleteNote', $note->id)
        ->assertHasNoErrors();

    expect(Note::where('id', $note->id)->exists())->toBeFalse();
});

test('prevents a user from deleting someone else’s note', function () {
    $user = User::factory()->create();
    $otherUser = User::factory()->create();
    $note = Note::factory()->for($otherUser)->create();

    $this->actingAs($user);

    Livewire::test(Notes::class)
        ->call('deleteNote', $note->id)
        ->assertForbidden();

    expect(Note::where('id', $note->id)->exists())->toBeTrue();
});
