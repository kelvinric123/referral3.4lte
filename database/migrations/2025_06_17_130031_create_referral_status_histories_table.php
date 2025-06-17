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
        Schema::create('referral_status_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('referral_id')->constrained()->onDelete('cascade');
            $table->string('status');
            $table->string('previous_status')->nullable();
            $table->string('changed_by_type'); // User, GP, BookingAgent, etc.
            $table->unsignedBigInteger('changed_by_id');
            $table->string('changed_by_name');
            $table->text('notes')->nullable();
            $table->timestamps();
            
            $table->index(['referral_id', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('referral_status_histories');
    }
};
