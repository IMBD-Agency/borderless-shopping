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
            'email' => 'info@borderlessgroup.com.au',
            'phone' => '+61451807841',
            'whatsapp' => '+61451807841',
            'youtube_tutorial' => 'https://www.youtube.com/watch?v=2iIOEH_tbMU',
        ]);
    }
}
