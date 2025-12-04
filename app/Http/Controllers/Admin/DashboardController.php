<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Package;
use App\Models\Hotel;
use App\Models\Category;
use App\Models\Booking;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $totalPackages = Package::count();
        $activePackages = Package::where('is_active', 1)->count();
        $totalHotels = Hotel::count();
        $activeHotels = Hotel::where('is_active', 1)->count();
        $totalCategories = Category::count();
        $activeCategories = Category::where('is_active', 1)->count();
        $totalBookings = Booking::count();
        $totalUsers = User::count();

        $pendingBookings = Booking::where('status', 'pending')->count();
        $confirmedBookings = Booking::where('status', 'confirmed')->count();
        $completedBookings = Booking::where('status', 'completed')->count();
        $cancelledBookings = Booking::where('status', 'cancelled')->count();

        $totalRevenue = Booking::sum('total_amount');
        $totalReceived = Booking::sum('paid_amount');
        $totalDeposit = Booking::where('payment_status', 'partial')->sum('paid_amount');
        $totalPending = Booking::sum('remaining_amount');

        $paidBookings = Booking::where('payment_status', 'paid')->count();
        $partialPayments = Booking::where('payment_status', 'partial')->count();
        $pendingPayments = Booking::where('payment_status', 'pending')->count();

        $packageGrowth = $this->calculatePackageGrowth();
        $hotelGrowth = $this->calculateHotelGrowth();
        $bookingGrowth = $this->calculateBookingGrowth();
        $revenueGrowth = $this->calculateRevenueGrowth();

        $recentPackages = Package::with('hotel')
            ->latest()
            ->take(5)
            ->get();

        $recentBookings = Booking::with('package')
            ->latest()
            ->take(5)
            ->get();

        $packageUtilization = $totalPackages > 0 ? round(($activePackages / $totalPackages) * 100) : 0;
        $hotelUtilization = $totalHotels > 0 ? round(($activeHotels / $totalHotels) * 100) : 0;
        $bookingConversionRate = $totalBookings > 0 ? round(($confirmedBookings / $totalBookings) * 100) : 0;
        $paymentCollectionRate = $totalRevenue > 0 ? round(($totalReceived / $totalRevenue) * 100) : 0;

        $revenueData = $this->getMonthlyRevenueData();

        $bookingStatusData = $this->getBookingStatusData();

        $recentActivity = $this->getRecentActivity();

        $topPackages = $this->getTopPackages();

        return view('admin.dashboard', compact(
            'totalPackages',
            'activePackages',
            'totalHotels',
            'activeHotels',
            'totalCategories',
            'activeCategories',
            'totalBookings',
            'totalUsers',
            'pendingBookings',
            'confirmedBookings',
            'completedBookings',
            'cancelledBookings',
            'totalRevenue',
            'totalReceived',
            'totalDeposit',
            'totalPending',
            'paidBookings',
            'partialPayments',
            'pendingPayments',
            'recentPackages',
            'recentBookings',
            'packageGrowth',
            'hotelGrowth',
            'bookingGrowth',
            'revenueGrowth',
            'packageUtilization',
            'hotelUtilization',
            'bookingConversionRate',
            'paymentCollectionRate',
            'revenueData',
            'bookingStatusData',
            'recentActivity',
            'topPackages'
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

    private function calculateBookingGrowth()
    {
        $currentMonthCount = Booking::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();

        $lastMonthCount = Booking::whereMonth('created_at', now()->subMonth()->month)
            ->whereYear('created_at', now()->subMonth()->year)
            ->count();

        if ($lastMonthCount === 0) {
            return $currentMonthCount > 0 ? 100 : 0;
        }

        return round((($currentMonthCount - $lastMonthCount) / $lastMonthCount) * 100);
    }

    private function calculateRevenueGrowth()
    {
        $currentMonthRevenue = Booking::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->sum('total_amount');

        $lastMonthRevenue = Booking::whereMonth('created_at', now()->subMonth()->month)
            ->whereYear('created_at', now()->subMonth()->year)
            ->sum('total_amount');

        if ($lastMonthRevenue == 0) {
            return $currentMonthRevenue > 0 ? 100 : 0;
        }

        return round((($currentMonthRevenue - $lastMonthRevenue) / $lastMonthRevenue) * 100);
    }

    private function getMonthlyRevenueData()
    {
        $months = [];
        $revenues = [];

        for ($i = 11; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $months[] = $date->format('M');

            $revenue = Booking::whereMonth('created_at', $date->month)
                ->whereYear('created_at', $date->year)
                ->sum('total_amount');

            $revenues[] = $revenue;
        }

        return [
            'labels' => $months,
            'data' => $revenues
        ];
    }

    private function getBookingStatusData()
    {
        return [
            'pending' => Booking::where('status', 'pending')->count(),
            'confirmed' => Booking::where('status', 'confirmed')->count(),
            'completed' => Booking::where('status', 'completed')->count(),
            'cancelled' => Booking::where('status', 'cancelled')->count(),
        ];
    }

    private function getTopPackages()
    {
        return Package::select('packages.*', DB::raw('COUNT(bookings.id) as bookings_count'))
            ->leftJoin('bookings', 'packages.id', '=', 'bookings.package_id')
            ->groupBy('packages.id')
            ->orderByDesc('bookings_count')
            ->take(5)
            ->get();
    }

    private function getRecentActivity()
    {
        $bookingActivities = Booking::with('package')
            ->latest()
            ->take(3)
            ->get()
            ->map(function ($booking) {
                return [
                    'type' => 'booking',
                    'message' => "New booking #{$booking->booking_reference} for \"{$booking->package->title}\"",
                    'time' => $booking->created_at->diffForHumans(),
                    'icon' => 'calendar-check',
                    'color' => 'purple',
                    'created_at' => $booking->created_at
                ];
            });

        $packageActivities = Package::with('hotel')
            ->latest()
            ->take(2)
            ->get()
            ->map(function ($package) {
                return [
                    'type' => 'package',
                    'message' => "Package \"{$package->title}\" was " . ($package->created_at->diffInHours(now()) < 24 ? 'created' : 'updated'),
                    'time' => $package->created_at->diffForHumans(),
                    'icon' => 'box',
                    'color' => 'blue',
                    'created_at' => $package->created_at
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
                    'color' => 'green',
                    'created_at' => $hotel->created_at
                ];
            });

        return $bookingActivities
            ->merge($packageActivities)
            ->merge($hotelActivities)
            ->sortByDesc('created_at')
            ->take(5);
    }
}
