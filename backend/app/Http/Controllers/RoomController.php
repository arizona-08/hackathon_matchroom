<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    public function index()
    {
        return Room::with('hotel')->get();
    }

    public function store(Request $request)
    {
        $room = Room::create($request->all());
        return response()->json($room, 201);
    }

    public function show(Room $room)
    {
        return $room->load('hotel');
    }

    public function update(Request $request, Room $room)
    {
        $room->update($request->all());
        return $room;
    }

    public function destroy(Room $room)
    {
        $room->delete();
        return response()->json(null, 204);
    }
}
