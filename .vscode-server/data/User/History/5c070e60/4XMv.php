<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController; 
use App\Http\Controllers\PetController; 
use App\Http\Controllers\SittingRequestController;
use Illuminate\Support\Facades\Route;

// Home route
Route::get('/', function () {
    return view('welcome');
});

// Dashboard route
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Profile routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
Route::get('/all-sitters', [SitterController::class, 'showAllSitters'])->name('sitters.all');
// Pet-related routes
Route::get('/jouw-huisdieren', [PetController::class, 'index'])->name('your.pets');
// route om de submit knop van pet toe te voegen te storen in de database


// Sitting requests routes
Route::resource('sitting-requests', SittingRequestController::class);

// User-related routes
Route::resource('users', UserController::class);


Route::get('/all-pets', function () {
    return view('all.pets'); // Create this view
})->middleware(['auth'])->name('all.pets'); // Corrected to match the navigation link

Route::get('/all-sitters', function () {
    return view('all-sitters'); // Create this view
})->middleware(['auth'])->name('sitters.all'); // Corrected to match the navigation link

Route::get('/admin', function () {
    return view('admin'); // Create this view
})->middleware(['auth', 'admin'])->name('admin'); // Assuming you have an admin middleware

// Require authentication routes
require __DIR__.'/auth.php';

// Ensure the file ends properly with no extra characters or whitespace
