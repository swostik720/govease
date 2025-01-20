<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Plus2;
use App\Models\User;

class Plus2Seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::first();

        Plus2::create([
            'symbol_number' => 'SYM-001',
            'name' => 'John Doe',
            'passed_year' => 2020,
            'gpa' => '3.8',
            'college' => 'ABC',
            'user_id' => $user ? $user->id : null,

        ]);

        Plus2::create([
            'symbol_number' => 'SYM-002',
            'name' => 'Jane Smith',
            'passed_year' => 2015,
            'gpa' => '3.5',
            'college' => 'XYZ',
            'user_id' => $user ? $user->id : null,

        ]);
    }
}
