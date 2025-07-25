<?php

namespace App\Http\Controllers;

use App\Models\LeaveRequest;
use App\Models\LeaveType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Carbon\Carbon;

class LeaveRequestController extends Controller
{
    public function __construct()
    {
        // Middleware untuk otorisasi
        $this->middleware('auth');
    }

    // view khusus untuk admin / HR
      public function index()
    {
        Gate::authorize('manage-leave-requests');

        $leaveRequests = LeaveRequest::with(['user', 'leaveType'])->latest()->paginate(10);

        return view('leave_requests.index', compact('leaveRequests'));
    }

    /**
     * Show the form for creating a new leave request (for Employees).
     */
    public function create()
    {
        Gate::authorize('submit-leave-request'); // Hanya karyawan yang bisa mengajukan cuti

        $leaveTypes = LeaveType::all();
        return view('leave_requests.create', compact('leaveTypes'));
    }

    /**
     * Store a newly created leave request in storage.
     */
    public function store(Request $request)
    {
        Gate::authorize('submit-leave-request');

        $validatedData = $request->validate([
            'leave_type_id' => 'required|exists:leave_types,id',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after_or_equal:start_date',
            'reason' => 'required|string|max:500',
        ]);
        Auth::user()->leaveRequests()->create($validatedData);

        return redirect()->route('leave_requests.my-requests')->with('success', 'Permintaan cuti berhasil diajukan!');
    }

    /**
     * Display a listing of the authenticated user's leave requests.
     */
    public function myRequests()
    {
        $leaveRequests = Auth::user()->leaveRequests()->with('leaveType')->latest()->paginate(10);
        return view('leave_requests.my_requests', compact('leaveRequests'));
    }

    // Metode untuk admin/HR (index dan updateStatus) akan ditambahkan di Hari ke-10
    // public function index()
    // {
    //     // Placeholder untuk Hari ke-10
    //     Gate::authorize('manage-leave-requests');
    //     $leaveRequests = LeaveRequest::with(['user', 'leaveType'])->latest()->paginate(10);
    //     return view('leave_requests.index', compact('leaveRequests'));
    // }

    public function updateStatus(Request $request, LeaveRequest $leaveRequest)
    {
        // Placeholder untuk Hari ke-10
        Gate::authorize('manage-leave-requests');
        $validatedData = $request->validate([
            'status' => 'required|in:approved,rejected',
            'admin_notes' => 'nullable|string|max:500',
        ]);
        $leaveRequest->update($validatedData);
        return redirect()->route('leave_requests.index')->with('success', 'Status permintaan cuti berhasil diperbarui!');
    }
}