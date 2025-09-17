<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Table;
use App\Models\Tablecategory;
use App\Models\Branch;
use App\Models\User;

class ChaatKingTableSeeder extends Seeder
{
    public function run(): void
    {
        // Get the first user and branch
        $user = User::first();
        $branch = Branch::first();
        
        if (!$user || !$branch) {
            $this->command->warn("No user or branch found. Please create them first.");
            return;
        }

        // Define table categories suitable for Chaat King
        $tableCategories = [
            [
                'name' => 'Main Hall',
                'description' => 'Main dining area for regular customers'
            ],
            [
                'name' => 'Family Section', 
                'description' => 'Spacious area for families and groups'
            ],
            [
                'name' => 'Counter Seating',
                'description' => 'Quick seating near the counter'
            ]
        ];

        $tableCategoryIds = [];

        // Create table categories
        foreach ($tableCategories as $categoryData) {
            $category = Tablecategory::create([
                'name' => $categoryData['name'],
                'branch_id' => $branch->id,
            ]);
            $tableCategoryIds[$categoryData['name']] = $category->id;
        }

        // Define 10 tables distributed across categories
        $tables = [
            // Main Hall - 4 tables
            'Main Hall' => [
                ['name' => 'T-01', 'description' => 'Main Hall Table 1'],
                ['name' => 'T-02', 'description' => 'Main Hall Table 2'],
                ['name' => 'T-03', 'description' => 'Main Hall Table 3'],
                ['name' => 'T-04', 'description' => 'Main Hall Table 4'],
            ],
            
            // Family Section - 4 tables
            'Family Section' => [
                ['name' => 'F-01', 'description' => 'Family Table 1'],
                ['name' => 'F-02', 'description' => 'Family Table 2'],
                ['name' => 'F-03', 'description' => 'Family Table 3'],
                ['name' => 'F-04', 'description' => 'Family Table 4'],
            ],
            
            // Counter Seating - 2 tables
            'Counter Seating' => [
                ['name' => 'C-01', 'description' => 'Counter Seat 1'],
                ['name' => 'C-02', 'description' => 'Counter Seat 2'],
            ]
        ];

        // Create tables
        foreach ($tables as $categoryName => $categoryTables) {
            $categoryId = $tableCategoryIds[$categoryName];
            
            foreach ($categoryTables as $tableData) {
                Table::create([
                    'name' => $tableData['name'],
                    'tablecategory_id' => $categoryId,
                    'branch_id' => $branch->id,
                ]);
            }
        }

        $this->command->info('Chaat King tables seeded successfully!');
        $this->command->info('Created ' . count($tableCategories) . ' table categories');
        $this->command->info('Created 10 tables total');
    }
}
