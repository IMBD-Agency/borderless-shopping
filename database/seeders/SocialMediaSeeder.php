<?php

namespace Database\Seeders;

use App\Models\SocialMedia;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SocialMediaSeeder extends Seeder {
    /**
     * Run the database seeds.
     */
    public function run(): void {
        $socialMedia = [
            [
                'name' => 'Facebook',
                'url' => 'https://www.facebook.com/borderlesshopping.com.au',
                'icon' => 'fab fa-facebook',
            ],
            [
                'name' => 'Instagram',
                'url' => 'https://www.instagram.com/borderlesshopping',
                'icon' => 'fab fa-instagram',
            ],
            [
                'name' => 'Pinterest',
                'url' => 'https://www.pinterest.com/borderlesshopping',
                'icon' => 'fab fa-pinterest',
            ]
        ];

        foreach ($socialMedia as $media) {
            SocialMedia::create($media);
        }
    }
}
