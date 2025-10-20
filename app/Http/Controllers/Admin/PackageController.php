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

        // Handle multiple images upload
        $imagesPaths = [];
        if ($request->hasFile('package_images')) {
            foreach ($request->file('package_images') as $image) {
                $path = $image->store('packages/gallery', 'public');
                $imagesPaths[] = Storage::url($path);
            }
        }
        $data['images'] = $imagesPaths;

        // Ensure features saved as array
        $data['features'] = $data['features'] ?? [];

        Package::create($data);

        return redirect()->route('admin.packages.index')->with('success', 'Package created successfully.');
    }

    /**
     * Display the specified package.
     */
    public function show(Package $package)
    {
        return view('admin.packages.show', compact('package'));
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

        // Handle multiple images upload
        $existingImages = $package->images ?? [];
        
        // Handle image deletions
        if ($request->has('delete_images')) {
            $deleteImagesJson = $request->input('delete_images')[0] ?? null;
            if ($deleteImagesJson) {
                $deleteImages = json_decode($deleteImagesJson, true);
                if (is_array($deleteImages)) {
                    foreach ($deleteImages as $imageToDelete) {
                        // Delete from storage
                        if (str_contains($imageToDelete, '/storage/')) {
                            $oldPath = str_replace('/storage/', '', $imageToDelete);
                            Storage::disk('public')->delete($oldPath);
                        }
                        // Remove from array
                        $existingImages = array_values(array_filter($existingImages, function($img) use ($imageToDelete) {
                            return $img !== $imageToDelete;
                        }));
                    }
                }
            }
        }

        // Add new images
        if ($request->hasFile('package_images')) {
            foreach ($request->file('package_images') as $image) {
                $path = $image->store('packages/gallery', 'public');
                $existingImages[] = Storage::url($path);
            }
        }

        $data['images'] = $existingImages;
        $data['features'] = $data['features'] ?? [];

        $package->update($data);

        return redirect()->route('admin.packages.index')->with('success', 'Package updated successfully.');
    }

    /**
     * Remove the specified package.
     */
    public function destroy(Package $package)
    {
        // Delete main image if exists
        if ($package->main_image && str_contains($package->main_image, '/storage/')) {
            $oldPath = str_replace('/storage/', '', $package->main_image);
            Storage::disk('public')->delete($oldPath);
        }

        // Delete all gallery images
        if ($package->images && is_array($package->images)) {
            foreach ($package->images as $image) {
                if (str_contains($image, '/storage/')) {
                    $oldPath = str_replace('/storage/', '', $image);
                    Storage::disk('public')->delete($oldPath);
                }
            }
        }

        $package->delete();

        return redirect()->route('admin.packages.index')->with('success', 'Package deleted successfully.');
    }
}
