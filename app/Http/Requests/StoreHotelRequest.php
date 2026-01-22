<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreHotelRequest extends FormRequest
{
    /**
     * Determine if the user is authorized.
     */
    public function authorize(): bool
    {
        return auth()->check();
    }

    /**
     * Validation rules.
     */
    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'location' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'image_file' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:55120', // 55MB
            'image_url' => 'nullable|url|max:500',
            'star_rating' => 'nullable|integer|between:1,5',
            'contact_email' => 'nullable|email|max:255',
            'is_active' => 'boolean',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Hotel name is required',
            'name.max' => 'Hotel name cannot exceed 255 characters',
            'image_file.image' => 'The uploaded file must be an image',
            'image_file.mimes' => 'Image must be a JPEG, PNG, JPG, or GIF',
            'image_file.max' => 'Image size cannot exceed 5MB',
            'image_url.url' => 'Please enter a valid image URL',
            'star_rating.between' => 'Star rating must be between 1 and 5',
            'contact_email.email' => 'Please enter a valid email address',
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if (!$this->isMethod('PUT') && !$this->isMethod('PATCH')) {
                if (!$this->hasFile('image_file') && empty($this->image_url)) {
                    $validator->errors()->add(
                        'image_file',
                        'Please either upload an image or provide an image URL.'
                    );
                }
            }
        });
    }
}
