<?php

namespace Database\Seeders;

use App\Models\Hospital;
use App\Models\Service;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        // Common medical services
        $serviceTemplates = [
            [
                'name' => 'General Health Check-up',
                'description' => 'Comprehensive physical examination including vital signs, blood tests, and health screening.',
                'cost' => 250.00,
                'duration' => '1 hour',
            ],
            [
                'name' => 'Basic Blood Test',
                'description' => 'Standard blood test including complete blood count, cholesterol levels, and glucose levels.',
                'cost' => 100.00,
                'duration' => '30 minutes',
            ],
            [
                'name' => 'X-Ray Imaging',
                'description' => 'Standard X-ray imaging service for skeletal and chest examination.',
                'cost' => 150.00,
                'duration' => '20 minutes',
            ],
            [
                'name' => 'MRI Scan',
                'description' => 'Magnetic Resonance Imaging for detailed internal organ and tissue examination.',
                'cost' => 800.00,
                'duration' => '45 minutes',
            ],
            [
                'name' => 'CT Scan',
                'description' => 'Computed Tomography scan for detailed cross-sectional imaging of bones, blood vessels, and soft tissues.',
                'cost' => 600.00,
                'duration' => '30 minutes',
            ],
            [
                'name' => 'Ultrasound',
                'description' => 'Diagnostic ultrasound service for examining internal organs and blood flow.',
                'cost' => 300.00,
                'duration' => '30 minutes',
            ],
            [
                'name' => 'EKG/ECG',
                'description' => 'Electrocardiogram to check heart rhythm and electrical activity.',
                'cost' => 200.00,
                'duration' => '15 minutes',
            ],
            [
                'name' => 'Physical Therapy Session',
                'description' => 'Therapeutic exercises and treatments to help patients recover from injuries or manage chronic conditions.',
                'cost' => 150.00,
                'duration' => '1 hour',
            ],
            [
                'name' => 'Vaccination',
                'description' => 'Standard vaccination services including flu shots, travel vaccines, and routine immunizations.',
                'cost' => 80.00,
                'duration' => '15 minutes',
            ],
            [
                'name' => 'Dental Cleaning',
                'description' => 'Professional dental cleaning and oral health assessment.',
                'cost' => 120.00,
                'duration' => '30 minutes',
            ],
            [
                'name' => 'Eye Examination',
                'description' => 'Comprehensive eye exam including vision test and eye health assessment.',
                'cost' => 150.00,
                'duration' => '45 minutes',
            ],
            [
                'name' => 'Allergy Testing',
                'description' => 'Testing for common allergies including food, environmental, and seasonal allergens.',
                'cost' => 250.00,
                'duration' => '1 hour',
            ],
            [
                'name' => 'Nutritional Consultation',
                'description' => 'Personalized nutritional assessment and meal planning with a registered dietitian.',
                'cost' => 180.00,
                'duration' => '45 minutes',
            ],
            [
                'name' => 'Mental Health Counseling',
                'description' => 'Professional counseling session with a licensed therapist or psychologist.',
                'cost' => 200.00,
                'duration' => '50 minutes',
            ],
            [
                'name' => 'Hearing Test',
                'description' => 'Comprehensive hearing assessment and evaluation.',
                'cost' => 120.00,
                'duration' => '30 minutes',
            ],
        ];

        // Get all hospitals
        $hospitals = Hospital::all();

        // Delete existing services
        Service::query()->delete();

        // Create 3 services for each hospital
        foreach ($hospitals as $hospital) {
            // Shuffle service templates to randomize which 3 services each hospital gets
            $shuffledTemplates = $faker->randomElements($serviceTemplates, 3);
            
            foreach ($shuffledTemplates as $serviceTemplate) {
                // Add a price variation of +/- 20% to make services slightly different across hospitals
                $costVariation = $serviceTemplate['cost'] * $faker->randomFloat(2, 0.8, 1.2);
                
                Service::create([
                    'name' => $serviceTemplate['name'],
                    'description' => $serviceTemplate['description'],
                    'cost' => round($costVariation, 2),
                    'duration' => $serviceTemplate['duration'],
                    'hospital_id' => $hospital->id,
                    'is_active' => true,
                ]);
            }
        }
    }
} 