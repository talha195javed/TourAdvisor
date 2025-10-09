<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreHotelRequest;
use App\Models\Hotel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HotelController extends Controller
{
    /**
     * Display a listing of hotels.
     */
    public function index(Request $request)
    {
        $query = Hotel::query();

        // Search filter
        if ($request->filled('q')) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->q . '%')
                    ->orWhere('location', 'like', '%' . $request->q . '%');
            });
        }

        // Status filter
        if ($request->filled('status')) {
            if ($request->status === 'active') {
                $query->where('is_active', true);
            } elseif ($request->status === 'inactive') {
                $query->where('is_active', false);
            }
        }

        // Sort options
        switch ($request->get('sort', 'newest')) {
            case 'oldest':
                $query->orderBy('created_at', 'asc');
                break;
            case 'name_asc':
                $query->orderBy('name', 'asc');
                break;
            case 'name_desc':
                $query->orderBy('name', 'desc');
                break;
            default:
                $query->orderBy('created_at', 'desc');
        }

        // Get active hotels count for stats
        $activeHotelsCount = Hotel::where('is_active', true)->count();

        $hotels = $query->paginate(10);

        return view('admin.hotels.index', compact('hotels', 'activeHotelsCount'));
    }

    /**
     * Show the form for creating a new hotel.
     */
    public function create()
    {
        return view('admin.hotels.create');
    }

    /**
     * Store a newly created hotel.
     */
    public function store(StoreHotelRequest $request)
    {
        try {
            $data = $request->validated();

            // Handle image upload or URL
            if ($request->hasFile('image_file')) {
                $path = $request->file('image_file')->store('hotels', 'public');
                $data['image_path'] = Storage::url($path);
            } elseif (!empty($data['image_url'])) {
                $data['image_path'] = $data['image_url'];
            }

            // Ensure boolean value for is_active
            $data['is_active'] = $request->has('is_active');

            Hotel::create($data);

            return redirect()->route('admin.hotels.index')
                ->with('success', 'Hotel created successfully!');

        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Failed to create hotel: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for editing a hotel.
     */
    public function edit(Hotel $hotel)
    {
        return view('admin.hotels.edit', compact('hotel'));
    }

    /**
     * Update the specified hotel.
     */
    public function update(StoreHotelRequest $request, Hotel $hotel)
    {
        try {
            $data = $request->validated();

            // Handle image upload or URL
            if ($request->hasFile('image_file')) {
                // Delete old image if it exists and is from storage
                if ($hotel->image_path && str_contains($hotel->image_path, '/storage/')) {
                    $oldPath = str_replace('/storage/', '', $hotel->image_path);
                    Storage::disk('public')->delete($oldPath);
                }
                $path = $request->file('image_file')->store('hotels', 'public');
                $data['image_path'] = Storage::url($path);
            } elseif (!empty($data['image_url'])) {
                $data['image_path'] = $data['image_url'];
            }

            // Ensure boolean value for is_active
            $data['is_active'] = $request->has('is_active');

            $hotel->update($data);

            return redirect()->route('admin.hotels.index')
                ->with('success', 'Hotel updated successfully!');

        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Failed to update hotel: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified hotel.
     */
    public function destroy(Hotel $hotel)
    {
        try {
            // Check if hotel has any packages before deletion
            if ($hotel->packages()->exists()) {
                return redirect()->route('admin.hotels.index')
                    ->with('error', 'Cannot delete hotel. There are packages associated with this hotel.');
            }

            // Delete image if it exists and is from storage
            if ($hotel->image_path && str_contains($hotel->image_path, '/storage/')) {
                $oldPath = str_replace('/storage/', '', $hotel->image_path);
                Storage::disk('public')->delete($oldPath);
            }

            $hotel->delete();

            return redirect()->route('admin.hotels.index')
                ->with('success', 'Hotel deleted successfully!');

        } catch (\Exception $e) {
            return redirect()->route('admin.hotels.index')
                ->with('error', 'Failed to delete hotel: ' . $e->getMessage());
        }
    }

    /**
     * Toggle hotel status (Active/Inactive)
     */
    public function toggleStatus(Hotel $hotel)
    {
        try {
            $hotel->update([
                'is_active' => !$hotel->is_active
            ]);

            $status = $hotel->is_active ? 'activated' : 'deactivated';

            if (request()->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => "Hotel {$status} successfully!",
                    'is_active' => $hotel->is_active
                ]);
            }

            return redirect()->route('admin.hotels.index')
                ->with('success', "Hotel {$status} successfully!");

        } catch (\Exception $e) {
            if (request()->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to update hotel status: ' . $e->getMessage()
                ], 500);
            }

            return redirect()->route('admin.hotels.index')
                ->with('error', 'Failed to update hotel status: ' . $e->getMessage());
        }
    }

    /**
     * Bulk actions for hotels
     */
    public function bulkAction(Request $request)
    {
        $request->validate([
            'action' => 'required|in:activate,deactivate,delete',
            'ids' => 'required|array',
            'ids.*' => 'exists:hotels,id'
        ]);

        try {
            switch ($request->action) {
                case 'activate':
                    Hotel::whereIn('id', $request->ids)->update(['is_active' => true]);
                    $message = 'Selected hotels activated successfully!';
                    break;

                case 'deactivate':
                    Hotel::whereIn('id', $request->ids)->update(['is_active' => false]);
                    $message = 'Selected hotels deactivated successfully!';
                    break;

                case 'delete':
                    // Check if any hotels have packages
                    $hotelsWithPackages = Hotel::whereIn('id', $request->ids)
                        ->whereHas('packages')
                        ->count();

                    if ($hotelsWithPackages > 0) {
                        return response()->json([
                            'success' => false,
                            'message' => 'Cannot delete hotels that have packages associated with them.'
                        ], 422);
                    }

                    // Delete images and hotels
                    $hotels = Hotel::whereIn('id', $request->ids)->get();
                    foreach ($hotels as $hotel) {
                        if ($hotel->image_path && str_contains($hotel->image_path, '/storage/')) {
                            $oldPath = str_replace('/storage/', '', $hotel->image_path);
                            Storage::disk('public')->delete($oldPath);
                        }
                    }

                    Hotel::whereIn('id', $request->ids)->delete();
                    $message = 'Selected hotels deleted successfully!';
                    break;
            }

            return response()->json([
                'success' => true,
                'message' => $message
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to perform bulk action: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get hotel statistics for dashboard
     */
    public function getStats()
    {
        $totalHotels = Hotel::count();
        $activeHotels = Hotel::where('is_active', true)->count();
        $newHotelsThisMonth = Hotel::where('created_at', '>=', now()->subMonth())->count();

        return response()->json([
            'total' => $totalHotels,
            'active' => $activeHotels,
            'new_this_month' => $newHotelsThisMonth
        ]);
    }
}
