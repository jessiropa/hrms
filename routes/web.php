<?php

use App\Http\Controllers\ProfileController;
use App\Models\Department;
use App\Models\User;
use App\Models\Employee;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\EmployeeController;
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

        return view('dashboard', compact('totalDepartments', 'totalEmployees', 'totalUsers'));
    })->name('dashboard')->middleware('can:view-dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('departments', DepartmentController::class)->middleware('can:manage-employees');
    Route::resource('employees', EmployeeController::class)->middleware('can:manage-employees');
    Route::resource('users', UserController::class)->middleware('can:manage-users');
});

// require __DIR__.'/auth.php';