<?php

namespace Database\Seeders;

use App\Models\Department;
use App\Models\Employee;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Models\User;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        // // pastikan ada department yang tersedia
        // if(Department::count() === 0){
        //     $this->call(DepartmentSeeder::class);
        // }

        // // Dapatkan semua user yang ada
        // $users = User::all();
        // $departments = Department::all();

        //  $adminUser = User::where('email', 'admin@example.com')->first();
        // if ($adminUser && $adminUser->employee === null) {
        //     Employee::create([ // Gunakan create() langsung karena ini spesifik
        //         'name' => $adminUser->name,
        //         'email' => $adminUser->email,
        //         'position' => 'Administrator', // Posisi default untuk admin
        //         'department_id' => $departments->random()->id, // Pilih departemen acak
        //         'user_id' => $adminUser->id,
        //     ]);
        //     $this->command->info('Admin user linked to an employee record.');
        // } else {
        //     $this->command->info('Admin user already has an employee record or does not exist.');
        // }

        //         // memuat 10 karyawan dummy
        // Employee::factory()->count(10)->create([
        //     'department_id' => function () use ($departments){
        //         return $departments->random()->id;
        //     },
        //     'user_id' => function() use ($users){
        //         // menghubungkan karyawan dengan user 
        //         $availableUsers = $users->filter(function ($user){
        //             return $user->employee === null; // khusus user yang belum punya employee record
        //         });

        //         if($availableUsers->isNotEmpty()){
        //             return $availableUsers->random()->id;
        //         }

        //         return null;
        //     },
        // ]);

        // $this->command->info('Employees seeded successfully');

        // Pastikan ada departemen yang tersedia
        if (Department::count() === 0) {
            $this->call(DepartmentSeeder::class); // Panggil DepartmentSeeder jika belum ada departemen
        }
        $departments = Department::all(); // Ambil semua departemen

        // Dapatkan user yang belum punya employee record
        // Ini akan mengambil user yang belum ditautkan ke employee manapun
        $usersWithoutEmployee = User::doesntHave('employee')->get();
        // Acak koleksi user yang tersedia agar penautan lebih bervariasi
        $usersForEmployees = $usersWithoutEmployee->shuffle();

        // --- Buat/Tautkan Employee untuk Admin User ---
        $adminUser = User::where('email', 'admin@example.com')->first();
        if ($adminUser && $adminUser->employee === null) {
            Employee::create([
                'name' => $adminUser->name, // Ambil nama dari user
                'email' => $adminUser->email,
                'user_id' => $adminUser->id,
                'position' => 'Administrator',
                'department_id' => $departments->random()->id,
                // 'employee_id' => 'ADM-' . str_pad($adminUser->id, 3, '0', STR_PAD_LEFT),
            ]);
            $this->command->info('Admin user linked to an employee record.');
        } else {
            $this->command->info('Admin user already has an employee record or does not exist.');
        }

        // --- Buat/Tautkan Employee untuk User dengan Role 'employee' (atau user lain yang belum ditautkan) ---
        // Kita akan menautkan user yang memiliki role 'employee' ke employee record
        // Atau user lain yang belum memiliki employee record (dari User::factory() di UserSeeder)
        $employeeUsers = User::where('role', 'employee')->doesntHave('employee')->get();
        $otherAvailableUsers = User::doesntHave('employee')->whereNotIn('role', ['admin', 'hr', 'employee'])->get();

        $usersToLink = $employeeUsers->merge($otherAvailableUsers)->shuffle();

        $countLinkedEmployees = 0;
        foreach ($usersToLink as $user) {
            // Pastikan user belum punya employee record
            if ($user->employee === null) {
                Employee::create([
                    'user_id' => $user->id,
                    'department_id' => $departments->random()->id,
                    // 'employee_id' => 'EMP-' . str_pad($user->id, 3, '0', STR_PAD_LEFT), // ID Karyawan unik
                    'name' => $user->name, // Ambil nama dari user
                    'email' => $user->email,
                    'position' => 'Staff',
                ]);
                $countLinkedEmployees++;
            }
        }
        $this->command->info($countLinkedEmployees . ' employee records linked to users.');

        // --- Buat beberapa Employee tanpa User ID (opsional, untuk data historis/belum punya akun) ---
        // Jika Anda masih ingin beberapa karyawan yang tidak bisa login
        $employeesWithoutUser = 3; // Jumlah karyawan tanpa user ID
        Employee::factory()->count($employeesWithoutUser)->create([
            'user_id' => null, // Pastikan user_id null
            'department_id' => function () use ($departments) {
                return $departments->random()->id;
            },
        ]);
        $this->command->info($employeesWithoutUser . ' employees without user accounts created.');

        $this->command->info('Employee seeding completed.');
    }
    // }
}