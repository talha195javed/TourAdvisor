@extends('admin.layouts.app')

@section('page-title', 'Create New Booking')

@section('content')
<div class="container-fluid px-4 py-6">
    <!-- Header -->
    <div class="flex items-center mb-8">
        <a href="{{ route('admin.bookings.index') }}" class="mr-4 text-gray-600 hover:text-gray-900">
            <i class="fas fa-arrow-left text-xl"></i>
        </a>
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Create New Booking</h1>
            <p class="text-gray-600 mt-1">Add a new customer booking to the system</p>
        </div>
    </div>

    <!-- Form -->
    <form action="{{ route('admin.bookings.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf

        <!-- Customer Information -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
            <h3 class="text-xl font-bold text-gray-800 mb-6 flex items-center">
                <i class="fas fa-user text-blue-600 mr-3"></i>
                Customer Information
            </h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Customer Name -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Customer Name <span class="text-red-500">*</span>
                    </label>
                    <input
                        type="text"
                        name="customer_name"
                        value="{{ old('customer_name') }}"
                        required
                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('customer_name') border-red-300 @enderror"
                        placeholder="Enter customer full name"
                    >
                    @error('customer_name')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Customer Email -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Email Address <span class="text-red-500">*</span>
                    </label>
                    <input
                        type="email"
                        name="customer_email"
                        value="{{ old('customer_email') }}"
                        required
                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('customer_email') border-red-300 @enderror"
                        placeholder="customer@example.com"
                    >
                    @error('customer_email')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Customer Phone -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Phone Number <span class="text-red-500">*</span>
                    </label>
                    <input
                        type="text"
                        name="customer_phone"
                        value="{{ old('customer_phone') }}"
                        required
                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('customer_phone') border-red-300 @enderror"
                        placeholder="+971 50 123 4567"
                    >
                    @error('customer_phone')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Customer Country -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Country
                    </label>
                    <input
                        type="text"
                        name="customer_country"
                        value="{{ old('customer_country') }}"
                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('customer_country') border-red-300 @enderror"
                        placeholder="United Arab Emirates"
                    >
                    @error('customer_country')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Customer Address -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Address
                    </label>
                    <textarea
                        name="customer_address"
                        rows="3"
                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('customer_address') border-red-300 @enderror"
                        placeholder="Enter customer address"
                    >{{ old('customer_address') }}</textarea>
                    @error('customer_address')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Booking Details -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
            <h3 class="text-xl font-bold text-gray-800 mb-6 flex items-center">
                <i class="fas fa-calendar-alt text-green-600 mr-3"></i>
                Booking Details
            </h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Package Selection -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Select Package <span class="text-red-500">*</span>
                    </label>
                    <select
                        name="package_id"
                        id="package_select"
                        required
                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('package_id') border-red-300 @enderror"
                    >
                        <option value="">Select a package</option>
                        @foreach($packages as $package)
                        <option value="{{ $package->id }}" data-price="{{ $package->price }}" data-visa-price="{{ $package->visa_price ?? 0 }}" {{ old('package_id') == $package->id ? 'selected' : '' }}>
                            {{ $package->title }} - ${{ number_format($package->price, 2) }}
                        </option>
                        @endforeach
                    </select>
                    @error('package_id')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Travel Date -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Travel Date <span class="text-red-500">*</span>
                    </label>
                    <input
                        type="date"
                        name="travel_date"
                        value="{{ old('travel_date') }}"
                        required
                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('travel_date') border-red-300 @enderror"
                    >
                    @error('travel_date')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Return Date -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Return Date
                    </label>
                    <input
                        type="date"
                        name="return_date"
                        value="{{ old('return_date') }}"
                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('return_date') border-red-300 @enderror"
                    >
                    @error('return_date')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Number of Adults -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Number of Adults <span class="text-red-500">*</span>
                    </label>
                    <input
                        type="number"
                        name="number_of_adults"
                        id="number_of_adults"
                        value="{{ old('number_of_adults', 1) }}"
                        min="1"
                        required
                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('number_of_adults') border-red-300 @enderror"
                    >
                    @error('number_of_adults')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Number of Children -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Number of Children
                    </label>
                    <input
                        type="number"
                        name="number_of_children"
                        id="number_of_children"
                        value="{{ old('number_of_children', 0) }}"
                        min="0"
                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('number_of_children') border-red-300 @enderror"
                    >
                    @error('number_of_children')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Number of Infants -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Number of Infants
                    </label>
                    <input
                        type="number"
                        name="number_of_infants"
                        value="{{ old('number_of_infants', 0) }}"
                        min="0"
                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('number_of_infants') border-red-300 @enderror"
                    >
                    @error('number_of_infants')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Pricing Information -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
            <h3 class="text-xl font-bold text-gray-800 mb-6 flex items-center">
                <i class="fas fa-dollar-sign text-purple-600 mr-3"></i>
                Pricing Information
            </h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Package Price -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Package Price (Per Person) <span class="text-red-500">*</span>
                    </label>
                    <input
                        type="number"
                        name="package_price"
                        id="package_price"
                        value="{{ old('package_price') }}"
                        step="0.01"
                        min="0"
                        required
                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('package_price') border-red-300 @enderror"
                        placeholder="0.00"
                    >
                    @error('package_price')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Total Amount -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Total Amount <span class="text-red-500">*</span>
                    </label>
                    <input
                        type="number"
                        name="total_amount"
                        id="total_amount"
                        value="{{ old('total_amount') }}"
                        step="0.01"
                        min="0"
                        required
                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('total_amount') border-red-300 @enderror"
                        placeholder="0.00"
                    >
                    @error('total_amount')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Paid Amount -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Paid Amount
                    </label>
                    <input
                        type="number"
                        name="paid_amount"
                        id="paid_amount"
                        value="{{ old('paid_amount', 0) }}"
                        step="0.01"
                        min="0"
                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('paid_amount') border-red-300 @enderror"
                        placeholder="0.00"
                    >
                    @error('paid_amount')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Payment Method -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Payment Method
                    </label>
                    <select
                        name="payment_method"
                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('payment_method') border-red-300 @enderror"
                    >
                        <option value="">Select payment method</option>
                        <option value="cash" {{ old('payment_method') == 'cash' ? 'selected' : '' }}>Cash</option>
                        <option value="card" {{ old('payment_method') == 'card' ? 'selected' : '' }}>Credit/Debit Card</option>
                        <option value="bank_transfer" {{ old('payment_method') == 'bank_transfer' ? 'selected' : '' }}>Bank Transfer</option>
                        <option value="online" {{ old('payment_method') == 'online' ? 'selected' : '' }}>Online Payment</option>
                    </select>
                    @error('payment_method')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Transaction ID -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Transaction ID
                    </label>
                    <input
                        type="text"
                        name="transaction_id"
                        value="{{ old('transaction_id') }}"
                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('transaction_id') border-red-300 @enderror"
                        placeholder="TXN123456789"
                    >
                    @error('transaction_id')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Payment Status -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Payment Status <span class="text-red-500">*</span>
                    </label>
                    <select
                        name="payment_status"
                        required
                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('payment_status') border-red-300 @enderror"
                    >
                        <option value="pending" {{ old('payment_status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="partial" {{ old('payment_status') == 'partial' ? 'selected' : '' }}>Partial Payment</option>
                        <option value="paid" {{ old('payment_status') == 'paid' ? 'selected' : '' }}>Fully Paid</option>
                        <option value="refunded" {{ old('payment_status') == 'refunded' ? 'selected' : '' }}>Refunded</option>
                    </select>
                    @error('payment_status')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Status & Notes -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
            <h3 class="text-xl font-bold text-gray-800 mb-6 flex items-center">
                <i class="fas fa-info-circle text-orange-600 mr-3"></i>
                Status & Additional Information
            </h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Booking Status -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Booking Status <span class="text-red-500">*</span>
                    </label>
                    <select
                        name="status"
                        required
                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('status') border-red-300 @enderror"
                    >
                        <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="confirmed" {{ old('status') == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                        <option value="cancelled" {{ old('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                        <option value="completed" {{ old('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                    </select>
                    @error('status')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Special Requests -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Special Requests
                    </label>
                    <textarea
                        name="special_requests"
                        rows="3"
                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('special_requests') border-red-300 @enderror"
                        placeholder="Any special requests from the customer..."
                    >{{ old('special_requests') }}</textarea>
                    @error('special_requests')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Admin Notes -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Admin Notes (Internal)
                    </label>
                    <textarea
                        name="admin_notes"
                        rows="3"
                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('admin_notes') border-red-300 @enderror"
                        placeholder="Internal notes for admin use only..."
                    >{{ old('admin_notes') }}</textarea>
                    @error('admin_notes')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Visa Information -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
            <h3 class="text-xl font-bold text-gray-800 mb-6 flex items-center">
                <i class="fas fa-passport text-teal-600 mr-3"></i>
                Visa Information
            </h3>

            <!-- Visa Required Checkbox -->
            <div class="mb-6">
                <label class="flex items-center cursor-pointer">
                    <input
                        type="checkbox"
                        name="visa_required"
                        id="visa_required"
                        value="1"
                        {{ old('visa_required') ? 'checked' : '' }}
                        class="w-5 h-5 text-teal-600 border-gray-300 rounded focus:ring-teal-500"
                    >
                    <span class="ml-3 text-sm font-medium text-gray-700">Visa Required for this booking</span>
                </label>
            </div>

            <!-- Visa Fields (shown when checkbox is checked) -->
            <div id="visa_fields" class="{{ old('visa_required') ? '' : 'hidden' }}">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                    <!-- Number of Visas -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Number of Visas <span class="text-red-500">*</span>
                        </label>
                        <input
                            type="number"
                            name="number_of_visas"
                            id="number_of_visas"
                            value="{{ old('number_of_visas', 1) }}"
                            min="1"
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-teal-500 focus:border-teal-500 @error('number_of_visas') border-red-300 @enderror"
                            placeholder="1"
                        >
                        @error('number_of_visas')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Visa Price Per Person -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Visa Price (Per Person)
                        </label>
                        <input
                            type="number"
                            name="visa_price_per_person"
                            id="visa_price_per_person"
                            value="{{ old('visa_price_per_person', 0) }}"
                            step="0.01"
                            min="0"
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-teal-500 focus:border-teal-500 @error('visa_price_per_person') border-red-300 @enderror"
                            placeholder="0.00"
                        >
                        @error('visa_price_per_person')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Total Visa Amount -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Total Visa Amount
                        </label>
                        <input
                            type="number"
                            name="total_visa_amount"
                            id="total_visa_amount"
                            value="{{ old('total_visa_amount', 0) }}"
                            step="0.01"
                            min="0"
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-teal-500 focus:border-teal-500 bg-gray-50 @error('total_visa_amount') border-red-300 @enderror"
                            placeholder="0.00"
                            readonly
                        >
                        @error('total_visa_amount')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- File Upload Fields -->
                <div class="grid grid-cols-1 gap-6">
                    <!-- Passport Images Upload -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Upload Passport Images <span class="text-gray-500 text-xs">(Upload images in JPEG, JPG, or PNG format. Max 5MB each)</span>
                        </label>
                        <input
                            type="file"
                            name="passport_images[]"
                            accept="image/*"
                            multiple
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-teal-500 focus:border-teal-500 @error('passport_images.*') border-red-300 @enderror"
                        >
                        @error('passport_images.*')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-xs text-gray-500">You can select multiple images at once.</p>
                    </div>

                    <!-- Applicant Images Upload -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Upload Applicant Photos <span class="text-gray-500 text-xs">(Upload images in JPEG, JPG, or PNG format. Max 5MB each)</span>
                        </label>
                        <input
                            type="file"
                            name="applicant_images[]"
                            accept="image/*"
                            multiple
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-teal-500 focus:border-teal-500 @error('applicant_images.*') border-red-300 @enderror"
                        >
                        @error('applicant_images.*')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-xs text-gray-500">You can select multiple images at once.</p>
                    </div>

                    <!-- Emirates ID Images Upload -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Upload Emirates ID Images <span class="text-gray-500 text-xs">(Upload images in JPEG, JPG, or PNG format. Max 5MB each)</span>
                        </label>
                        <input
                            type="file"
                            name="emirates_id_images[]"
                            accept="image/*"
                            multiple
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-teal-500 focus:border-teal-500 @error('emirates_id_images.*') border-red-300 @enderror"
                        >
                        @error('emirates_id_images.*')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-xs text-gray-500">You can select multiple images at once.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex items-center justify-end space-x-4">
            <a href="{{ route('admin.bookings.index') }}" class="px-6 py-3 border border-gray-300 text-gray-700 rounded-xl hover:bg-gray-50 transition-colors">
                Cancel
            </a>
            <button type="submit" class="px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-700 text-white font-semibold rounded-xl hover:from-blue-700 hover:to-blue-800 transition-all duration-200 shadow-lg hover:shadow-xl">
                <i class="fas fa-save mr-2"></i>
                Create Booking
            </button>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const packageSelect = document.getElementById('package_select');
    const packagePriceInput = document.getElementById('package_price');
    const numberOfAdults = document.getElementById('number_of_adults');
    const numberOfChildren = document.getElementById('number_of_children');
    const totalAmountInput = document.getElementById('total_amount');
    const paidAmountInput = document.getElementById('paid_amount');
    
    // Visa elements
    const visaRequiredCheckbox = document.getElementById('visa_required');
    const visaFields = document.getElementById('visa_fields');
    const numberOfVisas = document.getElementById('number_of_visas');
    const visaPricePerPerson = document.getElementById('visa_price_per_person');
    const totalVisaAmount = document.getElementById('total_visa_amount');

    // Toggle visa fields visibility
    visaRequiredCheckbox.addEventListener('change', function() {
        if (this.checked) {
            visaFields.classList.remove('hidden');
        } else {
            visaFields.classList.add('hidden');
        }
        calculateTotal();
    });

    // Calculate visa amount
    function calculateVisaAmount() {
        const numVisas = parseInt(numberOfVisas.value) || 0;
        const visaPrice = parseFloat(visaPricePerPerson.value) || 0;
        const visaTotal = numVisas * visaPrice;
        totalVisaAmount.value = visaTotal.toFixed(2);
        return visaTotal;
    }

    // Auto-fill package price and visa price when package is selected
    packageSelect.addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        const price = selectedOption.getAttribute('data-price');
        const visaPrice = selectedOption.getAttribute('data-visa-price');
        
        if (price) {
            packagePriceInput.value = price;
        }
        
        // Auto-fill visa price if available
        if (visaPrice && parseFloat(visaPrice) > 0) {
            visaPricePerPerson.value = visaPrice;
        } else {
            visaPricePerPerson.value = '0.00';
        }
        
        calculateTotal();
    });

    // Calculate total amount (package + visa)
    function calculateTotal() {
        const pricePerPerson = parseFloat(packagePriceInput.value) || 0;
        const adults = parseInt(numberOfAdults.value) || 0;
        const children = parseInt(numberOfChildren.value) || 0;
        
        // Children might be 50% price, adjust as needed
        let total = (pricePerPerson * adults) + (pricePerPerson * 0.5 * children);
        
        // Add visa amount if visa is required
        if (visaRequiredCheckbox.checked) {
            const visaTotal = calculateVisaAmount();
            total += visaTotal;
        }
        
        totalAmountInput.value = total.toFixed(2);
    }

    // Recalculate on input changes
    packagePriceInput.addEventListener('input', calculateTotal);
    numberOfAdults.addEventListener('input', calculateTotal);
    numberOfChildren.addEventListener('input', calculateTotal);
    
    // Visa calculation listeners
    if (numberOfVisas) {
        numberOfVisas.addEventListener('input', calculateTotal);
    }
    if (visaPricePerPerson) {
        visaPricePerPerson.addEventListener('input', calculateTotal);
    }
});
</script>
@endsection
