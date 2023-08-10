<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Foundation\Auth\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'user1 user1',
            'email' => 'user1@gmail.com',
            'password' => bcrypt('12345678'),
        ]);
        User::create([
            'name' => 'user2 user2',
            'email' => 'user2@gmail.com',
            'password' => bcrypt('12345678'),
        ]);
        User::create([
            'name' => 'user3 user3',
            'email' => 'user3@gmail.com',
            'password' => bcrypt('12345678'),
        ]);
    }
        
}
