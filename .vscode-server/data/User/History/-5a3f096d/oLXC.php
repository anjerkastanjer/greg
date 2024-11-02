<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SittingRequestController extends Controller
{
    // Display a listing of the sitting requests
    public function index()
    {
        $sittingRequests = SittingRequest::all();
        return view('sitting_requests.index', compact('sittingRequests')); // Create a view to display sitting requests
    }

    // Show the form for creating a new sitting request
    public function create()
    {
        return view('sitting_requests.create'); // Create a view for the form
    }

    // Store a newly created sitting request
    public function store(Request $request)
    {
        // Validate and create sitting request
        $validatedData = $request->validate([
            'pet_id' => 'required|exists:pets,id', // Assuming sitting request is linked to a pet
            'user_id' => 'required|exists:users,id', // Assuming sitting request is linked to a user
            'start_date' => 'required|date',
            'end_date' => 'required|date',
        ]);

        SittingRequest::create($validatedData);
        return redirect()->route('sitting_requests.index'); // Redirect to sitting requests listing
    }

    // Show the form for editing the specified sitting request
    public function edit(SittingRequest $sittingRequest)
    {
        return view('sitting_requests.edit', compact('sittingRequest')); // Create a view for editing sitting request
    }

    // Update the specified sitting request
    public function update(Request $request, SittingRequest $sittingRequest)
    {
        // Validate and update sitting request
        $validatedData = $request->validate([
            'pet_id' => 'sometimes|required|exists:pets,id',
            'user_id' => 'sometimes|required|exists:users,id',
            'start_date' => 'sometimes|required|date',
            'end_date' => 'sometimes|required|date',
        ]);

        $sittingRequest->update($validatedData);
        return redirect()->route('sitting_requests.index'); // Redirect to sitting requests listing
    }

    // Remove the specified sitting request
    public function destroy(SittingRequest $sittingRequest)
    {
        $sittingRequest->delete();
        return redirect()->route('sitting_requests.index'); // Redirect to sitting requests listing
    }
}
