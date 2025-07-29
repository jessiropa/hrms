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
        // if(!User::where('email', 'admin@example.com')->exists()){
        //     User::create([
        //         'name' => 'Admin HRMS',
        //         'email' => 'admin@example.com',
        //         'password' => Hash::make('password'),
        //         'email_verified_at' => now(),
        //         'role' => 'admin',
        //     ]);
        //     $this->command->info('Admin user created!');
        // }else{
        //     $this->command->info('Admin user already exists.');
        // }

        // User::factory()->count(10)->create([
        //      'role' => 'employee', 
        // ]);
        // $this->command->info('10 fake users created!');

        // create data hrd 
        User::create([
            'name' => 'HR Manager',
            'email' => 'hr@example.com',
            'password' => Hash::make('password'),
            'role' => 'hr',
        ]);

        $this->command->info('HR user created');

        // create data admin 
        User::create([
            'name' => 'Admin HRMS',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);
        $this->command->info('Admin user created');

        // create data employee
        User::create([
            'name' => 'Bela Employee',
            'email' => 'bela@example.com',
            'password' => Hash::make('password'),
            'role' => 'employee',
        ]);
        User::create([
            'name' => 'Dina Employee',
            'email' => 'dina@example.com',
            'password' => Hash::make('password'),
            'role' => 'employee',
        ]);
        User::create([
            'name' => 'Candra Employee',
            'email' => 'candra@example.com',
            'password' => Hash::make('password'),
            'role' => 'employee',
        ]);
        $this->command->info('Dummy employee users created.');

        User::factory()->count(5)->create(); // Membuat 5 user dummy lainnya
        $this->command->info('Additional dummy users created.');
    }
}