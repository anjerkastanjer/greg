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
    // Validate the input
    $request->validate([
        'soort_dier' => 'required|array', // Ensure 'soort_dier' is an array
        'soort_dier.*' => 'string|max:255', // Each entry in the array should be a string
        'loon' => 'required|numeric|min:0', // Ensure 'loon' is a positive number
        'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Validate the profile image
    ]);

    $user_id = Auth::id(); // Get the ID of the logged-in user
    $user_name = Auth::user()->name; // Get the name of the logged-in user

    // Check if the user already has an 'oppasser'
    $existingOppasser = Oppasser::where('user_id', $user_id)->first();
    if ($existingOppasser) {
        return redirect()->route('dashboard')->with('message', 'Je hebt je al aangemeld als oppasser.');
    }

    // Handle the profile image upload
    $profileImagePath = null;
    if ($request->hasFile('profile_image')) {
        $profileImagePath = $request->file('profile_image')->store('profile_images', 'public');
    }

    // Create a new 'oppasser' with the species array encoded as JSON
    Oppasser::create([
        'user_id' => $user_id,
        'naam' => $user_name,
        'soort_dier' => json_encode($request->soort_dier), // Encode the array as JSON
        'loon' => $request->loon,
        'profile_image' => $profileImagePath, // Store the profile image path
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
            $oppasser->soort_dier = json_decode($oppasser->soort_dier, true) ?? [];
        }
    
        // Geef de oppasser door aan de view
        return view('dashboard', [
            'oppassers' => Oppasser::where('user_id', '!=', auth()->id())->get(), // Alleen andere oppassers
            'oppasser' => $oppasser, // De specifieke oppasser voor deze gebruiker
        ]);
    }
    
    public function showOppassersPage()
    {
        // Get the logged-in user's oppasser
        $currentUserOppasser = Oppasser::where('user_id', auth()->id())->first(); 
    
        // Get all oppassers for the list
        $oppassers = Oppasser::all(); 
    
        // Return the view with the oppassers
        return view('Oppassers', compact('currentUserOppasser', 'oppassers'));
    }
    
    /**
     * Show the specified oppasser.
     */
    public function show($id)
{
    $oppasser = Oppasser::findOrFail($id); // Find the oppasser by ID
    
    // Decode the 'soort_dier' JSON into an array
    $soortDierArray = json_decode($oppasser->soort_dier, true);
    
    // Implode the array into a string for display
    $soortDierString = implode(', ', $soortDierArray);
    
    // Pass the oppasser and the profile image path to the view
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
