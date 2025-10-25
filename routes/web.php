<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

// Chat Routes
Route::get('/chat', App\Livewire\Chat\Index::class)
    ->middleware(['auth'])
    ->name('chat');

require __DIR__.'/auth.php';
