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
        Schema::create('order_payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->onDelete('cascade');
            $table->enum('mode', ['cash', 'card', 'upi', 'wallet', 'bank_transfer']); // Add modes as needed
            $table->decimal('amount', 10, 2);
            $table->string('transaction_id')->nullable(); // For UPI, card, etc.
            $table->text('note')->nullable(); // Optional note
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_payments');
    }
};
