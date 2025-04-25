<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Favorite;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    public function index()
    {
        return Favorite::with('room')->where('user_id', Auth::id())->get();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'room_id' => 'required|exists:rooms,id',
        ]);

        $favorite = Favorite::firstOrCreate([
            'user_id' => Auth::id(),
            'room_id' => $validated['room_id'],
        ]);

        return response()->json($favorite, 201);
    }

    public function destroy(Favorite $favorite)
    {
        // Vérifier que le favori appartient bien au user connecté
        if ($favorite->user_id !== auth()->id()) {
            abort(403, 'Unauthorized');
        }

        $favorite->delete();
        return response()->json(null, 204);
    }

}
