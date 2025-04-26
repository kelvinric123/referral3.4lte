<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // First, remove the enum constraint
        DB::statement('ALTER TABLE loyalty_point_settings MODIFY COLUMN referral_status VARCHAR(255)');
        
        // Now we can add the new statuses as records
        DB::table('loyalty_point_settings')->insert([
            [
                'entity_type' => 'GP',
                'referral_status' => 'GP Referral Program Participated',
                'points' => 20,
                'description' => 'When GP participated in the GP referral program',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'entity_type' => 'GP',
                'referral_status' => 'GP Referral Program Attended',
                'points' => 40,
                'description' => 'When GP attended the GP referral program',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Remove the new status records
        DB::table('loyalty_point_settings')
            ->whereIn('referral_status', [
                'GP Referral Program Participated',
                'GP Referral Program Attended'
            ])
            ->delete();
            
        // Optionally, we could revert to enum, but that would need to check if other custom statuses exist
        // We'll leave it as VARCHAR to prevent potential issues
    }
};
