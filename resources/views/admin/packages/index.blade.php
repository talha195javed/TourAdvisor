@extends('admin.layouts.app')

@section('page-title', 'Packages')

@section('content')
<div class="mb-8">
    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">All Packages</h2>
            <p class="text-gray-600 mt-1">Manage your travel packages and offerings</p>
        </div>

        <div class="flex flex-col sm:flex-row gap-3">
            <!-- Quick Stats -->
            <div class="flex items-center space-x-6 bg-white rounded-xl shadow-soft px-4 py-3">
                <div class="text-center">
                    <div class="text-lg font-bold text-gray-800">{{ $packages->total() }}</div>
                    <div class="text-xs text-gray-500">Total</div>
                </div>
                <div class="h-8 w-px bg-gray-200"></div>
                <div class="text-center">
                    <div class="text-lg font-bold text-green-600">{{ $activePackagesCount }}</div>
                    <div class="text-xs text-gray-500">Active</div>
                </div>
                <div class="h-8 w-px bg-gray-200"></div>
                <div class="text-center">
                    <div class="text-lg font-bold text-gray-600">{{ $packages->total() - $activePackagesCount }}</div>
                    <div class="text-xs text-gray-500">Inactive</div>
                </div>
            </div>

            <a href="{{ route('admin.packages.create') }}" class="inline-flex items-center justify-center px-4 py-3 bg-gradient-to-r from-primary-500 to-primary-600 text-white font-medium rounded-xl shadow-soft hover:shadow-glow transition-all hover-lift">
                <i class="fas fa-plus mr-2"></i>
                Add New Package
            </a>
        </div>
    </div>
</div>

<!-- Filters Card -->
<div class="bg-white rounded-2xl shadow-soft p-6 mb-6 animate-fadeIn">
    <form action="{{ route('admin.packages.index') }}" method="GET" class="flex flex-col lg:flex-row lg:items-end gap-4">
        <div class="flex-1 grid grid-cols-1 md:grid-cols-3 gap-4">
            <!-- Search Input -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Search Packages</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-search text-gray-400"></i>
                    </div>
                    <input
                        name="q"
                        type="text"
                        placeholder="Search by title..."
                        value="{{ request('q') }}"
                        class="pl-10 w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors"
                    >
                </div>
            </div>

            <!-- Category Filter -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Category</label>
                <select name="category_id" class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors">
                    <option value="">All Categories</option>
                    @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>
                    {{ $cat->name }}
                    </option>
                    @endforeach
                </select>
            </div>

            <!-- Status Filter -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                <select name="status" class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors">
                    <option value="">All Status</option>
                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>
        </div>

        <div class="flex gap-3">
            <a href="{{ route('admin.packages.index') }}" class="px-6 py-2 border border-gray-300 text-gray-700 font-medium rounded-xl hover:bg-gray-50 transition-colors">
                Reset
            </a>
            <button type="submit" class="px-6 py-2 bg-primary-500 text-white font-medium rounded-xl hover:bg-primary-600 transition-colors shadow-soft hover-lift">
                Apply Filters
            </button>
        </div>
    </form>
</div>

