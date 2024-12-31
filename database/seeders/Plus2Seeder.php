<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Plus2;

class Plus2Seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        Plus2::create([
            'symbol_number' => 'SYM-001',
            'name' => 'John Doe',
            'college' => '2022-06-15',
            'gpa' => '3.8',
        ]);

        Plus2::create([
            'symbol_number' => 'SYM-002',
            'name' => 'Jane Smith',
            'college' => '2021-12-01',
            'gpa' => '3.5',
        ]);
    }
}
