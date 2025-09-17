<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Customer;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Customer::create([
            'name'      => 'Test Customer',
            'email'     => 'test@example.com',
            'password'  => Hash::make('secret123'),
            'phone'     => '9876543210',
            'address'   => 'Varanasi',
            'branch_id' => 1,
        ]);
    }
}
