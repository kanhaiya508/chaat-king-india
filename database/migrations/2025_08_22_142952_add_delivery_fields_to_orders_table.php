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
        Schema::table('orders', function (Blueprint $table) {
            $table->string('delivery_partner_name')->nullable()->after('status');
            $table->string('delivery_partner_phone', 20)->nullable()->after('delivery_partner_name');
            $table->string('delivery_location')->nullable()->after('delivery_partner_phone');
            $table->decimal('delivery_distance', 8, 2)->nullable()->after('delivery_location'); // km with 2 decimals
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn([
                'delivery_partner_name',
                'delivery_partner_phone',
                'delivery_location',
                'delivery_distance',
            ]);
        });
    }
};
