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
        Schema::table('orders', function (\Illuminate\Database\Schema\Blueprint $table) {
            $table->decimal('write_off', 10, 2)->default(0)->after('total');
            $table->string('write_off_reason')->nullable()->after('write_off');
            $table->decimal('round_off', 10, 2)->default(0)->after('write_off_reason'); // optional: roundings
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (\Illuminate\Database\Schema\Blueprint $table) {
            $table->dropColumn(['write_off', 'write_off_reason', 'round_off']);
        });
    }
};
