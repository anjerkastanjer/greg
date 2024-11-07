<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function store(Request $request)
{
    $request->validate([
        'pet_id' => 'required|exists:pets,id',
        'rating' => 'required|integer|min:1|max:5',
        'body' => 'required|string|max:1000',
    ]);

    Review::create([
        'pet_id' => $request->pet_id,
        'rating' => $request->rating,
        'body' => $request->body,
    ]);

    return redirect()->back()->with('success', 'Review added successfully.');
}
}
