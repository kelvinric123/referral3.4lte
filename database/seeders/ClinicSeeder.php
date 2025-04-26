<?php

namespace Database\Seeders;

use App\Models\Clinic;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class ClinicSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Malaysian cities and states
        $locations = [
            ['Kuala Lumpur', 'Federal Territory', '50000'],
            ['Georgetown', 'Penang', '10000'],
            ['Johor Bahru', 'Johor', '80000'],
            ['Ipoh', 'Perak', '30000'],
            ['Kota Kinabalu', 'Sabah', '88000'],
        ];

        // Operating hours templates
        $operatingHours = [
            'Mon-Fri: 8:00 AM - 6:00 PM, Sat: 8:00 AM - 1:00 PM, Sun: Closed',
            'Mon-Sat: 9:00 AM - 5:00 PM, Sun: 9:00 AM - 12:00 PM',
            'Mon-Fri: 7:30 AM - 7:30 PM, Sat-Sun: 8:00 AM - 2:00 PM',
            'Daily: 8:00 AM - 10:00 PM',
            'Mon-Thu: 8:00 AM - 8:00 PM, Fri: 8:00 AM - 12:30 PM, Sat-Sun: 9:00 AM - 6:00 PM',
        ];

        // Clinic names
        $clinicNames = [
            'HealthFirst Medical Clinic',
            'MediCare Family Clinic',
            'Klinik Kesihatan Perdana',
            'Klinik Dr. Wong & Associates',
            'Pusat Rawatan Familia',
        ];

        Clinic::query()->delete();

        $faker = Faker::create('ms_MY');

        // Create 5 clinics
        for ($i = 0; $i < 5; $i++) {
            Clinic::create([
                'name' => $clinicNames[$i],
                'address' => $faker->streetAddress,
                'city' => $locations[$i][0],
                'state' => $locations[$i][1],
                'postal_code' => $locations[$i][2],
                'phone' => '0' . rand(1, 1) . rand(0, 9) . '-' . rand(1000000, 9999999),
                'email' => strtolower(str_replace(' ', '', explode(' ', $clinicNames[$i])[0])) . '@gmail.com',
                'operating_hours' => $operatingHours[$i],
                'is_active' => true,
            ]);
        }
    }
} 