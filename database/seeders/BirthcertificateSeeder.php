<?php

namespace Database\Seeders;

use App\Models\BirthCertificate;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BirthcertificateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        BirthCertificate::create([
            'name' => 'John Doe',
            'birthcertificate_number' => 'BC123456789',
            'issue_date' => '2020-01-01',
            'address' => '123 Main Street, Springfield',
            'father_name' => 'Robert Doe',
            'mother_name' => 'Emily Doe',
        ]);

        BirthCertificate::create([
            'name' => 'Jane Smith',
            'birthcertificate_number' => 'BC987654321',
            'issue_date' => '2019-05-15',
            'address' => '456 Elm Street, Metropolis',
            'father_name' => 'Michael Smith',
            'mother_name' => 'Sophia Smith',
        ]);
    }
}
