<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController; 
use App\Http\Controllers\PetController; 
use App\Http\Controllers\SittingRequestController;
use App\Http\Controllers\OppasserController;
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

// alle oppassers pagina route
Route::get('/oppassers', function () {
    return view('Oppassers'); 
})->middleware(['auth'])->name('oppassers');

// Profile routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Oppasser routes
Route::middleware(['auth'])->group(function () {
    Route::get('/oppasser/create', [OppasserController::class, 'create'])->name('oppasser.create');
    Route::post('/oppasser', [OppasserController::class, 'store'])->name('oppasser.store');
    Route::get('/dashboard', [OppasserController::class, 'dashboard'])->middleware(['auth', 'verified'])->name('dashboard');

    Route::get('/oppasser/{id}', [OppasserController::class, 'show'])->name('oppasser.show'); // To show a specific oppasser
    Route::get('/oppasser/{id}/edit', [OppasserController::class, 'edit'])->name('oppasser.edit'); // To show edit form
    Route::patch('/oppasser/{id}', [OppasserController::class, 'update'])->name('oppasser.update'); // To update oppasser
    Route::delete('/oppasser/{id}', [OppasserController::class, 'destroy'])->name('oppasser.destroy'); // To delete oppasser
});

// Pet-related routes
Route::resource('pets', PetController::class);
// delete huisdier/pet
Route::delete('/pets/{id}', [PetController::class, 'destroy'])->name('pets.destroy');


// jouw huisdieren pagina routes
Route::get('/pets.index', function () {
    $pets = Pet::where('user_id', auth()->id())->get(); // Fetch only pets for the authenticated user
    return view('pets.index', compact('pets')); // Pass the user's pets to the view
})->middleware(['auth'])->name('pets.index');

// alle huisdieren pagina routes
Route::get('/pets/all', function () {
    return view('pets.all'); // Zorg ervoor dat het bestand pets/all.blade.php correct is aangemaakt
})->middleware(['auth'])->name('pets.all');
Route::get('/pets/{id}', [App\Http\Controllers\PetController::class, 'show'])->name('pets.show');
// User-related routes
Route::resource('users', UserController::class);

// Additional routes for navigation

Route::get('/all-sitters', function () {
    return view('all-sitters'); // Create this view
})->middleware(['auth'])->name('sitters.all');

Route::get('/admin', function () {
    return view('admin'); // Create this view
})->middleware(['auth', 'admin'])->name('admin'); // Assuming you have an admin middleware

// Require authentication routes
require __DIR__.'/auth.php';