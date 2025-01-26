<?php

namespace Database\Seeders;

use App\Models\BirthCertificate;
use App\Models\User;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class BirthcertificateSeeder extends Seeder
{

    function convertNepaliToGregorian($nepaliDate)
    {
        // Simulate conversion (replace this logic with a library for actual Nepali to Gregorian conversion)
        $mapping = [
            '२०७६-१०-०१' => '2019-12-16',
            '२०७६-०२-१५' => '2019-05-29',
        ];

        return $mapping[$nepaliDate] ?? null;
    }

    public function run()
    {
        $user = User::first();

        BirthCertificate::create([
            'name' => 'जोन डो',
            'birthcertificate_number' => 'बीसी१२३४५६७८९',
            'issue_date' => '2019-12-16', // Standard format
            'address' => '१२३ मेन स्ट्रीट, स्प्रिंगफिल्ड',
            'father_name' => 'रबर्ट डो',
            'mother_name' => 'एमिली डो',
            'user_id' => $user ? $user->id : null,
            'birth_date_in_words' => 'दुई हजार बीस सालको पुस महिनाको एक गते',
            'birth_date_in_digits' => '2019-05-29', // Converted to Gregorian date
            'birth_time' => '10:30 AM',
            'gender' => 'पुरुष',
            'religion' => 'हिन्दु',
            'caste' => 'क्षत्रीय',
            'registrar_name' => 'कृष्ण अधिकारी',
            'registration_date' => '2019-05-29', // Standard format
            'remarks' => 'यो प्रमाण पत्र कुनै पनि सरकारी प्रयोजनका लागि मान्य छ।',
        ]);

        BirthCertificate::create([
            'name' => 'जेन स्मिथ',
            'birthcertificate_number' => 'बीसी९८७६५४३२१',
            'issue_date' => '2019-12-16', // Standard format
            'address' => '४५६ एल्म स्ट्रीट, मेट्रोपोलिस',
            'father_name' => 'माइकल स्मिथ',
            'mother_name' => 'सोफिया स्मिथ',
            'user_id' => $user ? $user->id : null,
            'birth_date_in_words' => 'दुई हजार उन्नाइस सालको जेठ महिनाको पन्ध्र गते',
            'birth_date_in_digits' => '2019-05-29', // Converted to Gregorian date
            'birth_time' => '03:45 PM',
            'gender' => 'महिला',
            'religion' => 'ईसाई',
            'caste' => 'ब्राह्मण',
            'registrar_name' => 'रामचन्द्र पौडेल',
            'registration_date' => '2019-05-29', // Standard format
            'remarks' => 'यस प्रमाण पत्रलाई प्रमाणका रूपमा प्रयोग गर्न सकिन्छ।',
        ]);
    }
}
