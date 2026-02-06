<?php

use App\Http\Controllers\API\AuthController;
use App\Models\Category;
use App\Models\Hotel;
use App\Models\Package;
use App\Services\TranslationService;
use App\Services\StripePaymentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// Authentication Routes
Route::post('/auth/register', [AuthController::class, 'register']);
Route::post('/auth/login', [AuthController::class, 'login']);

// Protected Routes (require authentication)
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/auth/logout', [AuthController::class, 'logout']);
    Route::get('/auth/me', [AuthController::class, 'me']);
    Route::get('/auth/my-bookings', [AuthController::class, 'myBookings']);
    
    // Stripe Payment Routes
    Route::post('/stripe/create-payment-intent', function (Request $request) {
        $validated = $request->validate([
            'amount' => 'required|numeric|min:0.01',
            'booking_reference' => 'required|string',
        ]);

        $stripeService = new StripePaymentService();
        $result = $stripeService->createPaymentIntent(
            $validated['amount'],
            'usd',
            [
                'booking_reference' => $validated['booking_reference'],
                'customer_email' => $request->user()->email,
            ]
        );

        if ($result['success']) {
            return response()->json([
                'success' => true,
                'clientSecret' => $result['client_secret'],
                'paymentIntentId' => $result['payment_intent_id'],
            ]);
        }

        return response()->json([
            'success' => false,
            'error' => $result['error'],
        ], 400);
    });

    Route::post('/stripe/confirm-payment', function (Request $request) {
        $validated = $request->validate([
            'payment_intent_id' => 'required|string',
            'booking_id' => 'required|exists:bookings,id',
        ]);

        $stripeService = new StripePaymentService();
        $result = $stripeService->confirmPayment($validated['payment_intent_id']);

        if ($result['success']) {
            // Update booking with payment information
            $booking = \App\Models\Booking::findOrFail($validated['booking_id']);
            $booking->update([
                'stripe_payment_intent_id' => $validated['payment_intent_id'],
                'stripe_charge_id' => $result['charge_id'],
                'payment_status' => 'paid',
                'paid_amount' => $booking->total_amount,
                'remaining_amount' => 0,
                'payment_method' => 'card',
                'payment_method_type' => 'stripe',
                'payment_timing' => 'now',
                'transaction_id' => $result['charge_id'],
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Payment confirmed successfully',
                'booking' => $booking->fresh()->load('package'),
            ]);
        }

        return response()->json([
            'success' => false,
            'error' => $result['error'],
        ], 400);
    });

    // Update booking (only if can_edit_before_payment is true)
    Route::put('/bookings/{id}', function (Request $request, $id) {
        $booking = \App\Models\Booking::findOrFail($id);
        
        // Check if user owns this booking
        if ($booking->client_id !== $request->user()->id) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized',
            ], 403);
        }

        // Check if booking can be edited
        if (!$booking->can_edit_before_payment) {
            return response()->json([
                'success' => false,
                'message' => 'This booking cannot be edited. Payment has been initiated or completed.',
            ], 403);
        }

        $validated = $request->validate([
            'customer_name' => 'nullable|string|max:255',
            'customer_email' => 'nullable|email|max:255',
            'customer_phone' => 'nullable|string|max:255',
            'customer_country' => 'nullable|string|max:255',
            'customer_address' => 'nullable|string',
            'travel_date' => 'nullable|date|after_or_equal:today',
            'return_date' => 'nullable|date|after_or_equal:travel_date',
            'number_of_adults' => 'nullable|integer|min:1',
            'number_of_children' => 'nullable|integer|min:0',
            'number_of_infants' => 'nullable|integer|min:0',
            'special_requests' => 'nullable|string',
        ]);

        // Handle passengers data
        $passengersData = null;
        if ($request->has('passengers')) {
            $passengersJson = $request->input('passengers');
            if (is_string($passengersJson)) {
                $passengersData = json_decode($passengersJson, true);
            } elseif (is_array($passengersJson)) {
                $passengersData = $passengersJson;
            }
            $validated['passengers_data'] = $passengersData;
        }

        // Recalculate total if passenger numbers changed
        if (isset($validated['number_of_adults']) || isset($validated['number_of_children'])) {
            $package = $booking->package;
            $adults = $validated['number_of_adults'] ?? $booking->number_of_adults;
            $children = $validated['number_of_children'] ?? $booking->number_of_children;
            
            $totalAmount = ($adults * $package->price) + ($children * $package->price * 0.5);
            
            if ($booking->visa_required && $booking->number_of_visas > 0) {
                $totalAmount += $booking->total_visa_amount;
            }
            
            $validated['total_amount'] = $totalAmount;
            $validated['remaining_amount'] = $totalAmount;
        }

        $booking->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Booking updated successfully',
            'booking' => $booking->fresh()->load('package'),
        ]);
    });

    // Make payment for existing booking
    Route::post('/bookings/{id}/pay', function (Request $request, $id) {
        $booking = \App\Models\Booking::findOrFail($id);
        
        // Check if user owns this booking
        if ($booking->client_id !== $request->user()->id) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized',
            ], 403);
        }

        // Check if already paid
        if ($booking->payment_status === 'paid') {
            return response()->json([
                'success' => false,
                'message' => 'This booking has already been paid.',
            ], 400);
        }

        $validated = $request->validate([
            'payment_method_type' => 'required|string|in:stripe,cash,personal',
        ]);

        // If Stripe, create payment intent
        if ($validated['payment_method_type'] === 'stripe') {
            $stripeService = new StripePaymentService();
            $result = $stripeService->createPaymentIntent(
                $booking->total_amount,
                'usd',
                [
                    'booking_reference' => $booking->booking_reference,
                    'customer_email' => $booking->customer_email,
                ]
            );

            if ($result['success']) {
                return response()->json([
                    'success' => true,
                    'clientSecret' => $result['client_secret'],
                    'paymentIntentId' => $result['payment_intent_id'],
                    'booking' => $booking,
                ]);
            }

            return response()->json([
                'success' => false,
                'error' => $result['error'],
            ], 400);
        }

        // For cash/personal, update payment method
        $booking->update([
            'payment_method_type' => $validated['payment_method_type'],
            'payment_timing' => 'now',
            'can_edit_before_payment' => false,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Payment method updated. Please complete payment.',
            'booking' => $booking->fresh()->load('package'),
        ]);
    });
});

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

