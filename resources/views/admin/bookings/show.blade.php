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

            <!-- Passengers Information -->
            @if($booking->passengers_data && count($booking->passengers_data) > 0)
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
                <h3 class="text-xl font-bold text-gray-800 mb-6 flex items-center">
                    <i class="fas fa-users text-amber-600 mr-3"></i>
                    Passengers Information
                    <span class="ml-2 text-sm font-normal text-gray-500">({{ count($booking->passengers_data) }} {{ count($booking->passengers_data) == 1 ? 'passenger' : 'passengers' }})</span>
                </h3>

                <div class="space-y-6">
                    @foreach($booking->passengers_data as $index => $passenger)
                    <div class="bg-gradient-to-r from-amber-50 to-orange-50 border-2 border-amber-200 rounded-xl p-6">
                        <div class="flex items-center mb-4">
                            <span class="bg-amber-600 text-white rounded-full w-8 h-8 flex items-center justify-center mr-3 text-sm font-bold">
                                {{ $index + 1 }}
                            </span>
                            <h4 class="text-lg font-bold text-gray-800">
                                {{ ucfirst($passenger['type'] ?? 'adult') }} Passenger
                            </h4>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @if(!empty($passenger['full_name_passport']))
                            <div>
                                <label class="text-sm font-medium text-gray-500">Full Name (as per passport)</label>
                                <p class="text-lg font-semibold text-gray-900 mt-1">{{ $passenger['full_name_passport'] }}</p>
                            </div>
                            @endif

                            @if(!empty($passenger['date_of_birth']))
                            <div>
                                <label class="text-sm font-medium text-gray-500">Date of Birth</label>
                                <p class="text-lg text-gray-900 mt-1">{{ \Carbon\Carbon::parse($passenger['date_of_birth'])->format('F d, Y') }}</p>
                            </div>
                            @endif

                            @if(!empty($passenger['gender']))
                            <div>
                                <label class="text-sm font-medium text-gray-500">Gender</label>
                                <p class="text-lg text-gray-900 mt-1">{{ ucfirst($passenger['gender']) }}</p>
                            </div>
                            @endif

                            @if(!empty($passenger['nationality']))
                            <div>
                                <label class="text-sm font-medium text-gray-500">Nationality</label>
                                <p class="text-lg text-gray-900 mt-1">{{ $passenger['nationality'] }}</p>
                            </div>
                            @endif

                            @if(!empty($passenger['passport_number']))
                            <div>
                                <label class="text-sm font-medium text-gray-500">Passport Number</label>
                                <p class="text-lg text-gray-900 mt-1 font-mono">{{ $passenger['passport_number'] }}</p>
                            </div>
                            @endif

                            @if(!empty($passenger['passport_expiration']))
                            <div>
                                <label class="text-sm font-medium text-gray-500">Passport Expiration Date</label>
                                <p class="text-lg text-gray-900 mt-1">{{ \Carbon\Carbon::parse($passenger['passport_expiration'])->format('F d, Y') }}</p>
                            </div>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

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

            <!-- Visa Information -->
            @if($booking->visa_required)
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
                <h3 class="text-xl font-bold text-gray-800 mb-6 flex items-center">
                    <i class="fas fa-passport text-teal-600 mr-3"></i>
                    Visa Information
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label class="text-sm font-medium text-gray-500">Number of Visas</label>
                        <p class="text-lg font-semibold text-gray-900 mt-1">{{ $booking->number_of_visas }}</p>
                    </div>

                    @if($booking->visa_price_per_person)
                    <div>
                        <label class="text-sm font-medium text-gray-500">Visa Price (Per Person)</label>
                        <p class="text-lg font-semibold text-gray-900 mt-1">${{ number_format($booking->visa_price_per_person, 2) }}</p>
                    </div>
                    @endif

                    @if($booking->total_visa_amount)
                    <div>
                        <label class="text-sm font-medium text-gray-500">Total Visa Amount</label>
                        <p class="text-xl font-bold text-teal-600 mt-1">${{ number_format($booking->total_visa_amount, 2) }}</p>
                    </div>
                    @endif
                </div>

                <!-- Passport Images -->
                @if($booking->passport_images && count($booking->passport_images) > 0)
                <div class="mb-6">
                    <label class="text-sm font-medium text-gray-700 mb-3 block">Passport Images ({{ count($booking->passport_images) }})</label>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        @foreach($booking->passport_images as $index => $image)
                        <div class="relative group">
                            <img src="{{ asset('storage/' . $image) }}" alt="Passport {{ $index + 1 }}" class="w-full h-32 object-cover rounded-lg border border-gray-300">
                            <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-60 transition-all rounded-lg flex items-center justify-center">
                                <a href="{{ asset('storage/' . $image) }}" download class="opacity-0 group-hover:opacity-100 bg-white text-gray-800 px-3 py-2 rounded-lg text-sm font-medium hover:bg-gray-100 transition-all">
                                    <i class="fas fa-download mr-1"></i> Download
                                </a>
                            </div>
                            <div class="absolute top-2 left-2">
                                <span class="bg-blue-500 text-white text-xs px-2 py-1 rounded">{{ $index + 1 }}</span>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Applicant Images -->
                @if($booking->applicant_images && count($booking->applicant_images) > 0)
                <div class="mb-6">
                    <label class="text-sm font-medium text-gray-700 mb-3 block">Applicant Photos ({{ count($booking->applicant_images) }})</label>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        @foreach($booking->applicant_images as $index => $image)
                        <div class="relative group">
                            <img src="{{ asset('storage/' . $image) }}" alt="Applicant {{ $index + 1 }}" class="w-full h-32 object-cover rounded-lg border border-gray-300">
                            <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-60 transition-all rounded-lg flex items-center justify-center">
                                <a href="{{ asset('storage/' . $image) }}" download class="opacity-0 group-hover:opacity-100 bg-white text-gray-800 px-3 py-2 rounded-lg text-sm font-medium hover:bg-gray-100 transition-all">
                                    <i class="fas fa-download mr-1"></i> Download
                                </a>
                            </div>
                            <div class="absolute top-2 left-2">
                                <span class="bg-green-500 text-white text-xs px-2 py-1 rounded">{{ $index + 1 }}</span>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Emirates ID Images -->
                @if($booking->emirates_id_images && count($booking->emirates_id_images) > 0)
                <div>
                    <label class="text-sm font-medium text-gray-700 mb-3 block">Emirates ID Images ({{ count($booking->emirates_id_images) }})</label>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        @foreach($booking->emirates_id_images as $index => $image)
                        <div class="relative group">
                            <img src="{{ asset('storage/' . $image) }}" alt="Emirates ID {{ $index + 1 }}" class="w-full h-32 object-cover rounded-lg border border-gray-300">
                            <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-60 transition-all rounded-lg flex items-center justify-center">
                                <a href="{{ asset('storage/' . $image) }}" download class="opacity-0 group-hover:opacity-100 bg-white text-gray-800 px-3 py-2 rounded-lg text-sm font-medium hover:bg-gray-100 transition-all">
                                    <i class="fas fa-download mr-1"></i> Download
                                </a>
                            </div>
                            <div class="absolute top-2 left-2">
                                <span class="bg-purple-500 text-white text-xs px-2 py-1 rounded">{{ $index + 1 }}</span>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>
            @endif

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
