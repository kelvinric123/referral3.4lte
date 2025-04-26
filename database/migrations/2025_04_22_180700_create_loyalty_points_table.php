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
        // First create the table without foreign keys
        Schema::create('loyalty_points', function (Blueprint $table) {
            $table->id();
            $table->morphs('pointable'); // For GP or Booking Agent
            $table->unsignedBigInteger('referral_id');
            $table->integer('points');
            $table->enum('status', ['Pending', 'Approved', 'Rejected', 'No Show', 'Completed']);
            $table->text('description')->nullable();
            $table->integer('balance'); // Running total
            $table->timestamps();
        });

        // Add foreign key if referrals table exists
        Schema::table('loyalty_points', function (Blueprint $table) {
            if (Schema::hasTable('referrals')) {
                $table->foreign('referral_id')->references('id')->on('referrals')->onDelete('cascade');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('loyalty_points');
    }
}; 