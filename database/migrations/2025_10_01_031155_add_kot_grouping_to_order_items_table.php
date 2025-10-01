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
        Schema::table('order_items', function (Blueprint $table) {
            $table->string('kot_group_id')->nullable()->after('order_id');
            $table->boolean('kot_printed')->default(false)->after('kot_group_id');
            $table->timestamp('kot_printed_at')->nullable()->after('kot_printed');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('order_items', function (Blueprint $table) {
            $table->dropColumn(['kot_group_id', 'kot_printed', 'kot_printed_at']);
        });
    }
};
