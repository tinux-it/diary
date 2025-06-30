<?php

use App\Http\Controllers\BlogController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Route::get('/', [BlogController::class, 'index'])->name('home');

// Public blog post viewing (no auth required)
Route::get('post/{blogPost}', [BlogController::class, 'showPublic'])->name('blog.show.public');

Route::get('dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    // Blog routes (private dashboard)
    Route::get('blog/create', [BlogController::class, 'create'])->name('blog.create');
    Route::post('blog/store', [BlogController::class, 'store'])->name('blog.store');
    Route::get('blog/{blogPost}', [BlogController::class, 'show'])->name('blog.show');
    Route::get('blog/{blogPost}/edit', [BlogController::class, 'edit'])->name('blog.edit');
    Route::put('blog/{blogPost}', [BlogController::class, 'update'])->name('blog.update');
    Route::delete('blog/{blogPost}', [BlogController::class, 'destroy'])->name('blog.destroy');
    Route::patch('blog/{blogPost}/toggle-visibility', [BlogController::class, 'toggleVisibility'])->name('blog.toggle-visibility');

    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');
});

require __DIR__.'/auth.php';
