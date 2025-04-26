<?php

namespace Database\Seeders;

use App\Models\Clinic;
use App\Models\GP;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class GPSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('ms_MY');

        // Malaysian qualifications for GPs
        $qualifications = [
            'MBBS (UM), FRACGP',
            'MD (UKM), MMed (Family Medicine)',
            'MBBS (IMU), MRCGP (UK)',
            'MD (USM), Dip. Family Medicine',
            'MBBS (Manipal), FRACGP',
            'MBBS (UM), MMed (Primary Care)',
            'MD (AIMST), MRCGP (INT)',
            'MBBS (Monash), FRACGP',
            'MBBS (Newcastle), FRACGP',
            'MD (IMU), MMed (Family Medicine)',
        ];

        // Malaysian/common languages
        $languages = ['English', 'Malay', 'Mandarin', 'Tamil', 'Hindi', 'Cantonese', 'Hokkien', 'Teochew', 'Hakka', 'Iban', 'Kadazan'];

        // Get all clinics
        $clinics = Clinic::all();

        // Delete existing GPs
        GP::query()->delete();

        // Create 2 GPs for each clinic
        foreach ($clinics as $clinic) {
            // Determine genders to ensure at least one male and one female per clinic
            $genders = ['male', 'female'];
            
            for ($i = 0; $i < 2; $i++) {
                // Generate a Malaysian-style name based on gender
                if ($genders[$i] === 'male') {
                    $name = 'Dr. ' . $faker->firstNameMale . ' ' . $faker->lastName;
                } else {
                    $name = 'Dr. ' . $faker->firstNameFemale . ' ' . $faker->lastName;
                }
                
                // Randomly select 2-3 languages
                $gpLanguages = $faker->randomElements(
                    $languages, 
                    $faker->numberBetween(2, 3)
                );
                
                // Simplified email (as requested)
                $email = strtolower(explode(' ', $name)[1]) . '@gmail.com';
                
                // Create GP
                GP::create([
                    'name' => $name,
                    'clinic_id' => $clinic->id,
                    'qualifications' => $faker->randomElement($qualifications),
                    'years_experience' => $faker->numberBetween(2, 25),
                    'email' => $email,
                    'password' => '88888888',
                    'phone' => '01' . $faker->numberBetween(0, 9) . '-' . $faker->numberBetween(1000000, 9999999),
                    'gender' => $genders[$i],
                    'languages' => $gpLanguages,
                    'is_active' => true,
                ]);
            }
        }
    }
} 