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
        Schema::create('loyalty_point_settings', function (Blueprint $table) {
            $table->id();
            $table->enum('entity_type', ['GP', 'Booking Agent']);
            $table->enum('referral_status', ['Pending', 'Approved', 'Rejected', 'No Show', 'Completed']);
            $table->integer('points')->default(0);
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            // Add a unique constraint on entity_type and referral_status
            $table->unique(['entity_type', 'referral_status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('loyalty_point_settings');
    }
}; 