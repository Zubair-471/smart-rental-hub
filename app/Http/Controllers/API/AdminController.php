<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Device;
use App\Models\User;
use App\Models\Rental;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    /**
     * Get dashboard overview statistics
     */
    public function dashboard()
    {
        $stats = [
            'total_users' => User::count(),
            'total_devices' => Device::count(),
            'active_rentals' => Rental::where('status', 'active')->count(),
            'total_categories' => Category::count(),
            'revenue' => [
                'today' => Rental::whereDate('created_at', today())->sum('total_cost'),
                'this_month' => Rental::whereMonth('created_at', now()->month)->sum('total_cost'),
                'total' => Rental::sum('total_cost')
            ],
            'device_status' => [
                'available' => Device::where('availability_status', 'available')->count(),
                'rented' => Device::where('availability_status', 'rented')->count(),
                'maintenance' => Device::where('availability_status', 'maintenance')->count()
            ]
        ];

        return response()->json($stats);
    }

    /**
     * Get detailed statistics
     */
    public function statistics()
    {
        // Most rented devices
        $popularDevices = Device::select('devices.*', DB::raw('COUNT(rentals.id) as rental_count'))
            ->leftJoin('rentals', 'devices.id', '=', 'rentals.device_id')
            ->groupBy('devices.id')
            ->orderByDesc('rental_count')
            ->limit(5)
            ->get();

        // Category distribution
        $categoryStats = Category::select('categories.name', DB::raw('COUNT(devices.id) as device_count'))
            ->leftJoin('devices', 'categories.id', '=', 'devices.category_id')
            ->groupBy('categories.id')
            ->get();

        // Monthly revenue trend
        $monthlyRevenue = Rental::select(
            DB::raw('YEAR(created_at) as year'),
            DB::raw('MONTH(created_at) as month'),
            DB::raw('SUM(total_cost) as revenue')
        )
            ->groupBy('year', 'month')
            ->orderBy('year', 'desc')
            ->orderBy('month', 'desc')
            ->limit(12)
            ->get();

        return response()->json([
            'popular_devices' => $popularDevices,
            'category_stats' => $categoryStats,
            'monthly_revenue' => $monthlyRevenue
        ]);
    }

    /**
     * Get all users with their rental counts
     */
    public function users()
    {
        $users = User::select('users.*', DB::raw('COUNT(rentals.id) as rental_count'))
            ->leftJoin('rentals', 'users.id', '=', 'rentals.user_id')
            ->groupBy('users.id')
            ->paginate(10);

        return response()->json($users);
    }

    /**
     * Update user details
     */
    public function updateUser(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'is_admin' => 'boolean'
        ]);

        $user->update($validated);

        return response()->json($user);
    }

    /**
     * Delete a user
     */
    public function deleteUser(User $user)
    {
        // Check if user has active rentals
        if ($user->rentals()->where('status', 'active')->exists()) {
            return response()->json([
                'message' => 'Cannot delete user with active rentals'
            ], 400);
        }

        $user->delete();

        return response()->json([
            'message' => 'User deleted successfully'
        ]);
    }

    /**
     * Get all rentals with user and device details
     */
    public function rentals()
    {
        $rentals = Rental::with(['user', 'device'])
            ->orderByDesc('created_at')
            ->paginate(10);

        return response()->json($rentals);
    }

    /**
     * Update rental status
     */
    public function updateRentalStatus(Request $request, Rental $rental)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,active,completed,cancelled'
        ]);

        $rental->update($validated);

        // Update device availability status
        if ($validated['status'] === 'active') {
            $rental->device->update(['availability_status' => 'rented']);
        } elseif (in_array($validated['status'], ['completed', 'cancelled'])) {
            $rental->device->update(['availability_status' => 'available']);
        }

        return response()->json($rental->load('device'));
    }
} 