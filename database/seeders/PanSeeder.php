<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Pan;

class PanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        Pan::create([
            'pan_number' => 'PAN-123456',
            'name' => 'John Doe',
            'issue_date' => '2021-03-10',
            'address' => '123 Main Street',
        ]);

        Pan::create([
            'pan_number' => 'PAN-789012',
            'name' => 'Jane Smith',
            'issue_date' => '2020-12-25',
            'address' => '456 Elm Street',
        ]);
    }
}
