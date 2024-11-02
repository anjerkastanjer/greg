<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PetController extends Controller
{
    // Display a listing of the pets
    public function index()
    {
        $pets = Pet::all();
        return view('pets.index', compact('pets')); // Create a view to display pets
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
            'name' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'age' => 'required|integer',
            'user_id' => 'required|exists:users,id', // Assume a user can own a pet
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
            'name' => 'sometimes|required|string|max:255',
            'type' => 'sometimes|required|string|max:255',
            'age' => 'sometimes|required|integer',
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
