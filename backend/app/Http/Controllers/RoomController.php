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
        // $room = Room::create($request->all());
        $user = $request->user();
        $user->load('hotel');

        $hotel_id = $user->hotel->id;



        $room = Room::create([
            'hotel_id' => $hotel_id,
            'name' => $request->name,
            'description' => $request->description,
            'price_per_night' => $request->price,
            'capacity' => $request->capacity,
            'available_from' => $request->available_from,
            'available_to' => $request->available_to,
            'equipment' => $request->equipment,
            'score_matching' => $request->score_matching,
        ]);

        $room->save();
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
