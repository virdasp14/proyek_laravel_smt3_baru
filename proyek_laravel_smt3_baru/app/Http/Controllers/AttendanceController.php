<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Attendance;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            // Ambil semua pegawai yang tidak nonaktif
            $employees = Employee::where('status', '!=', 'Nonaktif')
                                 ->orderBy('nama_lengkap', 'asc')
                                 ->get();

            // Get today's attendance
            $today = Carbon::today();
            $attendances = Attendance::whereDate('tanggal', $today)
                                     ->with('employee')
                                     ->get();

            // Statistik hari ini
            $stats = [
                'hadir' => $attendances->where('status', 'hadir')->count(),
                'izin' => $attendances->where('status', 'izin')->count(),
                'sakit' => $attendances->where('status', 'sakit')->count(),
                'alpha' => $attendances->where('status', 'alpha')->count(),
                'terlambat' => $attendances->where('status', 'terlambat')->count(),
            ];

            return view('attendance.index', compact('employees', 'attendances', 'stats'));

        } catch (\Exception $e) {
            return back()->with('error', 'Gagal mengambil data absensi: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        try {
            $employees = Employee::where('status', 'Aktif')->get();
            return view('attendance.create', compact('employees'));
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal membuka form: ' . $e->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'employee_id' => 'required|exists:employees,id',
                'tanggal' => 'required|date',
                'jam_masuk' => 'required',
                'jam_keluar' => 'nullable',
                'status' => 'required|in:hadir,izin,sakit,alpha,terlambat',
                'keterangan' => 'nullable|string'
            ]);

            // Cek apakah sudah ada absensi untuk pegawai ini di tanggal yang sama
            $existingAttendance = Attendance::where('employee_id', $validated['employee_id'])
                                           ->whereDate('tanggal', $validated['tanggal'])
                                           ->first();

            if ($existingAttendance) {
                return back()->with('error', 'Absensi untuk pegawai ini di tanggal tersebut sudah ada!')->withInput();
            }

            // Hitung total jam kerja jika jam keluar ada
            if (!empty($validated['jam_keluar'])) {
                $masuk = Carbon::parse($validated['jam_masuk']);
                $keluar = Carbon::parse($validated['jam_keluar']);

                if ($keluar->gt($masuk)) {
                    $validated['total_jam'] = $masuk->diffInHours($keluar);
                } else {
                    $validated['total_jam'] = 0;
                }
            }

            // Tentukan status terlambat otomatis jika jam masuk > 08:00
            if ($validated['status'] == 'hadir') {
                $jamMasuk = Carbon::parse($validated['jam_masuk']);
                $batasWaktu = Carbon::parse('08:00');

                if ($jamMasuk->gt($batasWaktu)) {
                    $validated['status'] = 'terlambat';
                }
            }

            Attendance::create($validated);

            return redirect()->route('attendance.index')
                ->with('success', 'Data absensi berhasil ditambahkan!');

        } catch (\Illuminate\Validation\ValidationException $e) {
            return back()->withErrors($e->validator)->withInput();
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menambahkan data: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $attendance = Attendance::with('employee')->findOrFail($id);
            return view('attendance.show', compact('attendance'));
        } catch (\Exception $e) {
            return redirect()->route('attendance.index')
                ->with('error', 'Data absensi tidak ditemukan!');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        try {
            $attendance = Attendance::findOrFail($id);
            $employees = Employee::where('status', 'Aktif')->get();
            return view('attendance.edit', compact('attendance', 'employees'));
        } catch (\Exception $e) {
            return redirect()->route('attendance.index')
                ->with('error', 'Data absensi tidak ditemukan!');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $attendance = Attendance::findOrFail($id);

            $validated = $request->validate([
                'employee_id' => 'required|exists:employees,id',
                'tanggal' => 'required|date',
                'jam_masuk' => 'required',
                'jam_keluar' => 'nullable',
                'status' => 'required|in:hadir,izin,sakit,alpha,terlambat',
                'keterangan' => 'nullable|string'
            ]);

            // Hitung total jam kerja
            if (!empty($validated['jam_keluar'])) {
                $masuk = Carbon::parse($validated['jam_masuk']);
                $keluar = Carbon::parse($validated['jam_keluar']);

                if ($keluar->gt($masuk)) {
                    $validated['total_jam'] = $masuk->diffInHours($keluar);
                }
            }

            $attendance->update($validated);

            return redirect()->route('attendance.index')
                ->with('success', 'Data absensi berhasil diperbarui!');

        } catch (\Exception $e) {
            return back()->with('error', 'Gagal memperbarui data: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $attendance = Attendance::findOrFail($id);
            $attendance->delete();

            return redirect()->route('attendance.index')
                ->with('success', 'Data absensi berhasil dihapus!');

        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menghapus data: ' . $e->getMessage());
        }
    }

    /**
     * Get attendance report
     */
    public function report(Request $request)
    {
        try {
            $month = $request->input('month', date('m'));
            $year = $request->input('year', date('Y'));

            $attendances = Attendance::with('employee')
                                     ->whereMonth('tanggal', $month)
                                     ->whereYear('tanggal', $year)
                                     ->orderBy('tanggal', 'desc')
                                     ->get();

            return view('attendance.report', compact('attendances', 'month', 'year'));

        } catch (\Exception $e) {
            return back()->with('error', 'Gagal membuat laporan: ' . $e->getMessage());
        }
    }

    /**
     * Auto check-in for all active employees
     */
    public function autoCheckIn()
    {
        try {
            $today = Carbon::today();
            $employees = Employee::where('status', 'Aktif')->get();

            $count = 0;
            foreach ($employees as $employee) {
                // Cek apakah sudah absen hari ini
                $exists = Attendance::where('employee_id', $employee->id)
                                   ->whereDate('tanggal', $today)
                                   ->exists();

                if (!$exists) {
                    Attendance::create([
                        'employee_id' => $employee->id,
                        'tanggal' => $today,
                        'jam_masuk' => '08:00:00',
                        'status' => 'hadir',
                        'keterangan' => 'Auto check-in'
                    ]);
                    $count++;
                }
            }

            return redirect()->back()
                ->with('success', "Auto check-in berhasil untuk {$count} pegawai!");

        } catch (\Exception $e) {
            return back()->with('error', 'Gagal auto check-in: ' . $e->getMessage());
        }
    }
}
