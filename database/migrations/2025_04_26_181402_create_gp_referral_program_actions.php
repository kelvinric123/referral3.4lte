<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('gp_referral_program_actions', function (Blueprint $table) {
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
            $table->unique(['gp_id', 'gp_referral_program_id', 'action_type'], 'gp_refprogram_action_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gp_referral_program_actions');
    }
};
