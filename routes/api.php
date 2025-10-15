<?php

use App\Models\Category;
use App\Models\Hotel;
use App\Models\Package;
use App\Services\TranslationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// Get featured packages (latest 6) - MUST be before /packages/{id}
Route::get('/packages/featured/list', function (Request $request) {
    $lang = $request->get('lang', 'en');
    $translator = new TranslationService();
    
    $packages = Package::with(['category', 'hotel'])
        ->where('is_active', true)
        ->orderBy('created_at', 'desc')
        ->limit(6)
        ->get()
        ->map(function ($package) use ($lang, $translator) {
            if ($lang === 'ar') {
                // Use stored Arabic or auto-translate
                $package->title = $translator->getTranslatedValue($package->title, $package->title_ar, 'ar');
                $package->description = $translator->getTranslatedValue($package->description, $package->description_ar, 'ar');
                $package->location = $translator->getTranslatedValue($package->location, $package->location_ar, 'ar');
                
                if ($package->category) {
                    $package->category->name = $translator->getTranslatedValue($package->category->name, $package->category->name_ar, 'ar');
                }
                
                if ($package->hotel) {
                    $package->hotel->name = $translator->getTranslatedValue($package->hotel->name, $package->hotel->name_ar, 'ar');
                    $package->hotel->description = $translator->getTranslatedValue($package->hotel->description, $package->hotel->description_ar, 'ar');
                    $package->hotel->location = $translator->getTranslatedValue($package->hotel->location, $package->hotel->location_ar, 'ar');
                }
            }
            return $package;
        });
    
    return response()->json($packages);
});

// Get all active packages with relationships
Route::get('/packages', function (Request $request) {
    $lang = $request->get('lang', 'en');
    
    $query = Package::with(['category', 'hotel'])
        ->where('is_active', true);
     
    // Filter by category (only if category_id is provided and not empty)
    if ($request->has('category_id') && $request->category_id !== '' && $request->category_id !== null) {
        $query->where('category_id', $request->category_id);
    }
    
    // Search by title or location (only if search is provided and not empty)
    if ($request->has('search') && $request->search !== '' && $request->search !== null) {
        $search = $request->search;
        $query->where(function($q) use ($search, $lang) {
            if ($lang === 'ar') {
                $q->where('title_ar', 'like', "%{$search}%")
                  ->orWhere('title', 'like', "%{$search}%")
                  ->orWhere('location_ar', 'like', "%{$search}%")
                  ->orWhere('location', 'like', "%{$search}%");
            } else {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('location', 'like', "%{$search}%");
            }
        });
    }
    
    // Sort
    $sortBy = $request->get('sort_by', 'created_at');
    $sortOrder = $request->get('sort_order', 'desc');
    $query->orderBy($sortBy, $sortOrder);
    
    $translator = new TranslationService();
    
    $packages = $query->get()->map(function ($package) use ($lang, $translator) {
        if ($lang === 'ar') {
            // Use stored Arabic or auto-translate
            $package->title = $translator->getTranslatedValue($package->title, $package->title_ar, 'ar');
            $package->description = $translator->getTranslatedValue($package->description, $package->description_ar, 'ar');
            $package->location = $translator->getTranslatedValue($package->location, $package->location_ar, 'ar');
            
            if ($package->category) {
                $package->category->name = $translator->getTranslatedValue($package->category->name, $package->category->name_ar, 'ar');
            }
            
            if ($package->hotel) {
                $package->hotel->name = $translator->getTranslatedValue($package->hotel->name, $package->hotel->name_ar, 'ar');
                $package->hotel->description = $translator->getTranslatedValue($package->hotel->description, $package->hotel->description_ar, 'ar');
                $package->hotel->location = $translator->getTranslatedValue($package->hotel->location, $package->hotel->location_ar, 'ar');
            }
        }
        return $package;
    });
    
    return response()->json($packages);
});

// Get single package by ID
Route::get('/packages/{id}', function (Request $request, $id) {
    $lang = $request->get('lang', 'en');
    $package = Package::with(['category', 'hotel'])->findOrFail($id);
    $translator = new TranslationService();
    
    if ($lang === 'ar') {
        // Use stored Arabic or auto-translate
        $package->title = $translator->getTranslatedValue($package->title, $package->title_ar, 'ar');
        $package->description = $translator->getTranslatedValue($package->description, $package->description_ar, 'ar');
        $package->location = $translator->getTranslatedValue($package->location, $package->location_ar, 'ar');
        
        if ($package->category) {
            $package->category->name = $translator->getTranslatedValue($package->category->name, $package->category->name_ar, 'ar');
        }
        
        if ($package->hotel) {
            $package->hotel->name = $translator->getTranslatedValue($package->hotel->name, $package->hotel->name_ar, 'ar');
            $package->hotel->description = $translator->getTranslatedValue($package->hotel->description, $package->hotel->description_ar, 'ar');
            $package->hotel->location = $translator->getTranslatedValue($package->hotel->location, $package->hotel->location_ar, 'ar');
        }
    }
    
    return response()->json($package);
});

// Get all active categories
Route::get('/categories', function (Request $request) {
    $lang = $request->get('lang', 'en');
    $translator = new TranslationService();
    
    $categories = Category::where('is_active', true)
        ->withCount('packages')
        ->get()
        ->map(function ($category) use ($lang, $translator) {
            if ($lang === 'ar') {
                $category->name = $translator->getTranslatedValue($category->name, $category->name_ar, 'ar');
            }
            return $category;
        });
    
    return response()->json($categories);
});

// Get all active hotels
Route::get('/hotels', function () {
    $hotels = Hotel::where('is_active', true)->get();
    return response()->json($hotels);
});
