<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController; 
use App\Http\Controllers\PetController; 
use App\Http\Controllers\SittingRequestController;
use App\Http\Controllers\OppasserController;
use App\Http\Controllers\AanvraagController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;
use App\Models\Pet;

// Home route
Route::get('/', function () {
    return view('home');
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
Route::get('/reviews', [ReviewController::class, 'index'])->name('reviews.index');


// jouw huisdieren pagina routes
Route::get('/pets.index', function () {
    $pets = Pet::where('user_id', auth()->id())->get(); 
    return view('pets.index', compact('pets')); 
})->middleware(['auth'])->name('pets.index');

// alle huisdieren pagina routes
Route::get('/pets/all', [PetController::class, 'show'])->middleware(['auth'])->name('pets.all');
Route::get('/pets/{id}', [App\Http\Controllers\PetController::class, 'show'])->name('pets.show');

// User-related routes
Route::resource('users', UserController::class);

// admin routes
Route::get('/admin', [AdminController::class, 'index'])->middleware('admin'); // Only apply the middleware here
Route::delete('admin/oppassers/{oppasser}', [OppasserController::class, 'destroy'])->name('admin.oppasser.destroy');
Route::delete('admin/aanvragen/{id}', [AdminController::class, 'deleteOppasaanvraag'])->name('admin.aanvraag.destroy');
Route::patch('/profile/toggle-admin', [ProfileController::class, 'toggleAdmin'])->name('profile.toggleAdmin')->middleware('auth');

// Require authentication routes
require __DIR__.'/auth.php';
