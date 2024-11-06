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

        return redirect()->route('aanvragen.index')->with('success', 'Aanvraag geaccepteerd!');
    }

    return redirect()->route('aanvragen.index')->with('error', 'Je mag deze aanvraag niet accepteren.');
}

public function geaccepteerdeAanvragen()
{
    // Verkrijg alleen de geaccepteerde aanvragen voor de ingelogde oppasser
    $geaccepteerdeAanvragen = Aanvraag::where('oppasser_id', Auth::id())
        ->where('status', 'accepted')
        ->get();

    return view('aanvragen.geaccepteerd', compact('geaccepteerdeAanvragen'));
}

// Reject the aanvraag (delete or set status to 'rejected')
public function rejectAanvraag($id)
{
    $aanvraag = Aanvraag::findOrFail($id);
    
    // Only the owner can reject
    if ($aanvraag->owner_id == Auth::id()) {
        // If you want to delete the aanvraag
        $aanvraag->delete();

        // Or if you want to set it as rejected instead of deleting:
        // $aanvraag->status = 'rejected';
        // $aanvraag->save();

        return redirect()->route('aanvragen.index')->with('success', 'Aanvraag afgewezen!');
    }

    return redirect()->route('aanvragen.index')->with('error', 'Je mag deze aanvraag niet afwijzen.');
}


}
