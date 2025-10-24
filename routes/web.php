<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Analytics;

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

require __DIR__.'/auth.php';
