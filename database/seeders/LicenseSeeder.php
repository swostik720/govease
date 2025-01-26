<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\License;
use App\Models\User;

class LicenseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::first();

        License::create([
            'license_number' => 'LIC-001',
            'name' => 'John Doe',
            'dob' => '2002-01-01',
            'vehicle_type' => 'Car',
            'issue_date' => '2022-01-01',
            'user_id' => $user ? $user->id : null,

        ]);

        License::create([
            'license_number' => 'LIC-002',
            'name' => 'Jane Smith',
            'dob' => '2002-01-01',
            'vehicle_type' => 'Bike',
            'issue_date' => '2023-06-15',
            'user_id' => $user ? $user->id : null,

        ]);
    }
}
