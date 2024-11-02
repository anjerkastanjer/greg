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
Route::post('/pets', [PetController::class, 'store'])->name('pets.store');

// Sitting requests routes
Route::resource('sitting-requests', SittingRequestController::class);

// User-related routes
Route::resource('users', UserController::class);

Route::get('/alle-huisdieren', [PetController::class, 'allPets'])->name('all.pets');
