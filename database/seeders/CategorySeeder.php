<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'General',
                'slug' => 'general',
                'description' => 'Common questions about how BorderlesShopping works.',
                'order' => 0,
                'is_active' => true,
            ],
            [
                'name' => 'Payments & Billing',
                'slug' => 'payments-billing',
                'description' => 'Questions about paying for your order and billing.',
                'order' => 1,
                'is_active' => true,
            ],
        ];

        foreach ($categories as $cat) {
            Category::updateOrCreate(
                ['slug' => $cat['slug']],
                $cat
            );
        }
    }
}
