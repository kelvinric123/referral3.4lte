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
        // First check if the original table exists
        if (Schema::hasTable('gp_referral_program_actions')) {
            // Try to create a duplicate table with the new naming
            try {
                // Create the g_p_referral_program_actions table with the same structure
                if (!Schema::hasTable('g_p_referral_program_actions')) {
                    // Create the table
                    Schema::create('g_p_referral_program_actions', function (Blueprint $table) {
                        $table->id();
                        $table->unsignedBigInteger('gp_id');
                        $table->unsignedBigInteger('gp_referral_program_id');
                        $table->enum('action_type', ['participated', 'attended']);
                        $table->boolean('points_awarded')->default(false);
                        $table->timestamps();
                        
                        // Add indexes for better performance
                        $table->index('gp_id');
                        $table->index('gp_referral_program_id');
                        
                        // Each GP can only have one record of each action type per program
                        $table->unique(['gp_id', 'gp_referral_program_id', 'action_type'], 'gp_refprog_act_unique');
                    });
                }
            } catch (\Exception $e) {
                // If we can't create the table, log the error
                \Log::error('Could not create g_p_referral_program_actions table: ' . $e->getMessage());
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Do not drop the table on rollback since we're just fixing a naming issue
    }
};
