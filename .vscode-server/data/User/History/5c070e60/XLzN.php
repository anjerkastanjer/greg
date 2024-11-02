<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController; 
use App\Http\Controllers\PetController; 
use App\Http\Controllers\SittingRequestController;
use App\Http\Controllers\SitterController; // Don't forget to include the SitterController
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

// Admin route
Route::get('/admin', function () {
    return view('admin.dashboard'); // Ensure you have this view created
})->middleware(['auth', 'admin'])->name('admin'); // Adjust middleware as needed

// All sitters route
Route::get('/all-sitters', [SitterController::class, 'showAllSitters'])->name('sitters.all');

// Pet-related routes
Route::get('/jouw-huisdieren', [PetController::class, 'index'])->name('your.pets');

// Route to store a newly created pet
Route::post('/pets', [PetController::class, 'store'])->name('pets.store');

// Sitting requests routes
Route::resource('sitting-requests', SittingRequestController::class);

// User-related routes
Route::resource('users', UserController::class);

// Route for all pets
Route::get('/alle-huisdieren', [PetController::class, 'allPets'])->name('all.pets');
