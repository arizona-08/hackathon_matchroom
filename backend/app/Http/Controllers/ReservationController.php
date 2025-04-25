<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\Room;
use App\Models\Negotiation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReservationController extends Controller
{

    public function index()
    {
        $reservations = Reservation::with(['room.hotel', 'negotiation'])
            ->where('user_id', Auth::id())
            ->orderBy('start_date', 'desc')
            ->get();

        return response()->json($reservations);
    }


    public function show(Reservation $reservation)
    {
        $this->authorize('view', $reservation);
        return response()->json($reservation->load(['room.hotel', 'negotiation']));
    }

    public function store(Request $request)
{
    $request->validate([
        'room_id' => 'required|exists:rooms,id',
        'start_date' => 'required|date',
        'end_date' => 'required|date|after:start_date',
        'price_paid' => 'required|numeric|min:1',
        'negotiation_id' => 'nullable|exists:negotiations,id',
        'status' => 'nullable|in:pending,confirmed,cancelled',
    ]);

    $reservation = Reservation::create([
        'user_id' => Auth::id(),
        'room_id' => $request->room_id,
        'start_date' => $request->start_date,
        'end_date' => $request->end_date,
        'price_paid' => $request->price_paid,
        'status' => $request->status ?? 'pending',
        'negotiation_id' => $request->negotiation_id,
    ]);

    return response()->json(['message' => 'Réservation créée avec succès', 'reservation' => $reservation], 201);
}

public function isAvailable(Request $request)
{
    $request->validate([
        'room_id' => 'required|exists:rooms,id',
        'start_date' => 'required|date',
        'end_date' => 'required|date|after:start_date',
    ]);

    $exists = \App\Models\Reservation::where('room_id', $request->room_id)
        ->where('status', 'confirmed')
        ->where(function ($query) use ($request) {
            $query->whereBetween('start_date', [$request->start_date, $request->end_date])
                  ->orWhereBetween('end_date', [$request->start_date, $request->end_date])
                  ->orWhere(function ($q) use ($request) {
                      $q->where('start_date', '<=', $request->start_date)
                        ->where('end_date', '>=', $request->end_date);
                  });
        })
        ->exists();

    return response()->json([
        'available' => !$exists
    ]);
}



}
