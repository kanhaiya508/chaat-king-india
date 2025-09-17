<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Item;
use App\Models\ItemVariant;
use App\Models\ItemAddon;
use App\Models\Category;

class ItemSeeder extends Seeder
{
    public function run(): void
    {
        $userId = 5;

        // Fetch category_ids for user 3
        $categories = Category::where('user_id', $userId)->pluck('id')->toArray();

        if (empty($categories)) {
            $this->command->warn("No categories found for user_id = 3. Please seed categories first.");
            return;
        }

        $items = [
            'Margherita Pizza',
            'Veg Biryani',
            'Cheese Burger',
            'Pasta Alfredo',
            'Paneer Tikka',
            'Spring Roll',
            'Hakka Noodles',
            'Masala Dosa',
            'Chole Bhature',
            'Chicken Momos',
        ];



        $variantsList = [
            ['label' => 'Small', 'price' => 99],
            ['label' => 'Medium', 'price' => 149],
            ['label' => 'Large', 'price' => 199],
        ];

        $addonsList = [
            ['name' => 'Extra Cheese', 'price' => 30],
            ['name' => 'Extra Sauce', 'price' => 20],
            ['name' => 'Paneer Topping', 'price' => 40],
            ['name' => 'Chilli Flakes', 'price' => 10],
        ];

        foreach ($items as $itemName) {
            $item = Item::create([
                'user_id' => $userId,
                'name' => $itemName,
                'category_id' => fake()->randomElement($categories),
                'type' => fake()->randomElement(['food', 'beverage']),
                'is_available' => true,
            ]);

            // Add variants
            foreach ($variantsList as $variant) {
                ItemVariant::create([
                    'item_id' => $item->id,
                    'label' => $variant['label'],
                    'price' => $variant['price'],
                ]);
            }

            // Add 2 random addons
            foreach (fake()->randomElements($addonsList, 2) as $addon) {
                ItemAddon::create([
                    'item_id' => $item->id,
                    'name' => $addon['name'],
                    'price' => $addon['price'],
                ]);
            }
        }
    }
}
