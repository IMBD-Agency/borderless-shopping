<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class DistrictsAndSubCitiesSeeder extends Seeder {
    /**
     * Run the database seeds.
     */
    public function run(): void {
        // Clear existing data
        DB::table('sub_cities')->delete();
        DB::table('districts')->delete();

        // Read the JSON file
        $jsonPath = public_path('bangladesh-districts.json');

        if (!File::exists($jsonPath)) {
            $this->command->error('JSON file not found at: ' . $jsonPath);
            return;
        }

        $jsonData = File::get($jsonPath);
        $data = json_decode($jsonData, true);

        if (!$data || !isset($data['bangladesh']['divisions'])) {
            $this->command->error('Invalid JSON structure');
            return;
        }

        $this->command->info('Starting to seed districts and sub-cities...');

        $totalDistricts = 0;
        $totalSubCities = 0;

        // Process each division
        foreach ($data['bangladesh']['divisions'] as $division) {
            $this->command->info("Processing division: {$division['name']}");

            // Process each district in the division
            foreach ($division['districts'] as $districtData) {
                $districtName = $districtData['name'];

                // Insert district
                $districtId = DB::table('districts')->insertGetId([
                    'name' => $districtName,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                $totalDistricts++;
                $this->command->info("  - Inserted district: {$districtName} (ID: {$districtId})");

                // Insert sub-cities for this district
                if (isset($districtData['sub_cities']) && is_array($districtData['sub_cities'])) {
                    $subCitiesData = [];

                    foreach ($districtData['sub_cities'] as $subCityName) {
                        $subCitiesData[] = [
                            'name' => $subCityName,
                            'district_id' => $districtId,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ];
                        $totalSubCities++;
                    }

                    // Batch insert sub-cities for better performance
                    if (!empty($subCitiesData)) {
                        DB::table('sub_cities')->insert($subCitiesData);
                        $this->command->info("    - Inserted " . count($subCitiesData) . " sub-cities for {$districtName}");
                    }
                }
            }
        }

        $this->command->info("Seeding completed!");
        $this->command->info("Total districts inserted: {$totalDistricts}");
        $this->command->info("Total sub-cities inserted: {$totalSubCities}");
    }
}
