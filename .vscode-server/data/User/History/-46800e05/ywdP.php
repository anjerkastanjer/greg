<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pet;

class PetController extends Controller
{
    // Display a listing of the user's pets
    public function index()
    {
        $userName = auth()->user()->name; // Get the logged-in user's name
        $pets = Pet::where('owner_name', $userName)->get(); // Retrieve all pets of the user
        return view('pets.index', compact('pets'));
    }

    // Display a listing of all pets
    public function allPets()
    {
        $pets = Pet::all(); // Retrieve all pets from the database
        return view('pets.all', compact('pets')); // Make sure to create a view named 'pets.all'
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
            'naam' => 'required|string|max:255',
            'soort' => 'required|string|max:255',
            'loon_per_uur' => 'required|decimal:0,2',
            'start_date' => 'required|date',
        ]);

        $validatedData['owner_name'] = auth()->user()->name; // Get the logged-in user's name

        // Create the new pet
        Pet::create($validatedData); // Should now contain the correct data
        
        return redirect()->route('your.pets'); // Redirect to the user's pets listing
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
            'naam' => 'sometimes|required|string|max:255',
            'soort' => 'sometimes|required|string|max:255',
            'loon_per_uur' => 'sometimes|required|numeric|between:0,9999.99',
            'start_date' => 'sometimes|required|date',
        ]);

        $pet->update($validatedData); // Update the pet with the validated data
        return redirect()->route('your.pets'); // Redirect to the user's pets listing
    }

    // Remove the specified pet
    public function destroy(Pet $pet)
    {
        $pet->delete(); // Delete the pet
        return redirect()->route('your.pets'); // Redirect to the user's pets listing
    }
}
