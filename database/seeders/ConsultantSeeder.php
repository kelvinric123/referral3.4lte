<?php

namespace Database\Seeders;

use App\Models\Consultant;
use App\Models\Specialty;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;

class ConsultantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        // Languages array
        $languages = ['English', 'Malay', 'Mandarin', 'Tamil', 'Hindi', 'Arabic', 'Japanese', 'Korean', 'French', 'German'];
        
        // Qualifications array
        $qualifications = [
            'MBBS, MD (Internal Medicine)',
            'MBBS, MS (General Surgery)',
            'MBBS, MD (Pediatrics)',
            'MBBS, MS (Orthopedics)',
            'MBBS, MD (Obstetrics & Gynecology)',
            'MBBS, MS (Ophthalmology)',
            'MBBS, MD (Dermatology)',
            'MBBS, DM (Neurology)',
            'MBBS, DM (Cardiology)',
            'MBBS, MCh (Neurosurgery)',
            'MBBS, MCh (Plastic Surgery)',
            'MBBS, MD (Psychiatry)',
            'BDS, MDS (Dental Surgery)',
            'MBBS, MD (Radiology)',
            'MBBS, MD (Anesthesiology)',
        ];

        // Get all specialties
        $specialties = Specialty::with('hospital')->get();

        // Delete existing consultants
        Consultant::truncate();

        // Create 2 consultants for each specialty
        foreach ($specialties as $specialty) {
            // Determine genders to ensure at least one male and one female per specialty
            $genders = ['male', 'female'];
            
            for ($i = 0; $i < 2; $i++) {
                // Randomly select 2-4 languages
                $consultantLanguages = $faker->randomElements(
                    $languages, 
                    $faker->numberBetween(2, 4)
                );
                
                // Create consultant
                Consultant::create([
                    'name' => $faker->name($genders[$i]),
                    'specialty_id' => $specialty->id,
                    'hospital_id' => $specialty->hospital_id,
                    'gender' => $genders[$i],
                    'languages' => $consultantLanguages,
                    'qualifications' => $faker->randomElement($qualifications),
                    'experience' => $faker->numberBetween(5, 30) . ' years',
                    'bio' => $faker->paragraph(3),
                    'email' => $faker->email,
                    'password' => Hash::make('qmed.asia'),
                    'phone' => $faker->phoneNumber,
                    'is_active' => true,
                ]);
            }
        }
    }
} 