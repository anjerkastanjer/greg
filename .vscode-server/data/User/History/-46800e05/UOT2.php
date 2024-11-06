<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pet; // Make sure the namespace is correct

class PetController extends Controller
{
    // Display a listing of the pets for the logged-in user
    // pagina van jouw huisdieren om de gebruikers huisdieren te tonen
    public function index()
{
    // Retrieve pets belonging to the authenticated user
    $pets = Pet::where('user_id', auth()->id())->get(); // Use 'user_id' to fetch pets
    return view('Pets.index', compact('pets')); // Passes the pets to the view
}

    // functie om alle pets te tonen
    public function showAllPets()
    {
        $allPets = Pet::all(); // Haalt alle huisdieren op
        return view('pets.all', compact('allPets')); // Geeft alle huisdieren door aan de view
    }


    // Store a newly created pet
    public function store(Request $request)
    {
        // Validate and create pet
    $validatedData = $request->validate([
        'naam' => 'required|string|max:255',
        'soort' => 'required|string|max:255',
        'loon_per_uur' => 'required|numeric|between:0,9999.99', // Corrected to numeric validation
        'start_date' => 'required|date',
    ]);

    // Set the user_id to the authenticated user's ID
    $validatedData['user_id'] = auth()->id(); // Store user_id instead of owner_name

    // Create the new pet
    Pet::create($validatedData); // This will now contain the correct data
    
    return redirect()->route('pets.index')->with('success', 'Pet added successfully!'); // Redirect to pets listing
    }

    // Show the form for editing the specified pet
    public function edit(Pet $pet)
    {
        return view('Pets.edit', compact('pet')); // Create a view for editing pet
    }

    // Update the specified pet
    public function update(Request $request, Pet $pet)
    {
        // Validate and update pet
        $validatedData = $request->validate([
            'naam' => 'sometimes|required|string|max:255',
            'soort' => 'sometimes|required|string|max:255',
            'loon_per_uur' => 'sometimes|required|numeric|between:0,9999.99', // Ensure it's numeric
            'start_date' => 'sometimes|required|date',
        ]);

        $pet->update($validatedData); // Update the pet with validated data
        return redirect()->route('pets.index')->with('success', 'Pet updated successfully!'); // Redirect to pets listing
    }

    // Remove the specified pet
    public function destroy($id)
    {
        $pet = Pet::findOrFail($id); // Find the pet by ID
        $pet->delete(); // Delete the pet
        return redirect()->back()->with('success', 'Pet deleted successfully!'); // Redirect back with a success message
    }
}
