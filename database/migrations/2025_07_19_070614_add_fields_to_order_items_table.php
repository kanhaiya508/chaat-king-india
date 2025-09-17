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
            $table->foreignId('item_id')->nullable()->after('order_id');
            $table->foreignId('variant_id')->nullable()->after('item_id');
            $table->string('item_name')->nullable()->after('variant_id');

            $table->decimal('total_price', 10, 2)->default(0)->after('price');
            $table->json('addon_ids')->nullable()->after('total_price');
            $table->text('remark')->nullable()->after('addon_ids');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('order_items', function (Blueprint $table) {
            $table->dropColumn([
                'item_id',
                'variant_id',
                'item_name',
                'total_price',
                'addon_ids',
                'remark',
            ]);
        });
    }
};
