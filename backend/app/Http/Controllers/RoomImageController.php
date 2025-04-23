<?php

namespace App\Http\Controllers;

use App\Models\RoomImage;
use Illuminate\Http\Request;

class RoomImageController extends Controller
{
    public function index()
    {
        return RoomImage::with('room')->get();
    }

    public function store(Request $request)
    {
        $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'image_url' => 'required|url',
        ]);

        return RoomImage::create($request->all());
    }

    public function destroy(RoomImage $roomImage)
    {
        $roomImage->delete();
        return response()->json(null, 204);
    }
}
