<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Salary;
use Illuminate\Http\Request;

class SalaryController extends Controller
{
    public function index()
    {
        $salaries = Salary::with('employee')->latest()->get();
        return view('salaries.index', compact('salaries'));
    }

    public function create()
    {
        $employees = Employee::all();
        return view('salaries.create', compact('employees'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'karyawan_id' => 'required|exists:employees,id',
            'bulan' => 'required|string|max:10',
            'gaji_pokok' => 'required|numeric|min:0',
            'tunjangan' => 'nullable|numeric|min:0',
            'potongan' => 'nullable|numeric|min:0',
            'total_gaji' => 'required|numeric|min:0',
        ]);

        $validated['tunjangan'] = $request->input('tunjangan', 0);
        $validated['potongan'] = $request->input('potongan', 0);

        Salary::create($validated);

        return redirect()->route('salaries.index')->with('success', '');
    }

    public function show(Salary $salary)
    {
        $salary->load('employee');
        return view('salaries.show', compact('salary'));
    }

    public function edit(Salary $salary)
    {
        $employees = Employee::all();
        return view('salaries.edit', compact('salary', 'employees'));
    }

    public function update(Request $request, Salary $salary)
    {
        $validated = $request->validate([
            'karyawan_id' => 'sometimes|required|exists:employees,id',
            'bulan' => 'sometimes|required|string|max:10',
            'gaji_pokok' => 'sometimes|required|numeric|min:0',
            'tunjangan' => 'nullable|numeric|min:0',
            'potongan' => 'nullable|numeric|min:0',
            'total_gaji' => 'sometimes|required|numeric|min:0',
        ]);

        $validated['tunjangan'] = $request->input('tunjangan', 0);
        $validated['potongan'] = $request->input('potongan', 0);

        $salary->update($validated);

        return redirect()->route('salaries.index')->with('success', '');
    }

    public function destroy(Salary $salary)
    {
        $salary->delete();
        return redirect()->route('salaries.index')->with('success', '');
    }
}
