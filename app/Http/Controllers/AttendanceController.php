<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Gate;

class AttendanceController extends Controller
{
    public function __construct()
    {
        // Untuk saat ini, asumsikan semua user yang login bisa melihat kehadiran mereka sendiri.
        // Anda bisa menambahkan gate khusus di sini jika diperlukan, misal:
        // $this->middleware('can:view-attendance');
    }

    /**
     * Display a listing of the attendance records for the authenticated user.
     */
    public function index()
    {
        $user = Auth::user();

        // Hapus baris dd() yang sebelumnya untuk debugging
        // dd($user->attendances());
        // dd(get_class($user));

        // Ambil riwayat kehadiran user yang login, diurutkan dari yang terbaru
        $attendances = $user->attendances()->latest()->paginate(10);

        // Cek status kehadiran hari ini (apakah sudah check-in tapi belum check-out)
        $todayAttendance = Attendance::where('user_id', $user->id)
                                    ->whereDate('check_in_time', Carbon::today())
                                    ->first();

        // Pengecekan null yang lebih aman
        $hasCheckedIn = $todayAttendance && $todayAttendance->check_in_time !== null;
        $hasCheckedOut = $todayAttendance && $todayAttendance->check_out_time !== null;

        return view('attendances.index', compact('attendances', 'hasCheckedIn', 'hasCheckedOut'));
    }

    /**
     * Handle the check-in process.
     */
    public function checkIn()
    {
        $user = Auth::user();

        $todayAttendance = Attendance::where('user_id', $user->id)
                                    ->whereDate('check_in_time', Carbon::today())
                                    ->first();

        if ($todayAttendance && $todayAttendance->check_in_time !== null) {
            return redirect()->route('attendances.index')->with('error', 'Anda sudah melakukan check-in hari ini.');
        }

        Attendance::create([
            'user_id' => $user->id,
            'check_in_time' => Carbon::now(),
        ]);

        return redirect()->route('attendances.index')->with('success', 'Check-in berhasil!');
    }

    /**
     * Handle the check-out process.
     */
    public function checkOut()
    {
        $user = Auth::user();

        $todayAttendance = Attendance::where('user_id', $user->id)
                                    ->whereDate('check_in_time', Carbon::today())
                                    ->whereNull('check_out_time')
                                    ->first();

        if (!$todayAttendance) {
            return redirect()->route('attendances.index')->with('error', 'Anda belum melakukan check-in hari ini atau sudah check-out.');
        }

        $todayAttendance->update([
            'check_out_time' => Carbon::now(),
        ]);

        return redirect()->route('attendances.index')->with('success', 'Check-out berhasil!');
    }
}