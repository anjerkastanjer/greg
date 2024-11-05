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
        $request->validate([
            'soort_dier' => 'required|array', // Validate that soort_dier is an array
            'soort_dier.*' => 'string|max:255', // Each entry in the array should be a string
            'loon' => 'required|numeric|min:0',
        ]);

        $user_id = Auth::id(); // Get the logged-in user's ID
        $user_name = Auth::user()->name; // Get the name of the authenticated user

        // Create a single oppasser record with the array of diersoorten as JSON
        Oppasser::create([
            'user_id' => $user_id,
            'naam' => $user_name,
            'soort_dier' => json_encode($request->soort_dier), // Encode the array as JSON
            'loon' => $request->loon,
        ]);

        return redirect()->route('dashboard')->with('success', 'Je bent succesvol aangemeld als oppas voor meerdere dieren.');
    }

    /**
     * Display a listing of the oppassers.
     */
    public function dashboard()
    {
        $oppassers = Oppasser::all(); // Get all oppassers
        return view('dashboard', compact('oppassers'));
    }

    /**
     * Show the specified oppasser.
     */
    public function show($id)
    {
        $oppasser = Oppasser::findOrFail($id); // Find oppasser by ID
        
        // Decode the soort_dier JSON into an array
        $soortDierArray = json_decode($oppasser->soort_dier, true);
        
        // Implode the array into a string
        $soortDierString = implode(', ', $soortDierArray);
        
        // Pass the string to the view
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
