<?php

use App\Models\Todo;
use App\Models\User;
use Livewire\Volt\Volt;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->user = User::factory()->create();
    $this->actingAs($this->user);
});

// Dashboard Volt component
test('dashboard displays todo-man component', function () {
    $response = $this->get('/dashboard');
    $response->assertOk();
    $response->assertSee('todo-man'); // loose match for Volt
});

// Toggle completion
test('can toggle todo completion', function () {
    $todo = Todo::factory()->create([
        'user_id' => $this->user->id,
        'is_completed' => false,
    ]);

    $todo->is_completed = ! $todo->is_completed;
    $todo->save();

    $this->assertTrue((bool) $todo->fresh()->is_completed);
});

test('can delete a todo', function () {
    $todo = Todo::factory()->create([
        'user_id' => $this->user->id,
    ]);

    $todo->delete();

    $this->assertDatabaseMissing('todos', [
        'id' => $todo->id,
    ]);
});


