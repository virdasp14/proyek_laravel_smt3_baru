<?php

// ============================================
// DepartmentController.php
// ============================================

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    public function index()
    {
        $departments = Department::withCount('employees')->paginate(10);
        return view('departments.index', compact('departments'));
    }

    public function create()
    {
        return view('departments.create');
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'nama_departemen' => 'required|string|max:255',
                'kepala_departemen' => 'required|string|max:255',
                'deskripsi' => 'required|string',
                'status' => 'required|in:Aktif,Nonaktif'
            ]);

            Department::create($validated);

            return redirect()->back()->with('success', 'Departemen berhasil ditambahkan!');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menambahkan departemen: ' . $e->getMessage());
        }
    }

    public function show($id)
    {
        $department = Department::withCount('employees')->with('employees')->findOrFail($id);
        return view('departments.show', compact('department'));
    }

    public function edit($id)
    {
        $department = Department::findOrFail($id);
        return view('departments.edit', compact('department'));
    }

    public function update(Request $request, $id)
    {
        try {
            $department = Department::findOrFail($id);

            $validated = $request->validate([
                'nama_departemen' => 'required|string|max:255',
                'kepala_departemen' => 'required|string|max:255',
                'deskripsi' => 'required|string',
                'status' => 'required|in:Aktif,Nonaktif'
            ]);

            $department->update($validated);

            return redirect()->back()->with('success', 'Departemen berhasil diperbarui!');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal memperbarui departemen: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $department = Department::findOrFail($id);

            // Cek apakah ada pegawai di departemen ini
            if ($department->employees()->count() > 0) {
                return back()->with('error', 'Tidak dapat menghapus departemen yang masih memiliki pegawai!');
            }

            $department->delete();

            return redirect()->back()->with('success', 'Departemen berhasil dihapus!');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menghapus departemen: ' . $e->getMessage());
        }
    }
}
