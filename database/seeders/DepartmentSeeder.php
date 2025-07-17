<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Department::create([
            'name' => 'Keuangan',
            'description' => 'Departemen yang mengelola keuangan perusahaan.',
        ]);

        Department::create([
            'name' => 'SDM',
            'description' => 'Departemen yang mengelola karyawan dan HRD.',
        ]);

        Department::create([
            'name' => 'IT',
            'description' => 'Departemen yang mengelola teknologi informasi .',
        ]);
    }
}