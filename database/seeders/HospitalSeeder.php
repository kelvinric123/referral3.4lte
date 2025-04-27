<?php

namespace Database\Seeders;

use App\Models\Hospital;
use Illuminate\Database\Seeder;

class HospitalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $hospitals = [
            [
                'name' => 'Hospital Kuala Lumpur',
                'address' => 'Jalan Pahang',
                'city' => 'Kuala Lumpur',
                'state' => 'Wilayah Persekutuan',
                'country' => 'Malaysia',
                'postal_code' => '50586',
                'phone' => '+60 3-2615 5555',
                'email' => 'info@hkl.moh.gov.my',
                'password' => 'qmed.asia',
                'website' => 'https://hkl.moh.gov.my',
                'is_active' => true,
            ],
            [
                'name' => 'Hospital Pulau Pinang',
                'address' => 'Jalan Residensi',
                'city' => 'Georgetown',
                'state' => 'Pulau Pinang',
                'country' => 'Malaysia',
                'postal_code' => '10990',
                'phone' => '+60 4-222 5333',
                'email' => 'info@hpp.moh.gov.my',
                'password' => 'qmed.asia',
                'website' => 'https://hpp.moh.gov.my',
                'is_active' => true,
            ],
            [
                'name' => 'Gleneagles Hospital Kuala Lumpur',
                'address' => '286, Jalan Ampang',
                'city' => 'Kuala Lumpur',
                'state' => 'Wilayah Persekutuan',
                'country' => 'Malaysia',
                'postal_code' => '50450',
                'phone' => '+60 3-4141 3000',
                'email' => 'contact@gleneagles.com.my',
                'password' => 'qmed.asia',
                'website' => 'https://www.gleneagles.com.my',
                'is_active' => true,
            ],
            [
                'name' => 'Sunway Medical Centre',
                'address' => '5, Jalan Lagoon Selatan, Bandar Sunway',
                'city' => 'Petaling Jaya',
                'state' => 'Selangor',
                'country' => 'Malaysia',
                'postal_code' => '47500',
                'phone' => '+60 3-7491 9191',
                'email' => 'info@sunwaymedical.com',
                'password' => 'qmed.asia',
                'website' => 'https://www.sunwaymedical.com',
                'is_active' => true,
            ],
            [
                'name' => 'Hospital Sultanah Aminah',
                'address' => 'Jalan Persiaran Abu Bakar Sultan',
                'city' => 'Johor Bahru',
                'state' => 'Johor',
                'country' => 'Malaysia',
                'postal_code' => '80100',
                'phone' => '+60 7-223 1666',
                'email' => 'info@hsa.moh.gov.my',
                'password' => 'qmed.asia',
                'website' => 'https://hsa.moh.gov.my',
                'is_active' => true,
            ],
        ];

        foreach ($hospitals as $hospital) {
            Hospital::create($hospital);
        }
    }
}
