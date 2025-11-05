<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ResumeController;

// Redirect root to login
Route::get('/', function () {
    return redirect()->route('login');
});

// Authenticated routes
Route::middleware(['auth'])->group(function () {

    // Dashboard
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Edit Resume (private)
    Route::get('/resume/edit', [ResumeController::class, 'edit'])->name('resume.edit');
    Route::put('/resume/update', [ResumeController::class, 'update'])->name('resume.update');
});

// Public Resume View
Route::get('/resume/{id}', [ResumeController::class, 'show'])->name('resume.public'); // <- changed name

// Include auth routes
require __DIR__.'/auth.php';
