<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Oppasser;
use App\Models\Aanvraag;


class AdminController extends Controller
{

    public function index()
{
    // Fetch all oppassers
    $oppassers = Oppasser::all();

    // Fetch pending aanvragen
    $pendingAanvragen = Aanvraag::where('status', 'pending')->get();

    // Pass oppassers and pending aanvragen to the view
    return view('admin.index', compact('oppassers', 'pendingAanvragen'));
}

    // Block a user
    public function blockUser($id)
    {
        $user = User::find($id);
        if ($user) {
            $user->blocked = true;
            $user->save();
            return redirect()->route('admin.dashboard')->with('success', 'User blocked successfully.');
        }
        return redirect()->route('admin.dashboard')->with('error', 'User not found.');
    }

    // Delete an oppasaanvraag
    public function deleteOppasaanvraag($id)
    {
        $aanvraag = Aanvraag::find($id);
        if ($aanvraag) {
            $aanvraag->delete();
            return redirect()->route('admin.dashboard')->with('success', 'Request deleted successfully.');
        }
        return redirect()->route('admin.dashboard')->with('error', 'Request not found.');
    }

    public function destroy($id)
{
    $oppasser = Oppasser::find($id);
    if ($oppasser) {
        $oppasser->delete();
        return redirect()->route('admin.dashboard')->with('success', 'Oppasser deleted successfully.');
    }
    return redirect()->route('admin.dashboard')->with('error', 'Oppasser not found.');
}
}