@extends('admin.layouts.app')
@section('page-title', 'Analytics Dashboard')

@section('content')
<div class="flex-1 flex flex-col overflow-auto">
    <!-- Header -->
    <header class="bg-white shadow-sm p-6">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-bold text-gray-800">Analytics Dashboard</h1>
                <p class="text-gray-600 mt-1">Complete overview of your travel business</p>
            </div>
            <div class="flex items-center space-x-3">
                <div class="text-right">
                    <div class="text-sm font-medium text-gray-900">{{ auth()->user()->name }}</div>
                    <div class="text-xs text-gray-500">{{ now()->format('M d, Y') }}</div>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="p-6 flex-1 overflow-auto bg-gray-50">
        
        <!-- Key Metrics Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <!-- Total Revenue -->
            <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl shadow-lg p-6 text-white transform hover:scale-105 transition-transform">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-white bg-opacity-20 rounded-xl flex items-center justify-center">
                        <i class="fas fa-dollar-sign text-2xl"></i>
                    </div>
                    <span class="text-sm bg-white bg-opacity-20 px-3 py-1 rounded-full">
                        {{ $revenueGrowth >= 0 ? '+' : '' }}{{ $revenueGrowth }}%
                    </span>
                </div>
                <h3 class="text-3xl font-bold">${{ number_format($totalRevenue, 2) }}</h3>
                <p class="text-blue-100 mt-1">Total Revenue</p>
            </div>

            <!-- Total Received -->
            <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-2xl shadow-lg p-6 text-white transform hover:scale-105 transition-transform">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-white bg-opacity-20 rounded-xl flex items-center justify-center">
                        <i class="fas fa-check-circle text-2xl"></i>
                    </div>
                    <span class="text-sm bg-white bg-opacity-20 px-3 py-1 rounded-full">
                        {{ $paymentCollectionRate }}%
                    </span>
                </div>
                <h3 class="text-3xl font-bold">${{ number_format($totalReceived, 2) }}</h3>
                <p class="text-green-100 mt-1">Amount Received</p>
            </div>

            <!-- Total Deposit -->
            <div class="bg-gradient-to-br from-orange-500 to-orange-600 rounded-2xl shadow-lg p-6 text-white transform hover:scale-105 transition-transform">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-white bg-opacity-20 rounded-xl flex items-center justify-center">
                        <i class="fas fa-hand-holding-usd text-2xl"></i>
                    </div>
                    <span class="text-sm bg-white bg-opacity-20 px-3 py-1 rounded-full">
                        Partial
                    </span>
                </div>
                <h3 class="text-3xl font-bold">${{ number_format($totalDeposit, 2) }}</h3>
                <p class="text-orange-100 mt-1">Deposits Received</p>
            </div>

            <!-- Pending Amount -->
            <div class="bg-gradient-to-br from-red-500 to-red-600 rounded-2xl shadow-lg p-6 text-white transform hover:scale-105 transition-transform">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-white bg-opacity-20 rounded-xl flex items-center justify-center">
                        <i class="fas fa-clock text-2xl"></i>
                    </div>
                    <span class="text-sm bg-white bg-opacity-20 px-3 py-1 rounded-full">
                        Due
                    </span>
                </div>
                <h3 class="text-3xl font-bold">${{ number_format($totalPending, 2) }}</h3>
                <p class="text-red-100 mt-1">Pending Amount</p>
            </div>
        </div>

        <!-- Secondary Metrics -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <!-- Total Bookings -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <div class="flex items-center mb-2">
                            <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center mr-3">
                                <i class="fas fa-calendar-check text-purple-600"></i>
                            </div>
                            <div>
                                <h3 class="text-2xl font-bold text-gray-800">{{ $totalBookings }}</h3>
                                <p class="text-sm text-gray-500">Total Bookings</p>
                            </div>
                        </div>
                    </div>
                    <div class="text-right">
                        <span class="text-sm {{ $bookingGrowth >= 0 ? 'text-green-600' : 'text-red-600' }} font-medium">
                            {{ $bookingGrowth >= 0 ? '+' : '' }}{{ $bookingGrowth }}%
                        </span>
                    </div>
                </div>
            </div>

            <!-- Total Packages -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <div class="flex items-center mb-2">
                            <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center mr-3">
                                <i class="fas fa-boxes text-blue-600"></i>
                            </div>
                            <div>
                                <h3 class="text-2xl font-bold text-gray-800">{{ $totalPackages }}</h3>
                                <p class="text-sm text-gray-500">Total Packages</p>
                            </div>
                        </div>
                    </div>
                    <div class="text-right">
                        <span class="text-xs text-gray-500">{{ $activePackages }} Active</span>
                    </div>
                </div>
            </div>

            <!-- Total Hotels -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <div class="flex items-center mb-2">
                            <div class="w-10 h-10 bg-indigo-100 rounded-lg flex items-center justify-center mr-3">
                                <i class="fas fa-hotel text-indigo-600"></i>
                            </div>
                            <div>
                                <h3 class="text-2xl font-bold text-gray-800">{{ $totalHotels }}</h3>
                                <p class="text-sm text-gray-500">Total Hotels</p>
                            </div>
                        </div>
                    </div>
                    <div class="text-right">
                        <span class="text-xs text-gray-500">{{ $activeHotels }} Active</span>
                    </div>
                </div>
            </div>

            <!-- Total Categories -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <div class="flex items-center mb-2">
                            <div class="w-10 h-10 bg-pink-100 rounded-lg flex items-center justify-center mr-3">
                                <i class="fas fa-tags text-pink-600"></i>
                            </div>
                            <div>
                                <h3 class="text-2xl font-bold text-gray-800">{{ $totalCategories }}</h3>
                                <p class="text-sm text-gray-500">Categories</p>
                            </div>
                        </div>
                    </div>
                    <div class="text-right">
                        <span class="text-xs text-gray-500">{{ $activeCategories }} Active</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts and Details Row -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
            <!-- Revenue Chart -->
            <div class="lg:col-span-2 bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-bold text-gray-800">Monthly Revenue Trend</h3>
                    <div class="flex items-center space-x-2">
                        <span class="text-sm text-gray-500">Last 12 Months</span>
                    </div>
                </div>
                <canvas id="revenueChart" height="80"></canvas>
            </div>

            <!-- Booking Status Breakdown -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-bold text-gray-800 mb-6">Booking Status</h3>
                <div class="space-y-4">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="w-3 h-3 bg-yellow-500 rounded-full mr-3"></div>
                            <span class="text-sm text-gray-600">Pending</span>
                        </div>
                        <span class="text-sm font-semibold text-gray-800">{{ $pendingBookings }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="w-3 h-3 bg-blue-500 rounded-full mr-3"></div>
                            <span class="text-sm text-gray-600">Confirmed</span>
                        </div>
                        <span class="text-sm font-semibold text-gray-800">{{ $confirmedBookings }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="w-3 h-3 bg-green-500 rounded-full mr-3"></div>
                            <span class="text-sm text-gray-600">Completed</span>
                        </div>
                        <span class="text-sm font-semibold text-gray-800">{{ $completedBookings }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="w-3 h-3 bg-red-500 rounded-full mr-3"></div>
                            <span class="text-sm text-gray-600">Cancelled</span>
                        </div>
                        <span class="text-sm font-semibold text-gray-800">{{ $cancelledBookings }}</span>
                    </div>
                </div>

                <div class="mt-6 pt-6 border-t border-gray-200">
                    <h4 class="text-sm font-semibold text-gray-700 mb-4">Payment Status</h4>
                    <div class="space-y-3">
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600">Fully Paid</span>
                            <span class="text-sm font-semibold text-green-600">{{ $paidBookings }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600">Partial Payment</span>
                            <span class="text-sm font-semibold text-orange-600">{{ $partialPayments }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600">Pending Payment</span>
                            <span class="text-sm font-semibold text-yellow-600">{{ $pendingPayments }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bottom Row -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Top Packages -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-bold text-gray-800 mb-6">Top Performing Packages</h3>
                <div class="space-y-4">
                    @forelse($topPackages as $package)
                    <div class="flex items-center justify-between p-4 bg-gray-50 rounded-xl hover:bg-gray-100 transition-colors">
                        <div class="flex items-center flex-1">
                            <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center mr-4">
                                <i class="fas fa-box text-blue-600"></i>
                            </div>
                            <div class="flex-1">
                                <h4 class="font-semibold text-gray-800">{{ $package->title }}</h4>
                                <p class="text-sm text-gray-500">${{ number_format($package->price, 2) }}</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <span class="text-lg font-bold text-blue-600">{{ $package->bookings_count }}</span>
                            <p class="text-xs text-gray-500">bookings</p>
                        </div>
                    </div>
                    @empty
                    <p class="text-center text-gray-500 py-8">No packages available</p>
                    @endforelse
                </div>
            </div>

            <!-- Recent Bookings -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-bold text-gray-800 mb-6">Recent Bookings</h3>
                <div class="space-y-4">
                    @forelse($recentBookings as $booking)
                    <div class="flex items-center justify-between p-4 bg-gray-50 rounded-xl hover:bg-gray-100 transition-colors">
                        <div class="flex items-center flex-1">
                            <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center mr-4">
                                <i class="fas fa-calendar-check text-purple-600"></i>
                            </div>
                            <div class="flex-1">
                                <h4 class="font-semibold text-gray-800">{{ $booking->customer_name }}</h4>
                                <p class="text-sm text-gray-500">{{ $booking->package->title }}</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <span class="text-sm font-bold text-gray-800">${{ number_format($booking->total_amount, 2) }}</span>
                            <p class="text-xs text-gray-500">{{ $booking->created_at->diffForHumans() }}</p>
                        </div>
                    </div>
                    @empty
                    <p class="text-center text-gray-500 py-8">No recent bookings</p>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Performance Metrics -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mt-8">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 text-center">
                <div class="text-3xl font-bold text-blue-600">{{ $packageUtilization }}%</div>
                <p class="text-sm text-gray-600 mt-2">Package Utilization</p>
            </div>
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 text-center">
                <div class="text-3xl font-bold text-green-600">{{ $bookingConversionRate }}%</div>
                <p class="text-sm text-gray-600 mt-2">Booking Conversion</p>
            </div>
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 text-center">
                <div class="text-3xl font-bold text-purple-600">{{ $paymentCollectionRate }}%</div>
                <p class="text-sm text-gray-600 mt-2">Payment Collection</p>
            </div>
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 text-center">
                <div class="text-3xl font-bold text-orange-600">{{ $hotelUtilization }}%</div>
                <p class="text-sm text-gray-600 mt-2">Hotel Utilization</p>
            </div>
        </div>
    </main>
</div>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Revenue Chart
    const revenueCtx = document.getElementById('revenueChart').getContext('2d');
    new Chart(revenueCtx, {
        type: 'line',
        data: {
            labels: @json($revenueData['labels']),
            datasets: [{
                label: 'Revenue',
                data: @json($revenueData['data']),
                borderColor: 'rgb(59, 130, 246)',
                backgroundColor: 'rgba(59, 130, 246, 0.1)',
                tension: 0.4,
                fill: true,
                pointRadius: 4,
                pointHoverRadius: 6
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return '$' + context.parsed.y.toFixed(2);
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return '$' + value;
                        }
                    }
                }
            }
        }
    });
});
</script>
@endsection
