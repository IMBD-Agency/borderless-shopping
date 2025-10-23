<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder {
    /**
     * Run the database seeds.
     */
    public function run(): void {
        // Super Admin
        User::create([
            'name' => 'RH Rony',
            'image' => 'blank-profile.jpg',
            'email' => 'rhrony0009@gmail.com',
            'password' => Hash::make('12345678'),
            'role' => 'super_admin',
        ]);

        User::create([
            'name' => 'Syed Parvez',
            'image' => 'blank-profile.jpg',
            'email' => 'info@borderlessgroup.com.au',
            'password' => Hash::make('12345678'),
            'role' => 'admin',
        ]);
    }
}
