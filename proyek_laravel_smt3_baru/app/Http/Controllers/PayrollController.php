<?php

// ============================================
// PayrollController.php - UPDATED
// ============================================

namespace App\Http\Controllers;

use App\Models\Payroll;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class PayrollController extends Controller
{
    public function index()
    {
        try {
            $payrolls = Payroll::with('employee')
                               ->orderBy('periode', 'desc')
                               ->orderBy('created_at', 'desc')
                               ->get();

            $employees = Employee::where('status', 'Aktif')->get();

            // Hitung total gaji bulan ini
            $currentMonth = Carbon::now()->format('Y-m');
            $totalGaji = Payroll::whereRaw("DATE_FORMAT(periode, '%Y-%m') = ?", [$currentMonth])
                               ->sum('total_gaji');

            return view('payroll.index', compact('payrolls', 'employees', 'totalGaji'));

        } catch (\Exception $e) {
            return back()->with('error', 'Gagal mengambil data penggajian: ' . $e->getMessage());
        }
    }

    public function store(Request $request)
    {
        try {
            Log::info('Payroll Store Request:', $request->all());

            $validated = $request->validate([
                'employee_id' => 'required|exists:employees,id',
                'gaji_pokok' => 'required|numeric|min:0',
                'tunjangan' => 'nullable|numeric|min:0',
                'potongan' => 'nullable|numeric|min:0',
                'periode' => 'required|date_format:Y-m',
                'keterangan' => 'nullable|string'
            ]);

            Log::info('Payroll Validation Passed:', $validated);

            // Set default values
            $validated['tunjangan'] = $validated['tunjangan'] ?? 0;
            $validated['potongan'] = $validated['potongan'] ?? 0;

            // Hitung total gaji
            $validated['total_gaji'] = $validated['gaji_pokok'] +
                                       $validated['tunjangan'] -
                                       $validated['potongan'];

            $validated['status_pembayaran'] = 'pending';

            // Convert periode to date format (first day of month)
            $validated['periode'] = Carbon::createFromFormat('Y-m', $validated['periode'])->startOfMonth();

            // Cek apakah sudah ada data gaji untuk pegawai ini di periode yang sama
            $exists = Payroll::where('employee_id', $validated['employee_id'])
                            ->whereYear('periode', Carbon::parse($validated['periode'])->year)
                            ->whereMonth('periode', Carbon::parse($validated['periode'])->month)
                            ->exists();

            if ($exists) {
                return back()->with('error', 'Data gaji untuk pegawai ini di periode tersebut sudah ada!')->withInput();
            }

            $payroll = Payroll::create($validated);

            Log::info('Payroll Created Successfully:', ['id' => $payroll->id]);

            return redirect()->route('payroll.index')
                ->with('success', 'Data penggajian berhasil ditambahkan!');

        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Payroll Validation Error:', [
                'errors' => $e->errors(),
                'request' => $request->all()
            ]);
            return back()->withErrors($e->validator)->withInput();
        } catch (\Exception $e) {
            Log::error('Payroll Store Error:', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'request' => $request->all()
            ]);
            return back()->with('error', 'Gagal menambahkan data: ' . $e->getMessage())->withInput();
        }
    }

    public function show(string $id)
    {
        try {
            $payroll = Payroll::with('employee')->findOrFail($id);
            return view('payroll.show', compact('payroll'));
        } catch (\Exception $e) {
            return redirect()->route('payroll.index')
                ->with('error', 'Data penggajian tidak ditemukan!');
        }
    }

    public function edit(string $id)
    {
        try {
            $payroll = Payroll::findOrFail($id);
            $employees = Employee::where('status', 'Aktif')->get();
            return view('payroll.edit', compact('payroll', 'employees'));
        } catch (\Exception $e) {
            return redirect()->route('payroll.index')
                ->with('error', 'Data penggajian tidak ditemukan!');
        }
    }

    public function update(Request $request, string $id)
    {
        try {
            $payroll = Payroll::findOrFail($id);

            $validated = $request->validate([
                'gaji_pokok' => 'required|numeric|min:0',
                'tunjangan' => 'nullable|numeric|min:0',
                'potongan' => 'nullable|numeric|min:0',
                'status_pembayaran' => 'required|in:pending,dibayar',
                'keterangan' => 'nullable|string'
            ]);

            $validated['tunjangan'] = $validated['tunjangan'] ?? 0;
            $validated['potongan'] = $validated['potongan'] ?? 0;

            // Hitung ulang total gaji
            $validated['total_gaji'] = $validated['gaji_pokok'] +
                                       $validated['tunjangan'] -
                                       $validated['potongan'];

            $payroll->update($validated);

            return redirect()->route('payroll.index')
                ->with('success', 'Data penggajian berhasil diperbarui!');

        } catch (\Exception $e) {
            return back()->with('error', 'Gagal memperbarui data: ' . $e->getMessage())->withInput();
        }
    }

    public function destroy(string $id)
    {
        try {
            $payroll = Payroll::findOrFail($id);
            $payroll->delete();

            return redirect()->route('payroll.index')
                ->with('success', 'Data penggajian berhasil dihapus!');

        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menghapus data: ' . $e->getMessage());
        }
    }

    public function markAsPaid(string $id)
    {
        try {
            $payroll = Payroll::findOrFail($id);
            $payroll->update(['status_pembayaran' => 'dibayar']);

            return redirect()->back()
                ->with('success', 'Status pembayaran berhasil diubah menjadi dibayar!');

        } catch (\Exception $e) {
            return back()->with('error', 'Gagal mengubah status: ' . $e->getMessage());
        }
    }
}
