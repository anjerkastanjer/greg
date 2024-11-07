<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController; 
use App\Http\Controllers\PetController; 
use App\Http\Controllers\SittingRequestController;
use App\Http\Controllers\OppasserController;
use App\Http\Controllers\AanvraagController;
use App\Http\Controllers\ReviewController;
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
Route::middleware(['auth'])->group(function () {
    Route::get('/oppassers', [OppasserController::class, 'showOppassersPage'])->name('oppassers');
});

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

// Aanvragen routes
Route::get('/aanvragen', [AanvraagController::class, 'index'])->name('aanvragen.index');
Route::post('/aanvragen/{owner_id}', [AanvraagController::class, 'store'])->name('aanvragen.store');
Route::patch('/aanvragen/{aanvraag_id}', [AanvraagController::class, 'updateStatus'])->name('aanvragen.updateStatus');
Route::patch('/aanvragen/{aanvraag}/accept', [AanvraagController::class, 'acceptAanvraag'])->name('aanvragen.accept');
Route::delete('/aanvragen/{aanvraag}/reject', [AanvraagController::class, 'rejectAanvraag'])->name('aanvragen.reject');

// Mijn Diensten (Geaccepteerde Aanvragen) route
Route::get('/aanvragen/geaccepteerd', [AanvraagController::class, 'geaccepteerdeAanvragen'])->name('aanvragen.geaccepteerd');

// Pet-related routes
Route::resource('pets', PetController::class);
// delete huisdier/pet
Route::delete('/pets/{id}', [PetController::class, 'destroy'])->name('pets.destroy');

// review routes
Route::post('/reviews', [ReviewController::class, 'store'])->name('reviews.store');

// jouw huisdieren pagina routes
Route::get('/pets.index', function () {
    $pets = Pet::where('user_id', auth()->id())->get(); // Fetch only pets for the authenticated user
    return view('pets.index', compact('pets')); // Pass the user's pets to the view
})->middleware(['auth'])->name('pets.index');

// alle huisdieren pagina route with corrected method call
Route::get('/pets/all', [PetController::class, 'allPets'])->middleware(['auth'])->name('pets.all'); // Calls the allPets method to display all pets with reviews

// Single pet details route
Route::get('/pets/{id}', [PetController::class, 'show'])->name('pets.show'); // Calls the show method to display details of a single pet

// User-related routes
Route::resource('users', UserController::class);

Route::get('/admin', function () {
    return view('admin'); // Create this view
})->middleware(['auth', 'admin'])->name('admin'); // Assuming you have an admin middleware

// Require authentication routes
require __DIR__.'/auth.php';