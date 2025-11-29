<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\EmployeeExport;
use App\Imports\EmployeeImport;
use PDF;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            // Ambil semua data employees dari database
            $employees = Employee::orderBy('created_at', 'desc')->get();

            // Ambil data departments dan positions untuk modal tambah pegawai
            $departments = \App\Models\Department::orderBy('nama_departemen')->get();
            $positions = \App\Models\Position::orderBy('nama_jabatan')->get();

            // Return ke view dengan data employees, departments, dan positions
            return view('employees.index', compact('employees', 'departments', 'positions'));

        } catch (\Exception $e) {
            // Jika ada error, tampilkan halaman error
            Log::error('Error di Employee Index: ' . $e->getMessage());
            return response()->view('errors.500', ['message' => 'Gagal mengambil data pegawai: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        try {
            return view('employees.create');
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
            // Log request untuk debugging
            Log::info('Employee Store Request:', $request->all());

            // Validasi input
            $validated = $request->validate([
                'nama_lengkap' => 'required|string|max:255',
                'email' => 'required|email|unique:employees,email',
                'nomor_telepon' => 'required|string|max:20',
                'tanggal_lahir' => 'required|date',
                'alamat' => 'required|string',
                'tanggal_masuk' => 'required|date',
                'status' => 'required|in:Aktif,Cuti,Nonaktif'
            ]);

            // Simpan ke database
            $employee = Employee::create($validated);
            Log::info('Employee Created Successfully:', ['id' => $employee->id]);

            return redirect()->route('employees.index')
                ->with('success', 'Data pegawai berhasil ditambahkan!');

        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Employee Validation Error:', $e->errors());
            return back()->withErrors($e->validator)->withInput();
        } catch (\Exception $e) {
            Log::error('Employee Store Error:', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);
            return back()->with('error', 'Gagal menyimpan data: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $employee = Employee::findOrFail($id);
            return view('employees.show', compact('employee'));
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return redirect()->route('employees.index')
                ->with('error', 'Data pegawai tidak ditemukan!');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menampilkan data: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        try {
            $employee = Employee::findOrFail($id);
            return view('employees.edit', compact('employee'));
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return redirect()->route('employees.index')
                ->with('error', 'Data pegawai tidak ditemukan!');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal membuka form edit: ' . $e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $employee = Employee::findOrFail($id);

            // Validasi input
            $validated = $request->validate([
                'nama_lengkap' => 'required|string|max:255',
                'email' => 'required|email|unique:employees,email,' . $id,
                'nomor_telepon' => 'required|string|max:20',
                'tanggal_lahir' => 'required|date',
                'alamat' => 'required|string',
                'tanggal_masuk' => 'required|date',
                'status' => 'required|in:Aktif,Cuti,Nonaktif',
                'department_id' => 'nullable|exists:departments,id'
            ]);

            // Update data
            $employee->update($validated);

            return redirect()->route('employees.index')
                ->with('success', 'Data pegawai berhasil diperbarui!');

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return redirect()->route('employees.index')
                ->with('error', 'Data pegawai tidak ditemukan!');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return back()->withErrors($e->validator)->withInput();
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
            $employee = Employee::findOrFail($id);
            $employee->delete();

            return redirect()->route('employees.index')
                ->with('success', 'Data pegawai berhasil dihapus!');

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return redirect()->route('employees.index')
                ->with('error', 'Data pegawai tidak ditemukan!');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menghapus data: ' . $e->getMessage());
        }
    }



    public function export(Request $request)
    {
        try {
            $format = $request->format;
            $dataType = $request->data_type;

            $query = Employee::query();

            // Filter berdasarkan tipe data
            if ($dataType !== 'all') {
                $query->where('status', ucfirst($dataType));
            }

            // Filter berdasarkan periode jika ada
            if ($request->start_date && $request->end_date) {
                $query->whereBetween('tanggal_masuk', [$request->start_date, $request->end_date]);
            }

            $employees = $query->get();

            if ($format === 'excel') {
                return Excel::download(new EmployeeExport($employees), 'data_pegawai.xlsx');
            } elseif ($format === 'csv') {
                return Excel::download(new EmployeeExport($employees), 'data_pegawai.csv');
            } elseif ($format === 'pdf') {
                $pdf = PDF::loadView('employees.pdf', compact('employees'));
                return $pdf->download('data_pegawai.pdf');
            }

            return back()->with('error', 'Format tidak valid!');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal export: ' . $e->getMessage());
        }
    }

    public function import(Request $request)
    {
        try {
            $request->validate([
                'file' => 'required|mimes:xlsx,xls,csv|max:5120'
            ]);

            Excel::import(new EmployeeImport, $request->file('file'));

            return redirect()->back()->with('success', 'Data berhasil diimport!');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal import: ' . $e->getMessage());
        }
    }

    public function downloadTemplate()
    {
        $headers = [
            'Nama Lengkap',
            'Email',
            'Nomor Telepon',
            'Tanggal Lahir',
            'Alamat',
            'Tanggal Masuk',
            'Status'
        ];

        $filename = 'template_import_pegawai.csv';

        $handle = fopen('php://output', 'w');
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="' . $filename . '"');

        fputcsv($handle, $headers);
        fputcsv($handle, [
            'John Doe',
            'john.doe@example.com',
            '081234567890',
            '1990-01-01',
            'Jl. Contoh No. 123',
            '2024-01-01',
            'Aktif'
        ]);

        fclose($handle);
        exit;
    }

    public function printReport(Request $request)
    {
        try {
            $reportType = $request->report_type;
            $period = $request->period;
            $outputFormat = $request->output_format;

            $data = [];
            $data['employees'] = Employee::all();
            $data['title'] = 'Laporan ' . ucwords(str_replace('_', ' ', $reportType));
            $data['period'] = $period;
            $data['date'] = now()->format('d M Y');

            if ($outputFormat === 'pdf') {
                $pdf = PDF::loadView('reports.employee', $data);
                return $pdf->stream('laporan_pegawai.pdf');
            } else {
                return Excel::download(new EmployeeExport($data['employees']), 'laporan_pegawai.xlsx');
            }
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal cetak laporan: ' . $e->getMessage());
        }
    }
}
