<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    public function index()
    {
        $departments = Department::all();
        return view('departments.index', compact('departments'));
    }

    public function create()
    {
        return view('');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_departemen' => 'required|string|max:100',
        ]);

        Department::create($validated);
        return redirect()->route('')->with("Department {$validated['nama_departemen']} berhasil ditambahkan.");
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
        return redirect()->route('')->with('success', "Department {$department->nama_departemen} berhasil diupdate.");
    }

    public function destroy(Department $department)
    {
        $department->delete();
        return redirect()->route('departments.index')->with('success', "Department {$department->nama_departemen} berhasil dihapus.");
    }
}