// Create booking from frontend
Route::post('/bookings', function (Request $request) {
    $validated = $request->validate([
        'package_id' => 'required|exists:packages,id',
        'customer_name' => 'required|string|max:255',
        'customer_email' => 'required|email|max:255',
        'customer_phone' => 'required|string|max:255',
        'customer_country' => 'nullable|string|max:255',
        'customer_address' => 'nullable|string',
        'travel_date' => 'required|date|after_or_equal:today',
        'return_date' => 'nullable|date|after_or_equal:travel_date',
        'number_of_adults' => 'required|integer|min:1',
        'number_of_children' => 'nullable|integer|min:0',
        'number_of_infants' => 'nullable|integer|min:0',
        'special_requests' => 'nullable|string',
        'visa_required' => 'nullable|boolean',
        'number_of_visas' => 'nullable|integer|min:0',
        'passport_images.*' => 'nullable|image|max:5120',
        'applicant_images.*' => 'nullable|image|max:5120',
        'emirates_id_images.*' => 'nullable|image|max:5120',
        'payment_method_type' => 'nullable|string|in:stripe,cash,personal,later',
        'payment_timing' => 'nullable|string|in:now,later',
    ]);

    // Get package to calculate pricing
    $package = Package::findOrFail($validated['package_id']);
    
    // Calculate total amount
    $adults = $validated['number_of_adults'];
    $children = $validated['number_of_children'] ?? 0;
    $infants = $validated['number_of_infants'] ?? 0;
    
    // Simple calculation: adults pay full price, children 50%, infants free
    $totalAmount = ($adults * $package->price) + ($children * $package->price * 0.5);
    
    // Calculate visa amount if required
    $visaRequired = (bool) $request->input('visa_required', false);
    $numberOfVisas = (int) $request->input('number_of_visas', 0);
    $totalVisaAmount = 0;
    $visaPricePerPerson = 0;
    
    if ($visaRequired && $numberOfVisas > 0 && $package->visa_price) {
        $visaPricePerPerson = $package->visa_price;
        $totalVisaAmount = $numberOfVisas * $visaPricePerPerson;
        $totalAmount += $totalVisaAmount;
    }
    
    // Handle visa file uploads
    $passportImages = [];
    $applicantImages = [];
    $emiratesIdImages = [];
    
    if ($visaRequired) {
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
    
    // Generate booking reference
    $bookingReference = \App\Models\Booking::generateBookingReference();
    
    // Handle passengers data (from frontend JSON string)
    $passengersData = null;
    if ($request->has('passengers')) {
        $passengersJson = $request->input('passengers');
        if (is_string($passengersJson)) {
            $passengersData = json_decode($passengersJson, true);
        } elseif (is_array($passengersJson)) {
            $passengersData = $passengersJson;
        }
    }
    
    // Get authenticated client (optional for guest bookings)
    $client = $request->user();
    
    // Determine payment status and method
    $paymentMethodType = $request->input('payment_method_type', 'later');
    $paymentTiming = $request->input('payment_timing', 'later');
    $paymentStatus = 'pending';
    $canEditBeforePayment = true;

    // Guests cannot use Stripe (Stripe routes require auth)
    if (!$client && $paymentMethodType === 'stripe') {
        return response()->json([
            'success' => false,
            'message' => 'Authentication required for card payments.',
        ], 422);
    }
    
    // If payment method is cash or personal and timing is now, mark as pending but allow completion
    if (in_array($paymentMethodType, ['cash', 'personal']) && $paymentTiming === 'now') {
        $paymentStatus = 'pending'; // Admin will confirm later
        $canEditBeforePayment = false;
    }
    
    // Create booking
    $booking = \App\Models\Booking::create([
        'booking_reference' => $bookingReference,
        'package_id' => $validated['package_id'],
        'client_id' => $client?->id,
        'customer_name' => $validated['customer_name'],
        'customer_email' => $validated['customer_email'],
        'customer_phone' => $validated['customer_phone'],
        'customer_country' => $validated['customer_country'] ?? null,
        'customer_address' => $validated['customer_address'] ?? null,
        'travel_date' => $validated['travel_date'],
        'return_date' => $validated['return_date'] ?? null,
        'number_of_adults' => $adults,
        'number_of_children' => $children,
        'number_of_infants' => $infants,
        'package_price' => $package->price,
        'total_amount' => $totalAmount,
        'paid_amount' => 0,
        'remaining_amount' => $totalAmount,
        'payment_status' => $paymentStatus,
        'payment_method_type' => $paymentMethodType,
        'payment_timing' => $paymentTiming,
        'can_edit_before_payment' => $canEditBeforePayment,
        'status' => 'pending',
        'special_requests' => $validated['special_requests'] ?? null,
        'visa_required' => $visaRequired,
        'number_of_visas' => $numberOfVisas,
        'visa_price_per_person' => $visaPricePerPerson,
        'total_visa_amount' => $totalVisaAmount,
        'passport_images' => $passportImages,
        'applicant_images' => $applicantImages,
        'emirates_id_images' => $emiratesIdImages,
        'passengers_data' => $passengersData,
    ]);

    return response()->json([
        'success' => true,
        'message' => 'Booking created successfully!',
        'booking' => $booking->load('package'),
    ], 201);
});
