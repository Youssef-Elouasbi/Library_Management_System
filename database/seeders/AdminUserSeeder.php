<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Youssef Elouasbi',
            'email' => 'Youssef@gmail.com',
            'password' => bcrypt('123456'),
            'role' => 'admin'
        ]);
    }
}
