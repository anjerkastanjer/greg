<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController; 
use App\Http\Controllers\PetController; 
use App\Http\Controllers\SittingRequestController;
use Illuminate\Support\Facades\Route;
use App\Models\Pet;

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

//oppasser router


// Pet-related routes
Route::resource('pets', PetController::class);
// delete huisdier/pet
Route::delete('/pets/{id}', [PetController::class, 'destroy'])->name('pets.destroy');

Route::get('/pets.index', function () {
    $pets = Pet::all();
    return view('pets.index', compact('pets')); // Create this view
})->middleware(['auth'])->name('pets.index');



// User-related routes
Route::resource('users', UserController::class);

// Additional routes for navigation

// Route::get('/all-pets', function () {
//     return view('all-pets'); // Create this view
// })->middleware(['auth'])->name('all.pets');

// Route::get('/all-sitters', function () {
//     return view('all-sitters'); // Create this view
// })->middleware(['auth'])->name('sitters.all');

// Route::get('/admin', function () {
//     return view('admin'); // Create this view
// })->middleware(['auth', 'admin'])->name('admin'); // Assuming you have an admin middleware

// // Require authentication routes
// require __DIR__.'/auth.php';