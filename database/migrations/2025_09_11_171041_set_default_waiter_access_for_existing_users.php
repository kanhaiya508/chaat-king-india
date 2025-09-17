<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Set waiter_app_access to true for existing users
        // You can modify this query based on your requirements
        
        // Option 1: Enable for all existing users
        DB::table('users')->update(['waiter_app_access' => true]);
        
        // Option 2: Enable only for specific emails (uncomment and modify as needed)
        // $waiterEmails = ['admin@example.com', 'waiter@example.com'];
        // DB::table('users')->whereIn('email', $waiterEmails)->update(['waiter_app_access' => true]);
        
        // Option 3: Enable based on roles (if you have roles table)
        // DB::table('users')
        //     ->whereIn('id', function($query) {
        //         $query->select('model_id')
        //               ->from('model_has_roles')
        //               ->where('role_id', function($subQuery) {
        //                   $subQuery->select('id')
        //                            ->from('roles')
        //                            ->where('name', 'waiter');
        //               });
        //     })
        //     ->update(['waiter_app_access' => true]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Set waiter_app_access to false for all users
        DB::table('users')->update(['waiter_app_access' => false]);
    }
};
