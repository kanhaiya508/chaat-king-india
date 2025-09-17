<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 👇 जिन tables में branch_id चाहिए उनके नाम यहां डालो
        $tables = [
            'categories',
            'customers',
            'event_bookings',
            'event_halls',
            'event_hall_slots',
            'food_categories',
            'items',
            'orders',
            'order_items',
            'order_payments',
            'tablecategories',
            'tables',

        ];

        foreach ($tables as $table) {
            Schema::table($table, function (Blueprint $t) use ($table) {
                if (!Schema::hasColumn($table, 'branch_id')) {
                    $t->foreignId('branch_id')
                        ->nullable()
                        ->after('id')
                        ->constrained('branches')
                        ->onDelete('cascade');
                }
            });
        }
    }

    public function down(): void
    {
        $tables = [
            'categories',
            'customers',
            'event_bookings',
            'event_halls',
            'event_hall_slots',
            'food_categories',
            'items',
            'orders',
            'order_items',
            'order_payments',
            'tablecategories',
            'tables',
        ];

        foreach ($tables as $table) {
            Schema::table($table, function (Blueprint $t) use ($table) {
                if (Schema::hasColumn($table, 'branch_id')) {
                    $t->dropForeign([$table . '_branch_id_foreign']);
                    $t->dropColumn('branch_id');
                }
            });
        }
    }
};
