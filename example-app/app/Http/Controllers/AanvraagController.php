<?php

namespace App\Http\Controllers;

use App\Models\Aanvraag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AanvraagController extends Controller
{
    public function index()
{
    // Haal de binnenkomende aanvragen op voor de ingelogde gebruiker
    $binnenkomendeAanvragen = Aanvraag::where('owner_id', Auth::id())
        ->where('status', '!=', 'accepted') // Alleen niet-geaccepteerde aanvragen
        ->with('pet') // Laad de pet relatie
        ->get();

    // Haal de uitgaande aanvragen op voor de ingelogde gebruiker
    $uitgaandeAanvragen = Aanvraag::where('oppasser_id', Auth::id())
        ->where('status', '!=', 'accepted') // Alleen niet-geaccepteerde aanvragen
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
    // Validate the aanvraag
    $validatedData = $request->validate([
        'pet_id' => 'required|exists:pets,id', // Ensure pet exists
        'oppasser_id' => 'required|exists:users,id', // Ensure oppasser exists
        'owner_id' => 'required|exists:users,id', // Ensure owner exists
        'status' => 'required|string', // Validate status
        ]);

    // Check if the current user has already made a request for this pet
    $existingAanvraag = Aanvraag::where('pet_id', $validatedData['pet_id'])
                                ->where('owner_id', auth()->id()) // Ensure the current user is the owner
                                ->where('status', '!=', 'accepted') // Prevent requests that are already accepted
                                ->exists();

    if ($existingAanvraag) {
        return redirect()->back()->with('error', 'Je hebt al een aanvraag gedaan voor dit huisdier.');
    }

    // Create the new aanvraag
    Aanvraag::create($validatedData);

    return redirect()->route('aanvragen.index')->with('success', 'Aanvraag succesvol ingediend!');
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
