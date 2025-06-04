<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Teacher;


class TeacherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Teacher::create(['name' => 'John Doe', 'email' => 'john.doe@example.com', 'password' => bcrypt('password')]);
        Teacher::create(['name' => 'Jane Smith', 'email' => 'jane.smith@example.com', 'password' => bcrypt('password')]);
    }
}
