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
        // First create the table with basic columns without foreign keys
        Schema::create('referrals', function (Blueprint $table) {
            $table->id();
            $table->string('patient_name');
            $table->string('patient_id', 30); // IC/Passport number
            $table->date('patient_dob');
            $table->string('patient_contact', 20);
            $table->unsignedBigInteger('hospital_id');
            $table->unsignedBigInteger('specialty_id');
            $table->unsignedBigInteger('consultant_id');
            $table->enum('referrer_type', ['GP', 'BookingAgent']);
            $table->unsignedBigInteger('gp_id')->nullable();
            $table->unsignedBigInteger('booking_agent_id')->nullable();
            $table->date('preferred_date');
            $table->enum('priority', ['Normal', 'Urgent', 'Emergency'])->default('Normal');
            $table->text('diagnosis');
            $table->text('clinical_history')->nullable();
            $table->text('remarks')->nullable();
            $table->enum('status', ['Pending', 'Approved', 'Rejected', 'No Show', 'Completed'])->default('Pending');
            $table->timestamps();
        });

        // Add foreign key constraints if the referenced tables exist
        Schema::table('referrals', function (Blueprint $table) {
            if (Schema::hasTable('hospitals')) {
                $table->foreign('hospital_id')->references('id')->on('hospitals')->onDelete('restrict');
            }
            
            if (Schema::hasTable('specialties')) {
                $table->foreign('specialty_id')->references('id')->on('specialties')->onDelete('restrict');
            }
            
            if (Schema::hasTable('consultants')) {
                $table->foreign('consultant_id')->references('id')->on('consultants')->onDelete('restrict');
            }
            
            if (Schema::hasTable('gps')) {
                $table->foreign('gp_id')->references('id')->on('gps')->onDelete('set null');
            }
            
            if (Schema::hasTable('booking_agents')) {
                $table->foreign('booking_agent_id')->references('id')->on('booking_agents')->onDelete('set null');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('referrals');
    }
}; 