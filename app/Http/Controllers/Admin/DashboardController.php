<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Device;
use App\Models\Category;
use App\Models\Rental;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function index()
    {
        // Get current month's revenue
        $currentMonthRevenue = Rental::whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->sum('total_cost');

        // Get last month's revenue
        $lastMonthRevenue = Rental::whereMonth('created_at', Carbon::now()->subMonth()->month)
            ->whereYear('created_at', Carbon::now()->subMonth()->year)
            ->sum('total_cost');

        // Calculate revenue growth
        $revenueGrowth = 0;
        if ($lastMonthRevenue > 0) {
            $revenueGrowth = (($currentMonthRevenue - $lastMonthRevenue) / $lastMonthRevenue) * 100;
        }

        $stats = [
            'total_devices' => Device::count(),
            'total_categories' => Category::count(),
            'total_rentals' => Rental::count(),
            'total_users' => User::count(),
            'recent_rentals' => Rental::with(['user', 'device'])
                ->latest()
                ->take(5)
                ->get(),
            'popular_devices' => Device::withCount('rentals')
                ->orderBy('rentals_count', 'desc')
                ->take(5)
                ->get(),
            'revenue' => [
                'value' => $currentMonthRevenue,
                'trend' => $revenueGrowth >= 0 ? 'up' : 'down',
                'growth' => round(abs($revenueGrowth), 1)
            ],
            'monthly_revenue' => [
                'current' => $currentMonthRevenue,
                'previous' => $lastMonthRevenue,
                'growth' => round($revenueGrowth, 1)
            ]
        ];

        return view('admin.dashboard', compact('stats'));
    }

    public function devices()
    {
        $devices = Device::with('category')->latest()->paginate(10);
        $categories = Category::all();
        return view('admin.devices.index', compact('devices', 'categories'));
    }

    public function categories()
    {
        $categories = Category::withCount('devices')->latest()->paginate(10);
        return view('admin.categories.index', compact('categories'));
    }

    public function rentals()
    {
        $rentals = Rental::with(['user', 'device'])->latest()->paginate(10);
        return view('admin.rentals.index', compact('rentals'));
    }

    public function users()
    {
        $users = User::latest()->paginate(10);
        return view('admin.users.index', compact('users'));
    }
} 