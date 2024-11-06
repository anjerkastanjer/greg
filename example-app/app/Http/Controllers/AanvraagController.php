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
        $aanvragen = Aanvraag::where('owner_id', Auth::id())->orWhere('oppasser_id', Auth::id())->get();
        
        return view('aanvragen.index', compact('aanvragen'));
    }

    // Maak een nieuwe aanvraag
    public function store(Request $request, $owner_id)
    {
        // Valideer de aanvraaggegevens
        $request->validate([
            'status' => 'required|in:pending,accepted,rejected',
        ]);

        // Maak de aanvraag aan
        Aanvraag::create([
            'oppasser_id' => Auth::id(),
            'owner_id' => $owner_id,
            'status' => 'pending', // De aanvraag start altijd als 'pending'
        ]);

        // Redirect terug naar de lijst van aanvragen of naar de profielpagina van de eigenaar
        return redirect()->route('aanvragen.index')->with('success', 'Aanvraag succesvol verstuurd.');
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

        return redirect()->route('aanvragen.index')->with('success', 'Status van de aanvraag bijgewerkt.');
    }
}
