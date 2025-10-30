<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Employee;
use App\Models\Position;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Employee::with(['jabatan', 'departemen']);

        if ($request->filled('departemen_id')) {
            $query->where('departemen_id', $request->departemen_id);
        }

        $employees = $query->latest()->get();
        $departments = Department::all();
        $positions = Position::all();
        $selectedEmployee = null;

        if ($request->filled('selected_id')) {
            $selectedEmployee = Employee::with(['jabatan', 'departemen'])->find($request->selected_id);
        }

        return view('page-branch.index', compact(
            'employees',
            'departments',
            'positions',
            'selectedEmployee'
        ));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $validated = $request->validate([
            'nama_lengkap'  => ['required', 'string', 'max:255'],
            'email'         => ['required', 'email', 'max:255', 'unique:employees,email'],
            'nomor_telepon' => ['required', 'string', 'max:20'],
            'tanggal_lahir' => ['required', 'date'],
            'alamat'        => ['required', 'string', 'max:255'],
            'tanggal_masuk' => ['required', 'date'],
            'departemen_id' => ['required', 'exists:departments,id'],
            'jabatan_id'    => ['required', 'exists:positions,id'],
        ]);

        Employee::create($validated);
        return redirect()->back();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Employee $employee)
    {
        $validated = $request->validate([
            'nama_lengkap'  => ['required', 'string', 'max:255'],
            'email'         => ['required', 'email', 'max:255', Rule::unique('employees')->ignore($employee->id)],
            'nomor_telepon' => ['required', 'string', 'max:20'],
            'tanggal_lahir' => ['required', 'date'],
            'alamat'        => ['required', 'string', 'max:255'],
            'tanggal_masuk' => ['required', 'date'],
            'departemen_id' => ['required', 'exists:departments,id'],
            'jabatan_id'    => ['required', 'exists:positions,id'],
            'status'        => ['required', 'string', 'in:aktif,nonaktif'],
        ]);

        $employee->update($validated);
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Employee $employee)
    {
        $employee->delete();
        return redirect()->back();
    }
}
