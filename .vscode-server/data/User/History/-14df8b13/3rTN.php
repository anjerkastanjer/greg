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
        // Debug statement - Remove once confirmed it works correctly
        // dd($request->all(), $owner_id);
        
        // This method was originally used to create new aanvragen, but the form in the view is for updating status
        // We will leave this method empty or delete if not needed anymore
    }

    // Verander de status van de aanvraag
    public function updateStatus(Request $request, $aanvraag_id)
{
    $aanvraag = Aanvraag::findOrFail($aanvraag_id);

    // Alleen de eigenaar kan de status veranderen
    if ($aanvraag->owner_id != Auth::id()) {
        return redirect()->route('aanvragen.index')->with('error', 'Je hebt geen toestemming om deze aanvraag te bewerken.');
    }

    // Werk de status bij
    $aanvraag->update([
        'status' => $request->status,
    ]);

    // Voeg een succesbericht toe aan de sessie
    return redirect()->route('aanvragen.index')->with('success', 'Je hebt je succesvol aangemeld om op dit dier te passen, wacht de eigenaar af om deze aanvraag te accepteren.');
}
}
