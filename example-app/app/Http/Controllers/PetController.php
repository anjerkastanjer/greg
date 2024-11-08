<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pet; // Zorg ervoor dat de namespace correct is

class PetController extends Controller
{
    // Toon de huisdieren van de ingelogde gebruiker
    public function index()
    {
        // Haal huisdieren op die bij de ingelogde gebruiker horen
        $pets = Pet::where('user_id', auth()->id())->get(); // Gebruik 'user_id' om huisdieren op te halen
        return view('Pets.index', compact('pets')); // Geeft de huisdieren door aan de view
    }

    // Toon alle huisdieren van alle gebruikers
    public function show(Request $request)
    {
        // Ophalen van het minimale uurloon uit de request
        $minLoon = $request->input('min_loon');
    
        // Ophalen van alle huisdieren met hun reviews, waarbij het minimum uurloon wordt gefilterd als dat is ingesteld
        $allPetsWithReviews = Pet::with('reviews')
            ->when($minLoon, function ($query, $minLoon) {
                return $query->where('loon_per_uur', '>=', $minLoon);
            })
            ->get();
    
        // Huisdieren van de ingelogde gebruiker
        $userPets = $allPetsWithReviews->where('user_id', auth()->id());
    
        // Huisdieren van andere gebruikers, gefilterd op minimum uurloon
        $otherPets = $allPetsWithReviews->reject(function ($pet) {
            return $pet->user_id === auth()->id();
        });
    
        // Doorsturen naar de view met gefilterde huisdieren en reviews
        return view('pets.all', compact('otherPets', 'userPets', 'allPetsWithReviews'));
    }
    // Opslaan van een nieuw huisdier
    public function store(Request $request)
    {
        // Valideer en maak het huisdier aan
        $validatedData = $request->validate([
            'naam' => 'required|string|max:255',
            'soort' => 'required|string|max:255',
            'loon_per_uur' => 'required|numeric|between:0,9999.99', // Correcte validatie voor numerieke waarden
            'start_date' => 'required|date',
        ]);

        // Zet de 'user_id' op de ingelogde gebruiker
        $validatedData['user_id'] = auth()->id(); // Sla de user_id op van de ingelogde gebruiker

        // Maak het nieuwe huisdier aan
        Pet::create($validatedData); // Dit bevat nu de juiste data
        
        return redirect()->route('pets.index')->with('success', 'Huisdier succesvol toegevoegd!'); // Redirect naar de huisdierenlijst
    }

    // Toon het formulier voor het bewerken van het specifieke huisdier
    public function edit(Pet $pet)
    {
        return view('Pets.edit', compact('pet')); // Maak een view voor het bewerken van het huisdier
    }

    // Werk het specifieke huisdier bij
    public function update(Request $request, Pet $pet)
    {
        // Valideer en werk het huisdier bij
        $validatedData = $request->validate([
            'naam' => 'sometimes|required|string|max:255',
            'soort' => 'sometimes|required|string|max:255',
            'loon_per_uur' => 'sometimes|required|numeric|between:0,9999.99', // Zorg ervoor dat het numeriek is
            'start_date' => 'sometimes|required|date',
        ]);

        $pet->update($validatedData); // Werk het huisdier bij met gevalideerde data
        return redirect()->route('pets.index')->with('success', 'Huisdier succesvol bijgewerkt!'); // Redirect naar de huisdierenlijst
    }

    // Verwijder het specifieke huisdier
    public function destroy($id)
    {
        $pet = Pet::findOrFail($id); // Zoek het huisdier op ID
        $pet->delete(); // Verwijder het huisdier
        return redirect()->back()->with('success', 'Huisdier succesvol verwijderd!'); // Redirect terug met een succesbericht
    }
}
