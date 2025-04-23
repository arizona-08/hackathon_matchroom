<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Favorite;

class FavoriteController extends Controller
{
    public function index(Request $request)
    {
        return $request->user()->favorites()->with('room')->get();
    }

    public function store(Request $request)
    {
        $request->validate([
            'room_id' => 'required|exists:rooms,id',
        ]);

        return $request->user()->favorites()->firstOrCreate([
            'room_id' => $request->room_id,
        ]);
    }

    public function destroy(Request $request, $room_id)
    {
        $request->user()->favorites()->where('room_id', $room_id)->delete();

        return response()->json(['message' => 'Favori supprimé']);
    }

}
