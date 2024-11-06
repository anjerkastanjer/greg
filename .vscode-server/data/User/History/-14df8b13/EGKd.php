<?php

namespace App\Http\Controllers;

use App\Models\Aanvraag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\QueryException;

class AanvraagController extends Controller
{
    public function index()
    {
        // Haal de binnenkomende aanvragen op voor de ingelogde gebruiker
        $binnenkomendeAanvragen = Aanvraag::where('owner_id', Auth::id())
            ->where('status', '!=', 'accepted') // Alleen niet-geaccepteerde aanvragen
            ->where('status', '!=', 'geannulleerd') // Voeg de filter voor geannuleerde aanvragen toe
            ->with('pet') // Laad de pet relatie
            ->get();
    
        // Haal de uitgaande aanvragen op voor de ingelogde gebruiker
        $uitgaandeAanvragen = Aanvraag::where('oppasser_id', Auth::id())
            ->where('status', '!=', 'accepted') // Alleen niet-geaccepteerde aanvragen
            ->where('status', '!=', 'geannulleerd') // Voeg de filter voor geannuleerde aanvragen toe
            ->with('pet') // Laad de pet relatie
            ->get();
    
        // Haal de gecancelde aanvragen op voor de ingelogde gebruiker
        $gecanceldeAanvragen = Aanvraag::where('owner_id', Auth::id())
            ->where('status', 'geannulleerd') // Alleen gecancelde aanvragen
            ->with('pet') // Laad de pet relatie
            ->get();
    
        // Dit zou de gecancelde aanvragen moeten ophalen en naar de view sturen
        return view('aanvragen.index', compact('binnenkomendeAanvragen', 'uitgaandeAanvragen', 'gecanceldeAanvragen'));
    }
    
    // view returnen voor de mijn diensten pagina
    public function geaccepteerdPagina()
{
    // Haal geaccepteerde aanvragen op voor de oppasser
    $geaccepteerdeAanvragen = Aanvraag::where('status', 'accepted')
        ->where('oppasser_id', Auth::id())
        ->with('pet') // Laad de relatie met pet
        ->get();

    // Toon de geaccepteerde aanvragen in de view
    return view('aanvragen.geaccepteerd', compact('geaccepteerdeAanvragen'));
}

public function reject(Aanvraag $aanvraag)
{
    // Controleer of de aanvraag behoort tot de ingelogde gebruiker
    if ($aanvraag->owner_id === Auth::id() || $aanvraag->oppasser_id === Auth::id()) {
        // Zet de status op 'geannulleerd' in plaats van 'rejected'
        $aanvraag->update([
            'status' => 'geannulleerd'
        ]);

        // Optioneel: geef een succesmelding terug
        return redirect()->route('aanvragen.index')->with('success', 'De aanvraag is geannuleerd.');
    }

    // Als de gebruiker geen rechten heeft, stuur ze terug met een foutmelding
    return redirect()->route('aanvragen.index')->with('error', 'Je hebt geen rechten om deze aanvraag te annuleren.');
}

public function store(Request $request)
{
    // Valideer de aanvraag
    $validatedData = $request->validate([
        'pet_id' => 'required|exists:pets,id', // Zorg ervoor dat het huisdier bestaat
        'oppasser_id' => 'required|exists:users,id', // Zorg ervoor dat de oppasser bestaat
        'owner_id' => 'required|exists:users,id', // Zorg ervoor dat de eigenaar bestaat
        'status' => 'required|string', // Valideer de status
    ]);

    try {
        // Controleer of de huidige gebruiker al een aanvraag heeft gedaan voor dit huisdier
        $existingAanvraag = Aanvraag::where('pet_id', $validatedData['pet_id'])
                                        ->where('owner_id', auth()->id()) // Zorg ervoor dat de huidige gebruiker de eigenaar is
                                        ->where('status', '!=', 'accepted') // Voorkom aanvragen die al geaccepteerd zijn
                                        ->exists();

        if ($existingAanvraag) {
            // Flash error message to session
            return redirect()->back()->with('error', 'Je bent al aangemeld voor dit huisdier.');
        }

        // Maak de nieuwe aanvraag aan
        Aanvraag::create($validatedData);

        return redirect()->route('aanvragen.index')->with('success', 'Aanvraag succesvol ingediend!');
    
    } catch (QueryException $e) {
        // Foutafhandeling voor duplicaten (Error code 1062 duidt op een duplicaat)
        if ($e->getCode() == 1062) {
            // Flash error message to session
            return redirect()->back()->with('error', 'Je hebt al een aanvraag voor dit huisdier ingediend.');
        }

        // Algemeen foutbericht voor andere databasefouten
        return redirect()->back()->with('error', 'Je hebt al een aanvraag voor dit huisdier ingediend');
    }
}


    public function acceptAanvraag($id)
    {
        $aanvraag = Aanvraag::findOrFail($id);

        // Alleen de eigenaar kan de aanvraag accepteren
        if ($aanvraag->owner_id == Auth::id()) {
            $aanvraag->status = 'accepted';
            $aanvraag->save();

            // Geef een succesbericht terug
            $message = 'De aanvraag is verwerkt en uw oppas wordt op de hoogte gesteld';
            return redirect()->route('aanvragen.index')->with('success', $message);
        }

        // Geef een foutmelding als de gebruiker geen eigenaar is
        return redirect()->route('aanvragen.index')->with('error', 'Je mag deze aanvraag niet accepteren.');
    }

    public function geaccepteerdeAanvragen()
    {
        // Haal geaccepteerde aanvragen op voor de oppasser
        $geaccepteerdeAanvragen = Aanvraag::where('status', 'accepted')
            ->where('oppasser_id', Auth::id())
            ->with('pet')
            ->get();

        // Toon de geaccepteerde aanvragen in de view
        return view('aanvragen.geaccepteerd', compact('geaccepteerdeAanvragen'));
    }

    public function rejectAanvraag($id)
    {
        $aanvraag = Aanvraag::findOrFail($id);

        // Alleen de eigenaar kan de aanvraag afwijzen
        if ($aanvraag->owner_id == Auth::id()) {
            $aanvraag->delete();
            return redirect()->route('aanvragen.index')->with('success', 'Aanvraag afgewezen!');
        }

        // Geef een foutmelding als de gebruiker geen eigenaar is
        return redirect()->route('aanvragen.index')->with('error', 'Je mag deze aanvraag niet afwijzen.');
    }
}
