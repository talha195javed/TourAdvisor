@extends('admin.layouts.app')
@section('page-title', 'Dashboard')

@section('content')

<!-- Main content -->
<div class="flex-1 flex flex-col overflow-auto">
    <!-- Topbar -->
    <header class="bg-white shadow-card p-4 flex justify-between items-center">
        <div>
            <h1 class="text-xl font-semibold text-gray-800">Dashboard</h1>
            <nav class="flex text-sm text-gray-500 mt-1">
                <a href="#" class="text-primary-600 hover:text-primary-800">Dashboard</a>
                <span class="mx-2">/</span>
                <span>Overview</span>
            </nav>
        </div>
        <div class="flex items-center space-x-4">
            <div class="flex items-center space-x-3 bg-gray-50 rounded-lg px-4 py-2">
                <i class="fas fa-search text-gray-400"></i>
                <input type="text" placeholder="Search..." class="bg-transparent border-none focus:outline-none focus:ring-0 text-sm">
            </div>

            <div class="relative">
                <button class="p-2 rounded-lg hover:bg-gray-100 transition-colors relative">
                    <i class="fas fa-bell text-xl text-gray-600"></i>
                    <span class="notification-dot"></span>
                </button>
            </div>

            <div class="flex items-center text-gray-700 border-l border-gray-200 pl-4">
                <div class="w-8 h-8 rounded-full bg-primary-100 flex items-center justify-center text-primary-800 font-semibold mr-2">
                    {{ substr(auth()->user()->name, 0, 1) }}
                </div>
                <div>
                    <div class="text-sm font-medium">Welcome, {{ auth()->user()->name }}</div>
                    <div class="text-xs text-gray-500">Last login: {{ \Carbon\Carbon::now()->format('M j, Y') }}</div>
                </div>
            </div>
        </div>
    </header>

    <!-- Page Content -->
    <main class="p-6 flex-1 overflow-auto bg-gray-50">
        <!-- Stats Overview -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <!-- Total Packages -->
            <div class="stat-card bg-white rounded-2xl shadow-soft p-6 flex items-center justify-between hover-lift animate-fadeIn"
                 style="--gradient-start: #3B82F6; --gradient-end: #1D4ED8;">
                <div class="flex items-center">
                    <div class="w-12 h-12 rounded-xl bg-blue-100 flex items-center justify-center mr-4">
                        <i class="fas fa-boxes text-blue-600 text-xl"></i>
                    </div>
                    <div>
                        <h2 class="text-2xl font-bold text-gray-800">{{ $totalPackages }}</h2>
                        <p class="text-sm text-gray-500 mt-1">Total Packages</p>
                    </div>
                </div>
                <div class="text-right">
                    <div class="text-green-500 text-sm font-medium flex items-center justify-end">
                        <i class="fas fa-arrow-up mr-1 text-xs"></i>
                        <span>{{ $packageGrowth }}%</span>
                    </div>
                    <div class="text-xs text-gray-400 mt-1">Since last month</div>
                </div>
            </div>

            <!-- Active Packages -->
            <div class="stat-card bg-white rounded-2xl shadow-soft p-6 flex items-center justify-between hover-lift animate-fadeIn"
                 style="--gradient-start: #10B981; --gradient-end: #047857;">
                <div class="flex items-center">
                    <div class="w-12 h-12 rounded-xl bg-green-100 flex items-center justify-center mr-4">
                        <i class="fas fa-check-circle text-green-600 text-xl"></i>
                    </div>
                    <div>
                        <h2 class="text-2xl font-bold text-gray-800">{{ $activePackages }}</h2>
                        <p class="text-sm text-gray-500 mt-1">Active Packages</p>
                    </div>
                </div>
                <div class="text-right">
                    <div class="text-green-500 text-sm font-medium flex items-center justify-end">
                        <i class="fas fa-arrow-up mr-1 text-xs"></i>
                        <span>{{ $packageGrowth }}%</span>
                    </div>
                    <div class="text-xs text-gray-400 mt-1">Since last month</div>
                </div>
            </div>

            <!-- Total Hotels -->
            <div class="stat-card bg-white rounded-2xl shadow-soft p-6 flex items-center justify-between hover-lift animate-fadeIn"
                 style="--gradient-start: #8B5CF6; --gradient-end: #7C3AED;">
                <div class="flex items-center">
                    <div class="w-12 h-12 rounded-xl bg-purple-100 flex items-center justify-center mr-4">
                        <i class="fas fa-hotel text-purple-600 text-xl"></i>
                    </div>
                    <div>
                        <h2 class="text-2xl font-bold text-gray-800">{{ $totalHotels }}</h2>
                        <p class="text-sm text-gray-500 mt-1">Total Hotels</p>
                    </div>
                </div>
                <div class="text-right">
                    <div class="text-green-500 text-sm font-medium flex items-center justify-end">
                        <i class="fas fa-arrow-up mr-1 text-xs"></i>
                        <span>{{ $hotelGrowth }}%</span>
                    </div>
                    <div class="text-xs text-gray-400 mt-1">Since last month</div>
                </div>
            </div>

            <!-- Active Hotels -->
            <div class="stat-card bg-white rounded-2xl shadow-soft p-6 flex items-center justify-between hover-lift animate-fadeIn"
                 style="--gradient-start: #EF4444; --gradient-end: #DC2626;">
                <div class="flex items-center">
                    <div class="w-12 h-12 rounded-xl bg-red-100 flex items-center justify-center mr-4">
                        <i class="fas fa-check text-red-600 text-xl"></i>
                    </div>
                    <div>
                        <h2 class="text-2xl font-bold text-gray-800">{{ $activeHotels }}</h2>
                        <p class="text-sm text-gray-500 mt-1">Active Hotels</p>
                    </div>
                </div>
                <div class="text-right">
                    <div class="text-green-500 text-sm font-medium flex items-center justify-end">
                        <i class="fas fa-arrow-up mr-1 text-xs"></i>
                        <span>{{ $hotelGrowth }}%</span>
                    </div>
                    <div class="text-xs text-gray-400 mt-1">Since last month</div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
            <!-- Revenue Overview -->
            <div class="lg:col-span-2 bg-white rounded-2xl shadow-soft p-6 animate-slideIn">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-lg font-semibold text-gray-800">Revenue Overview</h3>
                    <div class="flex space-x-2">
                        <button class="px-3 py-1 text-xs bg-primary-100 text-primary-700 rounded-lg font-medium">Monthly</button>
                        <button class="px-3 py-1 text-xs bg-gray-100 text-gray-600 rounded-lg font-medium">Quarterly</button>
                        <button class="px-3 py-1 text-xs bg-gray-100 text-gray-600 rounded-lg font-medium">Yearly</button>
                    </div>
                </div>
                <div class="chart-container">
                    <canvas id="revenueChart"></canvas>
                </div>
            </div>

            <!-- Performance Metrics -->
            <div class="bg-white rounded-2xl shadow-soft p-6 animate-slideIn">
                <h3 class="text-lg font-semibold text-gray-800 mb-6">Performance Metrics</h3>
                <div class="space-y-6">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="w-10 h-10 rounded-lg bg-blue-100 flex items-center justify-center mr-3">
                                <i class="fas fa-box-open text-blue-600"></i>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-700">Package Utilization</p>
                                <p class="text-xs text-gray-500">Active vs Total</p>
                            </div>
                        </div>
                        <div class="relative w-16 h-16">
                            <svg class="w-16 h-16 transform -rotate-90">
                                <circle cx="32" cy="32" r="28" stroke="#E5E7EB" stroke-width="6" fill="none"></circle>
                                <circle cx="32" cy="32" r="28" stroke="#3B82F6" stroke-width="6" fill="none"
                                        stroke-dasharray="175.93" stroke-dashoffset="{{ 175.93 - ($packageUtilization / 100 * 175.93) }}" stroke-linecap="round"></circle>
                            </svg>
                            <div class="absolute inset-0 flex items-center justify-center">
                                <span class="text-sm font-bold text-gray-800">{{ $packageUtilization }}%</span>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="w-10 h-10 rounded-lg bg-green-100 flex items-center justify-center mr-3">
                                <i class="fas fa-hotel text-green-600"></i>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-700">Hotel Utilization</p>
                                <p class="text-xs text-gray-500">Active vs Total</p>
                            </div>
                        </div>
                        <div class="relative w-16 h-16">
                            <svg class="w-16 h-16 transform -rotate-90">
                                <circle cx="32" cy="32" r="28" stroke="#E5E7EB" stroke-width="6" fill="none"></circle>
                                <circle cx="32" cy="32" r="28" stroke="#10B981" stroke-width="6" fill="none"
                                        stroke-dasharray="175.93" stroke-dashoffset="{{ 175.93 - ($hotelUtilization / 100 * 175.93) }}" stroke-linecap="round"></circle>
                            </svg>
                            <div class="absolute inset-0 flex items-center justify-center">
                                <span class="text-sm font-bold text-gray-800">{{ $hotelUtilization }}%</span>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="w-10 h-10 rounded-lg bg-purple-100 flex items-center justify-center mr-3">
                                <i class="fas fa-users text-purple-600"></i>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-700">Customer Satisfaction</p>
                                <p class="text-xs text-gray-500">Based on reviews</p>
                            </div>
                        </div>
                        <div class="relative w-16 h-16">
                            <svg class="w-16 h-16 transform -rotate-90">
                                <circle cx="32" cy="32" r="28" stroke="#E5E7EB" stroke-width="6" fill="none"></circle>
                                <circle cx="32" cy="32" r="28" stroke="#8B5CF6" stroke-width="6" fill="none"
                                        stroke-dasharray="175.93" stroke-dashoffset="26.39" stroke-linecap="round"></circle>
                            </svg>
                            <div class="absolute inset-0 flex items-center justify-center">
                                <span class="text-sm font-bold text-gray-800">85%</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
            <!-- Recent Packages -->
            <div class="bg-white rounded-2xl shadow-soft p-6 animate-fadeIn">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-lg font-semibold text-gray-800">Recent Packages</h3>
                    <a href="{{ route('admin.packages.index') }}" class="text-primary-600 text-sm font-medium hover:text-primary-800 flex items-center">
                        View All
                        <i class="fas fa-chevron-right ml-1 text-xs"></i>
                    </a>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Package</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Hotel</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                        @forelse($recentPackages as $package)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-4 py-3 text-sm font-medium text-gray-900">{{ $package->title }}</td>
                            <td class="px-4 py-3 text-sm text-gray-500">{{ $package->hotel->name ?? 'No Hotel' }}</td>
                            <td class="px-4 py-3 text-sm font-semibold text-green-600">${{ number_format($package->price, 2) }}</td>
                            <td class="px-4 py-3">
                                <span class="px-2 py-1 text-xs {{ $package->is_active ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }} rounded-full">
                                    {{ $package->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-4 py-3 text-sm text-gray-500 text-center">No packages found</td>
                        </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="bg-white rounded-2xl shadow-soft p-6 animate-fadeIn">
                <h3 class="text-lg font-semibold text-gray-800 mb-6">Quick Actions</h3>
                <div class="grid grid-cols-2 gap-4">
                    <a href="{{ route('admin.packages.create') }}" class="p-4 border border-gray-200 rounded-xl hover:border-primary-300 hover:bg-primary-50 transition-colors group">
                        <div class="flex flex-col items-center text-center">
                            <div class="w-12 h-12 rounded-lg bg-blue-100 flex items-center justify-center mb-3 group-hover:bg-blue-200 transition-colors">
                                <i class="fas fa-plus text-blue-600 text-lg"></i>
                            </div>
                            <span class="text-sm font-medium text-gray-700">Add Package</span>
                        </div>
                    </a>
                    <a href="{{ route('admin.hotels.create') }}" class="p-4 border border-gray-200 rounded-xl hover:border-primary-300 hover:bg-primary-50 transition-colors group">
                        <div class="flex flex-col items-center text-center">
                            <div class="w-12 h-12 rounded-lg bg-green-100 flex items-center justify-center mb-3 group-hover:bg-green-200 transition-colors">
                                <i class="fas fa-hotel text-green-600 text-lg"></i>
                            </div>
                            <span class="text-sm font-medium text-gray-700">Add Hotel</span>
                        </div>
                    </a>
                    <a href="#" class="p-4 border border-gray-200 rounded-xl hover:border-primary-300 hover:bg-primary-50 transition-colors group construction-link">
                        <div class="flex flex-col items-center text-center">
                            <div class="w-12 h-12 rounded-lg bg-purple-100 flex items-center justify-center mb-3 group-hover:bg-purple-200 transition-colors">
                                <i class="fas fa-users text-purple-600 text-lg"></i>
                            </div>
                            <span class="text-sm font-medium text-gray-700">Manage Users</span>
                        </div>
                    </a>
                    <a href="#" class="p-4 border border-gray-200 rounded-xl hover:border-primary-300 hover:bg-primary-50 transition-colors group construction-link">
                        <div class="flex flex-col items-center text-center">
                            <div class="w-12 h-12 rounded-lg bg-yellow-100 flex items-center justify-center mb-3 group-hover:bg-yellow-200 transition-colors">
                                <i class="fas fa-chart-bar text-yellow-600 text-lg"></i>
                            </div>
                            <span class="text-sm font-medium text-gray-700">View Reports</span>
                        </div>
                    </a>
                </div>
            </div>
        </div>

        <!-- Recent Activity -->
        <div class="bg-white rounded-2xl shadow-soft p-6 animate-slideIn">
            <h3 class="text-lg font-semibold text-gray-800 mb-6">Recent Activity</h3>
            <div class="space-y-4">
                @forelse($recentActivity as $activity)
                <div class="flex items-start">
                    <div class="w-10 h-10 rounded-full bg-{{ $activity['color'] }}-100 flex items-center justify-center mr-4 mt-1">
                        <i class="fas fa-{{ $activity['icon'] }} text-{{ $activity['color'] }}-600"></i>
                    </div>
                    <div class="flex-1">
                        <p class="text-sm font-medium text-gray-800">{{ $activity['message'] }}</p>
                        <p class="text-xs text-gray-500 mt-1">{{ $activity['time'] }}</p>
                    </div>
                    <span class="px-2 py-1 text-xs bg-{{ $activity['color'] }}-100 text-{{ $activity['color'] }}-800 rounded-full capitalize">
                        {{ $activity['type'] }}
                    </span>
                </div>
                @empty
                <div class="text-center text-gray-500 py-4">
                    <i class="fas fa-inbox text-3xl mb-2 text-gray-300"></i>
                    <p>No recent activity</p>
                </div>
                @endforelse
            </div>
        </div>
    </main>
</div>

<script>
    // Revenue Chart
    const revenueCtx = document.getElementById('revenueChart').getContext('2d');
    const revenueChart = new Chart(revenueCtx, {
        type: 'line',
        data: {
            labels: @json($revenueData['labels']),
            datasets: [{
                label: 'Revenue',
                data: @json($revenueData['data']),
                borderColor: '#0ea5e9',
                backgroundColor: 'rgba(14, 165, 233, 0.1)',
                borderWidth: 3,
                fill: true,
                tension: 0.4,
                pointBackgroundColor: '#0ea5e9',
                pointRadius: 4,
                pointHoverRadius: 6
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    mode: 'index',
                    intersect: false,
                    backgroundColor: 'rgba(255, 255, 255, 0.9)',
                    titleColor: '#1f2937',
                    bodyColor: '#4b5563',
                    borderColor: '#e5e7eb',
                    borderWidth: 1,
                    padding: 12,
                    boxPadding: 6,
                    usePointStyle: true,
                    callbacks: {
                        label: function(context) {
                            return `Revenue: $${context.parsed.y.toLocaleString()}`;
                        }
                    }
                }
            },
            scales: {
                x: {
                    grid: {
                        display: false
                    },
                    ticks: {
                        color: '#6b7280'
                    }
                },
                y: {
                    grid: {
                        color: '#f3f4f6'
                    },
                    ticks: {
                        color: '#6b7280',
                        callback: function(value) {
                            return '$' + value.toLocaleString();
                        }
                    }
                }
            },
            interaction: {
                intersect: false,
                mode: 'nearest'
            }
        }
    });
</script>
@endsection
