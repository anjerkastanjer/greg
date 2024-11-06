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
        'success' => 'Je hebt je succesvol aangemeld om op dit dier te passen, wacht de eigenaar af om deze aanvraag te accepteren.',
        'pet_id' => $request->pet_id, // Store the pet_id to match the success message
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

}
