<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        
        $bookings = Booking::when($user->user_type === 'customer', function ($query) use ($user) {
                return $query->where('customer_id', $user->id);
            })
            ->when($user->user_type === 'provider', function ($query) use ($user) {
                return $query->where('provider_id', $user->id);
            })
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json($bookings);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'service_id' => 'required|exists:services,id',
            'service_title' => 'required|string',
            'provider_id' => 'required|exists:users,id',
            'provider_name' => 'required|string',
            'date' => 'required|date',
            'time' => 'required',
            'price' => 'required|numeric'
        ]);

        $booking = Booking::create([
            ...$validated,
            'customer_id' => $request->user()->id,
            'customer_name' => $request->user()->name,
            'status' => 'pending'
        ]);

        return response()->json($booking, 201);
    }

    public function updateStatus(Request $request, Booking $booking)
    {
        $validated = $request->validate([
            'status' => 'required|in:confirmed,completed,cancelled'
        ]);

        $booking->update($validated);

        return response()->json($booking);
    }
}
