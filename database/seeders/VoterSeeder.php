<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Voter;
use App\Models\User;
use Illuminate\Support\Str;

class VoterSeeder extends Seeder
{
    public function run()
    {
        $user = User::first();

        Voter::create([
            'voter_number' => 'VOT-001',
            'name' => 'John Doe',
            'dob' => '2002-01-01',
            'issue_date' => '2019-08-15',
            'address' => '123 Main Street',
            'user_id' => $user ? $user->id : null,
        ]);

        Voter::create([
            'voter_number' => 'VOT-002',
            'name' => 'Jane Smith',
            'dob' => '2002-01-01',
            'issue_date' => '2020-01-01',
            'address' => '456 Elm Street',
            'user_id' => $user ? $user->id : null,
        ]);
    }
}
