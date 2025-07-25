<?php

use App\Http\Controllers\ProfileController;
use App\Models\Department;
use App\Models\User;
use App\Models\Employee;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\MyProfileController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\LeaveRequestController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
}); 

// Route::get('/dashboard', function () {

//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

require __DIR__.'/auth.php';

Route::middleware('auth')->group(function () {
    // Gate::authorize('view-dashboard'); 
    
    Route::get('/dashboard', function(){
        $totalDepartments = Department::count();
        $totalEmployees = Employee::count();
        $totalUsers = User::count();

        $employeesPerDepartment = Department::withCount('employees')->get();
        // $employeesPerDepartment = Department::withCount('employees')->get();

        return view('dashboard', compact('totalDepartments', 'totalEmployees', 'totalUsers', 'employeesPerDepartment'));
    })->name('dashboard')->middleware('can:view-dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('employees/export', [EmployeeController::class, 'export'])->name('employees.export')->middleware('can:manage-employees');
    Route::resource('departments', DepartmentController::class)->middleware('can:manage-employees');
    Route::resource('employees', EmployeeController::class)->middleware('can:manage-employees');
    Route::resource('users', UserController::class)->middleware('can:manage-users');

    // my profile disini 
    Route::prefix('my-profile')->name('my-profile.')->group(function() {
        Route::get('/', [MyProfileController::class, 'show'])->name('show');
        Route::get('/edit', [MyProfileController::class, 'edit'])->name('edit');
        Route::put('/', [MyProfileController::class, 'update'])->name('update');
    });

    Route::prefix('attendances')->name('attendances.')->group(function () {
        Route::get('/', [AttendanceController::class, 'index'])->name('index');
        Route::post('/check-in', [AttendanceController::class, 'checkIn'])->name('check-in');
        Route::post('/check-out', [AttendanceController::class, 'checkOut'])->name('check-out');
    });

    Route::prefix('leave-requests')->name('leave_requests.')->group(function () {
        // Rute untuk Karyawan
        Route::get('/create', [LeaveRequestController::class, 'create'])->name('create')->middleware('can:submit-leave-request');
        Route::post('/', [LeaveRequestController::class, 'store'])->name('store')->middleware('can:submit-leave-request');
        Route::get('/my-requests', [LeaveRequestController::class, 'myRequests'])->name('my-requests')->middleware('can:submit-leave-request');

        // Rute untuk Admin/HR (Manajemen Permintaan Cuti)
        Route::get('/', [LeaveRequestController::class, 'index'])->name('index')->middleware('can:manage-leave-requests');
        Route::patch('/{leaveRequest}/status', [LeaveRequestController::class, 'updateStatus'])->name('update-status')->middleware('can:manage-leave-requests');
    });

});

// require __DIR__.'/auth.php';