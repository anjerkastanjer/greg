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
            'soort' => 'required|string|max:255', // Aangepast naar 'soort'
            'loon_per_uur' => 'required|numeric|between:0,9999.99', // Aangepast naar 'loon_per_uur', hier kan je eventueel ook een andere validatie doen
            'start_date' => 'required|date', // Aangepast naar 'start_date'
        ]);

        // Voeg de eigenaar toe aan de gevalideerde gegevens
        $validatedData['owner_id'] = auth()->id(); // Stel de eigenaar in op de ID van de ingelogde gebruiker

        Pet::create($validatedData); // Maak een nieuw huisdier aan met de gevalideerde gegevens
        return redirect()->route('pets.index'); // Redirect naar de lijst van huisdieren
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
            'soort' => 'sometimes|required|string|max:255', // Aangepast naar 'soort'
            'loon_per_uur' => 'sometimes|required|numeric|between:0,9999.99', // Aangepast naar 'loon_per_uur'
            'start_date' => 'sometimes|required|date', // Aangepast naar 'start_date'
        ]);

        $pet->update($validatedData); // Update het huisdier met de gevalideerde gegevens
        return redirect()->route('pets.index'); // Redirect naar de lijst van huisdieren
    }

    // Remove the specified pet
    public function destroy(Pet $pet)
    {
        $pet->delete(); // Verwijder het huisdier
        return redirect()->route('pets.index'); // Redirect naar de lijst van huisdieren
    }
}
