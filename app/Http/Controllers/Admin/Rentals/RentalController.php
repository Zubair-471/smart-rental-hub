<?php

namespace App\Http\Controllers\Admin\Rentals;

use App\Http\Controllers\Controller;
use App\Models\Rental;
use App\Models\Device;
use App\Models\User;
use Illuminate\Http\Request;

class RentalController extends Controller
{
    /**
     * Display a listing of the rentals.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $rentals = Rental::with(['user', 'device'])
            ->latest()
            ->paginate(10);
            
        return view('admin.rentals.index', compact('rentals'));
    }

    /**
     * Show the form for creating a new rental.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $users = User::where('role', 'user')->get();
        $devices = Device::where('status', 'available')->get();
        return view('admin.rentals.create', compact('users', 'devices'));
    }

    /**
     * Store a newly created rental in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'device_id' => 'required|exists:devices,id',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after:start_date',
            'status' => 'required|in:pending,active,completed,cancelled',
            'notes' => 'nullable|string',
        ]);

        $device = Device::findOrFail($validated['device_id']);
        
        // Calculate rental duration and total amount
        $startDate = \Carbon\Carbon::parse($validated['start_date']);
        $endDate = \Carbon\Carbon::parse($validated['end_date']);
        $days = $startDate->diffInDays($endDate);
        
        $validated['total_amount'] = $device->daily_rate * $days;
        $validated['deposit_amount'] = $device->deposit_amount;

        // Create the rental
        $rental = Rental::create($validated);

        // Update device status if rental is active
        if ($validated['status'] === 'active') {
            $device->update(['status' => 'rented']);
        }

        return redirect()->route('admin.rentals.index')
            ->with('success', 'Rental created successfully.');
    }

    /**
     * Show the rental details.
     *
     * @param  \App\Models\Rental  $rental
     * @return \Illuminate\View\View
     */
    public function show(Rental $rental)
    {
        $rental->load(['user', 'device']);
        return view('admin.rentals.show', compact('rental'));
    }

    /**
     * Update the specified rental status.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Rental  $rental
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateStatus(Request $request, Rental $rental)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,active,completed,cancelled',
            'notes' => 'nullable|string',
        ]);

        $oldStatus = $rental->status;
        $rental->update($validated);

        // Handle device status changes
        $device = $rental->device;
        if ($validated['status'] === 'active' && $oldStatus !== 'active') {
            $device->update(['status' => 'rented']);
        } elseif (in_array($validated['status'], ['completed', 'cancelled']) && $oldStatus === 'active') {
            $device->update(['status' => 'available']);
        }

        return redirect()->route('admin.rentals.show', $rental)
            ->with('success', 'Rental status updated successfully.');
    }

    /**
     * Remove the specified rental from storage.
     *
     * @param  \App\Models\Rental  $rental
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Rental $rental)
    {
        // Only allow deletion of non-active rentals
        if ($rental->status === 'active') {
            return redirect()->route('admin.rentals.index')
                ->with('error', 'Cannot delete an active rental.');
        }

        $rental->delete();

        return redirect()->route('admin.rentals.index')
            ->with('success', 'Rental deleted successfully.');
    }
} 