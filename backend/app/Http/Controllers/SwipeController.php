<?php

namespace App\Http\Controllers;

use App\Models\Swipe;
use Illuminate\Http\Request;

class SwipeController extends Controller
{
    public function index()
    {
        return Swipe::with(['user', 'room'])->get();
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'room_id' => 'required|exists:rooms,id',
            'action' => 'required|in:like,pass',
        ]);

        $swipe = Swipe::create($request->all());
        return response()->json($swipe, 201);
    }

    public function show(Swipe $swipe)
    {
        return $swipe->load(['user', 'room']);
    }

    public function update(Request $request, Swipe $swipe)
    {
        $swipe->update($request->all());
        return $swipe;
    }

    public function destroy(Swipe $swipe)
    {
        $swipe->delete();
        return response()->json(null, 204);
    }
}

