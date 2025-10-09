<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Package;
use App\Models\Hotel;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Basic counts
        $totalPackages = Package::count();
        $activePackages = Package::where('is_active', 1)->count();
        $totalHotels = Hotel::count();
        $activeHotels = Hotel::where('is_active', 1)->count();

        // Growth calculations (last month vs current month)
        $packageGrowth = $this->calculatePackageGrowth();
        $hotelGrowth = $this->calculateHotelGrowth();

        // Recent packages with hotel relationship
        $recentPackages = Package::with('hotel')
            ->latest()
            ->take(5)
            ->get();

        // Performance metrics
        $packageUtilization = $totalPackages > 0 ? round(($activePackages / $totalPackages) * 100) : 0;
        $hotelUtilization = $totalHotels > 0 ? round(($activeHotels / $totalHotels) * 100) : 0;

        // Revenue data for chart (you can replace this with actual revenue data)
        $revenueData = $this->getRevenueData();

        // Recent activity
        $recentActivity = $this->getRecentActivity();

        return view('admin.dashboard', compact(
            'totalPackages',
            'activePackages',
            'totalHotels',
            'activeHotels',
            'recentPackages',
            'packageGrowth',
            'hotelGrowth',
            'packageUtilization',
            'hotelUtilization',
            'revenueData',
            'recentActivity'
        ));
    }

    private function calculatePackageGrowth()
    {
        $currentMonthCount = Package::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();

        $lastMonthCount = Package::whereMonth('created_at', now()->subMonth()->month)
            ->whereYear('created_at', now()->subMonth()->year)
            ->count();

        if ($lastMonthCount === 0) {
            return $currentMonthCount > 0 ? 100 : 0;
        }

        return round((($currentMonthCount - $lastMonthCount) / $lastMonthCount) * 100);
    }

    private function calculateHotelGrowth()
    {
        $currentMonthCount = Hotel::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();

        $lastMonthCount = Hotel::whereMonth('created_at', now()->subMonth()->month)
            ->whereYear('created_at', now()->subMonth()->year)
            ->count();

        if ($lastMonthCount === 0) {
            return $currentMonthCount > 0 ? 100 : 0;
        }

        return round((($currentMonthCount - $lastMonthCount) / $lastMonthCount) * 100);
    }

    private function getRevenueData()
    {
        // This is sample data - replace with your actual revenue logic
        return [
            'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            'data' => [6500, 7900, 8100, 7800, 9200, 10500, 11500, 10800, 12200, 13500, 14200, 15800]
        ];
    }

    private function getRecentActivity()
    {
        $packageActivities = Package::with('hotel')
            ->latest()
            ->take(3)
            ->get()
            ->map(function ($package) {
                return [
                    'type' => 'package',
                    'message' => "Package \"{$package->title}\" was " . ($package->created_at->diffInHours(now()) < 24 ? 'created' : 'updated'),
                    'time' => $package->created_at->diffForHumans(),
                    'icon' => 'box',
                    'color' => 'blue'
                ];
            });

        $hotelActivities = Hotel::latest()
            ->take(2)
            ->get()
            ->map(function ($hotel) {
                return [
                    'type' => 'hotel',
                    'message' => "Hotel \"{$hotel->name}\" was " . ($hotel->created_at->diffInHours(now()) < 24 ? 'added' : 'updated'),
                    'time' => $hotel->created_at->diffForHumans(),
                    'icon' => 'hotel',
                    'color' => 'green'
                ];
            });

        return $packageActivities->merge($hotelActivities)->sortByDesc('time')->take(3);
    }
}
