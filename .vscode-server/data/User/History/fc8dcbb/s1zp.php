<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{

    public function toggleAdmin(Request $request)
{
    $user = auth()->user();

    // Update de 'is_admin' status op basis van het formulier
    $user->is_admin = $request->has('is_admin') ? 1 : 0;
    $user->save();

    return redirect()->route('admin')->with('status', 'Admin-rechten bijgewerkt!');
}

    public function index()
    {
        $users = User::all();
        return view('users.index', compact('users')); 
    }

   
    public function create()
    {
        return view('users.create'); 
    }


    public function store(Request $request)
    {
       
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);

        $validatedData['password'] = bcrypt($validatedData['password']);

        User::create($validatedData);
        return redirect()->route('users.index'); 
    }

    
    public function edit(User $user)
    {
        return view('users.edit', compact('user')); 
    }

    public function update(Request $request, User $user)
    {
     
        $validatedData = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'sometimes|nullable|string|min:8',
        ]);

        if (isset($validatedData['password'])) {
            $validatedData['password'] = bcrypt($validatedData['password']);
        }

        $user->update($validatedData);
        return redirect()->route('users.index'); 
    }

   
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index'); 
    }
}
