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
                'url' => 'https://www.facebook.com/BorderlesShopping',
                'icon' => 'fab fa-facebook',
            ],
            [
                'name' => 'Twitter',
                'url' => 'https://www.twitter.com/BorderlesShopping',
                'icon' => 'fab fa-twitter',
            ],
            [
                'name' => 'Instagram',
                'url' => 'https://www.instagram.com/BorderlesShopping',
                'icon' => 'fab fa-instagram',
            ],
            [
                'name' => 'LinkedIn',
                'url' => 'https://www.linkedin.com/BorderlesShopping',
                'icon' => 'fab fa-linkedin',
            ],
        ];

        foreach ($socialMedia as $media) {
            SocialMedia::create($media);
        }
    }
}
