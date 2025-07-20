<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;
// use Inertia\Inertia;
use Illuminate\Support\Facades\Gate;

class DepartmentController extends Controller
{
    // public function __construct(){
    //     $this->middleware('can:manage-employees');
    // }
    /*
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $departments = Department::latest()->paginate(10);
        return view('departments.index', compact('departments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('departments.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //validasi data
        $validatedData = $request->validate([
            'name' => 'required|unique:departments|max:255',
            'description' => 'nullable',
        ]);

        // simpan data ke database
        Department::create($validatedData);
        
        return redirect()->route('departments.index')->with('success', 'Data berhasil ditambahkan'); 
    }

    /**
     * Display the specified resource.
     */
    public function show(Department $department)
    {
        return view('departments.show', compact('departments'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Department $department)
    {
        return view('departments.edit', compact('department'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Department $department)
    {
         //validasi data
        $validatedData = $request->validate([
            'name' => 'required|max:255|unique:departments,name,'.$department->id,
            'description' => 'nullable',
        ]);

        // simpan data ke database
        // Department::create($validatedData);
        $department->update($validatedData);
        
        return redirect()->route('departments.index')->with('success', 'Data berhasil diperbaharui'); 
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Department $department)
    {
        $department->delete();
        return redirect()->route('departments.index')->with('success', 'Data berhasil dihapus'); 
    }
}