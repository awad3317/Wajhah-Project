<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Admin',
            'phone' => '967730236551',
            'password' => '12121212',
            'phone_verified_at'=>now(),
            'user_type' => 'admin',
        ]);

        User::create([
            'name' => 'User',
            'phone' => '967730236552',
            'password' => '12121212',
            'phone_verified_at'=>now(),
            'user_type' => 'user',
        ]);
    }
}
