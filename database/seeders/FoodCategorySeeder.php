<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FoodCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('food_categories')->insert([
            ['name' => 'veg', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'non-veg', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'egg', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
