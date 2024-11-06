<?php

namespace App\Http\Controllers;

use App\Models\Oppasser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OppasserController extends Controller
{
    /**
     * Store a newly created oppasser in storage.
     */
    public function store(Request $request)
    {
        // Validatie van de invoer
        $request->validate([
            'soort_dier' => 'required|array', // Zorg ervoor dat soort_dier een array is
            'soort_dier.*' => 'string|max:255', // Elke invoer in de array moet een string zijn
            'loon' => 'required|numeric|min:0', // Zorg ervoor dat loon een positief nummer is
        ]);

        $user_id = Auth::id(); // Verkrijg het ID van de ingelogde gebruiker
        $user_name = Auth::user()->name; // Verkrijg de naam van de ingelogde gebruiker

        // Controleer of de gebruiker al een oppasser heeft
        $existingOppasser = Oppasser::where('user_id', $user_id)->first();
        if ($existingOppasser) {
            return redirect()->route('dashboard')->with('message', 'Je hebt je al aangemeld als oppasser.');
        }

        // Maak een nieuwe oppasser aan met de array van diersoorten als JSON
        Oppasser::create([
            'user_id' => $user_id,
            'naam' => $user_name,
            'soort_dier' => json_encode($request->soort_dier), // Encodeer de array als JSON
            'loon' => $request->loon,
        ]);

        return redirect()->route('dashboard')->with('success', 'Je bent succesvol aangemeld als oppas voor meerdere dieren.');
    }

    /**
     * Display a listing of the oppassers.
     */
    public function dashboard()
{
    // Haal de geauthenticeerde gebruiker op
    $user = auth()->user();

    // Zoek naar de oppasser die aan deze gebruiker is gekoppeld
    $oppasser = Oppasser::where('user_id', $user->id)->first();

    // Decodeer de soort_dier JSON naar een array voor weergave
    if ($oppasser) {
        $oppasser->soort_dier = json_decode($oppasser->soort_dier, true);
    }

    public function showOppassersPage()
{
    $oppasser = Oppasser::where('user_id', auth()->id())->first(); // Get the logged-in user's oppasser
    $oppassers = Oppasser::all(); // Get all oppassers for the list

    return view('your-view-name', compact('oppasser', 'oppassers'));
}
    // Geef de oppasser door aan de view
    return view('dashboard', [
        'oppassers' => Oppasser::all(), // Dit kan gefilterd worden indien nodig
        'oppasser' => $oppasser, // De specifieke oppasser voor deze gebruiker
    ]);
}

    /**
     * Show the specified oppasser.
     */
    public function show($id)
    {
        $oppasser = Oppasser::findOrFail($id); // Zoek oppasser op ID
        
        // Decodeer de soort_dier JSON naar een array
        $soortDierArray = json_decode($oppasser->soort_dier, true);
        
        // Implode de array naar een string
        $soortDierString = implode(', ', $soortDierArray);
        
        // Geef de string door aan de view
        return view('oppasser.show', compact('oppasser', 'soortDierString'));
    }

    /**
     * Remove the specified oppasser from storage.
     */
    public function destroy($id)
    {
        $oppasser = Oppasser::find($id);

        if ($oppasser) {
            $oppasser->delete();
            return redirect()->back()->with('success', 'Oppasser succesvol verwijderd.');
        }

        return redirect()->back()->with('error', 'Oppasser niet gevonden.');
    }
}
