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
        // Department::create([
        //     'name' => 'Keuangan',
        //     'description' => 'Departemen yang mengelola keuangan perusahaan.',
        // ]);

        // Department::create([
        //     'name' => 'SDM',
        //     'description' => 'Departemen yang mengelola karyawan dan HRD.',
        // ]);

        // Department::create([
        //     'name' => 'IT',
        //     'description' => 'Departemen yang mengelola teknologi informasi .',
        // ]);
        // Department::create([
        //    'name' => 'Operations', 'description' => 'Mengelola operasional harian.'
        // ]);
        // Department::create([
        //     'name' => 'Marketing', 'description' => 'Mengembangkan strategi pemasaran.'
        // ]);

         $defaultDepartments = [
            [ 'name' => 'Keuangan',
            'description' => 'Departemen yang mengelola keuangan perusahaan.',],
            [ 'name' => 'SDM',
            'description' => 'Departemen yang mengelola karyawan dan HRD.',],
            [ 'name' => 'IT',
            'description' => 'Departemen yang mengelola teknologi informasi .',],
            ['name' => 'Marketing', 'description' => 'Mengembangkan strategi pemasaran.'],
            ['name' => 'Operations', 'description' => 'Mengelola operasional harian.'],
        ];

         foreach ($defaultDepartments as $dept) {
            // Cek apakah departemen sudah ada untuk menghindari duplikasi
            if (!Department::where('name', $dept['name'])->exists()) {
                Department::create($dept);
            }
        }

        $this->command->info('Default departments created or already exist!');

        // Membuat 5 departemen palsu tambahan menggunakan DepartmentFactory
        Department::factory()->count(5)->create();
        $this->command->info('5 fake departments created!');


    }
}