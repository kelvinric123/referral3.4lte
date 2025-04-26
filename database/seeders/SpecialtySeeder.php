<?php

namespace Database\Seeders;

use App\Models\Hospital;
use App\Models\Specialty;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SpecialtySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all hospitals (or first if none)
        $hospitals = Hospital::all();
        if ($hospitals->isEmpty()) {
            // Create a default hospital if none exists
            $hospital = Hospital::create([
                'name' => 'Kuala Lumpur General Hospital',
                'address' => 'Jalan Pahang',
                'city' => 'Kuala Lumpur',
                'state' => 'Federal Territory',
                'country' => 'Malaysia',
                'postal_code' => '50586',
                'phone' => '03-26155555',
                'email' => 'info@hkl.gov.my',
                'website' => 'https://hkl.gov.my',
                'is_active' => true,
            ]);
            $hospitals = collect([$hospital]);
        }

        // English specialty list
        $specialties = [
            [
                'name' => 'Cardiology',
                'description' => 'Specializes in heart and blood vessel disorders including heart attacks, high blood pressure, and heart failure.',
            ],
            [
                'name' => 'Orthopedics',
                'description' => 'Specializes in bones, joints, and muscles. Treats fractures, joint problems, and ligament injuries.',
            ],
            [
                'name' => 'Neurology',
                'description' => 'Specializes in the nervous system. Treats conditions like strokes, epilepsy, and migraines.',
            ],
            [
                'name' => 'Pediatrics',
                'description' => 'Specializes in child health care. Treats health issues involving infants, children, and adolescents.',
            ],
            [
                'name' => 'Obstetrics & Gynecology',
                'description' => 'Specializes in women\'s health and pregnancy. Manages pregnancy, childbirth, and female reproductive health issues.',
            ],
            [
                'name' => 'Ophthalmology',
                'description' => 'Specializes in eye care. Treats vision problems and eye diseases such as cataracts and glaucoma.',
            ],
            [
                'name' => 'Dermatology',
                'description' => 'Specializes in skin conditions. Treats issues like eczema, psoriasis, and skin cancer.',
            ],
            [
                'name' => 'Nephrology',
                'description' => 'Specializes in kidney care. Treats kidney disorders such as kidney failure and infections.',
            ],
            [
                'name' => 'Gastroenterology',
                'description' => 'Specializes in the digestive system. Treats conditions like liver disease, stomach ulcers, and irritable bowel syndrome.',
            ],
            [
                'name' => 'Endocrinology',
                'description' => 'Specializes in hormones and glands. Treats conditions like diabetes, thyroid disorders, and hormone imbalances.',
            ],
            [
                'name' => 'Pulmonology',
                'description' => 'Specializes in lung and respiratory disorders. Treats conditions such as asthma, COPD, and sleep apnea.',
            ],
            [
                'name' => 'Urology',
                'description' => 'Specializes in the urinary tract and male reproductive system. Treats urinary tract infections, kidney stones, and prostate issues.',
            ],
            [
                'name' => 'Psychiatry',
                'description' => 'Specializes in mental health. Treats conditions like depression, anxiety, bipolar disorder, and schizophrenia.',
            ],
            [
                'name' => 'Hematology',
                'description' => 'Specializes in blood disorders. Treats conditions like anemia, leukemia, lymphoma, and blood clotting disorders.',
            ],
            [
                'name' => 'Oncology',
                'description' => 'Specializes in cancer diagnosis and treatment. Provides chemotherapy, radiation therapy, and surgical options for cancer patients.',
            ],
        ];

        // Delete existing specialties
        // Specialty::truncate();
        Specialty::query()->delete();
        
        // Assign 5 specialties to each hospital
        foreach ($hospitals as $index => $hospital) {
            // Calculate start index based on hospital index (wrapping around if needed)
            $startIndex = ($index * 5) % count($specialties);
            
            // Assign 5 consecutive specialties to this hospital
            for ($i = 0; $i < 5; $i++) {
                $specialtyIndex = ($startIndex + $i) % count($specialties);
                
                Specialty::create([
                    'name' => $specialties[$specialtyIndex]['name'],
                    'description' => $specialties[$specialtyIndex]['description'],
                    'hospital_id' => $hospital->id,
                    'is_active' => true,
                ]);
            }
        }
    }
} 