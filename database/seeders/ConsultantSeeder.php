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

        // Professional bio templates in English
        $bioTemplates = [
            'Dr. {name} is a dedicated healthcare professional with extensive experience in {specialty}. Committed to providing exceptional patient care and staying current with the latest medical advancements. Known for compassionate treatment and excellent clinical outcomes.',
            'With {years} years of experience in {specialty}, Dr. {name} brings a wealth of knowledge and expertise to patient care. Dedicated to evidence-based medicine and personalized treatment approaches for optimal patient outcomes.',
            'Dr. {name} is a highly skilled {specialty} specialist with a passion for delivering comprehensive healthcare. Focuses on patient-centered care and maintains strong relationships with patients and their families throughout the treatment process.',
            'As an experienced {specialty} practitioner, Dr. {name} combines clinical excellence with compassionate care. Committed to continuous professional development and implementing innovative treatment methodologies.',
            'Dr. {name} has established a reputation for excellence in {specialty} care. With a focus on preventive medicine and early intervention, provides comprehensive healthcare solutions tailored to individual patient needs.'
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

                // Generate years of experience
                $yearsExperience = $faker->numberBetween(5, 30);
                
                // Generate professional bio in English
                $bioTemplate = $faker->randomElement($bioTemplates);
                $consultantName = $faker->name($genders[$i]);
                $bio = str_replace(
                    ['{name}', '{years}', '{specialty}'],
                    [explode(' ', $consultantName)[1] ?? $consultantName, $yearsExperience, $specialty->name],
                    $bioTemplate
                );

                // Create consultant
                Consultant::create([
                    'name' => $consultantName,
                    'specialty_id' => $specialty->id,
                    'hospital_id' => $specialty->hospital_id,
                    'gender' => $genders[$i],
                    'languages' => $consultantLanguages,
                    'qualifications' => $faker->randomElement($qualifications),
                    'experience' => $yearsExperience . ' years',
                    'bio' => $bio,
                    'email' => $faker->email,
                    'password' => Hash::make('qmed.asia'),
                    'phone' => $faker->phoneNumber,
                    'is_active' => true,
                ]);
            }
        }
    }
} 