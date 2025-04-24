<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RoomController extends Controller
{
    public function index()
    {
        return response()->json([
            "rooms" => Room::with('hotel')->get()
        ]);
    }


    public function store(Request $request)
    {
        // $room = Room::create($request->all());
        $user = $request->user();
        $user->load('hotel');

        $request->validate([
            'photo_path' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $path = null;
        if ($request->hasFile('photo_path')) {
            $path = $request->file('photo_path')->store('uploads/rooms', 'public');
        }

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
            'photo_path' => $path,
            'number_of_beds' => $request->number_of_beds,
            'negotiation_max_discount' => $request->negotiation_max_discount,
            'negotiation_auto_accept_threshold' => $request->negotiation_auto_accept_threshold,
        ]);

        $room->save();
        return response()->json($room, 201);
    }

    public function show(Room $room)
    {
        $room->load('hotel');
        return response()->json([
            "room" => $room
        ]);
        ;
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
