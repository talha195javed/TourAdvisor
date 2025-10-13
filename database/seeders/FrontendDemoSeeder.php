<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Hotel;
use App\Models\Package;

class FrontendDemoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Categories
        $categories = [
            ['name' => 'Beach & Coastal', 'slug' => 'beach-coastal', 'is_active' => true],
            ['name' => 'Mountain & Adventure', 'slug' => 'mountain-adventure', 'is_active' => true],
            ['name' => 'City Tours', 'slug' => 'city-tours', 'is_active' => true],
            ['name' => 'Cultural Heritage', 'slug' => 'cultural-heritage', 'is_active' => true],
            ['name' => 'Luxury Escapes', 'slug' => 'luxury-escapes', 'is_active' => true],
        ];

        foreach ($categories as $category) {
            Category::firstOrCreate(['slug' => $category['slug']], $category);
        }

        // Create Hotels
        $hotels = [
            [
                'name' => 'Grand Seaside Resort',
                'location' => 'Dubai, UAE',
                'description' => 'Luxury beachfront resort with world-class amenities',
                'star_rating' => 5,
                'is_active' => true,
                'amenities' => ['Pool', 'Spa', 'Restaurant', 'Beach Access'],
            ],
            [
                'name' => 'Mountain View Lodge',
                'location' => 'Swiss Alps',
                'description' => 'Cozy mountain retreat with stunning views',
                'star_rating' => 4,
                'is_active' => true,
                'amenities' => ['Ski Access', 'Restaurant', 'Fireplace', 'Spa'],
            ],
            [
                'name' => 'City Center Hotel',
                'location' => 'Paris, France',
                'description' => 'Modern hotel in the heart of the city',
                'star_rating' => 4,
                'is_active' => true,
                'amenities' => ['WiFi', 'Restaurant', 'Bar', 'Gym'],
            ],
        ];

        foreach ($hotels as $hotel) {
            Hotel::firstOrCreate(['name' => $hotel['name']], $hotel);
        }

        // Create Sample Packages
        $packages = [
            [
                'title' => 'Dubai Beach Paradise - 7 Days',
                'description' => 'Experience the luxury of Dubai with pristine beaches, world-class shopping, and unforgettable desert safaris. Includes 5-star accommodation and daily breakfast.',
                'price' => 1299.99,
                'duration_days' => 7,
                'main_image' => 'https://images.unsplash.com/photo-1512453979798-5ea266f8880c?w=800',
                'features' => ['5-Star Hotel', 'Daily Breakfast', 'Desert Safari', 'City Tour', 'Airport Transfer'],
                'category_id' => Category::where('slug', 'beach-coastal')->first()->id,
                'hotel_id' => Hotel::where('name', 'Grand Seaside Resort')->first()->id,
                'location' => 'Dubai, UAE',
                'transfer_type' => 'Air',
                'is_active' => true,
            ],
            [
                'title' => 'Swiss Alps Adventure - 5 Days',
                'description' => 'Discover the breathtaking beauty of the Swiss Alps with guided mountain tours, skiing, and cozy alpine lodges. Perfect for adventure seekers.',
                'price' => 1599.99,
                'duration_days' => 5,
                'main_image' => 'https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=800',
                'features' => ['Mountain Lodge', 'Ski Pass', 'Guided Tours', 'Equipment Rental', 'Meals Included'],
                'category_id' => Category::where('slug', 'mountain-adventure')->first()->id,
                'hotel_id' => Hotel::where('name', 'Mountain View Lodge')->first()->id,
                'location' => 'Swiss Alps, Switzerland',
                'transfer_type' => 'Air',
                'is_active' => true,
            ],
            [
                'title' => 'Paris City Explorer - 4 Days',
                'description' => 'Immerse yourself in the romance and culture of Paris. Visit iconic landmarks, enjoy French cuisine, and experience the city of lights.',
                'price' => 899.99,
                'duration_days' => 4,
                'main_image' => 'https://images.unsplash.com/photo-1502602898657-3e91760cbb34?w=800',
                'features' => ['4-Star Hotel', 'City Pass', 'Museum Tickets', 'Seine River Cruise', 'Welcome Dinner'],
                'category_id' => Category::where('slug', 'city-tours')->first()->id,
                'hotel_id' => Hotel::where('name', 'City Center Hotel')->first()->id,
                'location' => 'Paris, France',
                'transfer_type' => 'Air',
                'is_active' => true,
            ],
            [
                'title' => 'Maldives Luxury Escape - 6 Days',
                'description' => 'Relax in paradise with overwater villas, crystal-clear waters, and world-class diving. The ultimate tropical getaway.',
                'price' => 2499.99,
                'duration_days' => 6,
                'main_image' => 'https://images.unsplash.com/photo-1514282401047-d79a71a590e8?w=800',
                'features' => ['Overwater Villa', 'All-Inclusive', 'Diving & Snorkeling', 'Spa Access', 'Private Beach'],
                'category_id' => Category::where('slug', 'luxury-escapes')->first()->id,
                'location' => 'Maldives',
                'transfer_type' => 'Air',
                'is_active' => true,
            ],
            [
                'title' => 'Ancient Rome & Florence - 8 Days',
                'description' => 'Journey through Italian history with guided tours of Rome\'s ancient ruins and Florence\'s Renaissance art. Includes authentic Italian dining experiences.',
                'price' => 1799.99,
                'duration_days' => 8,
                'main_image' => 'https://images.unsplash.com/photo-1552832230-c0197dd311b5?w=800',
                'features' => ['Historic Hotels', 'Guided Tours', 'Museum Access', 'Cooking Class', 'Wine Tasting'],
                'category_id' => Category::where('slug', 'cultural-heritage')->first()->id,
                'location' => 'Rome & Florence, Italy',
                'transfer_type' => 'Air',
                'is_active' => true,
            ],
            [
                'title' => 'Bali Island Retreat - 7 Days',
                'description' => 'Find your zen in Bali with yoga retreats, temple visits, and stunning rice terraces. Experience authentic Balinese culture and hospitality.',
                'price' => 1099.99,
                'duration_days' => 7,
                'main_image' => 'https://images.unsplash.com/photo-1537996194471-e657df975ab4?w=800',
                'features' => ['Beach Resort', 'Yoga Classes', 'Temple Tours', 'Spa Treatments', 'Cultural Shows'],
                'category_id' => Category::where('slug', 'beach-coastal')->first()->id,
                'location' => 'Bali, Indonesia',
                'transfer_type' => 'Air',
                'is_active' => true,
            ],
        ];

        foreach ($packages as $package) {
            Package::firstOrCreate(
                ['title' => $package['title']],
                $package
            );
        }

        $this->command->info('Frontend demo data seeded successfully!');
    }
}
