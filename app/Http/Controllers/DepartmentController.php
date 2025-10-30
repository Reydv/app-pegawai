<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Position;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    public function index()
    {
        $positions = Position::all();
        $departments = Department::all();
        return view('page-branch.dept', compact('departments', 'positions'));
    }

    public function create()
    {
        return view('page-branch.dept');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_departemen' => 'required|string|max:100',
        ]);

        Department::create($validated);
        return redirect()->back();
    }

    public function show(Department $department)
    {
        return view('', compact('department'));
    }


    public function edit(Department $department)
    {
        return view('', compact('department'));
    }

    public function update(Request $request, Department $department)
    {
        $validated = $request->validate([
            'nama_departemen' => 'required|string|max:100',
        ]);

        $department->update($validated);
        return redirect()->back();
    }

    public function destroy(Department $department)
    {
        $department->delete();
        return redirect()->route('departments.index')->with('success', "Department {$department->nama_departemen} berhasil dihapus.");
    }
}
