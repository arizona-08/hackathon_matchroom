<?php

namespace App\Http\Controllers;

use App\Models\Hotel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class HotelController extends Controller
{
    public function index() {
        return Hotel::with('rooms')->get();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'rating_average' => 'nullable|numeric',
            'cancellation_policy' => 'nullable|string',
            'number_of_stars' => 'required|integer',
        ]);

        $user = Auth::user();

        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $hotel = Hotel::create([
            ...$validated,
            'user_id' => $user->id,
        ]);

        return response()->json($hotel, 201);
    }

    public function show(Hotel $hotel) {
        return $hotel->load('rooms');
    }

    public function update(Request $request, Hotel $hotel) {
        $hotel->update($request->all());
        return $hotel;
    }

    public function destroy(Hotel $hotel) {
        $hotel->delete();
        return response()->json(null, 204);
    }
}

