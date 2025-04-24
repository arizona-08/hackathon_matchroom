<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class HotelAccessController extends Controller
{
    public function generate(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);

        $plainKey = bin2hex(random_bytes(8));
        $user = User::findOrFail($request->user_id);
        $user->hotel_access_key = Hash::make($plainKey);
        $user->save();

        return response()->json([
            'message' => 'Clé générée avec succès',
            'access_key' => $plainKey,
            'user_id' => $user->id,
        ]);
    }

    public function validateKey(Request $request)
    {
        $request->validate([
            'access_key' => 'required|string',
        ]);

        $user = auth()->user();

        if (!$user->hotel_access_key || !Hash::check($request->access_key, $user->hotel_access_key)) {
            return response()->json(['message' => 'Clé invalide'], 403);
        }

        return response()->json(['message' => 'Clé valide']);
    }
}
