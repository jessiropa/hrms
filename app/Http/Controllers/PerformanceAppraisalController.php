<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\PerformanceAppraisal;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;

class PerformanceAppraisalController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // menampilkan semua daftar penilaian kinerja untuk admin / hr
    public function index()
    {
        // hanya untuk HR dan admin
        Gate::authorize('manage-appraisals');
        $appraisals = PerformanceAppraisal::with(['employee', 'reviewer'])->latest()->paginate(10);
        return view('performance_appraisals.index', compact('appraisals'));
    }

    // menampilkan daftar penilaian sesuai user yang sedang login
    public function myAppraisals()
    {
        // cek data user sesuai dengan user yang sedang login
        $user = Auth::user();

        // mendapatkan penilaian yang dibuat oleh user ini sebagai reviewer
        $reviewedAppraisals = $user->reviewedAppraisals()->with('employee')->latest()->paginate(5, ['*'], 'reviewed_page');

        // mendapatkan penilaian yang diterima oleh karyawan 
        $myAppraisals = collect();
        if($user->employee){
            $myAppraisals = $user->employee->performanceAppraisals()->with('reviewer')->latest()->paginate(5, ['*'], 'my_appraisals_page');
        }

        return view('performance_appraisals.my_appraisals', compact('reviewedAppraisals', 'myAppraisals'));
    }

    // menampilkan form membuat penilaian kinerja baru 
    public function create()
    {
        Gate::authorize('create-appraisal');

        $employees = Employee::all();
        return view('performance_appraisals.create', compact('employees'));
    }

    // menyimpan penilaian yang baru dibuat ke database 
    public function store(Request $request)
    {
        Gate::authorize('create-appraisal');

        $validatedData  = $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'appraisal_date' => 'required|date|before_or_equal:today',
            'overall_score' => 'nullable|integer|min:1|max:5',
            'comments' => 'nullable|string|max:1000',
            'status' => 'required|in:draft,submitted,reviewed',
        ]);

        // secara otomatis mengisi reviewer_id dengan id user yang sedang login
        $validatedData['reviewer_id'] = Auth::id();

        PerformanceAppraisal::create($validatedData);
        return redirect()->route('performance_appraisals.my-appraisals')->with('success', 'Penilaian kinerja berhasil dibuat!');
    }

    // edit penilaian kerja 
    public function edit(PerformanceAppraisal $performanceAppraisal)
    {
        Gate::authorize('manage-appraisals');
        $employees = Employee::all();
        return view('performance_appraisals.edit', compact('performanceAppraisal', 'employees'));
    }

    public function update(Request $request, PerformanceAppraisal $performanceAppraisal)
    {
        Gate::authorize('manage-appraisals');
        $validatedData = $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'appraisal_date' => 'required|date|before_or_equal:today',
            'overall_score' => 'nullable|integer|min:1|max:5',
            'comments' => 'nullable|string|max:1000',
            'status' => 'required|in:draft,submitted,reviewed',
        ]);

        $performanceAppraisal->update($validatedData);
        return redirect()->route('performance_appraisals.my-appraisals')->with('success', 'Penilaian kinerja berhasil diperbarui!');
    }

}