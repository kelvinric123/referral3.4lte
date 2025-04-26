<?php

namespace Database\Seeders;

use App\Models\LoyaltyPointSetting;
use Illuminate\Database\Seeder;

class LoyaltyPointSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Default statuses
        $statuses = ['Pending', 'Approved', 'Rejected', 'No Show', 'Completed'];
        
        // GP point values
        $gpPointValues = [
            'Pending' => 10,
            'Approved' => 20,
            'Rejected' => 0,
            'No Show' => 0,
            'Completed' => 50,
        ];
        
        // Booking Agent point values
        $baPointValues = [
            'Pending' => 5,
            'Approved' => 10,
            'Rejected' => 0,
            'No Show' => 0,
            'Completed' => 25,
        ];
        
        // Create GP settings
        foreach ($statuses as $status) {
            LoyaltyPointSetting::create([
                'entity_type' => 'GP',
                'referral_status' => $status,
                'points' => $gpPointValues[$status],
                'description' => "Points for GP when referral is {$status}",
                'is_active' => true,
            ]);
        }
        
        // Create Booking Agent settings
        foreach ($statuses as $status) {
            LoyaltyPointSetting::create([
                'entity_type' => 'Booking Agent',
                'referral_status' => $status,
                'points' => $baPointValues[$status],
                'description' => "Points for Booking Agent when referral is {$status}",
                'is_active' => true,
            ]);
        }
    }
} 