<?php

use App\Http\Controllers\ProfileController;
use App\Models\Department;
use App\Models\User;
use App\Models\Employee;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\MyProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Gate;
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

});

// require __DIR__.'/auth.php';