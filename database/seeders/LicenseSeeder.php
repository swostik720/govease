<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\License;

class LicenseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        License::create([
            'license_number' => 'LIC-001',
            'name' => 'John Doe',
            'vehicle_type' => 'Car',
            'issue_date' => '2022-01-01',
        ]);

        License::create([
            'license_number' => 'LIC-002',
            'name' => 'Jane Smith',
            'vehicle_type' => 'Bike',
            'issue_date' => '2023-06-15',
        ]);
    }
}