<!-- Packages Table -->
<div class="bg-white rounded-2xl shadow-soft overflow-hidden animate-fadeIn">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
            <tr>
                <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                    Package
                </th>
                <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                    Category
                </th>
                <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                    Hotel
                </th>
                <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                    Price
                </th>
                <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                    Status
                </th>
                <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                    Actions
                </th>
            </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-100">
            @foreach($packages as $pkg)
            <tr class="hover:bg-gray-50 transition-colors group">
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 h-12 w-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center text-white font-bold text-sm mr-4">
                            {{ substr($pkg->title, 0, 2) }}
                        </div>
                        <div>
                            <div class="text-sm font-semibold text-gray-900 group-hover:text-primary-600 transition-colors">
                                {{ $pkg->title }}
                            </div>
                            <div class="text-xs text-gray-500">#PKG-{{ str_pad($pkg->id, 3, '0', STR_PAD_LEFT) }}</div>
                        </div>
                    </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    @if($pkg->category)
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                            {{ $pkg->category->name }}
                        </span>
                    @else
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                            Uncategorized
                        </span>
                    @endif
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                    {{ $pkg->hotel?->name ?? 'No Hotel' }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-900">
                    ${{ number_format($pkg->price, 2) }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    @if($pkg->is_active)
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                            <i class="fas fa-circle mr-1 text-[8px]"></i>
                            Active
                        </span>
                    @else
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                            <i class="fas fa-circle mr-1 text-[8px]"></i>
                            Inactive
                        </span>
                    @endif
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                    <div class="flex items-center space-x-3">
                        <a href="{{ route('admin.packages.edit', $pkg) }}" class="text-primary-600 hover:text-primary-900 transition-colors group relative" title="Edit">
                            <i class="fas fa-edit"></i>
                            <span class="absolute -top-8 left-1/2 transform -translate-x-1/2 bg-gray-800 text-white text-xs rounded py-1 px-2 opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap z-10">
                                    Edit Package
                                </span>
                        </a>
                        <a href="#" class="text-green-600 hover:text-green-900 transition-colors group relative" title="View">
                            <i class="fas fa-eye"></i>
                            <span class="absolute -top-8 left-1/2 transform -translate-x-1/2 bg-gray-800 text-white text-xs rounded py-1 px-2 opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap z-10">
                                    View Details
                                </span>
                        </a>
                        <form method="POST" action="{{ route('admin.packages.destroy', $pkg) }}" class="inline-block" onsubmit="return confirm('Are you sure you want to delete this package?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-900 transition-colors group relative" title="Delete">
                                <i class="fas fa-trash"></i>
                                <span class="absolute -top-8 left-1/2 transform -translate-x-1/2 bg-gray-800 text-white text-xs rounded py-1 px-2 opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap z-10">
                                        Delete Package
                                    </span>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @endforeach

            @if($packages->isEmpty())
            <tr>
                <td colspan="6" class="px-6 py-12 text-center">
                    <div class="flex flex-col items-center justify-center text-gray-500">
                        <i class="fas fa-box-open text-4xl mb-3 text-gray-300"></i>
                        <p class="text-lg font-medium text-gray-400">No packages found</p>
                        <p class="text-sm mt-1">Get started by creating your first package</p>
                        <a href="{{ route('admin.packages.create') }}" class="mt-4 px-4 py-2 bg-primary-500 text-white rounded-lg hover:bg-primary-600 transition-colors">
                            Create Package
                        </a>
                    </div>
                </td>
            </tr>
            @endif
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    @if($packages->hasPages())
    <div class="bg-white px-6 py-4 border-t border-gray-200">
        <div class="flex items-center justify-between">
            <div class="text-sm text-gray-700">
                Showing
                <span class="font-medium">{{ $packages->firstItem() }}</span>
                to
                <span class="font-medium">{{ $packages->lastItem() }}</span>
                of
                <span class="font-medium">{{ $packages->total() }}</span>
                results
            </div>
            <div class="flex space-x-2">
                {{ $packages->withQueryString()->links('vendor.pagination.tailwind') }}
            </div>
        </div>
    </div>
    @endif
</div>

<!-- Custom Pagination Styles -->
<style>
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

    .shadow-soft {
        box-shadow: 0 2px 15px -3px rgba(0, 0, 0, 0.07), 0 10px 20px -2px rgba(0, 0, 0, 0.04);
    }

    .shadow-glow {
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
    }
</style>

<script>
    // Tooltip functionality
    document.addEventListener('DOMContentLoaded', function() {
        const tooltipButtons = document.querySelectorAll('a[title], button[title]');

        tooltipButtons.forEach(button => {
            button.addEventListener('mouseenter', function() {
                const title = this.getAttribute('title');
                this.removeAttribute('title');

                const tooltip = document.createElement('div');
                tooltip.className = 'absolute z-10 px-2 py-1 text-xs text-white bg-gray-800 rounded opacity-0 transition-opacity duration-200';
                tooltip.textContent = title;
                tooltip.style.top = '-30px';
                tooltip.style.left = '50%';
                tooltip.style.transform = 'translateX(-50%)';

                this.appendChild(tooltip);

                setTimeout(() => {
                    tooltip.classList.remove('opacity-0');
                    tooltip.classList.add('opacity-100');
                }, 10);
            });

            button.addEventListener('mouseleave', function() {
                const tooltip = this.querySelector('div');
                if (tooltip) {
                    tooltip.remove();
                }
                this.setAttribute('title', this.textContent.trim());
            });
        });
    });
</script>
@endsection
