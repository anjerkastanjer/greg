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

    // Loop through each soort_dier entry and create an oppasser record
    foreach ($request->soort_dier as $soort) {
        Oppasser::create([
            'user_id' => $user_id,
            'naam' => $user_name,
            'soort_dier' => $soort,
            'loon' => $request->loon,
        ]);
    }

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
        return view('oppasser.show', compact('oppasser'));
    }
}