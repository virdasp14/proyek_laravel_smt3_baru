<?php

namespace App\Http\Controllers;

use App\Models\Department; // <-- 1. Import Model
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // 2. Ambil data dan kirim ke view
        $departments = Department::latest()->paginate(10);
        return view('departments.index', compact('departments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // 3. Tampilkan form create
        return view('departments.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // 4. Validasi data
        $request->validate([
            'nama_department' => 'required|string|max:100|unique:departments',
        ]);

        // 5. Simpan data
        Department::create($request->all());

        // 6. Redirect ke index
        return redirect()->route('departments.index')
                         ->with('success', 'Department berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Department $department)
    {
        // 7. Tampilkan view show
        return view('departments.show', compact('department'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Department $department)
    {
        // 8. Tampilkan form edit
        return view('departments.edit', compact('department'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Department $department)
    {
        // 9. Validasi data
        $request->validate([
            'nama_department' => 'required|string|max:100|unique:departments,nama_department,' . $department->id,
        ]);

        // 10. Update data
        $department->update($request->all());

        // 11. Redirect ke index
        return redirect()->route('departments.index')
                         ->with('success', 'Department berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Department $department)
    {
        // 12. Hapus data
        $department->delete();

        // 13. Redirect ke index
        return redirect()->route('departments.index')
                         ->with('success', 'Department berhasil dihapus.');
    }
}
