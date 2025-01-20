<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use App\Models\Voter;

class VoterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::first();

        Voter::create([
            'voter_number' => 'VOT-001',
            'name' => 'John Doe',
            'issue_date' => '2019-08-15',
            'address' => '123 Main Street',
            'user_id' => $user ? $user->id : null,

        ]);

        Voter::create([
            'voter_number' => 'VOT-002',
            'name' => 'Jane Smith',
            'issue_date' => '2020-01-01',
            'address' => '456 Elm Street',
            'user_id' => $user ? $user->id : null,

        ]);
    }
}
