<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class MyProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
         $user = Auth::user();

        
        if(!$user->employee){
            return redirect()->route('dashboard')->with('error', 'Anda belum memiliki data karyawan yang terhubung.');
        }

        $employee = $user->employee;
        return view('profile.employee-profile.show', compact('employee'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        $user = Auth::user();
        
        if(!$user->employee){
            return redirect()->route('dashboard')->with('error', 'Anda belum memiliki data karyawan yang terhubung.');
        }

        $employee = $user->employee;
        $departments = Department::all();

        return view('profile.employee-profile.edit', compact('employee', 'departments'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $user = Auth::user();

        
        if(!$user->employee){
            return redirect()->route('dashboard')->with('error', 'Anda belum memiliki data karyawan yang terhubung.');
        }

        $employee = $user->employee;

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

        $user->update([
            'name' => $validatedData['name'],
            'email' => $validatedData['email']
        ]);

        $employee->update($validatedData);
        return redirect()->route('my-profile.show')->with('success', 'Profile karyawan anda berhasil diperbaharui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}