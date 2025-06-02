<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Device;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class HomeController extends Controller
{
    public function index()
    {
        try {
            // Get all categories with device count
            $categories = Category::withCount('devices')->get();

            // Get featured devices
            $featuredDevices = Device::where('is_featured', true)
                ->orWhere('status', Device::STATUS_AVAILABLE)
                ->take(6)
                ->get();

            // If no featured devices, get random available devices
            if ($featuredDevices->isEmpty()) {
                $featuredDevices = Device::where('status', Device::STATUS_AVAILABLE)
                    ->inRandomOrder()
                    ->take(6)
                    ->get();
            }

            // Get latest devices
            $latestDevices = Device::latest()
                ->take(6)
                ->get();

            return view('home', compact('categories', 'featuredDevices', 'latestDevices'));
        } catch (\Exception $e) {
            Log::error('Error in HomeController@index: ' . $e->getMessage());
            return view('home', [
                'categories' => collect(),
                'featuredDevices' => collect(),
                'latestDevices' => collect()
            ])->with('error', 'Unable to load some content. Please try again later.');
        }
    }

    public function about()
    {
        return view('about');
    }

    public function contact()
    {
        return view('contact');
    }
} 