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
        Schema::create('event_hall_slots', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_hall_id')->constrained('event_halls')->onDelete('cascade');
            $table->foreignId('slot_id')->constrained('slots')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('event_hall_slots');
    }
};
