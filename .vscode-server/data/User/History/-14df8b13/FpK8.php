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
    public function store(Request $request)
{
    // Validate the request data
    $validated = $request->validate([
        'pet_id' => 'required|exists:pets,id',
        'owner_id' => 'required|exists:users,id',
    ]);

    // If validation passes, create a new aanvraag (application)
    $aanvraag = new Aanvraag();
    $aanvraag->pet_id = $request->pet_id;
    $aanvraag->owner_id = $request->owner_id;
    $aanvraag->user_id = auth()->user()->id; // Add user_id as the logged-in user
    $aanvraag->save();

    // Set a success message and pass the pet_id for conditional display
    return redirect()->back()->with([
        'success' => 'Je hebt je succesvol aangemeld om op dit dier te passen!',
        'pet_id' => $request->pet_id
    ]);
}


}
