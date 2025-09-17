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
        Schema::create('slots', function (Blueprint $table) {
            $table->id();
            $table->date('date'); // Slot date
            $table->time('start_time'); // Start time
            $table->time('end_time'); // End time
            $table->integer('capacity')->default(1); // Kitne bookings allow
            $table->boolean('is_active')->default(true); // Active/Inactive status
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('slots');
    }
};
