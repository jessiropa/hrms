<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User; // Import model User
use Illuminate\Support\Facades\Hash; 

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if(!User::where('email', 'admin@example.com')->exists()){
            User::create([
                'name' => 'Admin HRMS',
                'email' => 'admin@example.com',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
                'role' => 'admin',
            ]);
            $this->command->info('Admin user created!');
        }else{
            $this->command->info('Admin user already exists.');
        }

        User::factory()->count(50)->create([
             'role' => 'employee', 
        ]);
        $this->command->info('50 fake users created!');
    }
}