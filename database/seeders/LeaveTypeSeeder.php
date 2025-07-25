<?php

namespace Database\Seeders;

use App\Models\LeaveRequest;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\LeaveType; 

class LeaveTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // LeaveType::truncate();

        $leaveType = [
            ['name' => 'Cuti Tahunan', 'description' => 'Cuti yang diberikan setiap tahunnya'],
            ['name' => 'Cuti Sakit', 'description' => 'Cuti karena alasan kesehatan, memerlukan surat sakit dari dokter'],
            ['name' => 'Cuti Melahirkan', 'description' => 'Cuti khusus untuk karyawan wanita yang melahirkan'],
            ['name' => 'Cuti Penting Lainnya', 'description' =>  'Cuti untuk urusan pribadi mendesak (misal: pernikahan, duka cita).'],
        ];

        foreach($leaveType as $type){
            LeaveType::create($type);
        }

        
        // <<< PASTIKAN BARIS INI ADA UNTUK KONFIRMASI >>>
        $this->command->info('Leave types seeded successfully!');
    }
}