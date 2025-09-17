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
        Schema::create('branches', function (Blueprint $table) {
            $table->id();
            $table->string('name');                 // Branch का नाम
            $table->string('contact_number')->nullable(); // Contact number
            $table->string('gst_number')->nullable();     // GST number
            $table->string('address')->nullable();        // Address
            $table->boolean('is_active')->default(true);  // Active / Inactive
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('branches');
    }
};
