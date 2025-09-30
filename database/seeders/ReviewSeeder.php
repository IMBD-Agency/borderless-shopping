<?php

namespace Database\Seeders;

use App\Models\Review;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ReviewSeeder extends Seeder {
    /**
     * Run the database seeds.
     */
    public function run(): void {
        $reviews = [
            [
                'name' => 'Ahmed Rahman',
                'location' => 'Dhaka, Bangladesh',
                'comment' => 'Amazing service! Got my iPhone delivered from Australia within 2 weeks. The process was so simple and transparent.'
            ],
            [
                'name' => 'Fatima Khan',
                'location' => 'Chittagong, Bangladesh',
                'comment' => 'Finally found a reliable way to shop from Australian stores. The customer support is excellent and pricing is very fair.'
            ],
            [
                'name' => 'Mohammad Ali',
                'location' => 'Sylhet, Bangladesh',
                'comment' => 'I\'ve used this service multiple times. Always professional, fast, and my packages arrive in perfect condition.'
            ]
        ];
        foreach ($reviews as $review) {
            Review::create($review);
        }
    }
}
