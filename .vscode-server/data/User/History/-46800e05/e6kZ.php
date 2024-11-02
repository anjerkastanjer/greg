<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pet; // Hoofdlettergebruik en juiste namespace

class PetController extends Controller
{
    // Display a listing of the pets
    public function index()
    {
        $userId = auth()->id(); // Haalt de ID van de ingelogde gebruiker op
        $pets = Pet::where('owner_id', $userId)->get(); // Haalt alle huisdieren van de gebruiker op
        return view('Pets.index', compact('pets'));
    }

    // Show the form for creating a new pet
    public function create()
    {
        return view('pets.create'); // Create a view for the form
    }

    // Store a newly created pet
    public function store(Request $request)
    {
        // Validate and create pet
        $validatedData = $request->validate([
            'naam' => 'required|string|max:255', // Aangepast naar 'naam' zoals in de migratie
            'eigenaar' => 'required|string|max:255', // Aangepast naar 'eigenaar'
            'soort' => 'required|string|max:255', // Aangepast naar 'soort'
            'loon_per_uur' => 'required|decimal:0,2', // Aangepast naar 'loon_per_uur'
            'start_date' => 'required|date', // Aangepast naar 'start_date'
        ]);

        Pet::create($validatedData);
        return redirect()->route('pets.index'); // Redirect to pets listing
    }

    // Show the form for editing the specified pet
    public function edit(Pet $pet)
    {
        return view('pets.edit', compact('pet')); // Create a view for editing pet
    }

    // Update the specified pet
    public function update(Request $request, Pet $pet)
    {
        // Validate and update pet
        $validatedData = $request->validate([
            'naam' => 'sometimes|required|string|max:255', // Aangepast naar 'naam'
            'eigenaar' => 'sometimes|required|string|max:255', // Aangepast naar 'eigenaar'
            'soort' => 'sometimes|required|string|max:255', // Aangepast naar 'soort'
            'loon_per_uur' => 'sometimes|required|decimal:0,2', // Aangepast naar 'loon_per_uur'
            'start_date' => 'sometimes|required|date', // Aangepast naar 'start_date'
        ]);

        $pet->update($validatedData);
        return redirect()->route('pets.index'); // Redirect to pets listing
    }

    // Remove the specified pet
    public function destroy(Pet $pet)
    {
        $pet->delete();
        return redirect()->route('pets.index'); // Redirect to pets listing
    }
}
