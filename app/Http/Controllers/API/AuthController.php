<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * Register a new client
     */
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:clients',
            'password' => 'required|string|min:8|confirmed',
            'phone' => 'nullable|string|max:255',
            'country' => 'nullable|string|max:255',
            'address' => 'nullable|string',
        ]);

        $client = Client::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'phone' => $validated['phone'] ?? null,
            'country' => $validated['country'] ?? null,
            'address' => $validated['address'] ?? null,
        ]);

        $token = $client->createToken('auth_token')->plainTextToken;

        return response()->json([
            'success' => true,
            'message' => 'Registration successful!',
            'client' => $client,
            'token' => $token,
        ], 201);
    }

    /**
     * Login a client
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $client = Client::where('email', $request->email)->first();

        if (!$client || !Hash::check($request->password, $client->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        $client->tokens()->delete();

        $token = $client->createToken('auth_token')->plainTextToken;

        return response()->json([
            'success' => true,
            'message' => 'Login successful!',
            'client' => $client,
            'token' => $token,
        ]);
    }

    /**
     * Logout a client
     */
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'success' => true,
            'message' => 'Logged out successfully!',
        ]);
    }

    /**
     * Get authenticated client
     */
    public function me(Request $request)
    {
        return response()->json([
            'success' => true,
            'client' => $request->user(),
        ]);
    }

    /**
     * Get client's bookings
     */
    public function myBookings(Request $request)
    {
        $bookings = $request->user()->bookings()->with('package')->latest()->get();

        return response()->json([
            'success' => true,
            'bookings' => $bookings,
        ]);
    }
}
