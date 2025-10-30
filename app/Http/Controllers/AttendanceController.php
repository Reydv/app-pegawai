<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Employee;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function index()
    {
        $employees = Employee::all();
        $attendances = Attendance::with('employee')->get();
        return view('page-branch.attendance', compact('attendances', 'employees'));
    }

    public function create()
    {
        $employees = Employee::all();
        return view('attendances.create', compact('employees'));
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $validated = $request->validate([
            'karyawan_id' => 'required|exists:employees,id',
            'tanggal' => 'required|date',
            'waktu_masuk' => 'nullable|date_format:H:i',
            'waktu_keluar' => 'nullable|date_format:H:i|after:waktu_masuk',
            'status_absensi' => 'required|in:hadir,izin,sakit,alpha',
        ]);

        Attendance::create($validated);
        return redirect()->back();
    }

    // ...

    public function update(Request $request, Attendance $attendance)
    {
        $validated = $request->validate([
            'karyawan_id' => 'sometimes|required|exists:employees,id',
            'tanggal' => 'sometimes|required|date',
            'waktu_masuk' => 'nullable|date_format:H:i',
            'waktu_keluar' => 'nullable|date_format:H:i|after:waktu_masuk',
            'status_absensi' => 'sometimes|required|in:hadir,izin,sakit,alpha',
        ]);

        $attendance->update($validated);
        return redirect()->route('attendances.index', [
            'selected_id' => $attendance->id,
            'tanggal' => $validated['tanggal'] ?? $attendance->tanggal
        ])->with('success', 'Absensi berhasil diperbarui.');
    }

    public function destroy(Attendance $attendance)
    {
        $attendance->delete();
        return redirect()->back();
    }
}
