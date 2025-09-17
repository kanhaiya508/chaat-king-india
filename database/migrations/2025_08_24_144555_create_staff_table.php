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
        Schema::create('staff', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Staff ka naam
            $table->string('father_name')->nullable(); // Father name (agar optional rakhna ho)
            $table->string('phone', 15)->unique(); // Phone number, unique rakha hai
            $table->string('address')->nullable(); // Address
            $table->string('aadhaar_number', 12)->unique(); // Aadhaar card number (12 digit)
            $table->string('designation')->nullable(); // Designation (job title)

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('staff');
    }
};
