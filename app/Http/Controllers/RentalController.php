<?php

namespace App\Http\Controllers;

use App\Models\Rental;
use App\Models\Device;
use Illuminate\Http\Request;
use Carbon\Carbon;

class RentalController extends Controller
{
    /**
     * Display a listing of the user's rentals.
     */
    public function index()
    {
        $rentals = auth()->user()->rentals()
            ->with(['device' => function($query) {
                $query->withTrashed();
            }])
            ->latest()
            ->get()
            ->map(function($rental) {
                return (object)[
                    'id' => $rental->id,
                    'device_name' => $rental->device->name,
                    'device_image' => $rental->device->image_url,
                    'start_date' => $rental->start_date,
                    'end_date' => $rental->end_date,
                    'total_cost' => $rental->total_cost,
                    'daily_price' => $rental->daily_price,
                    'deposit_amount' => $rental->deposit_amount,
                    'status' => $rental->status,
                    'return_date' => $rental->return_date
                ];
            });

        return view('rentals.index', compact('rentals'));
    }

    /**
     * Store a newly created rental in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'device_id' => 'required|exists:devices,id',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        $device = Device::findOrFail($request->device_id);

        // Check if device is available
        if ($device->status !== 'available') {
            return back()->with('error', 'This device is not available for rent.');
        }

        // Create the rental
        $rental = new Rental([
            'device_id' => $device->id,
            'user_id' => auth()->id(),
            'start_date' => Carbon::parse($request->start_date),
            'end_date' => Carbon::parse($request->end_date),
            'status' => 'pending'
        ]);

        // Calculate prices
        $rental->calculateTotalPrice();
        $rental->setDepositAmount();
        $rental->save();

        // Update device status
        $device->update(['status' => 'rented']);

        return redirect()->route('rentals.show', $rental)
            ->with('success', 'Rental has been created successfully.');
    }

    /**
     * Display the specified rental.
     */
    public function show(Rental $rental)
    {
        // Ensure the user can only view their own rentals
        if ($rental->user_id !== auth()->id()) {
            abort(403);
        }

        $rental->load(['device' => function($query) {
            $query->withTrashed();
        }]);

        return view('rentals.show', compact('rental'));
    }

    /**
     * Return a rented device.
     */
    public function return(Rental $rental)
    {
        // Ensure the user can only return their own rentals
        if ($rental->user_id !== auth()->id()) {
            abort(403);
        }

        // Check if the rental is active
        if ($rental->status !== 'active') {
            return back()->with('error', 'This rental cannot be returned.');
        }

        // Update the rental
        $rental->update([
            'status' => 'completed',
            'return_date' => Carbon::now()
        ]);

        // Update the device status
        $rental->device->update([
            'status' => 'available'
        ]);

        return redirect()->route('rentals.show', $rental)
            ->with('success', 'Device has been successfully returned.');
    }
} 