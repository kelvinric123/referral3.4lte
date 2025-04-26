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
        // Convert the status column from ENUM to VARCHAR to support custom statuses
        DB::statement('ALTER TABLE loyalty_points MODIFY COLUMN status VARCHAR(255)');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // No need to revert the column to ENUM type
        // That would risk data loss if there are already custom statuses in the table
    }
};
