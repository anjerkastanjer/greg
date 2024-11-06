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
        ->where('status', 'cancelled') // Alleen gecancelde aanvragen
        ->with('pet') // Laad de pet relatie
        ->get();

    return view('aanvragen.index', compact('binnenkomendeAanvragen', 'uitgaandeAanvragen', 'gecanceldeAanvragen'));
}


public function reject(Aanvraag $aanvraag)
{
    // Controleer of de aanvraag behoort tot de ingelogde gebruiker
    if ($aanvraag->owner_id === Auth::id() || $aanvraag->oppasser_id === Auth::id()) {
        // Zet de status op 'gecancelled' in plaats van 'rejected'
        $aanvraag->update([
            'status' => 'cancelled'
        ]);

        // Optioneel: geef een succesmelding terug
        return redirect()->route('aanvragen.index')->with('success', 'De aanvraag is geannuleerd.');
    }

    // Als de gebruiker geen rechten heeft, stuur ze terug met een foutmelding
    return redirect()->route('aanvragen.index')->with('error', 'Je hebt geen rechten om deze aanvraag te annuleren.');
}


    public function store(Request $aanvraag, $owner_id)
    {
        // Valideer het pet_id
        $aanvraag->validate([
            'pet_id' => 'required|exists:pets,id',
        ]);

        // Maak een nieuwe aanvraag aan
        Aanvraag::create([
            'oppasser_id' => Auth::id(),
            'owner_id' => $owner_id,
            'pet_id' => $aanvraag->pet_id,
            'status' => 'pending',
        ]);

        // Geef een succesbericht terug
        return back()->with('success', 'Je hebt je succesvol aangemeld om op dit dier te passen, wacht de eigenaar af om deze aanvraag te accepteren');
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
