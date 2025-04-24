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
                'name' => 'City General Hospital',
                'address' => '123 Main Street',
                'city' => 'New York',
                'state' => 'NY',
                'country' => 'USA',
                'postal_code' => '10001',
                'phone' => '+1 212-555-1234',
                'email' => 'info@citygeneral.com',
                'website' => 'https://citygeneral.com',
                'is_active' => true,
            ],
            [
                'name' => 'Central Medical Center',
                'address' => '456 Park Avenue',
                'city' => 'Chicago',
                'state' => 'IL',
                'country' => 'USA',
                'postal_code' => '60601',
                'phone' => '+1 312-555-6789',
                'email' => 'contact@centralmedical.com',
                'website' => 'https://centralmedical.com',
                'is_active' => true,
            ],
            [
                'name' => 'Riverside Hospital',
                'address' => '789 River Road',
                'city' => 'Los Angeles',
                'state' => 'CA',
                'country' => 'USA',
                'postal_code' => '90001',
                'phone' => '+1 323-555-9876',
                'email' => 'info@riversidehospital.org',
                'website' => 'https://riversidehospital.org',
                'is_active' => true,
            ],
            [
                'name' => 'Memorial Healthcare',
                'address' => '321 Oak Street',
                'city' => 'Houston',
                'state' => 'TX',
                'country' => 'USA',
                'postal_code' => '77001',
                'phone' => '+1 713-555-4321',
                'email' => 'contact@memorialhealthcare.com',
                'website' => 'https://memorialhealthcare.com',
                'is_active' => true,
            ],
            [
                'name' => 'Community Medical Center',
                'address' => '654 Pine Avenue',
                'city' => 'Miami',
                'state' => 'FL',
                'country' => 'USA',
                'postal_code' => '33101',
                'phone' => '+1 305-555-8765',
                'email' => 'info@communitymedical.org',
                'website' => 'https://communitymedical.org',
                'is_active' => true,
            ],
        ];

        foreach ($hospitals as $hospital) {
            Hospital::create($hospital);
        }
    }
}
