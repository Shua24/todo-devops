<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\DoneTasks;
use App\Livewire\TodoDetails;
use App\Livewire\Analytics;
use App\Livewire\CloseTodo;
use App\Livewire\Notes;
use App\Livewire\NoteEdit;
Route::view('/', 'welcome');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

Route::get('/tasks/done', DoneTasks::class)
    ->middleware(['auth'])
    ->name('tasks.done');

Route::get('todos/{id}', TodoDetails::class)
    ->middleware(['auth'])
    ->name('todos.show');

Route::get('/task/close', CloseTodo::class)
    ->middleware(['auth'])
    ->name('tasks.close');

Route::get('/analytics', Analytics::class)
    ->middleware(['auth'])
    ->name('analytics');

Route::get('/notes', Notes::class)
    ->middleware(['auth'])
    ->name('notes');

Route::get('/notes/{id}/edit', NoteEdit::class)
    ->middleware('auth')
    ->name('notes.edit');

require __DIR__.'/auth.php';
