<?php

namespace App\Http\Controllers;

use App\Models\Hotel;
use Illuminate\Http\Request;

class HotelController extends Controller
{
    public function index() {
        return Hotel::with('rooms')->get();
    }

    public function store(Request $request) {
        $hotel = Hotel::create($request->all());
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

