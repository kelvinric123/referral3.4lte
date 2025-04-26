<?php

namespace Database\Seeders;

use App\Models\Company;
use Illuminate\Database\Seeder;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $companies = [
            [
                'name' => 'Global Medical Travel',
                'address' => '123 Main St',
                'city' => 'Kuala Lumpur',
                'state' => 'Federal Territory',
                'postal_code' => '50450',
                'country' => 'Malaysia',
                'phone' => '+60123456789',
                'email' => 'info@globalmedtravel.com',
                'website' => 'https://globalmedtravel.com',
                'is_active' => true,
            ],
            [
                'name' => 'Asian Health Connect',
                'address' => '456 Jalan Bukit Bintang',
                'city' => 'Kuala Lumpur',
                'state' => 'Federal Territory',
                'postal_code' => '55100',
                'country' => 'Malaysia',
                'phone' => '+60198765432',
                'email' => 'contact@asianhealthconnect.com',
                'website' => 'https://asianhealthconnect.com',
                'is_active' => true,
            ],
            [
                'name' => 'MediTour Solutions',
                'address' => '789 Jalan Ampang',
                'city' => 'Kuala Lumpur',
                'state' => 'Federal Territory',
                'postal_code' => '50450',
                'country' => 'Malaysia',
                'phone' => '+60145678901',
                'email' => 'hello@meditour.com',
                'website' => 'https://meditour.com',
                'is_active' => true,
            ],
        ];

        foreach ($companies as $company) {
            Company::create($company);
        }
    }
} 