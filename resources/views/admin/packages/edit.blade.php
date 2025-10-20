@extends('admin.layouts.app')

@section('page-title', 'Edit Package')

@section('content')
<div class="max-w-6xl mx-auto">
    <!-- Header Section -->
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold text-gray-800">Edit Package</h2>
                <p class="text-gray-600 mt-1">Update package details and configuration</p>
            </div>
            <a href="{{ route('admin.packages.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 transition-colors">
                <i class="fas fa-arrow-left mr-2"></i>
                Back to Packages
            </a>
        </div>
    </div>

    <!-- Form Card -->
    <div class="bg-white rounded-2xl shadow-soft overflow-hidden animate-fadeIn">
        <form action="{{ route('admin.packages.update', $package) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- Form Header -->
            <div class="bg-gradient-to-r from-primary-50 to-primary-100 px-6 py-4 border-b border-primary-200">
                <div class="flex items-center">
                    <div class="w-10 h-10 rounded-lg bg-primary-500 flex items-center justify-center text-white mr-3">
                        <i class="fas fa-box-open"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800">Package Information</h3>
                        <p class="text-sm text-gray-600">Update the package details and configuration</p>
                    </div>
                </div>
            </div>

            <div class="p-6 space-y-6">
                <!-- Basic Information Section -->
                <div class="border-b border-gray-200 pb-6">
                    <h4 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                        <i class="fas fa-info-circle text-primary-500 mr-2"></i>
                        Basic Information
                    </h4>

                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <!-- Title -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Package Title <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-tag text-gray-400"></i>
                                </div>
                                <input
                                    type="text"
                                    name="title"
                                    value="{{ old('title', $package->title) }}"
                                    class="pl-10 w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors @error('title') border-red-300 @enderror"
                                    placeholder="Enter package title"
                                    required
                                >
                            </div>
                            @error('title')
                            <p class="mt-1 text-sm text-red-600 flex items-center">
                                <i class="fas fa-exclamation-circle mr-1"></i>
                                {{ $message }}
                            </p>
                            @enderror
                        </div>

                        <!-- Category -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Category
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-folder text-gray-400"></i>
                                </div>
                                <select name="category_id" class="pl-10 w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors @error('category_id') border-red-300 @enderror">
                                    <option value="">Select Category</option>
                                    @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}" {{ old('category_id', $package->category_id) == $cat->id ? 'selected' : '' }}>
                                    {{ $cat->name }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            @error('category_id')
                            <p class="mt-1 text-sm text-red-600 flex items-center">
                                <i class="fas fa-exclamation-circle mr-1"></i>
                                {{ $message }}
                            </p>
                            @enderror
                        </div>
                    </div>

                    <!-- Description -->
                    <div class="mt-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Description
                        </label>
                        <textarea
                            name="description"
                            rows="3"
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors @error('description') border-red-300 @enderror"
                            placeholder="Describe the package features and benefits..."
                        >{{ old('description', $package->description) }}</textarea>
                        @error('description')
                        <p class="mt-1 text-sm text-red-600 flex items-center">
                            <i class="fas fa-exclamation-circle mr-1"></i>
                            {{ $message }}
                        </p>
                        @enderror
                    </div>
                </div>

                <!-- Pricing & Duration Section -->
                <div class="border-b border-gray-200 pb-6">
                    <h4 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                        <i class="fas fa-dollar-sign text-green-500 mr-2"></i>
                        Pricing & Duration
                    </h4>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <!-- Price -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Price (USD) <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-dollar-sign text-gray-400"></i>
                                </div>
                                <input
                                    type="number"
                                    step="0.01"
                                    name="price"
                                    value="{{ old('price', $package->price) }}"
                                    class="pl-10 w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors @error('price') border-red-300 @enderror"
                                    placeholder="0.00"
                                    required
                                >
                            </div>
                            @error('price')
                            <p class="mt-1 text-sm text-red-600 flex items-center">
                                <i class="fas fa-exclamation-circle mr-1"></i>
                                {{ $message }}
                            </p>
                            @enderror
                        </div>

                        <!-- Duration -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Duration (Days) <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-calendar-alt text-gray-400"></i>
                                </div>
                                <input
                                    type="number"
                                    name="duration_days"
                                    value="{{ old('duration_days', $package->duration_days) }}"
                                    class="pl-10 w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors @error('duration_days') border-red-300 @enderror"
                                    placeholder="Number of days"
                                    required
                                >
                            </div>
                            @error('duration_days')
                            <p class="mt-1 text-sm text-red-600 flex items-center">
                                <i class="fas fa-exclamation-circle mr-1"></i>
                                {{ $message }}
                            </p>
                            @enderror
                        </div>

                        <!-- Hotel -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Hotel
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-hotel text-gray-400"></i>
                                </div>
                                <select name="hotel_id" class="pl-10 w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors @error('hotel_id') border-red-300 @enderror">
                                    <option value="">Select Hotel</option>
                                    @foreach($hotels as $hotel)
                                    <option value="{{ $hotel->id }}" {{ old('hotel_id', $package->hotel_id) == $hotel->id ? 'selected' : '' }}>
                                    {{ $hotel->name }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            @error('hotel_id')
                            <p class="mt-1 text-sm text-red-600 flex items-center">
                                <i class="fas fa-exclamation-circle mr-1"></i>
                                {{ $message }}
                            </p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Image Upload Section -->
                <div class="border-b border-gray-200 pb-6">
                    <h4 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                        <i class="fas fa-image text-purple-500 mr-2"></i>
                        Package Image
                    </h4>

                    <!-- Current Image Preview -->
                    @if($package->main_image)
                    <div class="mb-4">
                        <p class="text-sm text-gray-600 mb-2">Current Image:</p>
                        <div class="relative inline-block">
                            <img src="{{ asset('storage/packages/' . basename($package->main_image)) }}" alt="Current Package Image" class="w-48 h-32 object-cover rounded-lg shadow-sm border">
                            <div class="absolute top-2 right-2">
                                <span class="bg-green-100 text-green-800 text-xs px-2 py-1 rounded-full">Current</span>
                            </div>
                        </div>
                    </div>
                    @endif

                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <!-- File Upload -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Upload New Image
                            </label>
                            <div class="relative">
                                <input
                                    type="file"
                                    name="main_image_file"
                                    class="hidden"
                                    id="main_image_file"
                                    accept="image/*"
                                >
                                <label for="main_image_file" class="cursor-pointer">
                                    <div class="border-2 border-dashed border-gray-300 rounded-xl p-6 text-center hover:border-primary-400 hover:bg-primary-50 transition-colors group">
                                        <i class="fas fa-cloud-upload-alt text-3xl text-gray-400 group-hover:text-primary-500 mb-3"></i>
                                        <p class="text-sm text-gray-600 group-hover:text-gray-700">Click to upload image</p>
                                        <p class="text-xs text-gray-500 mt-1">PNG, JPG, JPEG up to 5MB</p>
                                    </div>
                                </label>
                            </div>
                            @error('main_image_file')
                            <p class="mt-1 text-sm text-red-600 flex items-center">
                                <i class="fas fa-exclamation-circle mr-1"></i>
                                {{ $message }}
                            </p>
                            @enderror
                        </div>

                        <!-- Image URL -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Or Enter Image URL
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-link text-gray-400"></i>
                                </div>
                                <input
                                    type="url"
                                    name="main_image_url"
                                    value="{{ old('main_image_url', $package->main_image) }}"
                                    class="pl-10 w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors @error('main_image_url') border-red-300 @enderror"
                                    placeholder="https://example.com/image.jpg"
                                >
                            </div>
                            @error('main_image_url')
                            <p class="mt-1 text-sm text-red-600 flex items-center">
                                <i class="fas fa-exclamation-circle mr-1"></i>
                                {{ $message }}
                            </p>
                            @enderror
                        </div>
                    </div>

                    <!-- Image Preview -->
                    <div id="imagePreview" class="mt-4 hidden">
                        <p class="text-sm text-gray-600 mb-2">New Image Preview:</p>
                        <img id="preview" class="w-48 h-32 object-cover rounded-lg shadow-sm border">
                    </div>
                </div>

                <!-- Multiple Images Gallery Section -->
                <div class="border-b border-gray-200 pb-6">
                    <h4 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                        <i class="fas fa-images text-indigo-500 mr-2"></i>
                        Package Gallery (Up to 25 Images)
                    </h4>

                    <!-- Existing Images -->
                    @if($package->images && count($package->images) > 0)
                    <div class="mb-6">
                        <p class="text-sm text-gray-600 mb-3 font-medium">Current Gallery Images ({{ count($package->images) }}):</p>
                        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4" id="existingImagesContainer">
                            @foreach($package->images as $index => $image)
                            <div class="relative group" data-image="{{ $image }}">
                                <img src="{{ $image }}" alt="Gallery Image {{ $index + 1 }}" class="w-full h-24 object-cover rounded-lg shadow-sm border border-gray-200">
                                <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-60 transition-all rounded-lg flex items-center justify-center">
                                    <button type="button" onclick="deleteImage('{{ $image }}')" class="opacity-0 group-hover:opacity-100 bg-red-500 text-white px-3 py-1 rounded-lg text-xs hover:bg-red-600 transition-all">
                                        <i class="fas fa-trash mr-1"></i> Delete
                                    </button>
                                </div>
                                <div class="absolute top-1 left-1">
                                    <span class="bg-blue-500 text-white text-xs px-2 py-0.5 rounded">{{ $index + 1 }}</span>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    <!-- Upload New Images -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Upload Additional Images
                        </label>
                        <div class="relative">
                            <input
                                type="file"
                                name="package_images[]"
                                class="hidden"
                                id="package_images"
                                accept="image/*"
                                multiple
                                max="25"
                            >
                            <label for="package_images" class="cursor-pointer">
                                <div class="border-2 border-dashed border-indigo-300 rounded-xl p-8 text-center hover:border-indigo-500 hover:bg-indigo-50 transition-colors group">
                                    <i class="fas fa-images text-4xl text-indigo-400 group-hover:text-indigo-600 mb-3"></i>
                                    <p class="text-sm text-gray-700 font-medium group-hover:text-gray-900">Click to upload more images</p>
                                    <p class="text-xs text-gray-500 mt-2">You can select up to 25 images at once</p>
                                    <p class="text-xs text-gray-500">PNG, JPG, JPEG up to 5MB each</p>
                                </div>
                            </label>
                        </div>
                        @error('package_images')
                        <p class="mt-1 text-sm text-red-600 flex items-center">
                            <i class="fas fa-exclamation-circle mr-1"></i>
                            {{ $message }}
                        </p>
                        @enderror
                    </div>

                    <!-- New Images Preview -->
                    <div id="multipleImagesPreview" class="mt-4 hidden">
                        <p class="text-sm text-gray-600 mb-3 font-medium">New Images to Upload (<span id="imageCount">0</span>):</p>
                        <div id="previewContainer" class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4"></div>
                    </div>

                    <!-- Hidden input for images to delete -->
                    <input type="hidden" name="delete_images[]" id="deleteImagesInput">
                </div>

                <!-- Features Section -->
                <div class="border-b border-gray-200 pb-6">
                    <h4 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                        <i class="fas fa-star text-yellow-500 mr-2"></i>
                        Package Features
                    </h4>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Features (comma separated)
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-list text-gray-400"></i>
                            </div>
                            <input
                                type="text"
                                name="features[]"
                                value="{{ old('features') ? implode(',', old('features')) : implode(',', $package->features ?? []) }}"
                                class="pl-10 w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors @error('features') border-red-300 @enderror"
                                placeholder="Free WiFi, Breakfast included, Swimming pool, etc."
                            >
                        </div>
                        <p class="mt-1 text-sm text-gray-500">Separate multiple features with commas</p>
                        @error('features')
                        <p class="mt-1 text-sm text-red-600 flex items-center">
                            <i class="fas fa-exclamation-circle mr-1"></i>
                            {{ $message }}
                        </p>
                        @enderror
                    </div>
                </div>

                <!-- Location & Transfer Section -->
                <div class="border-b border-gray-200 pb-6">
                    <h4 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                        <i class="fas fa-map-marker-alt text-red-500 mr-2"></i>
                        Location & Transfer
                    </h4>

                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <!-- Location -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Location
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-map-pin text-gray-400"></i>
                                </div>
                                <input
                                    type="text"
                                    name="location"
                                    value="{{ old('location', $package->location) }}"
                                    class="pl-10 w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors @error('location') border-red-300 @enderror"
                                    placeholder="Enter package location"
                                >
                            </div>
                            @error('location')
                            <p class="mt-1 text-sm text-red-600 flex items-center">
                                <i class="fas fa-exclamation-circle mr-1"></i>
                                {{ $message }}
                            </p>
                            @enderror
                        </div>

                        <!-- Transfer Type -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Transfer Type
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-car text-gray-400"></i>
                                </div>
                                <select name="transfer_type" class="pl-10 w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors">
                                    <option value="">Select Transfer Type</option>
                                    <option value="bus" {{ old('transfer_type', $package->transfer_type) == 'bus' ? 'selected' : '' }}>Bus</option>
                                    <option value="air" {{ old('transfer_type', $package->transfer_type) == 'air' ? 'selected' : '' }}>Air</option>
                                    <option value="car" {{ old('transfer_type', $package->transfer_type) == 'car' ? 'selected' : '' }}>Car</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Airport Information -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Departure Airport
                            </label>
                            <input
                                type="text"
                                name="departure_airport"
                                value="{{ old('departure_airport', $package->departure_airport) }}"
                                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors"
                                placeholder="Departure airport code"
                            >
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Arrival Airport
                            </label>
                            <input
                                type="text"
                                name="arrival_airport"
                                value="{{ old('arrival_airport', $package->arrival_airport) }}"
                                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors"
                                placeholder="Arrival airport code"
                            >
                        </div>
                    </div>
                </div>

                <!-- Status Section -->
                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-xl border">
                    <div>
                        <label class="text-sm font-medium text-gray-700">Package Status</label>
                        <p class="text-sm text-gray-500">Activate or deactivate this package</p>
                    </div>
                    <div class="flex items-center space-x-4">
                        <input type="hidden" name="is_active" value="0">
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input
                                type="checkbox"
                                name="is_active"
                                value="1"
                                class="sr-only peer"
                                {{ old('is_active', $package->is_active) ? 'checked' : '' }}
                            >
                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-primary-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-primary-600"></div>
                            <span class="ml-3 text-sm font-medium text-gray-900">
                                {{ $package->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </label>
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 flex flex-col sm:flex-row justify-between items-center gap-4">
                <div class="text-sm text-gray-500">
                    Last updated: {{ $package->updated_at->format('M j, Y g:i A') }}
                </div>
                <div class="flex space-x-3">
                    <a href="{{ route('admin.packages.index') }}" class="px-6 py-2 border border-gray-300 text-gray-700 font-medium rounded-xl hover:bg-gray-50 transition-colors">
                        Cancel
                    </a>
                    <button type="submit" class="px-6 py-2 bg-gradient-to-r from-primary-500 to-primary-600 text-white font-medium rounded-xl shadow-soft hover:shadow-glow hover-lift transition-all flex items-center">
                        <i class="fas fa-save mr-2"></i>
                        Update Package
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Custom Styles -->
<style>
    .shadow-soft {
        box-shadow: 0 2px 15px -3px rgba(0, 0, 0, 0.07), 0 10px 20px -2px rgba(0, 0, 0, 0.04);
    }

    .shadow-glow {
        box-shadow: 0 10px 15px -3px rgba(14, 165, 233, 0.3), 0 4px 6px -2px rgba(14, 165, 233, 0.1);
    }

    .hover-lift {
        transition: all 0.3s ease;
    }

    .hover-lift:hover {
        transform: translateY(-2px);
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .animate-fadeIn {
        animation: fadeIn 0.5s ease-out;
    }
</style>

<script>
    // Image preview functionality
    document.addEventListener('DOMContentLoaded', function() {
        const imageFileInput = document.getElementById('main_image_file');
        const imagePreview = document.getElementById('imagePreview');
        const previewImage = document.getElementById('preview');

        if (imageFileInput) {
            imageFileInput.addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        previewImage.src = e.target.result;
                        imagePreview.classList.remove('hidden');
                    }
                    reader.readAsDataURL(file);
                }
            });
        }

        // Toggle switch label update
        const statusToggle = document.querySelector('input[name="is_active"][type="checkbox"]');
        if (statusToggle) {
            const statusLabel = statusToggle.closest('label')?.querySelector('span');
            if (statusLabel) {
                statusToggle.addEventListener('change', function() {
                    statusLabel.textContent = this.checked ? 'Active' : 'Inactive';
                });
            }
        }

        // Multiple images preview functionality
        console.log('Initializing multiple images preview...');
        const multipleImagesInput = document.getElementById('package_images');
        const multipleImagesPreview = document.getElementById('multipleImagesPreview');
        const previewContainer = document.getElementById('previewContainer');
        const imageCount = document.getElementById('imageCount');
        
        console.log('Elements found:', {
            input: !!multipleImagesInput,
            preview: !!multipleImagesPreview,
            container: !!previewContainer,
            count: !!imageCount
        });
        
        let selectedFiles = [];

        if (multipleImagesInput) {
            console.log('Adding change event listener to package_images input');
            multipleImagesInput.addEventListener('change', function(e) {
                console.log('Change event triggered!');
                const files = Array.from(e.target.files);
                console.log('Files selected:', files.length, files);
                
                if (files.length > 25) {
                    alert('You can only upload up to 25 images at once.');
                    this.value = '';
                    return;
                }

                selectedFiles = files;
                console.log('Updating preview for', selectedFiles.length, 'files');
                updateNewImagesPreview();
            });
            
            // Also add a click listener to verify the input is being clicked
            multipleImagesInput.addEventListener('click', function() {
                console.log('File input clicked!');
            });
        } else {
            console.error('Multiple images input not found!');
        }

        function updateNewImagesPreview() {
            console.log('updateNewImagesPreview called with', selectedFiles.length, 'files');
            if (selectedFiles.length > 0) {
                console.log('Clearing preview container and showing preview');
                previewContainer.innerHTML = '';
                imageCount.textContent = selectedFiles.length;
                multipleImagesPreview.classList.remove('hidden');

                selectedFiles.forEach((file, index) => {
                    // Create container first
                    const div = document.createElement('div');
                    div.className = 'relative group';
                    div.setAttribute('data-index', index);
                    
                    // Add loading placeholder
                    div.innerHTML = `
                        <div class="w-full h-24 bg-gray-200 rounded-lg flex items-center justify-center">
                            <i class="fas fa-spinner fa-spin text-gray-400"></i>
                        </div>
                    `;
                    previewContainer.appendChild(div);

                    // Load image
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        div.innerHTML = `
                            <img src="${e.target.result}" class="w-full h-24 object-cover rounded-lg shadow-sm border border-gray-200">
                            <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-60 transition-all rounded-lg flex items-center justify-center">
                                <button type="button" onclick="removeNewSelectedImage(${index})" class="opacity-0 group-hover:opacity-100 bg-red-500 text-white px-2 py-1 rounded text-xs hover:bg-red-600 transition-all">
                                    <i class="fas fa-times mr-1"></i> Remove
                                </button>
                            </div>
                            <div class="absolute top-1 left-1">
                                <span class="bg-green-500 text-white text-xs px-2 py-0.5 rounded">New ${index + 1}</span>
                            </div>
                        `;
                    }
                    reader.readAsDataURL(file);
                });
            } else {
                multipleImagesPreview.classList.add('hidden');
            }
        }

        window.removeNewSelectedImage = function(index) {
            console.log('Removing image at index:', index);
            selectedFiles.splice(index, 1);
            
            // Update the file input
            try {
                const dt = new DataTransfer();
                selectedFiles.forEach(file => dt.items.add(file));
                multipleImagesInput.files = dt.files;
                console.log('Updated file input, remaining files:', selectedFiles.length);
            } catch (e) {
                console.log('DataTransfer not supported, using alternative method');
                // Alternative: just clear and let user know
                if (selectedFiles.length === 0) {
                    multipleImagesInput.value = '';
                }
            }
            
            updateNewImagesPreview();
        }
    });

    // Delete image functionality
    let imagesToDelete = [];
    
    function deleteImage(imageUrl) {
        if (confirm('Are you sure you want to delete this image?')) {
            imagesToDelete.push(imageUrl);
            
            // Update hidden input
            const deleteInput = document.getElementById('deleteImagesInput');
            deleteInput.value = JSON.stringify(imagesToDelete);
            
            // Remove from DOM
            const imageElement = document.querySelector(`[data-image="${imageUrl}"]`);
            if (imageElement) {
                imageElement.remove();
            }
            
            // Update count
            const container = document.getElementById('existingImagesContainer');
            const remainingImages = container.querySelectorAll('.relative.group').length;
            if (remainingImages === 0) {
                container.closest('.mb-6').remove();
            }
        }
    }
</script>
@endsection
