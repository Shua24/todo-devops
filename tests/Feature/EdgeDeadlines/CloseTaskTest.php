<?php

use App\Models\User;
use App\Models\Todo;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use App\Livewire\CloseTodo;

uses(RefreshDatabase::class);

test('renders the CloseTodo page for authenticated users', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->get(route('tasks.close'))
        ->assertStatus(200)
        ->assertSee('Kegiatan yang Tenggat Waktunya Seminggu dan yang Sudah Terlambat');
});

test('shows overdue and due-this-week tasks', function () {
    $user = User::factory()->create();

    // Task overdue
    $overdue = Todo::factory()->create([
        'user_id' => $user->id,
        'name' => 'Overdue Task',
        'deadline' => now()->subDays(2),
    ]);

    // Task due this week
    $thisWeek = Todo::factory()->create([
        'user_id' => $user->id,
        'name' => 'This Week Task',
        'deadline' => now()->addDays(3),
    ]);

    // Task due after a week
    $future = Todo::factory()->create([
        'user_id' => $user->id,
        'name' => 'Future Task',
        'deadline' => now()->addDays(10),
    ]);

    Livewire::actingAs($user)
        ->test('close-todo')
        ->assertSee('Overdue Task')
        ->assertSee('This Week Task')
        ->assertDontSee('Future Task');
});

test('can toggle a task as completed', function () {
    $user = User::factory()->create();

    // Task must have a deadline today or within a week (cannot be overdue)
    $task = Todo::factory()->create([
        'user_id' => $user->id,
        'name' => 'Toggle Task',
        'is_completed' => 0,
        'deadline' => now()->addDays(3), // safely within the "due this week" range
    ]);

    // Toggle the task as completed
    Livewire::actingAs($user)
        ->test(CloseTodo::class)
        ->call('toggleCompleted', $task->id)
        ->assertSee('Toggle Task'); // visible in the list

    // Verify database updated
    expect((bool) $task->fresh()->is_completed)->toBeTrue();

    // Toggle back to incomplete
    Livewire::actingAs($user)
        ->test(CloseTodo::class)
        ->call('toggleCompleted', $task->id);

    expect((bool) $task->fresh()->is_completed)->toBeFalse();
});

test('can delete a task', function () {
    $user = User::factory()->create();

    $task = Todo::factory()->create([
        'user_id' => $user->id,
    ]);

    Livewire::actingAs($user)
        ->test('close-todo')
        ->call('deleteTodo', $task->id)
        ->assertDontSee($task->name);

    expect(Todo::find($task->id))->toBeNull();
});

test('guests cannot access the CloseTodo page', function () {
    $this->get(route('tasks.close'))
        ->assertRedirect(route('login'));
});
