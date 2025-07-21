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
        // $departmentKeuangan = Department::where('name', 'Keuangan')->first();
        // $departmentSDM = Department::where('name', 'SDM')->first();
        // $departmentIT = Department::where('name', 'IT')->first();

        // if($departmentIT && $departmentSDM && $departmentKeuangan){
        //     Employee::create([
        //         'name' => 'Andi Wijaya',
        //         'email' => 'wijaya@contoh.com',
        //         'position' => 'Manager Keuangan',
        //         'department_id' => $departmentKeuangan->id,
        //     ]);

        //     Employee::create([
        //         'name' => 'Budiman',
        //         'email' => 'manbudi@contoh.com',
        //         'position' => 'Staff SDM',
        //         'department_id' => $departmentSDM->id,
        //     ]);

        //     Employee::create([
        //         'name' => 'Tutik Dewi',
        //         'email' => 'tikdewi@contoh.com',
        //         'position' => 'Web Developer',
        //         'department_id' => $departmentIT->id,
        //     ]);
        // }else{
        //     echo 'Peringatan : Department yang dibutuhkan untuk EmployeeSeeder tidak ditemukan. Pastikan DepartmentSeender sudah dijalankan terlebih dahulu.\n';
        // }

        // $faker = Faker::create('id_ID');
        // $deparmentIds = Department::pluck('id')->toArray();

        // if(empty($deparmentIds)){
        //     echo 'Peringatan: Tidak ada department ditemukan. Jalankan DepartmentSeeder terlebih dahulu. \n';
        //     return;
        // }

        // for($i = 0; $i < 50; $i++){
        //     Employee::create([
        //         'name' => $faker->name,
        //         'email' => $faker->unique()->safeEmail,
        //         'position' => $faker->jobTitle,
        //         'department_id' => $faker->randomElement($deparmentIds),
        //     ]);
        // }


        //     Employee::create([
        //         'name' => 'Tutik Dewi',
        //         'email' => 'tikdewi@contoh.com',
        //         'position' => 'Web Developer',
        //         'department_id' => $faker->randomElement($deparmentIds),
        //     ]);

        // pastikan ada department yang tersedia
        if(Department::count() === 0){
            $this->call(DepartmentSeeder::class);
        }

        // Dapatkan semua user yang ada
        $users = User::all();
        $departments = Department::all();

         $adminUser = User::where('email', 'admin@example.com')->first();
        if ($adminUser && $adminUser->employee === null) {
            Employee::create([ // Gunakan create() langsung karena ini spesifik
                'name' => $adminUser->name,
                'email' => $adminUser->email,
                'position' => 'Administrator', // Posisi default untuk admin
                'department_id' => $departments->random()->id, // Pilih departemen acak
                'user_id' => $adminUser->id,
            ]);
            $this->command->info('Admin user linked to an employee record.');
        } else {
            $this->command->info('Admin user already has an employee record or does not exist.');
        }

                // memuat 10 karyawan dummy
        Employee::factory()->count(10)->create([
            'department_id' => function () use ($departments){
                return $departments->random()->id;
            },
            'user_id' => function() use ($users){
                // menghubungkan karyawan dengan user 
                $availableUsers = $users->filter(function ($user){
                    return $user->employee === null; // khusus user yang belum punya employee record
                });

                if($availableUsers->isNotEmpty()){
                    return $availableUsers->random()->id;
                }

                return null;
            },
        ]);

        $this->command->info('Employees seeded successfully');
    }
}