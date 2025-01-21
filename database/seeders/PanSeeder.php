<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Pan;
use App\Models\User;
use Illuminate\Support\Str;

class PanSeeder extends Seeder
{
    public function run()
    {
        $user = User::first();

        Pan::create([
            'pan_number' => 'PAN-123456',
            'name' => 'John Doe',
            'issue_date' => '2021-03-10',
            'address' => '123 Main Street',
            'user_id' => $user ? $user->id : null,
            'token' => Str::random(60),
        ]);

        Pan::create([
            'pan_number' => 'PAN-789012',
            'name' => 'Jane Smith',
            'issue_date' => '2020-12-25',
            'address' => '456 Elm Street',
            'user_id' => $user ? $user->id : null,
            'token' => Str::random(60),
        ]);
    }
}
