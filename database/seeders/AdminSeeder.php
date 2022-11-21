<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Admin
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@toyotaforklifts-philippines.com',
            'email_verified_at' => now(),
            'password' => bcrypt('p@55w0rd2023'),
            'role' => 'admin',
        ]);

        // User
        User::create([
            'name' => 'John Arian Malondras',
            'email' => 'hii.malondras@toyotaforklifts-philippines.com',
            'email_verified_at' => now(),
            'password' => bcrypt('p@55w0rd2023'),
            'role' => 'user',
        ]);
    }
}
