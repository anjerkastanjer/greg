<?php

namespace App\Http\Controllers;

use App\Models\Oppasser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OppasserController extends Controller
{
    /**
     * Show the form for creating a new oppasser profile.
     */
    public function create()
    {
        return view('oppasser.create'); // Make sure you have a view for creating an oppasser
    }

    /**
     * Store a newly created oppasser in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'soort_dier' => 'required|string|max:255',
            'loon' => 'required|numeric|min:0',
        ]);

        $oppasser = new Oppasser();
        $oppasser->user_id = Auth::id(); // Set the user ID of the logged-in user
        $oppasser->naam = Auth::user()->name; // Get the name from the authenticated user
        $oppasser->soort_dier = $request->soort_dier;
        $oppasser->loon = $request->loon;
        $oppasser->save();

        return redirect()->route('dashboard')->with('success', 'Je bent succesvol aangemeld als oppas.');
    }

    /**
     * Display a listing of the oppassers.
     */
    public function index()
    {
        $oppassers = Oppasser::all(); // Get all oppassers, you can modify this to get specific ones
        return view('oppasser.index', compact('oppassers'));
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