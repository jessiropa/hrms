<?php

namespace Database\Seeders;

use App\Models\Department;
use App\Models\Employee;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $departmentKeuangan = Department::where('name', 'Keuangan')->first();
        $departmentSDM = Department::where('name', 'SDM')->first();
        $departmentIT = Department::where('name', 'IT')->first();

        if($departmentIT && $departmentSDM && $departmentKeuangan){
            Employee::create([
                'name' => 'Andi Wijaya',
                'email' => 'wijaya@contoh.com',
                'position' => 'Manager Keuangan',
                'department_id' => $departmentKeuangan->id,
            ]);

            Employee::create([
                'name' => 'Budiman',
                'email' => 'manbudi@contoh.com',
                'position' => 'Staff SDM',
                'department_id' => $departmentSDM->id,
            ]);

            Employee::create([
                'name' => 'Tutik Dewi',
                'email' => 'tikdewi@contoh.com',
                'position' => 'Web Developer',
                'department_id' => $departmentIT->id,
            ]);
        }else{
            echo 'Peringatan : Department yang dibutuhkan untuk EmployeeSeeder tidak ditemukan. Pastikan DepartmentSeender sudah dijalankan terlebih dahulu.\n';
        }
    }
}