<?php

// ============================================
// LeaveController.php - UPDATED & FIXED
// ============================================

namespace App\Http\Controllers;

use App\Models\Leave;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class LeaveController extends Controller
{
    public function index()
    {
        try {
            // Ambil semua data leave dengan relasi employee
            $leaves = Leave::with('employee')
                           ->orderBy('created_at', 'desc')
                           ->get();

            // Ambil semua pegawai (termasuk yang cuti)
            $employees = Employee::all();

            // PENTING: Passing data leaves ke view
            return view('leave.index', compact('leaves', 'employees'));

        } catch (\Exception $e) {
            return back()->with('error', 'Gagal mengambil data cuti: ' . $e->getMessage());
        }
    }

    public function store(Request $request)
    {
        try {
            // Log request untuk debugging
            Log::info('Leave Store Request:', $request->all());

            $validated = $request->validate([
                'employee_id' => 'required|exists:employees,id',
                'jenis' => 'required|in:cuti_tahunan,cuti_sakit,izin_pribadi,cuti_melahirkan,cuti_menikah',
                'tanggal_mulai' => 'required|date',
                'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
                'alasan' => 'required|string',
                'dokumen' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048'
            ]);

            // Hitung jumlah hari
            $mulai = Carbon::parse($validated['tanggal_mulai']);
            $selesai = Carbon::parse($validated['tanggal_selesai']);
            $validated['jumlah_hari'] = $mulai->diffInDays($selesai) + 1;

            // Upload dokumen jika ada
            if ($request->hasFile('dokumen')) {
                $file = $request->file('dokumen');
                $filename = time() . '_' . $file->getClientOriginalName();

                // Buat folder jika belum ada
                if (!file_exists(public_path('uploads/leave'))) {
                    mkdir(public_path('uploads/leave'), 0777, true);
                }

                $file->move(public_path('uploads/leave'), $filename);
                $validated['dokumen'] = $filename;
            }

            $validated['status'] = 'pending';

            $leave = Leave::create($validated);
            Log::info('Leave Created Successfully:', ['id' => $leave->id]);

            return redirect()->route('leave.index')
                ->with('success', 'Pengajuan cuti/izin berhasil diajukan!');

        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Leave Validation Error:', $e->errors());
            return back()->withErrors($e->validator)->withInput();
        } catch (\Exception $e) {
            Log::error('Leave Store Error:', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);
            return back()->with('error', 'Gagal mengajukan: ' . $e->getMessage())->withInput();
        }
    }

    public function show(string $id)
    {
        try {
            $leave = Leave::with('employee')->findOrFail($id);
            return view('leave.show', compact('leave'));
        } catch (\Exception $e) {
            return redirect()->route('leave.index')
                ->with('error', 'Data cuti tidak ditemukan!');
        }
    }

    public function edit(string $id)
    {
        try {
            $leave = Leave::findOrFail($id);
            $employees = Employee::where('status', '!=', 'Nonaktif')->get();
            return view('leave.edit', compact('leave', 'employees'));
        } catch (\Exception $e) {
            return redirect()->route('leave.index')
                ->with('error', 'Data cuti tidak ditemukan!');
        }
    }

    public function update(Request $request, string $id)
    {
        try {
            $leave = Leave::findOrFail($id);

            $validated = $request->validate([
                'jenis' => 'required|in:cuti_tahunan,cuti_sakit,izin_pribadi,cuti_melahirkan,cuti_menikah',
                'tanggal_mulai' => 'required|date',
                'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
                'alasan' => 'required|string',
            ]);

            // Hitung ulang jumlah hari
            $mulai = Carbon::parse($validated['tanggal_mulai']);
            $selesai = Carbon::parse($validated['tanggal_selesai']);
            $validated['jumlah_hari'] = $mulai->diffInDays($selesai) + 1;

            $leave->update($validated);

            return redirect()->route('leave.index')
                ->with('success', 'Data cuti/izin berhasil diperbarui!');

        } catch (\Exception $e) {
            return back()->with('error', 'Gagal memperbarui: ' . $e->getMessage())->withInput();
        }
    }

    public function approve($id)
    {
        try {
            $leave = Leave::findOrFail($id);
            $leave->update([
                'status' => 'disetujui',
                'approved_at' => now(),
                'approved_by' => Auth::id() ?? 1
            ]);

            // Update status pegawai menjadi cuti
            $leave->employee->update(['status' => 'Cuti']);

            return redirect()->route('leave.index')
                ->with('success', 'Cuti/Izin berhasil disetujui!');

        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menyetujui: ' . $e->getMessage());
        }
    }

    public function reject($id)
    {
        try {
            $leave = Leave::findOrFail($id);
            $leave->update([
                'status' => 'ditolak',
                'rejected_at' => now(),
                'rejected_by' => Auth::id() ?? 1
            ]);

            return redirect()->route('leave.index')
                ->with('success', 'Cuti/Izin berhasil ditolak!');

        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menolak: ' . $e->getMessage());
        }
    }

    public function destroy(string $id)
    {
        try {
            $leave = Leave::findOrFail($id);

            // Hapus file dokumen jika ada
            if ($leave->dokumen && file_exists(public_path('uploads/leave/' . $leave->dokumen))) {
                unlink(public_path('uploads/leave/' . $leave->dokumen));
            }

            $leave->delete();

            return redirect()->route('leave.index')
                ->with('success', 'Pengajuan berhasil dihapus!');

        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menghapus: ' . $e->getMessage());
        }
    }
}
