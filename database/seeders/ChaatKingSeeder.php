<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Item;
use App\Models\ItemVariant;
use App\Models\ItemAddon;
use App\Models\Category;
use App\Models\User;
use App\Models\Branch;

class ChaatKingSeeder extends Seeder
{
    public function run(): void
    {
        // Get the first user (assuming admin user exists)
        $user = User::first();
        if (!$user) {
            $this->command->warn("No user found. Please create a user first.");
            return;
        }

        // Get the first branch (assuming branch exists)
        $branch = Branch::first();
        if (!$branch) {
            $this->command->warn("No branch found. Please create a branch first.");
            return;
        }

        // Create categories
        $categories = [
            'Gol Gappe & Variants',
            'Tikki & Cutlets', 
            'Chaat Specials',
            'Street Food Snacks',
            'Traditional Items'
        ];

        $categoryIds = [];
        foreach ($categories as $categoryName) {
            $category = Category::create([
                'user_id' => $user->id,
                'name' => $categoryName,
                'branch_id' => $branch->id,
            ]);
            $categoryIds[$categoryName] = $category->id;
        }

        // Define items with their categories and variants
        $items = [
            // Gol Gappe & Variants
            'Gol Gappe & Variants' => [
                [
                    'name' => 'Gol Gappe Atta',
                    'variants' => [
                        ['label' => 'Regular', 'price' => 50]
                    ]
                ],
                [
                    'name' => 'Gol Gappe Suji', 
                    'variants' => [
                        ['label' => 'Regular', 'price' => 60]
                    ]
                ],
                [
                    'name' => 'Bhalla Wale Gol Gappe',
                    'variants' => [
                        ['label' => '6 pcs', 'price' => 80]
                    ]
                ]
            ],

            // Tikki & Cutlets
            'Tikki & Cutlets' => [
                [
                    'name' => 'Matar Tikki',
                    'variants' => [
                        ['label' => 'Regular', 'price' => 110]
                    ]
                ],
                [
                    'name' => 'Chole Tikki',
                    'variants' => [
                        ['label' => 'Regular', 'price' => 120]
                    ]
                ],
                [
                    'name' => 'Aloo Tikki',
                    'variants' => [
                        ['label' => 'Regular', 'price' => 100],
                        ['label' => 'Small', 'price' => 60]
                    ]
                ],
                [
                    'name' => 'Bun Tikki',
                    'variants' => [
                        ['label' => 'Regular', 'price' => 80]
                    ]
                ]
            ],

            // Chaat Specials
            'Chaat Specials' => [
                [
                    'name' => 'Dahi Bhalla',
                    'variants' => [
                        ['label' => 'Regular', 'price' => 80],
                        ['label' => 'Small', 'price' => 50]
                    ]
                ],
                [
                    'name' => 'Palak Patta Chaat',
                    'variants' => [
                        ['label' => 'Regular', 'price' => 100]
                    ]
                ],
                [
                    'name' => 'Bhalla Papdi',
                    'variants' => [
                        ['label' => 'Regular', 'price' => 90]
                    ]
                ],
                [
                    'name' => 'Basket Chaat',
                    'variants' => [
                        ['label' => 'Regular', 'price' => 200]
                    ]
                ],
                [
                    'name' => 'Papdi Chaat',
                    'variants' => [
                        ['label' => 'Regular', 'price' => 80]
                    ]
                ],
                [
                    'name' => 'Sev Puri',
                    'variants' => [
                        ['label' => 'Regular', 'price' => 80]
                    ]
                ],
                [
                    'name' => 'Papetu Chole',
                    'variants' => [
                        ['label' => 'Regular', 'price' => 100]
                    ]
                ]
            ],

            // Street Food Snacks
            'Street Food Snacks' => [
                [
                    'name' => 'Pav Bhaji',
                    'variants' => [
                        ['label' => '2 Pav', 'price' => 100]
                    ]
                ],
                [
                    'name' => 'Extra Pav',
                    'variants' => [
                        ['label' => 'Per Pav', 'price' => 30]
                    ]
                ],
                [
                    'name' => 'Vada Pav',
                    'variants' => [
                        ['label' => 'Regular', 'price' => 60]
                    ]
                ]
            ],

            // Traditional Items
            'Traditional Items' => [
                [
                    'name' => 'Kaanji Vada',
                    'variants' => [
                        ['label' => '2 pcs', 'price' => 80]
                    ]
                ]
            ]
        ];

        // Common addons for chaat items
        $commonAddons = [
            ['name' => 'Extra Dahi', 'price' => 20],
            ['name' => 'Extra Chutney', 'price' => 15],
            ['name' => 'Extra Sev', 'price' => 10],
            ['name' => 'Extra Onion', 'price' => 10],
            ['name' => 'Extra Coriander', 'price' => 5],
            ['name' => 'Extra Pomegranate', 'price' => 15],
        ];

        // Create items and their variants
        foreach ($items as $categoryName => $categoryItems) {
            $categoryId = $categoryIds[$categoryName];
            
            foreach ($categoryItems as $itemData) {
                $item = Item::create([
                    'user_id' => $user->id,
                    'name' => $itemData['name'],
                    'category_id' => $categoryId,
                    'is_available' => true,
                    'branch_id' => $branch->id,
                ]);

                // Add variants
                foreach ($itemData['variants'] as $variant) {
                    ItemVariant::create([
                        'item_id' => $item->id,
                        'label' => $variant['label'],
                        'price' => $variant['price'],
                    ]);
                }

                // Add 2-3 random addons for each item
                $randomAddons = array_rand($commonAddons, min(3, count($commonAddons)));
                if (!is_array($randomAddons)) {
                    $randomAddons = [$randomAddons];
                }
                
                foreach ($randomAddons as $addonIndex) {
                    ItemAddon::create([
                        'item_id' => $item->id,
                        'name' => $commonAddons[$addonIndex]['name'],
                        'price' => $commonAddons[$addonIndex]['price'],
                    ]);
                }
            }
        }

        $this->command->info('Chaat King items seeded successfully!');
    }
}
