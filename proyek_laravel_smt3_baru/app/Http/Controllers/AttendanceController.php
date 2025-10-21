<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Employee;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function index()
    {
        $attendances = Attendance::with('employee')->get();
        return view('attendance.index', compact('attendances'));
    }

    public function create()
    {
        $employees = Employee::all();
        return view('attendance.create', compact('employees'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'karyawan_id' => 'required',
            'tanggal' => 'required|date',
            'waktu_masuk' => 'nullable',
            'waktu_keluar' => 'nullable',
            'status_absensi' => 'required'
        ]);

        Attendance::create($request->all());
        return redirect()->route('attendance.index')->with('success', 'Data absensi berhasil ditambahkan!');
    }

    public function show(Attendance $attendance)
    {
        return view('attendance.show', compact('attendance'));
    }

    public function edit(Attendance $attendance)
    {
        $employees = Employee::all();
        return view('attendance.edit', compact('attendance', 'employees'));
    }

    public function update(Request $request, Attendance $attendance)
    {
        $request->validate([
            'karyawan_id' => 'required',
            'tanggal' => 'required|date',
            'waktu_masuk' => 'nullable',
            'waktu_keluar' => 'nullable',
            'status_absensi' => 'required'
        ]);

        $attendance->update($request->all());
        return redirect()->route('attendance.index')->with('success', 'Data absensi berhasil diperbarui!');
    }

    public function destroy(Attendance $attendance)
    {
        $attendance->delete();
        return redirect()->route('attendance.index')->with('success', 'Data absensi berhasil dihapus!');
    }
}
