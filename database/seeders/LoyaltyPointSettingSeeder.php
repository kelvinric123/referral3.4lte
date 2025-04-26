<?php

namespace Database\Seeders;

use App\Models\LoyaltyPointSetting;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

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
            'GP Referral Program Participated' => 20,
            'GP Referral Program Attended' => 40,
        ];
        
        // Booking Agent point values
        $baPointValues = [
            'Pending' => 5,
            'Approved' => 10,
            'Rejected' => 0,
            'No Show' => 0,
            'Completed' => 25,
        ];
        
        // Add GP settings
        foreach ($gpPointValues as $status => $points) {
            $this->createOrUpdateSetting([
                'entity_type' => 'GP',
                'referral_status' => $status,
                'points' => $points,
                'description' => "Points for GP when " . ($status === 'GP Referral Program Participated' ? 'participated in the GP referral program' : 
                                ($status === 'GP Referral Program Attended' ? 'attended the GP referral program' : 
                                "referral is {$status}")),
                'is_active' => true,
            ]);
        }
        
        // Add Booking Agent settings
        foreach ($statuses as $status) {
            $this->createOrUpdateSetting([
                'entity_type' => 'Booking Agent',
                'referral_status' => $status,
                'points' => $baPointValues[$status],
                'description' => "Points for Booking Agent when referral is {$status}",
                'is_active' => true,
            ]);
        }
    }
    
    /**
     * Create or update a loyalty point setting.
     */
    private function createOrUpdateSetting(array $data): void
    {
        // Check if the setting already exists
        $exists = DB::table('loyalty_point_settings')
            ->where('entity_type', $data['entity_type'])
            ->where('referral_status', $data['referral_status'])
            ->exists();
            
        if ($exists) {
            // Update existing setting
            DB::table('loyalty_point_settings')
                ->where('entity_type', $data['entity_type'])
                ->where('referral_status', $data['referral_status'])
                ->update([
                    'points' => $data['points'],
                    'description' => $data['description'],
                    'is_active' => $data['is_active'],
                    'updated_at' => now(),
                ]);
        } else {
            // Create new setting using DB facade to bypass model validation
            $data['created_at'] = now();
            $data['updated_at'] = now();
            DB::table('loyalty_point_settings')->insert($data);
        }
    }
} 