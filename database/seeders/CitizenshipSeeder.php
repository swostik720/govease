<?php

namespace Database\Seeders;

use App\Models\Citizenship;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;


class CitizenshipSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Citizenship::create([
            'number' => 'CIT-123456',
            'name' => 'John Doe',
            'issue_date' => '2020-01-01',
            'address' => '123 Main Street',
        ]);

        Citizenship::create([
            'number' => 'CIT-789012',
            'name' => 'Jane Smith',
            'issue_date' => '2021-05-15',
            'address' => '456 Elm Street',
        ]);
    }
}
