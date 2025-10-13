<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Package;
use App\Models\Category;
use App\Models\Hotel;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// Get featured packages (latest 6) - MUST be before /packages/{id}
Route::get('/packages/featured/list', function () {
    $packages = Package::with(['category', 'hotel'])
        ->where('is_active', true)
        ->orderBy('created_at', 'desc')
        ->limit(6)
        ->get();
    
    return response()->json($packages);
});

// Get all active packages with relationships
Route::get('/packages', function (Request $request) {
    $query = Package::with(['category', 'hotel'])
        ->where('is_active', true);
    
    // Filter by category (only if category_id is provided and not empty)
    if ($request->has('category_id') && $request->category_id !== '' && $request->category_id !== null) {
        $query->where('category_id', $request->category_id);
    }
    
    // Search by title or location (only if search is provided and not empty)
    if ($request->has('search') && $request->search !== '' && $request->search !== null) {
        $search = $request->search;
        $query->where(function($q) use ($search) {
            $q->where('title', 'like', "%{$search}%")
              ->orWhere('location', 'like', "%{$search}%");
        });
    }
    
    // Sort
    $sortBy = $request->get('sort_by', 'created_at');
    $sortOrder = $request->get('sort_order', 'desc');
    $query->orderBy($sortBy, $sortOrder);
    
    return response()->json($query->get());
});

// Get single package by ID
Route::get('/packages/{id}', function ($id) {
    $package = Package::with(['category', 'hotel'])->findOrFail($id);
    return response()->json($package);
});

// Get all active categories
Route::get('/categories', function () {
    $categories = Category::where('is_active', true)
        ->withCount('packages')
        ->get();
    
    return response()->json($categories);
});

// Get all active hotels
Route::get('/hotels', function () {
    $hotels = Hotel::where('is_active', true)->get();
    return response()->json($hotels);
});
