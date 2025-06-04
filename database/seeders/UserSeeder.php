<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'name' => 'John Teacher',
            'email' => 'john.teacher@example.com',
            'password' => bcrypt('password'),
            'role' => 'teacher',
        ]);

        User::create([
            'name' => 'Jane Student',
            'email' => 'jane.student@example.com',
            'password' => bcrypt('password'),
            'role' => 'student',
        ]);
        User::create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
            'role' => 'teacher',
        ]);
    }
}