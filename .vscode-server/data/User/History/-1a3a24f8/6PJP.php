<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Review;

class ReviewController extends Controller
{


    public function index()
    {
        // Get all reviews with their associated pet details (e.g., pet name)
        $reviews = Review::with('pet')->get();

        // Pass the reviews to the view
        return view('reviews.index', compact('reviews'));
    }
    
    public function store(Request $request)
{
    $request->validate([
        'pet_id' => 'required|exists:pets,id',
        'rating' => 'required|integer|min:1|max:5',
        'body' => 'nullable|string|max:1000', //laat toe iemand een lege body achter te laten
    ]);

    Review::create([
        'pet_id' => $request->pet_id,
        'rating' => $request->rating,
        'body' => $request->body,
    ]);

    return redirect()->back()->with('success', 'Review added successfully.');
}
}