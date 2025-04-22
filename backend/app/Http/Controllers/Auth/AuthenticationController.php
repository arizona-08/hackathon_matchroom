<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticationController extends Controller
{
    public function store(Request $request){
        $credentials = $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
        } else {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        $user = Auth::user();

        return response()->json(['message' => "User connected successfully", 'user' => $user], 200);
    }

    public function destroy(Request $request){
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return response()->json(['message' => 'User disconnected successfully'], 200);
    }
}
