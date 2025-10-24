<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Analytics;
use App\Livewire\CloseTodo;

Route::view('/', 'welcome');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

Route::get('/analytics', Analytics::class)
    ->middleware(['auth'])
    ->name('analytics');

Route::get('/task/close', CloseTodo::class)
    ->middleware(['auth'])
    ->name('tasks.close');

require __DIR__.'/auth.php';
