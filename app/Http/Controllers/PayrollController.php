<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Payroll;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class PayrollController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        Gate::authorize('manage-payrolls');

        $payrolls = Payroll::with('employee')->latest()->paginate(10);

        return view('payrolls.index', compact('payrolls'));
    }

        public function create()
    {
        Gate::authorize('manage-payrolls'); // Otorisasi untuk mengelola penggajian

        $employees = Employee::all(); // Ambil semua karyawan untuk dropdown
        return view('payrolls.create', compact('employees'));
    }

    public function store(Request $request)
    {
        Gate::authorize('manage-payrolls');

        $validatedData = $request->validate([
            'employee_id' => 'required|exists::employee,id',
            'pay_period_start' => 'required|date',
            'pay_period_end' => 'required|date|after_or_equal:pay_period_start',
            'base_salary' => 'required|numeric|min:0',
            'allowances' => 'nullable|numeric|min:0',
            'deductions' => 'nullable|numeric|min:0',
            'status' => 'required|in:pending,paid,failde',
            'notes' => 'nullable|string|max:1000'
        ]);

        $baseSalary = $validatedData['base_salary'];
        $allowances = $validatedData['allowances'] ?? 0;
        $deductions = $validatedData['deductions'] ?? 0;
        $validatedData['net_salary'] = $baseSalary + $allowances - $deductions;

        Payroll::create($validatedData);

        return redirect()->route('payrolls.index')->with('success', 'Slip gaji berhasil dibuat!');

    }

    public function show(Payroll $payroll)
    {
        // otoritas admin dan HR bisa lihat semua
        if(Auth::user()->role === 'employee'){
            if(Auth::user()->employee && Auth::user()->employee->id === $payroll->employee_id){

            }else{
                abort(403, 'Anda tidak diizinkan untuk melihat slip gaji ini.');
            }
        }else{
            Gate::authorize('manage-payrolls');
        }

        $payroll->load('employee');
        return view('payrolls.show', compact('payroll'));
    }

    public function edit(Payroll $payroll)
    {
        Gate::authorize('manage-payrolls');

        $employees = Employee::all();
        return view('payrolls.edit', compact('payrolls', 'employees'));
    }

    public function update(Request $request, Payroll$payroll)
    {
         Gate::authorize('manage-payrolls');

        $validatedData = $request->validate([
            'employee_id' => 'required|exists::employee,id',
            'pay_period_start' => 'required|date',
            'pay_period_end' => 'required|date|after_or_equal:pay_period_start',
            'base_salary' => 'required|numeric|min:0',
            'allowances' => 'nullable|numeric|min:0',
            'deductions' => 'nullable|numeric|min:0',
            'status' => 'required|in:pending,paid,failde',
            'notes' => 'nullable|string|max:1000'
        ]);

        $baseSalary = $validatedData['base_salary'];
        $allowances = $validatedData['allowances'] ?? 0;
        $deductions = $validatedData['deductions'] ?? 0;
        $validatedData['net_salary'] = $baseSalary + $allowances - $deductions;

        Payroll::update($validatedData);

        return redirect()->route('payrolls.index')->with('success', 'Slip gaji berhasil dibuat!');
    }



    public function destroy(Payroll $payroll)
    {
        Gate::authorize('manage-payrolls');

        $payroll->delete();
        return redirect()->route('payrolls.index')->with('success', 'Slip gaji berhasil dihapus!');
    }

    public function myPayrolls()
    {
        Gate::authorize('view-my-payrolls');

        $user = Auth::user();
        $payrolls = collect();

        if($user->employee){
            $payrolls = $user->employee->payrolls()->latest()->paginate(10);
        }

        return view('payrolls.my_payrolls', compact('payrolls'));
    }
}