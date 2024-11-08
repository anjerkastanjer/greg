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
        'soort_dier' => 'required|array',
        'soort_dier.*' => 'string|max:255', 
        'loon' => 'required|numeric|min:0',
        'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    $user_id = Auth::id(); 
    $user_name = Auth::user()->name; 

    
    $existingOppasser = Oppasser::where('user_id', $user_id)->first();
    if ($existingOppasser) {
        return redirect()->route('dashboard')->with('message', 'Je hebt je al aangemeld als oppasser.');
    }

    
    $profileImagePath = null;
    if ($request->hasFile('profile_image')) {
        $profileImagePath = $request->file('profile_image')->store('profile_images', 'public');
    }

    
    Oppasser::create([
        'user_id' => $user_id,
        'naam' => $user_name,
        'soort_dier' => json_encode($request->soort_dier), 
        'loon' => $request->loon,
        'profile_image' => $profileImagePath, 
    ]);

    return redirect()->route('dashboard')->with('success', 'Je bent succesvol aangemeld als oppas voor meerdere dieren.');
}

    
    public function dashboard()
    {
        
        $user = auth()->user();
    
        
        $oppasser = Oppasser::where('user_id', $user->id)->first();
    
        
        if ($oppasser) {
            $oppasser->soort_dier = json_decode($oppasser->soort_dier, true) ?? [];
        }
    
        
        return view('dashboard', [
            'oppassers' => Oppasser::where('user_id', '!=', auth()->id())->get(), 
            'oppasser' => $oppasser, 
        ]);
    }
    
    public function showOppassersPage()
    {     
        $currentUserOppasser = Oppasser::where('user_id', auth()->id())->first(); 
           
        $oppassers = Oppasser::all(); 
    
        return view('Oppassers', compact('currentUserOppasser', 'oppassers'));
    }
    
    public function show($id)
{
    $oppasser = Oppasser::findOrFail($id); 
    
    // Decode the 'soort_dier' JSON into an array
    $soortDierArray = json_decode($oppasser->soort_dier, true);
    
    // Implode the array into a string for display
    $soortDierString = implode(', ', $soortDierArray);
    
    return view('oppasser.show', compact('oppasser', 'soortDierString'));
}

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
