<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Package;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Booking::with('package');

        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('booking_reference', 'like', "%{$search}%")
                  ->orWhere('customer_name', 'like', "%{$search}%")
                  ->orWhere('customer_email', 'like', "%{$search}%")
                  ->orWhere('customer_phone', 'like', "%{$search}%");
            });
        }

        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        if ($request->has('payment_status') && $request->payment_status != '') {
            $query->where('payment_status', $request->payment_status);
        }

        $bookings = $query->latest()->paginate(15);

        return view('admin.bookings.index', compact('bookings'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $packages = Package::where('is_active', true)->get();
        return view('admin.bookings.create', compact('packages'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'package_id' => 'required|exists:packages,id',
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'customer_phone' => 'required|string|max:255',
            'customer_country' => 'nullable|string|max:255',
            'customer_address' => 'nullable|string',
            'travel_date' => 'required|date',
            'return_date' => 'nullable|date|after_or_equal:travel_date',
            'number_of_adults' => 'required|integer|min:1',
            'number_of_children' => 'nullable|integer|min:0',
            'number_of_infants' => 'nullable|integer|min:0',
            'package_price' => 'required|numeric|min:0',
            'total_amount' => 'required|numeric|min:0',
            'paid_amount' => 'nullable|numeric|min:0',
            'payment_status' => 'required|in:pending,partial,paid,refunded',
            'payment_method' => 'nullable|in:cash,card,bank_transfer,online',
            'transaction_id' => 'nullable|string|max:255',
            'status' => 'required|in:pending,confirmed,cancelled,completed',
            'special_requests' => 'nullable|string',
            'admin_notes' => 'nullable|string',
            'visa_required' => 'nullable|boolean',
            'number_of_visas' => 'nullable|integer|min:0',
            'visa_price_per_person' => 'nullable|numeric|min:0',
            'total_visa_amount' => 'nullable|numeric|min:0',
            'passport_images.*' => 'nullable|image|max:5120',
            'applicant_images.*' => 'nullable|image|max:5120',
            'emirates_id_images.*' => 'nullable|image|max:5120',
        ]);

        $passportImages = [];
        $applicantImages = [];
        $emiratesIdImages = [];

        if ($request->input('visa_required')) {
            if ($request->hasFile('passport_images')) {
                foreach ($request->file('passport_images') as $file) {
                    $path = $file->store('bookings/visa/passports', 'public');
                    $passportImages[] = $path;
                }
            }

            if ($request->hasFile('applicant_images')) {
                foreach ($request->file('applicant_images') as $file) {
                    $path = $file->store('bookings/visa/applicants', 'public');
                    $applicantImages[] = $path;
                }
            }

            if ($request->hasFile('emirates_id_images')) {
                foreach ($request->file('emirates_id_images') as $file) {
                    $path = $file->store('bookings/visa/emirates_ids', 'public');
                    $emiratesIdImages[] = $path;
                }
            }
        }

        $validated['booking_reference'] = Booking::generateBookingReference();

        $validated['remaining_amount'] = $validated['total_amount'] - ($validated['paid_amount'] ?? 0);

        $validated['passport_images'] = $passportImages;
        $validated['applicant_images'] = $applicantImages;
        $validated['emirates_id_images'] = $emiratesIdImages;

        // Handle passengers data
        if ($request->has('passengers')) {
            // From admin create view (array format)
            $validated['passengers_data'] = $request->input('passengers');
        } elseif ($request->has('passengers') && is_string($request->input('passengers'))) {
            // From frontend modal (JSON string)
            $validated['passengers_data'] = json_decode($request->input('passengers'), true);
        }

        Booking::create($validated);

        return redirect()->route('admin.bookings.index')
            ->with('success', 'Booking created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Booking $booking)
    {
        $booking->load('package');
        return view('admin.bookings.show', compact('booking'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Booking $booking)
    {
        $packages = Package::where('is_active', true)->get();
        return view('admin.bookings.edit', compact('booking', 'packages'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Booking $booking)
    {
        $validated = $request->validate([
            'package_id' => 'required|exists:packages,id',
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'customer_phone' => 'required|string|max:255',
            'customer_country' => 'nullable|string|max:255',
            'customer_address' => 'nullable|string',
            'travel_date' => 'required|date',
            'return_date' => 'nullable|date|after_or_equal:travel_date',
            'number_of_adults' => 'required|integer|min:1',
            'number_of_children' => 'nullable|integer|min:0',
            'number_of_infants' => 'nullable|integer|min:0',
            'package_price' => 'required|numeric|min:0',
            'total_amount' => 'required|numeric|min:0',
            'paid_amount' => 'nullable|numeric|min:0',
            'payment_status' => 'required|in:pending,partial,paid,refunded',
            'payment_method' => 'nullable|in:cash,card,bank_transfer,online',
            'transaction_id' => 'nullable|string|max:255',
            'status' => 'required|in:pending,confirmed,cancelled,completed',
            'special_requests' => 'nullable|string',
            'admin_notes' => 'nullable|string',
            'visa_required' => 'nullable|boolean',
            'number_of_visas' => 'nullable|integer|min:0',
            'visa_price_per_person' => 'nullable|numeric|min:0',
            'total_visa_amount' => 'nullable|numeric|min:0',
            'passport_images.*' => 'nullable|image|max:5120',
            'applicant_images.*' => 'nullable|image|max:5120',
            'emirates_id_images.*' => 'nullable|image|max:5120',
        ]);

        $passportImages = $booking->passport_images ?? [];
        $applicantImages = $booking->applicant_images ?? [];
        $emiratesIdImages = $booking->emirates_id_images ?? [];

        if ($request->has('delete_passport_images')) {
            $json = $request->input('delete_passport_images')[0] ?? null;
            if ($json) {
                $list = json_decode($json, true);
                if (is_array($list)) {
                    foreach ($list as $path) {
                        Storage::disk('public')->delete($path);
                        $passportImages = array_values(array_filter($passportImages, fn($p) => $p !== $path));
                    }
                }
            }
        }

        if ($request->has('delete_applicant_images')) {
            $json = $request->input('delete_applicant_images')[0] ?? null;
            if ($json) {
                $list = json_decode($json, true);
                if (is_array($list)) {
                    foreach ($list as $path) {
                        Storage::disk('public')->delete($path);
                        $applicantImages = array_values(array_filter($applicantImages, fn($p) => $p !== $path));
                    }
                }
            }
        }

        if ($request->has('delete_emirates_id_images')) {
            $json = $request->input('delete_emirates_id_images')[0] ?? null;
            if ($json) {
                $list = json_decode($json, true);
                if (is_array($list)) {
                    foreach ($list as $path) {
                        Storage::disk('public')->delete($path);
                        $emiratesIdImages = array_values(array_filter($emiratesIdImages, fn($p) => $p !== $path));
                    }
                }
            }
        }

        if ($request->input('visa_required')) {
            if ($request->hasFile('passport_images')) {
                foreach ($request->file('passport_images') as $file) {
                    $path = $file->store('bookings/visa/passports', 'public');
                    $passportImages[] = $path;
                }
            }

            if ($request->hasFile('applicant_images')) {
                foreach ($request->file('applicant_images') as $file) {
                    $path = $file->store('bookings/visa/applicants', 'public');
                    $applicantImages[] = $path;
                }
            }

            if ($request->hasFile('emirates_id_images')) {
                foreach ($request->file('emirates_id_images') as $file) {
                    $path = $file->store('bookings/visa/emirates_ids', 'public');
                    $emiratesIdImages[] = $path;
                }
            }
        }

        $validated['remaining_amount'] = $validated['total_amount'] - ($validated['paid_amount'] ?? 0);

        $validated['passport_images'] = $passportImages;
        $validated['applicant_images'] = $applicantImages;
        $validated['emirates_id_images'] = $emiratesIdImages;

        if ($request->has('passengers')) {
            $validated['passengers_data'] = $request->input('passengers');
        } elseif ($request->has('passengers') && is_string($request->input('passengers'))) {
            $validated['passengers_data'] = json_decode($request->input('passengers'), true);
        }

        $booking->update($validated);

        return redirect()->route('admin.bookings.index')
            ->with('success', 'Booking updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Booking $booking)
    {
        $booking->delete();

        return redirect()->route('admin.bookings.index')
            ->with('success', 'Booking deleted successfully!');
    }
}
