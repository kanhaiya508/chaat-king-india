<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Item;
use App\Models\ItemVariant;
use App\Models\Category;

class KkFoodsSeeder extends Seeder
{
    public function run(): void
    {
        $categoryId = 45;

        // Check if category exists
        $category = Category::find($categoryId);
        if (!$category) {
            $this->command->error("Category with ID {$categoryId} not found. Please create the category first.");
            return;
        }

        // Use the user_id from the category
        $userId = $category->user_id;

        $this->command->info("Adding K.K Food's menu items to category: {$category->name} (ID: {$categoryId})");
        $this->command->info("Using user_id: {$userId} from category");

        // K.K Food's menu items with prices
        $menuItems = [
            ['name' => 'Plain Dosa', 'price' => 80],
            ['name' => 'Masala Dosa', 'price' => 110],
            ['name' => 'Onion Masala', 'price' => 120],
            ['name' => 'Onion Plain', 'price' => 100],
            ['name' => 'Mysore Plain', 'price' => 100],
            ['name' => 'Mysore Masala', 'price' => 120],
            ['name' => 'Paneer Mix', 'price' => 130],
            ['name' => 'Paneer Dosa', 'price' => 150],
            ['name' => 'Butter Paneer', 'price' => 170],
            ['name' => 'Butter Masala', 'price' => 130],
            ['name' => 'Rawa Plain', 'price' => 120],
            ['name' => 'Rawa Masala', 'price' => 150],
            ['name' => 'Rawa Paneer', 'price' => 180],
            ['name' => 'Onion Uttapam', 'price' => 200],
            ['name' => 'Paneer Uttapam', 'price' => 240],
            ['name' => 'Mix Veg Uttapam', 'price' => 250],
            ['name' => 'Idli (2pcs)', 'price' => 70],
            ['name' => 'Family Masala Dosa', 'price' => 200],
            ['name' => 'Family Paneer Dosa', 'price' => 250],
            ['name' => 'Special Masala Dosa', 'price' => 150],
            ['name' => 'Sambar Vada (2pcs)', 'price' => 100],
        ];

        foreach ($menuItems as $menuItem) {
            // Create the item
            $item = Item::create([
                'user_id' => $userId,
                'name' => $menuItem['name'],
                'category_id' => $categoryId,
                'is_available' => true,
                'branch_id' => $category->branch_id, // Use the same branch as category
            ]);

            // Create a single variant with the menu price
            ItemVariant::create([
                'item_id' => $item->id,
                'label' => 'Regular',
                'price' => $menuItem['price'],
            ]);

            $this->command->info("Added: {$menuItem['name']} - ₹{$menuItem['price']}");
        }

        $this->command->info("Successfully added " . count($menuItems) . " items from K.K Food's menu to category ID {$categoryId}");
    }
}
