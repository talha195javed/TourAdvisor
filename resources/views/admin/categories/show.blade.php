@extends('admin.layouts.app')

@section('page-title', 'View Category')

@section('content')
<div class="max-w-6xl mx-auto">
    <!-- Header Section -->
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold text-gray-800">Category Details</h2>
                <p class="text-gray-600 mt-1">View category information and associated packages</p>
            </div>
            <div class="flex space-x-3">
                <a href="{{ route('admin.categories.edit', $category) }}" class="inline-flex items-center px-4 py-2 bg-amber-500 text-white font-medium rounded-lg hover:bg-amber-600 transition-colors">
                    <i class="fas fa-edit mr-2"></i>
                    Edit
                </a>
                <a href="{{ route('admin.categories.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 transition-colors">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Back
                </a>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Category Information Card -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-2xl shadow-soft overflow-hidden animate-fadeIn">
                <div class="bg-gradient-to-r from-primary-50 to-primary-100 px-6 py-4 border-b border-primary-200">
                    <div class="flex items-center">
                        <div class="w-10 h-10 rounded-lg bg-primary-500 flex items-center justify-center text-white mr-3">
                            <i class="fas fa-tag"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-800">Category Info</h3>
                        </div>
                    </div>
                </div>
                <div class="p-6 space-y-4">
                    <div>
                        <label class="text-xs font-semibold text-gray-500 uppercase tracking-wider">ID</label>
                        <p class="mt-1 text-sm font-medium text-gray-900">#{{ $category->id }}</p>
                    </div>
                    <div>
                        <label class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Name</label>
                        <p class="mt-1 text-lg font-semibold text-gray-900">{{ $category->name }}</p>
                    </div>
                    <div>
                        <label class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Slug</label>
                        <p class="mt-1"><code class="px-2 py-1 bg-gray-100 text-gray-800 rounded text-sm">{{ $category->slug }}</code></p>
                    </div>
                    <div>
                        <label class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Status</label>
                        <p class="mt-1">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium {{ $category->is_active ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                <i class="fas fa-{{ $category->is_active ? 'check' : 'times' }} mr-1"></i>
                                {{ $category->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </p>
                    </div>
                    <div>
                        <label class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Total Packages</label>
                        <p class="mt-1">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                {{ $category->packages->count() }} packages
                            </span>
                        </p>
                    </div>
                    <div class="pt-4 border-t border-gray-200">
                        <label class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Created At</label>
                        <p class="mt-1 text-sm text-gray-600">{{ $category->created_at->format('M d, Y h:i A') }}</p>
                    </div>
                    <div>
                        <label class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Updated At</label>
                        <p class="mt-1 text-sm text-gray-600">{{ $category->updated_at->format('M d, Y h:i A') }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Packages List Card -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-2xl shadow-soft overflow-hidden animate-fadeIn">
                <div class="bg-gradient-to-r from-blue-50 to-blue-100 px-6 py-4 border-b border-blue-200">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="w-10 h-10 rounded-lg bg-blue-500 flex items-center justify-center text-white mr-3">
                                <i class="fas fa-boxes"></i>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-800">Packages in this Category</h3>
                                <p class="text-sm text-gray-600">{{ $category->packages->count() }} total packages</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="p-6">
                    @if($category->packages->count() > 0)
                        <div class="space-y-4">
                            @foreach($category->packages as $package)
                                <a href="{{ route('admin.packages.show', $package) }}" 
                                   class="block p-4 border border-gray-200 rounded-lg hover:border-primary-300 hover:shadow-md transition-all">
                                    <div class="flex items-center justify-between">
                                        <div class="flex-1">
                                            <h4 class="text-base font-semibold text-gray-900 mb-1">{{ $package->title }}</h4>
                                            <div class="flex items-center space-x-4 text-sm text-gray-500">
                                                <span class="flex items-center">
                                                    <i class="fas fa-map-marker-alt mr-1"></i>
                                                    {{ $package->location }}
                                                </span>
                                                <span class="flex items-center">
                                                    <i class="fas fa-calendar mr-1"></i>
                                                    {{ $package->duration_days }} days
                                                </span>
                                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium {{ $package->is_active ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                                    {{ $package->is_active ? 'Active' : 'Inactive' }}
                                                </span>
                                            </div>
                                        </div>
                                        <div class="text-right ml-4">
                                            <p class="text-lg font-bold text-primary-600">${{ number_format($package->price, 2) }}</p>
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-12">
                            <i class="fas fa-boxes text-gray-300 text-5xl mb-4"></i>
                            <p class="text-gray-500 text-lg font-medium">No packages in this category yet</p>
                            <p class="text-gray-400 text-sm mt-1">Packages will appear here when assigned to this category</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
