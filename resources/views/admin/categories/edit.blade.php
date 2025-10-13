@extends('admin.layouts.app')

@section('page-title', 'Edit Category')

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- Header Section -->
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold text-gray-800">Edit Category</h2>
                <p class="text-gray-600 mt-1">Update category information</p>
            </div>
            <a href="{{ route('admin.categories.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 transition-colors">
                <i class="fas fa-arrow-left mr-2"></i>
                Back to Categories
            </a>
        </div>
    </div>

    <!-- Form Card -->
    <div class="bg-white rounded-2xl shadow-soft overflow-hidden animate-fadeIn">
        <form action="{{ route('admin.categories.update', $category) }}" method="POST">
            @csrf
            @method('PUT')

            <!-- Form Header -->
            <div class="bg-gradient-to-r from-amber-50 to-amber-100 px-6 py-4 border-b border-amber-200">
                <div class="flex items-center">
                    <div class="w-10 h-10 rounded-lg bg-amber-500 flex items-center justify-center text-white mr-3">
                        <i class="fas fa-edit"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800">Edit Category Details</h3>
                        <p class="text-sm text-gray-600">Update the category information</p>
                    </div>
                </div>
            </div>

            <div class="p-6 space-y-6">
                <!-- Category Information -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <!-- Name -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Category Name <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-tag text-gray-400"></i>
                            </div>
                            <input
                                type="text"
                                name="name"
                                id="name"
                                value="{{ old('name', $category->name) }}"
                                class="pl-10 w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors @error('name') border-red-500 @enderror"
                                placeholder="e.g., Beach & Coastal"
                                required>
                        </div>
                        @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Slug -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Slug
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-link text-gray-400"></i>
                            </div>
                            <input
                                type="text"
                                name="slug"
                                id="slug"
                                value="{{ old('slug', $category->slug) }}"
                                class="pl-10 w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors @error('slug') border-red-500 @enderror"
                                placeholder="Auto-generated from name">
                        </div>
                        <p class="mt-1 text-xs text-gray-500">Leave empty to auto-generate from name</p>
                        @error('slug')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Status -->
                <div class="border-t border-gray-200 pt-6">
                    <h4 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                        <i class="fas fa-toggle-on text-primary-500 mr-2"></i>
                        Status
                    </h4>
                    <div class="flex items-center">
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" name="is_active" value="1" class="sr-only peer" {{ old('is_active', $category->is_active) ? 'checked' : '' }}>
                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-primary-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-primary-600"></div>
                            <span class="ml-3 text-sm font-medium text-gray-700">Active</span>
                        </label>
                        <p class="ml-4 text-sm text-gray-500">Category will be visible on the frontend</p>
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="bg-gray-50 px-6 py-4 flex items-center justify-end space-x-3 border-t border-gray-200">
                <a href="{{ route('admin.categories.index') }}" class="px-4 py-2 border border-gray-300 text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 transition-colors">
                    Cancel
                </a>
                <button type="submit" class="inline-flex items-center px-6 py-2 bg-gradient-to-r from-primary-500 to-primary-600 text-white font-medium rounded-lg shadow-soft hover:shadow-glow transition-all hover-lift">
                    <i class="fas fa-save mr-2"></i>
                    Update Category
                </button>
            </div>
        </form>
    </div>
</div>

<script>
// Auto-generate slug from name
document.getElementById('name').addEventListener('input', function() {
    const slug = this.value
        .toLowerCase()
        .replace(/[^a-z0-9]+/g, '-')
        .replace(/(^-|-$)/g, '');
    document.getElementById('slug').value = slug;
});
</script>
@endsection
