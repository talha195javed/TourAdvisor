<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePackageRequest extends FormRequest
{
    /**
     * Determine if the user is authorized.
     */
    public function authorize(): bool
    {
        // Only allow logged-in users (or admin) to create
        return auth()->check();
    }

    /**
     * Validation rules.
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'visa_price' => 'nullable|numeric|min:0',
            'duration_days' => 'required|integer|min:1',
            'main_image_url' => 'nullable|url',
            'main_image_file' => 'nullable|image|max:2048',
            'features' => 'nullable|array',
            'features.*' => 'string|max:255',
            'category_id' => 'nullable|exists:categories,id',
            'hotel_id' => 'nullable|exists:hotels,id',
            'location' => 'nullable|string|max:255',
            'transfer_type' => 'nullable|in:bus,air,car',
            'departure_airport' => 'nullable|string|max:10',
            'arrival_airport' => 'nullable|string|max:10',
            'is_active' => 'sometimes|boolean',
        ];
    }
}
