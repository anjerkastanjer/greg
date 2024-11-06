<?php

namespace App\Http\Controllers;

use App\Models\Aanvraag;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AanvraagController extends Controller
{
    public function index()
    {
        // Haal aanvragen van de eigenaar op, maar exclusief de geaccepteerde aanvragen
        $aanvragen = Aanvraag::where('owner_id', Auth::id())
            ->where('status', '!=', 'accepted') // Filter de geaccepteerde aanvragen uit
            ->orWhere('oppasser_id', Auth::id())
            ->with('pet') // Laad de pet relatie
            ->get();
    
        return view('aanvragen.index', compact('aanvragen'));
    }

    public function store(Request $aanvraag, $owner_id)
{

    // dd($aanvraag->pet_id);
    $aanvraag->all();

    $aanvraag->validate([
        'pet_id' => 'required|exists:pets,id',
    ]);
    
    Aanvraag::create([
        'oppasser_id' => Auth::id(),
        'owner_id' => $owner_id,
        'pet_id' => $aanvraag->pet_id,
        'status' => 'pending',
    ]);
    return back()->with('success', 'Je hebt je succesvol aangemeld om op dit dier te passen, wacht de eigenaar af om deze aanvraag te accepteren');
}

public function acceptAanvraag($id)
{
    $aanvraag = Aanvraag::findOrFail($id);
    
    if ($aanvraag->owner_id == Auth::id()) {
        // Wijzig de status naar 'accepted'
        $aanvraag->status = 'accepted';
        $aanvraag->save();

        // Voeg een succesbericht toe
        $message = 'De aanvraag is verwerkt en uw oppas wordt op de hoogte gesteld';

        // Stuur een succesbericht naar de view en redirect naar de aanvragen index
        return redirect()->route('aanvragen.index')->with('success', $message);
    }

    return redirect()->route('aanvragen.index')->with('error', 'Je mag deze aanvraag niet accepteren.');
}

public function geaccepteerdeAanvragen()
{
    $geaccepteerdeAanvragen = Aanvraag::where('status', 'accepted')
        ->where('oppasser_id', Auth::id())
        ->with('pet') 
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