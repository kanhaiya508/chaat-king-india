<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Table;
use App\Models\Tablecategory;
use App\Models\Branch;

class TableSeeder extends Seeder
{
    public function run(): void
    {
        // Get all branches
        $branches = Branch::all();
        
        if ($branches->isEmpty()) {
            throw new \Exception('No branches found. Please run BranchSeeder first.');
        }

        // Table categories with descriptions
        $categories = [
            [
                'name' => 'Eat In',
                'description' => 'Regular dining area for customers'
            ],
            [
                'name' => 'VIP Lounge',
                'description' => 'Premium seating area for VIP customers'
            ],
            [
                'name' => 'Rooftop',
                'description' => 'Outdoor rooftop dining with city view'
            ],
            [
                'name' => 'Family Section',
                'description' => 'Spacious area suitable for families'
            ],
            [
                'name' => 'Outdoor Garden',
                'description' => 'Garden seating with natural ambiance'
            ],
        ];

        foreach ($branches as $branch) {
            foreach ($categories as $categoryData) {
                // Create table category for this branch
                $category = Tablecategory::create([
                    'name' => $categoryData['name'],
                    'branch_id' => $branch->id,
                ]);

                // Create tables for this category
                $tableCount = $this->getTableCountForCategory($categoryData['name']);
                
                for ($i = 1; $i <= $tableCount; $i++) {
                    Table::create([
                        'name' => $this->generateTableName($categoryData['name'], $i),
                        'tablecategory_id' => $category->id,
                        'branch_id' => $branch->id,
                    ]);
                }
            }
        }
    }

    /**
     * Get appropriate table count for each category
     */
    private function getTableCountForCategory(string $categoryName): int
    {
        return match ($categoryName) {
            'VIP Lounge' => rand(3, 6),      // Fewer VIP tables
            'Rooftop' => rand(4, 8),         // Medium rooftop tables
            'Family Section' => rand(6, 12), // More family tables
            'Outdoor Garden' => rand(5, 10), // Medium garden tables
            default => rand(8, 15),          // Regular eat-in tables
        };
    }

    /**
     * Generate meaningful table names
     */
    private function generateTableName(string $categoryName, int $tableNumber): string
    {
        $prefix = match ($categoryName) {
            'VIP Lounge' => 'VIP',
            'Rooftop' => 'RT',
            'Family Section' => 'FAM',
            'Outdoor Garden' => 'GARDEN',
            default => 'T',
        };

        return $prefix . '-' . str_pad($tableNumber, 2, '0', STR_PAD_LEFT);
    }
}
