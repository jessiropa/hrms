<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
// use Inertia\Inertia;
use Illuminate\Support\Facades\Gate;
use Maatwebsite\Excel\Facades\Excel; // <<< Tambahkan ini
use App\Exports\EmployeesExport; 

class EmployeeController extends Controller
{
    // public function __construct(){
    //     $this->middleware('can:manage-departments');
    // }
    /*
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        // dd($request->all());

        $query = Employee::with('department');

        // $query = Employee::with('department'); // Selalu eager load department

        // Logika pencarian
        // if ($request->has('search') && $request->search != '') {
        //     $search = $request->search;
        //     $query->where('name', 'like', '%' . $search . '%')
        //           ->orWhere('email', 'like', '%' . $search . '%')
        //           ->orWhere('position', 'like', '%' . $search . '%')
        //           // Mencari di nama departemen juga
        //           ->orWhereHas('department', function ($q) use ($search) {
        //                 $q->where('name', 'like', '%' . $search . '%');
        //             });
        // }
         if ($request->has('search') && $request->search != '') {
            $search = $request->search;

            // Mengelompokkan kondisi OR untuk pencarian agar logika berjalan dengan benar
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('email', 'like', '%' . $search . '%')
                  ->orWhere('position', 'like', '%' . $search . '%')
                  // Mencari di nama departemen juga menggunakan orWhereHas
                  ->orWhereHas('department', function ($subQuery) use ($search) {
                        $subQuery->where('name', 'like', '%' . $search . '%');
                    });
            });
        }

        // dd($query->toSql(), $query->getBindings());

        // $employees = Employee::latest()->paginate(10);
         $employees = $query->paginate(10);
        // dd($employees->toArray());
        
        //  $employees = $query->get();

        $employees->appends($request->query());
        return view('employees.index', compact('employees'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $departments = Department::all();
        return view('employees.create', compact('departments'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:employees',
            'position' => 'required|string|max:255',
            'department_id' => 'required|exists:departments,id',
        ]);

        Employee::create($validatedData);
        return redirect()->route('employees.index')->with('success', 'Data karyawan berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Employee $employee)
    {
        return view('employees.show', compact('employee'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Employee $employee)
    {
        $departments = Department::all(); // Ini mengambil semua departemen dari database
        // return view('employees.edit', compact('employee'));
        return view('employees.edit', compact('employee', 'departments')); // 'departments' di sini adalah variabel yang kita ambil tadi.
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Employee $employee)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('employees')->ignore($employee->id),
            ],
            'position' => 'required|string|max:255',
            'department_id' => 'required|exists:departments,id',
        ]);

        $employee->update($validatedData);
        return redirect()->route('employees.index')->with('success', 'Data karyawan berhasil diperbaharui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Employee $employee)
    {
        $employee->delete();
        return redirect()->route('employees.index')->with('success', 'Data berhasil dihapus'); 
    }

    public function export(){
        return Excel::download(new EmployeesExport, 'employees.xlsx');
    }
}