@extends('admin.layouts.app')

@section('page-title', 'Booking Details')

@section('content')
<div class="container-fluid px-4 py-6">
    <!-- Header -->
    <div class="flex items-center justify-between mb-8">
        <div class="flex items-center">
            <a href="{{ route('admin.bookings.index') }}" class="mr-4 text-gray-600 hover:text-gray-900">
                <i class="fas fa-arrow-left text-xl"></i>
            </a>
            <div>
                <h1 class="text-3xl font-bold text-gray-800">Booking Details</h1>
                <p class="text-gray-600 mt-1">Reference: {{ $booking->booking_reference }}</p>
            </div>
        </div>
        <div class="flex space-x-3">
            <a href="{{ route('admin.bookings.edit', $booking) }}" class="px-6 py-3 bg-blue-600 text-white rounded-xl hover:bg-blue-700 transition-colors">
                <i class="fas fa-edit mr-2"></i>
                Edit Booking
            </a>
            <form action="{{ route('admin.bookings.destroy', $booking) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this booking?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="px-6 py-3 bg-red-600 text-white rounded-xl hover:bg-red-700 transition-colors">
                    <i class="fas fa-trash mr-2"></i>
                    Delete
                </button>
            </form>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Customer Information -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
                <h3 class="text-xl font-bold text-gray-800 mb-6 flex items-center">
                    <i class="fas fa-user text-blue-600 mr-3"></i>
                    Customer Information
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="text-sm font-medium text-gray-500">Full Name</label>
                        <p class="text-lg font-semibold text-gray-900 mt-1">{{ $booking->customer_name }}</p>
                    </div>

                    <div>
                        <label class="text-sm font-medium text-gray-500">Email Address</label>
                        <p class="text-lg text-gray-900 mt-1">
                            <a href="mailto:{{ $booking->customer_email }}" class="text-blue-600 hover:text-blue-800">
                                {{ $booking->customer_email }}
                            </a>
                        </p>
                    </div>

                    <div>
                        <label class="text-sm font-medium text-gray-500">Phone Number</label>
                        <p class="text-lg text-gray-900 mt-1">
                            <a href="tel:{{ $booking->customer_phone }}" class="text-blue-600 hover:text-blue-800">
                                {{ $booking->customer_phone }}
                            </a>
                        </p>
                    </div>

                    @if($booking->customer_country)
                    <div>
                        <label class="text-sm font-medium text-gray-500">Country</label>
                        <p class="text-lg text-gray-900 mt-1">{{ $booking->customer_country }}</p>
                    </div>
                    @endif

                    @if($booking->customer_address)
                    <div class="md:col-span-2">
                        <label class="text-sm font-medium text-gray-500">Address</label>
                        <p class="text-lg text-gray-900 mt-1">{{ $booking->customer_address }}</p>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Booking Details -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
                <h3 class="text-xl font-bold text-gray-800 mb-6 flex items-center">
                    <i class="fas fa-calendar-alt text-green-600 mr-3"></i>
                    Booking Details
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="md:col-span-2">
                        <label class="text-sm font-medium text-gray-500">Package</label>
                        <p class="text-lg font-semibold text-gray-900 mt-1">{{ $booking->package->title }}</p>
                    </div>

                    <div>
                        <label class="text-sm font-medium text-gray-500">Travel Date</label>
                        <p class="text-lg text-gray-900 mt-1">{{ $booking->travel_date->format('F d, Y') }}</p>
                    </div>

                    @if($booking->return_date)
                    <div>
                        <label class="text-sm font-medium text-gray-500">Return Date</label>
                        <p class="text-lg text-gray-900 mt-1">{{ $booking->return_date->format('F d, Y') }}</p>
                    </div>
                    @endif

                    <div>
                        <label class="text-sm font-medium text-gray-500">Number of Adults</label>
                        <p class="text-lg text-gray-900 mt-1">{{ $booking->number_of_adults }}</p>
                    </div>

                    <div>
                        <label class="text-sm font-medium text-gray-500">Number of Children</label>
                        <p class="text-lg text-gray-900 mt-1">{{ $booking->number_of_children }}</p>
                    </div>

                    @if($booking->number_of_infants > 0)
                    <div>
                        <label class="text-sm font-medium text-gray-500">Number of Infants</label>
                        <p class="text-lg text-gray-900 mt-1">{{ $booking->number_of_infants }}</p>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Payment Information -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
                <h3 class="text-xl font-bold text-gray-800 mb-6 flex items-center">
                    <i class="fas fa-dollar-sign text-purple-600 mr-3"></i>
                    Payment Information
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="text-sm font-medium text-gray-500">Package Price (Per Person)</label>
                        <p class="text-lg font-semibold text-gray-900 mt-1">${{ number_format($booking->package_price, 2) }}</p>
                    </div>

                    <div>
                        <label class="text-sm font-medium text-gray-500">Total Amount</label>
                        <p class="text-2xl font-bold text-gray-900 mt-1">${{ number_format($booking->total_amount, 2) }}</p>
                    </div>

                    <div>
                        <label class="text-sm font-medium text-gray-500">Paid Amount</label>
                        <p class="text-lg font-semibold text-green-600 mt-1">${{ number_format($booking->paid_amount, 2) }}</p>
                    </div>

                    <div>
                        <label class="text-sm font-medium text-gray-500">Remaining Amount</label>
                        <p class="text-lg font-semibold {{ $booking->remaining_amount > 0 ? 'text-red-600' : 'text-green-600' }} mt-1">
                            ${{ number_format($booking->remaining_amount, 2) }}
                        </p>
                    </div>

                    @if($booking->payment_method)
                    <div>
                        <label class="text-sm font-medium text-gray-500">Payment Method</label>
                        <p class="text-lg text-gray-900 mt-1">{{ ucfirst(str_replace('_', ' ', $booking->payment_method)) }}</p>
                    </div>
                    @endif

                    @if($booking->transaction_id)
                    <div>
                        <label class="text-sm font-medium text-gray-500">Transaction ID</label>
                        <p class="text-lg text-gray-900 mt-1 font-mono">{{ $booking->transaction_id }}</p>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Special Requests & Notes -->
            @if($booking->special_requests || $booking->admin_notes)
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
                <h3 class="text-xl font-bold text-gray-800 mb-6 flex items-center">
                    <i class="fas fa-sticky-note text-orange-600 mr-3"></i>
                    Notes & Requests
                </h3>

                @if($booking->special_requests)
                <div class="mb-4">
                    <label class="text-sm font-medium text-gray-500">Special Requests</label>
                    <p class="text-gray-900 mt-2 p-4 bg-gray-50 rounded-lg">{{ $booking->special_requests }}</p>
                </div>
                @endif

                @if($booking->admin_notes)
                <div>
                    <label class="text-sm font-medium text-gray-500">Admin Notes (Internal)</label>
                    <p class="text-gray-900 mt-2 p-4 bg-yellow-50 rounded-lg border border-yellow-200">{{ $booking->admin_notes }}</p>
                </div>
                @endif
            </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Status Card -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-bold text-gray-800 mb-4">Status</h3>

                <div class="space-y-4">
                    <div>
                        <label class="text-sm font-medium text-gray-500">Booking Status</label>
                        @php
                            $statusColors = [
                                'pending' => 'bg-yellow-100 text-yellow-800 border-yellow-200',
                                'confirmed' => 'bg-blue-100 text-blue-800 border-blue-200',
                                'cancelled' => 'bg-red-100 text-red-800 border-red-200',
                                'completed' => 'bg-green-100 text-green-800 border-green-200',
                            ];
                        @endphp
                        <div class="mt-2">
                            <span class="px-4 py-2 inline-flex text-sm font-semibold rounded-full border {{ $statusColors[$booking->status] ?? 'bg-gray-100 text-gray-800 border-gray-200' }}">
                                {{ ucfirst($booking->status) }}
                            </span>
                        </div>
                    </div>

                    <div>
                        <label class="text-sm font-medium text-gray-500">Payment Status</label>
                        @php
                            $paymentColors = [
                                'pending' => 'bg-yellow-100 text-yellow-800 border-yellow-200',
                                'partial' => 'bg-orange-100 text-orange-800 border-orange-200',
                                'paid' => 'bg-green-100 text-green-800 border-green-200',
                                'refunded' => 'bg-red-100 text-red-800 border-red-200',
                            ];
                        @endphp
                        <div class="mt-2">
                            <span class="px-4 py-2 inline-flex text-sm font-semibold rounded-full border {{ $paymentColors[$booking->payment_status] ?? 'bg-gray-100 text-gray-800 border-gray-200' }}">
                                {{ ucfirst($booking->payment_status) }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Timeline Card -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-bold text-gray-800 mb-4">Timeline</h3>

                <div class="space-y-4">
                    <div class="flex items-start">
                        <div class="flex-shrink-0 w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-plus text-blue-600 text-xs"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-gray-900">Booking Created</p>
                            <p class="text-xs text-gray-500">{{ $booking->created_at->format('M d, Y h:i A') }}</p>
                        </div>
                    </div>

                    @if($booking->updated_at != $booking->created_at)
                    <div class="flex items-start">
                        <div class="flex-shrink-0 w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-edit text-green-600 text-xs"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-gray-900">Last Updated</p>
                            <p class="text-xs text-gray-500">{{ $booking->updated_at->format('M d, Y h:i A') }}</p>
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="bg-gradient-to-br from-blue-50 to-purple-50 rounded-2xl border border-blue-200 p-6">
                <h3 class="text-lg font-bold text-gray-800 mb-4">Quick Actions</h3>

                <div class="space-y-3">
                    <a href="mailto:{{ $booking->customer_email }}" class="block w-full px-4 py-3 bg-white text-gray-700 rounded-xl hover:bg-gray-50 transition-colors text-center font-medium">
                        <i class="fas fa-envelope mr-2"></i>
                        Email Customer
                    </a>
                    <a href="tel:{{ $booking->customer_phone }}" class="block w-full px-4 py-3 bg-white text-gray-700 rounded-xl hover:bg-gray-50 transition-colors text-center font-medium">
                        <i class="fas fa-phone mr-2"></i>
                        Call Customer
                    </a>
                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $booking->customer_phone) }}" target="_blank" class="block w-full px-4 py-3 bg-green-600 text-white rounded-xl hover:bg-green-700 transition-colors text-center font-medium">
                        <i class="fab fa-whatsapp mr-2"></i>
                        WhatsApp
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
