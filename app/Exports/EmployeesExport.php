<?php

namespace App\Exports;

use App\Models\Employee;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class EmployeesExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        // return Employee::all();
        return Employee::with('department')->get()->map(function ($employee, $key){
            return [
                'No.' => $key + 1,
                'ID' => $employee->id,
                'Nama Karyawan' => $employee->name,
                'Email' => $employee->email,
                'Posisi' => $employee->position,
                'Departemen' => $employee->department->name ?? 'N/A',
                'Tanggal Bergabung' => $employee->created_at->format('Y-m-d'),   
            ];
        });
    }

    public function headings():array{
        return [
            'No.',
            'ID',
            'Nama Karyawan',
            'Email',
            'Posisi',
            'Departemen',
            'Tanggal Bergabung',
        ];
    }
}