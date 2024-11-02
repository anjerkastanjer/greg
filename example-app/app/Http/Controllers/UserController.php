<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('users.index', compact('users')); // Create a view to display users
    }

    // Show the form for creating a new user (admin)
    public function create()
    {
        return view('users.create'); // Create a view for the form
    }

    // Store a newly created user
    public function store(Request $request)
    {
        // Validate and create user
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);

        $validatedData['password'] = bcrypt($validatedData['password']);

        User::create($validatedData);
        return redirect()->route('users.index'); // Redirect to users listing
    }

    // Show the form for editing the specified user
    public function edit(User $user)
    {
        return view('users.edit', compact('user')); // Create a view for editing user
    }

    // Update the specified user
    public function update(Request $request, User $user)
    {
        // Validate and update user
        $validatedData = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'sometimes|nullable|string|min:8',
        ]);

        if (isset($validatedData['password'])) {
            $validatedData['password'] = bcrypt($validatedData['password']);
        }

        $user->update($validatedData);
        return redirect()->route('users.index'); // Redirect to users listing
    }

    // Remove the specified user
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index'); // Redirect to users listing
    }
}
