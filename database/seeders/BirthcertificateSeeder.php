<?php

namespace Database\Seeders;

use App\Models\BirthCertificate;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class BirthcertificateSeeder extends Seeder
{
    public function run()
    {
        $user = User::first();

        BirthCertificate::create([
            'name' => 'John Doe',
            'birthcertificate_number' => 'BC123456789',
            'issue_date' => '2020-01-01',
            'address' => '123 Main Street, Springfield',
            'father_name' => 'Robert Doe',
            'mother_name' => 'Emily Doe',
            'user_id' => $user ? $user->id : null,
            'token' => Str::random(60),
        ]);

        BirthCertificate::create([
            'name' => 'Jane Smith',
            'birthcertificate_number' => 'BC987654321',
            'issue_date' => '2019-05-15',
            'address' => '456 Elm Street, Metropolis',
            'father_name' => 'Michael Smith',
            'mother_name' => 'Sophia Smith',
            'user_id' => $user ? $user->id : null,
            'token' => Str::random(60),
        ]);
    }
}
