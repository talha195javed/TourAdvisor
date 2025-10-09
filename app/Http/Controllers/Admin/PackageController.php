<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePackageRequest;
use App\Models\Category;
use App\Models\Hotel;
use App\Models\Package;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PackageController extends Controller
{
    /**
     * Display a listing of the packages.
     */
    public function index(Request $request)
    {
        $query = Package::with('category', 'hotel');

        // Search filter
        if ($request->filled('q')) {
            $query->where('title', 'like', '%' . $request->q . '%');
        }

        // Category filter
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        // Status filter
        if ($request->filled('status')) {
            if ($request->status === 'active') {
                $query->where('is_active', true);
            } elseif ($request->status === 'inactive') {
                $query->where('is_active', false);
            }
        }

        // Get active packages count for stats
        $activePackagesCount = Package::where('is_active', true)->count();

        $packages = $query->orderBy('created_at', 'desc')->paginate(10);
        $categories = Category::where('is_active', true)->get();

        return view('admin.packages.index', compact('packages', 'categories', 'activePackagesCount'));
    }
    /**
     * Show the form for creating a new package.
     */
    public function create()
    {
        $categories = Category::where('is_active', true)->get();
        $hotels = Hotel::where('is_active', true)->get();
        return view('admin.packages.create', compact('categories', 'hotels'));
    }

    /**
     * Store a newly created package.
     */
    public function store(StorePackageRequest $request)
    {
        $data = $request->validated();

        // Handle main image: file upload or URL
        if ($request->hasFile('main_image_file')) {
            $path = $request->file('main_image_file')->store('packages', 'public');
            $data['main_image'] = Storage::url($path);
        } elseif (!empty($data['main_image_url'])) {
            $data['main_image'] = $data['main_image_url'];
        }

        // Ensure features saved as array
        $data['features'] = $data['features'] ?? [];

        Package::create($data);

        return redirect()->route('admin.packages.index')->with('success', 'Package created successfully.');
    }

    /**
     * Show the form for editing a package.
     */
    public function edit(Package $package)
    {
        $categories = Category::where('is_active', true)->get();
        $hotels = Hotel::where('is_active', true)->get();
        return view('admin.packages.edit', compact('package', 'categories', 'hotels'));
    }

    /**
     * Update the specified package.
     */
    public function update(StorePackageRequest $request, Package $package)
    {

        $data = $request->validated();
        // Handle main image: replace if new uploaded
        if ($request->hasFile('main_image_file')) {
            // Delete old image if exists
            if ($package->main_image && str_contains($package->main_image, '/storage/')) {
                $oldPath = str_replace('/storage/', '', $package->main_image);
                Storage::disk('public')->delete($oldPath);
            }
            $path = $request->file('main_image_file')->store('packages', 'public');
            $data['main_image'] = Storage::url($path);
        } elseif (!empty($data['main_image_url'])) {
            $data['main_image'] = $data['main_image_url'];
        }

        $data['features'] = $data['features'] ?? [];

        $package->update($data);

        return redirect()->route('admin.packages.index')->with('success', 'Package updated successfully.');
    }

    /**
     * Remove the specified package.
     */
    public function destroy(Package $package)
    {
        // Delete image if exists
        if ($package->main_image && str_contains($package->main_image, '/storage/')) {
            $oldPath = str_replace('/storage/', '', $package->main_image);
            Storage::disk('public')->delete($oldPath);
        }

        $package->delete();

        return redirect()->route('admin.packages.index')->with('success', 'Package deleted successfully.');
    }
}
