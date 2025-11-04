<?php

namespace Database\Seeders;

use App\Models\Contact;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ContactSeeder extends Seeder {
    /**
     * Run the database seeds.
     */
    public function run(): void {
        Contact::create([
            'email' => 'info@BorderlesShopping.com',
            'phone' => '+8801717171717',
            'whatsapp' => '+8801717171717',
            'youtube_tutorial' => 'https://youtu.be/B7r64l2YGxQ',
        ]);
    }
}
