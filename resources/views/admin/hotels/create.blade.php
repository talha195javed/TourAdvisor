@extends('admin.layouts.app')

@section('page-title', 'Add New Hotel')

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- Header Section -->
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold text-gray-800">Create New Hotel</h2>
                <p class="text-gray-600 mt-1">Add a new hotel to your accommodation offerings</p>
            </div>
            <a href="{{ route('admin.hotels.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 transition-colors">
                <i class="fas fa-arrow-left mr-2"></i>
                Back to Hotels
            </a>
        </div>
    </div>

    <!-- Form Card -->
    <div class="bg-white rounded-2xl shadow-soft overflow-hidden animate-fadeIn">
        <form action="{{ route('admin.hotels.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- Form Header -->
            <div class="bg-gradient-to-r from-green-50 to-green-100 px-6 py-4 border-b border-green-200">
                <div class="flex items-center">
                    <div class="w-10 h-10 rounded-lg bg-green-500 flex items-center justify-center text-white mr-3">
                        <i class="fas fa-plus"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800">New Hotel Details</h3>
                        <p class="text-sm text-gray-600">Fill in the hotel information to create a new accommodation</p>
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
                        <!-- Hotel Name -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Hotel Name <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-building text-gray-400"></i>
                                </div>
                                <input
                                    type="text"
                                    name="name"
                                    value="{{ old('name') }}"
                                    class="pl-10 w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors @error('name') border-red-300 @enderror"
                                    placeholder="Enter hotel name"
                                    required
                                >
                            </div>
                            @error('name')
                            <p class="mt-1 text-sm text-red-600 flex items-center">
                                <i class="fas fa-exclamation-circle mr-1"></i>
                                {{ $message }}
                            </p>
                            @enderror
                        </div>

                        <!-- Location -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Location
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-map-marker-alt text-gray-400"></i>
                                </div>
                                <input
                                    type="text"
                                    name="location"
                                    value="{{ old('location') }}"
                                    class="pl-10 w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors @error('location') border-red-300 @enderror"
                                    placeholder="Enter hotel location"
                                >
                            </div>
                            @error('location')
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
                        Hotel Image
                    </h4>

                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <!-- File Upload -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Upload Hotel Image
                            </label>
                            <div class="relative">
                                <input
                                    type="file"
                                    name="image_file"
                                    class="hidden"
                                    id="image_file"
                                    accept="image/*"
                                >
                                <label for="image_file" class="cursor-pointer">
                                    <div class="border-2 border-dashed border-gray-300 rounded-xl p-6 text-center hover:border-primary-400 hover:bg-primary-50 transition-colors group">
                                        <i class="fas fa-cloud-upload-alt text-3xl text-gray-400 group-hover:text-primary-500 mb-3"></i>
                                        <p class="text-sm text-gray-600 group-hover:text-gray-700">Click to upload image</p>
                                        <p class="text-xs text-gray-500 mt-1">PNG, JPG, JPEG up to 5MB</p>
                                        <div class="mt-2 flex justify-center space-x-2">
                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs bg-blue-100 text-blue-800">
                                                <i class="fas fa-hotel mr-1"></i>
                                                Hotel
                                            </span>
                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs bg-green-100 text-green-800">
                                                <i class="fas fa-image mr-1"></i>
                                                Image
                                            </span>
                                        </div>
                                    </div>
                                </label>
                            </div>
                            @error('image_file')
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
                                    name="image_url"
                                    value="{{ old('image_url') }}"
                                    class="pl-10 w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors @error('image_url') border-red-300 @enderror"
                                    placeholder="https://example.com/hotel-image.jpg"
                                >
                            </div>
                            <p class="mt-2 text-xs text-gray-500 flex items-center">
                                <i class="fas fa-info-circle mr-1 text-blue-500"></i>
                                Recommended: High-quality hotel exterior or lobby photo
                            </p>
                            @error('image_url')
                            <p class="mt-1 text-sm text-red-600 flex items-center">
                                <i class="fas fa-exclamation-circle mr-1"></i>
                                {{ $message }}
                            </p>
                            @enderror
                        </div>
                    </div>

                    <!-- Image Preview -->
                    <div id="imagePreview" class="mt-4 hidden">
                        <p class="text-sm text-gray-600 mb-2">Image Preview:</p>
                        <div class="flex items-center space-x-4">
                            <img id="preview" class="w-48 h-32 object-cover rounded-lg shadow-sm border">
                            <div class="text-sm text-gray-500">
                                <p class="font-medium">Preview</p>
                                <p class="text-xs mt-1">This is how the image will appear</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Description Section -->
                <div class="border-b border-gray-200 pb-6">
                    <h4 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                        <i class="fas fa-align-left text-blue-500 mr-2"></i>
                        Hotel Description
                    </h4>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Description
                        </label>
                        <div class="relative">
                            <textarea
                                name="description"
                                rows="4"
                                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors @error('description') border-red-300 @enderror"
                                placeholder="Describe the hotel's features, amenities, unique selling points, and what makes it special for travelers..."
                            >{{ old('description') }}</textarea>
                        </div>
                        <div class="mt-2 flex items-center text-xs text-gray-500">
                            <i class="fas fa-lightbulb mr-1 text-yellow-500"></i>
                            Tip: Include key amenities, room types, and unique features
                        </div>
                        @error('description')
                        <p class="mt-1 text-sm text-red-600 flex items-center">
                            <i class="fas fa-exclamation-circle mr-1"></i>
                            {{ $message }}
                        </p>
                        @enderror
                    </div>
                </div>

                <!-- Additional Information Section -->
                <div class="border-b border-gray-200 pb-6">
                    <h4 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                        <i class="fas fa-star text-yellow-500 mr-2"></i>
                        Additional Information
                    </h4>

                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <!-- Star Rating -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Star Rating (Optional)
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-star text-yellow-400"></i>
                                </div>
                                <select name="star_rating" class="pl-10 w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors">
                                    <option value="">Select Star Rating</option>
                                    <option value="1" {{ old('star_rating') == '1' ? 'selected' : '' }}>⭐ 1 Star</option>
                                    <option value="2" {{ old('star_rating') == '2' ? 'selected' : '' }}>⭐⭐ 2 Stars</option>
                                    <option value="3" {{ old('star_rating') == '3' ? 'selected' : '' }}>⭐⭐⭐ 3 Stars</option>
                                    <option value="4" {{ old('star_rating') == '4' ? 'selected' : '' }}>⭐⭐⭐⭐ 4 Stars</option>
                                    <option value="5" {{ old('star_rating') == '5' ? 'selected' : '' }}>⭐⭐⭐⭐⭐ 5 Stars</option>
                                </select>
                            </div>
                        </div>

                        <!-- Contact Email -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Contact Email (Optional)
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-envelope text-gray-400"></i>
                                </div>
                                <input
                                    type="email"
                                    name="contact_email"
                                    value="{{ old('contact_email') }}"
                                    class="pl-10 w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors"
                                    placeholder="hotel@example.com"
                                >
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Status Section -->
                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-xl border">
                    <div>
                        <label class="text-sm font-medium text-gray-700">Hotel Status</label>
                        <p class="text-sm text-gray-500">Activate this hotel immediately</p>
                    </div>
                    <div class="flex items-center space-x-4">
                        <input type="hidden" name="is_active" value="0">
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input
                                type="checkbox"
                                name="is_active"
                                value="1"
                                class="sr-only peer"
                                {{ old('is_active', true) ? 'checked' : '' }}
                            >
                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-primary-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-green-600"></div>
                            <span class="ml-3 text-sm font-medium text-gray-900">
                                {{ old('is_active', true) ? 'Active' : 'Inactive' }}
                            </span>
                        </label>
                    </div>
                </div>

                <!-- Quick Tips -->
                <div class="bg-blue-50 border border-blue-200 rounded-xl p-4">
                    <div class="flex items-start">
                        <i class="fas fa-lightbulb text-blue-500 mt-1 mr-3"></i>
                        <div>
                            <h5 class="font-medium text-blue-800">Quick Tips</h5>
                            <ul class="text-sm text-blue-700 mt-1 space-y-1">
                                <li>• Use high-quality images that showcase the hotel's best features</li>
                                <li>• Include key amenities and unique selling points in the description</li>
                                <li>• Set the hotel as active to make it immediately available for packages</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 flex flex-col sm:flex-row justify-end items-center gap-4">
                <a href="{{ route('admin.hotels.index') }}" class="px-6 py-2 border border-gray-300 text-gray-700 font-medium rounded-xl hover:bg-gray-50 transition-colors">
                    Cancel
                </a>
                <button type="submit" class="px-6 py-2 bg-gradient-to-r from-green-500 to-green-600 text-white font-medium rounded-xl shadow-soft hover:shadow-glow hover-lift transition-all flex items-center">
                    <i class="fas fa-plus-circle mr-2"></i>
                    Create Hotel
                </button>
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
        box-shadow: 0 10px 15px -3px rgba(16, 185, 129, 0.3), 0 4px 6px -2px rgba(16, 185, 129, 0.1);
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
        const imageFileInput = document.getElementById('image_file');
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
        const statusToggle = document.querySelector('input[name="is_active"]');
        const statusLabel = statusToggle.closest('label').querySelector('span');

        statusToggle.addEventListener('change', function() {
            statusLabel.textContent = this.checked ? 'Active' : 'Inactive';
        });

        // Add character counter for description
        const descriptionTextarea = document.querySelector('textarea[name="description"]');
        if (descriptionTextarea) {
            const counter = document.createElement('div');
            counter.className = 'text-xs text-gray-500 text-right mt-1';
            descriptionTextarea.parentNode.appendChild(counter);

            function updateCounter() {
                const length = descriptionTextarea.value.length;
                counter.textContent = `${length} characters`;

                if (length > 500) {
                    counter.classList.add('text-green-600');
                    counter.classList.remove('text-gray-500');
                } else {
                    counter.classList.remove('text-green-600');
                    counter.classList.add('text-gray-500');
                }
            }

            descriptionTextarea.addEventListener('input', updateCounter);
            updateCounter();
        }
    });
</script>
@endsection
