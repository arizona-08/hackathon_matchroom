<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class AccessKeyController extends Controller
{
    public function generate(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);

        $user = User::findOrFail($request->user_id);

        $plainKey = Str::random(10);
        $user->hotel_access_key = Hash::make($plainKey);
        $user->save();

        return response()->json([
            'message' => 'Clé générée avec succès',
            'plain_key' => $plainKey
        ]);
    }

    public function validateKey(Request $request)
    {
        $request->validate([
            'access_key' => 'required|string',
        ]);

        $user = auth()->user();

        if (!$user || !Hash::check($request->access_key, $user->hotel_access_key)) {
            return response()->json(['message' => 'Clé invalide'], 403);
        }

        return response()->json(['message' => 'Clé valide']);
    }

}
