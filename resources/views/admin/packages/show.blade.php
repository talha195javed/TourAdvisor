@extends('admin.layouts.app')

@section('page-title', 'Package Details')

@section('content')
<div class="max-w-7xl mx-auto">
    <!-- Header Section -->
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold text-gray-800">{{ $package->title }}</h2>
                <p class="text-gray-600 mt-1">Package Details and Information</p>
            </div>
            <div class="flex gap-3">
                <a href="{{ route('admin.packages.edit', $package) }}" class="inline-flex items-center px-4 py-2 bg-primary-500 text-white text-sm font-medium rounded-lg hover:bg-primary-600 transition-colors">
                    <i class="fas fa-edit mr-2"></i>
                    Edit Package
                </a>
                <a href="{{ route('admin.packages.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 transition-colors">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Back to Packages
                </a>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Image Gallery Slider -->
            @if($package->images && count($package->images) > 0)
            <div class="bg-white rounded-2xl shadow-soft overflow-hidden">
                <div class="p-6 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-800 flex items-center">
                        <i class="fas fa-images text-indigo-500 mr-2"></i>
                        Package Gallery ({{ count($package->images) }} Images)
                    </h3>
                </div>
                
                <div class="p-6">
                    <!-- Main Slider -->
                    <div class="swiper mainSwiper mb-4 rounded-xl overflow-hidden">
                        <div class="swiper-wrapper">
                            @foreach($package->images as $index => $image)
                            <div class="swiper-slide">
                                <img src="{{ $image }}" alt="Package Image {{ $index + 1 }}" class="w-full h-96 object-cover">
                            </div>
                            @endforeach
                        </div>
                        <!-- Navigation Buttons -->
                        <div class="swiper-button-next"></div>
                        <div class="swiper-button-prev"></div>
                        <!-- Pagination -->
                        <div class="swiper-pagination"></div>
                    </div>

                    <!-- Thumbnail Slider -->
                    <div class="swiper thumbSwiper">
                        <div class="swiper-wrapper">
                            @foreach($package->images as $index => $image)
                            <div class="swiper-slide cursor-pointer">
                                <img src="{{ $image }}" alt="Thumbnail {{ $index + 1 }}" class="w-full h-20 object-cover rounded-lg">
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            @elseif($package->main_image)
            <!-- Single Main Image -->
            <div class="bg-white rounded-2xl shadow-soft overflow-hidden">
                <div class="p-6 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-800 flex items-center">
                        <i class="fas fa-image text-purple-500 mr-2"></i>
                        Package Image
                    </h3>
                </div>
                <div class="p-6">
                    <img src="{{ $package->main_image }}" alt="{{ $package->title }}" class="w-full h-96 object-cover rounded-xl">
                </div>
            </div>
            @endif

            <!-- Description -->
            @if($package->description)
            <div class="bg-white rounded-2xl shadow-soft overflow-hidden">
                <div class="p-6 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-800 flex items-center">
                        <i class="fas fa-align-left text-blue-500 mr-2"></i>
                        Description
                    </h3>
                </div>
                <div class="p-6">
                    <p class="text-gray-700 leading-relaxed">{{ $package->description }}</p>
                </div>
            </div>
            @endif

            <!-- Features -->
            @if($package->features && count($package->features) > 0)
            <div class="bg-white rounded-2xl shadow-soft overflow-hidden">
                <div class="p-6 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-800 flex items-center">
                        <i class="fas fa-star text-yellow-500 mr-2"></i>
                        Package Features
                    </h3>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                        @foreach($package->features as $feature)
                        <div class="flex items-center text-gray-700">
                            <i class="fas fa-check-circle text-green-500 mr-2"></i>
                            <span>{{ $feature }}</span>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Package Info Card -->
            <div class="bg-white rounded-2xl shadow-soft overflow-hidden">
                <div class="p-6 border-b border-gray-200 bg-gradient-to-r from-primary-50 to-primary-100">
                    <h3 class="text-lg font-semibold text-gray-800 flex items-center">
                        <i class="fas fa-info-circle text-primary-500 mr-2"></i>
                        Package Information
                    </h3>
                </div>
                <div class="p-6 space-y-4">
                    <!-- Price -->
                    <div class="flex items-center justify-between p-4 bg-green-50 rounded-xl">
                        <div class="flex items-center">
                            <i class="fas fa-dollar-sign text-green-500 mr-3 text-xl"></i>
                            <span class="text-sm text-gray-600">Price</span>
                        </div>
                        <span class="text-2xl font-bold text-green-600">${{ number_format($package->price, 2) }}</span>
                    </div>

                    <!-- Visa Price -->
                    @if($package->visa_price && $package->visa_price > 0)
                    <div class="flex items-center justify-between p-4 bg-teal-50 rounded-xl">
                        <div class="flex items-center">
                            <i class="fas fa-passport text-teal-500 mr-3 text-xl"></i>
                            <span class="text-sm text-gray-600">Visa Price</span>
                        </div>
                        <span class="text-xl font-bold text-teal-600">${{ number_format($package->visa_price, 2) }}</span>
                    </div>
                    @endif

                    <!-- Duration -->
                    <div class="flex items-center justify-between p-4 bg-blue-50 rounded-xl">
                        <div class="flex items-center">
                            <i class="fas fa-calendar-alt text-blue-500 mr-3 text-xl"></i>
                            <span class="text-sm text-gray-600">Duration</span>
                        </div>
                        <span class="text-lg font-semibold text-blue-600">{{ $package->duration_days }} Days</span>
                    </div>

                    <!-- Status -->
                    <div class="flex items-center justify-between p-4 bg-gray-50 rounded-xl">
                        <div class="flex items-center">
                            <i class="fas fa-toggle-{{ $package->is_active ? 'on' : 'off' }} text-gray-500 mr-3 text-xl"></i>
                            <span class="text-sm text-gray-600">Status</span>
                        </div>
                        <span class="px-3 py-1 rounded-full text-sm font-medium {{ $package->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ $package->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </div>

                    <!-- Category -->
                    @if($package->category)
                    <div class="flex items-center justify-between p-4 bg-purple-50 rounded-xl">
                        <div class="flex items-center">
                            <i class="fas fa-folder text-purple-500 mr-3 text-xl"></i>
                            <span class="text-sm text-gray-600">Category</span>
                        </div>
                        <span class="text-sm font-medium text-purple-600">{{ $package->category->name }}</span>
                    </div>
                    @endif

                    <!-- Hotel -->
                    @if($package->hotel)
                    <div class="flex items-center justify-between p-4 bg-orange-50 rounded-xl">
                        <div class="flex items-center">
                            <i class="fas fa-hotel text-orange-500 mr-3 text-xl"></i>
                            <span class="text-sm text-gray-600">Hotel</span>
                        </div>
                        <span class="text-sm font-medium text-orange-600">{{ $package->hotel->name }}</span>
                    </div>
                    @endif

                    <!-- Location -->
                    @if($package->location)
                    <div class="flex items-center justify-between p-4 bg-red-50 rounded-xl">
                        <div class="flex items-center">
                            <i class="fas fa-map-marker-alt text-red-500 mr-3 text-xl"></i>
                            <span class="text-sm text-gray-600">Location</span>
                        </div>
                        <span class="text-sm font-medium text-red-600">{{ $package->location }}</span>
                    </div>
                    @endif

                    <!-- Transfer Type -->
                    @if($package->transfer_type)
                    <div class="flex items-center justify-between p-4 bg-indigo-50 rounded-xl">
                        <div class="flex items-center">
                            <i class="fas fa-car text-indigo-500 mr-3 text-xl"></i>
                            <span class="text-sm text-gray-600">Transfer</span>
                        </div>
                        <span class="text-sm font-medium text-indigo-600 capitalize">{{ $package->transfer_type }}</span>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Airport Information -->
            @if($package->departure_airport || $package->arrival_airport)
            <div class="bg-white rounded-2xl shadow-soft overflow-hidden">
                <div class="p-6 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-800 flex items-center">
                        <i class="fas fa-plane text-sky-500 mr-2"></i>
                        Airport Information
                    </h3>
                </div>
                <div class="p-6 space-y-3">
                    @if($package->departure_airport)
                    <div class="flex items-center">
                        <i class="fas fa-plane-departure text-gray-400 mr-3"></i>
                        <div>
                            <p class="text-xs text-gray-500">Departure</p>
                            <p class="text-sm font-medium text-gray-700">{{ $package->departure_airport }}</p>
                        </div>
                    </div>
                    @endif
                    @if($package->arrival_airport)
                    <div class="flex items-center">
                        <i class="fas fa-plane-arrival text-gray-400 mr-3"></i>
                        <div>
                            <p class="text-xs text-gray-500">Arrival</p>
                            <p class="text-sm font-medium text-gray-700">{{ $package->arrival_airport }}</p>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
            @endif

            <!-- Timestamps -->
            <div class="bg-white rounded-2xl shadow-soft overflow-hidden">
                <div class="p-6 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-800 flex items-center">
                        <i class="fas fa-clock text-gray-500 mr-2"></i>
                        Timestamps
                    </h3>
                </div>
                <div class="p-6 space-y-3 text-sm">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Created:</span>
                        <span class="font-medium text-gray-800">{{ $package->created_at->format('M j, Y g:i A') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Last Updated:</span>
                        <span class="font-medium text-gray-800">{{ $package->updated_at->format('M j, Y g:i A') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Swiper CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

<!-- Custom Styles -->
<style>
    .shadow-soft {
        box-shadow: 0 2px 15px -3px rgba(0, 0, 0, 0.07), 0 10px 20px -2px rgba(0, 0, 0, 0.04);
    }

    .mainSwiper {
        width: 100%;
        height: 100%;
    }

    .mainSwiper .swiper-slide {
        background: #f8f9fa;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .thumbSwiper {
        height: 80px;
        box-sizing: border-box;
        padding: 10px 0;
    }

    .thumbSwiper .swiper-slide {
        width: 25%;
        height: 100%;
        opacity: 0.4;
        transition: opacity 0.3s;
    }

    .thumbSwiper .swiper-slide-thumb-active {
        opacity: 1;
        border: 2px solid #6366f1;
        border-radius: 0.5rem;
    }

    .swiper-button-next,
    .swiper-button-prev {
        color: white;
        background: rgba(0, 0, 0, 0.5);
        padding: 25px;
        border-radius: 50%;
        width: 40px;
        height: 40px;
    }

    .swiper-button-next:after,
    .swiper-button-prev:after {
        font-size: 18px;
    }

    .swiper-pagination-bullet {
        background: white;
        opacity: 0.7;
    }

    .swiper-pagination-bullet-active {
        background: white;
        opacity: 1;
    }
</style>

<!-- Swiper JS -->
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize thumbnail swiper first
        const thumbSwiper = new Swiper(".thumbSwiper", {
            spaceBetween: 10,
            slidesPerView: 4,
            freeMode: true,
            watchSlidesProgress: true,
            breakpoints: {
                320: {
                    slidesPerView: 3,
                },
                640: {
                    slidesPerView: 4,
                },
                768: {
                    slidesPerView: 5,
                },
                1024: {
                    slidesPerView: 6,
                }
            }
        });

        // Initialize main swiper
        const mainSwiper = new Swiper(".mainSwiper", {
            spaceBetween: 10,
            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev",
            },
            pagination: {
                el: ".swiper-pagination",
                clickable: true,
            },
            thumbs: {
                swiper: thumbSwiper,
            },
            loop: true,
            autoplay: {
                delay: 3000,
                disableOnInteraction: false,
            },
        });
    });
</script>
@endsection
