<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\PackageController;
use App\Http\Controllers\Admin\HotelController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\BookingController;

// Frontend Routes (React SPA)
Route::get('/', function () {
    return view('frontend');
});

Route::get('/packages', function () {
    return view('frontend');
});

// Admin Login Routes
Route::get('/admin/login', function () {
    return view('auth/login');
})->middleware('guest')->name('login');

Route::post('/admin/login', [App\Http\Controllers\Auth\AuthenticatedSessionController::class, 'store'])
    ->middleware('guest');

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::prefix('admin')->name('admin.')->middleware(['auth'])->group(function () {
    // Package routes
    Route::resource('packages', PackageController::class);

    // Category routes
    Route::resource('categories', CategoryController::class);
    Route::post('/categories/{category}/toggle-status', [CategoryController::class, 'toggleStatus'])->name('categories.toggle-status');

    // Hotel routes
    Route::get('/hotels', [HotelController::class, 'index'])->name('hotels.index');
    Route::get('/hotels/create', [HotelController::class, 'create'])->name('hotels.create');
    Route::post('/hotels', [HotelController::class, 'store'])->name('hotels.store');
    Route::get('/hotels/{hotel}/edit', [HotelController::class, 'edit'])->name('hotels.edit');
    Route::put('/hotels/{hotel}', [HotelController::class, 'update'])->name('hotels.update');
    Route::delete('/hotels/{hotel}', [HotelController::class, 'destroy'])->name('hotels.destroy');

    // Additional Hotel Features
    Route::post('/hotels/{hotel}/toggle-status', [HotelController::class, 'toggleStatus'])->name('hotels.toggle-status');
    Route::post('/hotels/bulk-action', [HotelController::class, 'bulkAction'])->name('hotels.bulk-action');
    Route::get('/hotels/stats', [HotelController::class, 'getStats'])->name('hotels.stats');

    // Booking routes
    Route::resource('bookings', BookingController::class);

    // User routes
    Route::resource('users', UserController::class);

    // Support route
    Route::get('/support', function () {
        return view('admin.support');
    })->name('support');
});



require __DIR__.'/auth.php';
