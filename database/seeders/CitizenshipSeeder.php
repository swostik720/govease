<?php

namespace Database\Seeders;

use App\Models\Citizenship;
use App\Models\User;
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
        $user = User::first();
        // dd($user);

        Citizenship::create([
            'number' => 'CIT-123456',
            'name' => 'John Doe',
            'dob' => '2002-01-01',
            'issue_date' => '2020-01-01',
            'address' => '123 Main Street',
            'user_id' => $user ? $user->id : null,
        ]);

        Citizenship::create([
            'number' => 'CIT-789012',
            'name' => 'Jane Smith',
            'dob' => '2002-01-01',
            'issue_date' => '2021-05-15',
            'address' => '456 Elm Street',
            'user_id' => $user ? $user->id : null,
        ]);
    }
}
