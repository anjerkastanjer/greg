<?php

namespace App\Http\Controllers;

use App\Models\Aanvraag;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AanvraagController extends Controller
{
    // Toon aanvragen van de ingelogde gebruiker
    public function index()
    {
        // Haal alle aanvragen op die door de ingelogde gebruiker zijn gestuurd of ontvangen
        $aanvragen = Aanvraag::where('owner_id', Auth::id())
            ->orWhere('oppasser_id', Auth::id())
            ->get();
        
        return view('aanvragen.index', compact('aanvragen'));
    }

    // Maak een nieuwe aanvraag (not used in the view now, as status update is handled separately)
    public function store(Request $request, $owner_id)
{
    // Validate the request
    $request->validate([
        'pet_id' => 'required|exists:pets,id', // Validate that the pet exists
    ]);

    // Create a new aanvraag (request)
    Aanvraag::create([
        'oppasser_id' => Auth::id(),
        'owner_id' => $owner_id,
        'pet_id' => $request->pet_id,
        'status' => 'pending',
    ]);

    // Return with a success message and stay on the same page
    return back()->with('success', 'Je hebt je succesvol aangemeld om op dit dier te passen, wacht de eigenaar af om deze aanvraag te accepteren');
}

public function acceptAanvraag($id)
{
    $aanvraag = Aanvraag::findOrFail($id);
    
    // Only the owner can accept
    if ($aanvraag->owner_id == Auth::id()) {
        $aanvraag->status = 'accepted';
        $aanvraag->save();

        // Zorg ervoor dat de aanvraag naar de geaccepteerde lijst van de oppasser wordt gestuurd
        // (de logica voor het verplaatsen van de aanvraag naar de lijst van de oppasser)
        // Bijvoorbeeld door de status te controleren in een andere view
        return redirect()->route('aanvragen.geaccepteerd')->with('success', 'Aanvraag geaccepteerd!');
    }

    return redirect()->route('aanvragen.index')->with('error', 'Je mag deze aanvraag niet accepteren.');
}


public function geaccepteerdeAanvragen()
{
    $geaccepteerdeAanvragen = Aanvraag::where('status', 'accepted')
        ->where('oppasser_id', Auth::id()) // Alleen de oppasser kan de geaccepteerde aanvragen zien
        ->get();

    return view('aanvragen.geaccepteerd', compact('geaccepteerdeAanvragen'));
}



public function rejectAanvraag($id)
{
    $aanvraag = Aanvraag::findOrFail($id);
    if ($aanvraag->owner_id == Auth::id()) {
        $aanvraag->delete();
        return redirect()->route('aanvragen.index')->with('success', 'Aanvraag afgewezen!');
    }
    return redirect()->route('aanvragen.index')->with('error', 'Je mag deze aanvraag niet afwijzen.');
}


}
