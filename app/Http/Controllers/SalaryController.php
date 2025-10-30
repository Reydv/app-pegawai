<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Salary;
use Illuminate\Http\Request;

class SalaryController extends Controller
{
    public function index()
    {
        $employees = Employee::all();
        $salaries = Salary::with('employee')->latest()->get();
        return view('page-branch.salary', compact('salaries', 'employees'));
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

        return redirect()->back();
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

        return redirect()->back();
    }

    public function destroy(Salary $salary)
    {
        $salary->delete();
        return redirect()->back();
    }
}
