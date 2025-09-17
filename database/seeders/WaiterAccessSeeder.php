<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class WaiterAccessSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Enable waiter app access for specific users
        // You can modify these emails based on your requirements
        
        $waiterEmails = [
            'waiter1@example.com',
            'waiter2@example.com',
            'staff@restaurant.com',
            // Add more waiter emails here
        ];

        foreach ($waiterEmails as $email) {
            $user = User::where('email', $email)->first();
            if ($user) {
                $user->update(['waiter_app_access' => true]);
                $this->command->info("Waiter access enabled for: {$email}");
            } else {
                $this->command->warn("User not found: {$email}");
            }
        }

        // Alternative: Enable waiter access for all users (uncomment if needed)
        // User::query()->update(['waiter_app_access' => true]);
        // $this->command->info("Waiter access enabled for all users");

        // Alternative: Enable waiter access for users with specific roles (uncomment if needed)
        // User::role('waiter')->update(['waiter_app_access' => true]);
        // $this->command->info("Waiter access enabled for all users with 'waiter' role");
    }
}
