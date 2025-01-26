<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Plus2;
use App\Models\User;
use Illuminate\Support\Str;

class Plus2Seeder extends Seeder
{
    public function run()
    {
        $user = User::first();

        Plus2::create([
            'symbol_number' => 'SYM-001',
            'name' => 'John Doe',
            'dob' => '2002-01-01',
            'passed_year' => 2020,
            'gpa' => '3.8',
            'college' => 'ABC',
            'user_id' => $user ? $user->id : null,
        ]);

        Plus2::create([
            'symbol_number' => 'SYM-002',
            'name' => 'Jane Smith',
            'dob' => '2002-01-01',
            'passed_year' => 2015,
            'gpa' => '3.5',
            'college' => 'XYZ',
            'user_id' => $user ? $user->id : null,
        ]);
    }
}
