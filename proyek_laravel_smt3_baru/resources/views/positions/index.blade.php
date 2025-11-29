@extends('employees.master')

@section('title', 'Daftar Jabatan')

@section('content')
    <style>
        .positions-container {
            padding: 40px 0;
        }

        .page-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 20px;
            padding: 40px;
            color: white;
            box-shadow: 0 10px 30px rgba(102, 126, 234, 0.3);
            margin-bottom: 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .page-header h1 {
            font-size: 2.5rem;
            font-weight: 800;
            margin: 0;
        }

        .btn-add {
            background: white;
            color: #667eea;
            padding: 12px 30px;
            border-radius: 10px;
            font-weight: 600;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            transition: all 0.3s ease;
            border: none;
        }

        .btn-add:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(255, 255, 255, 0.3);
            color: #764ba2;
        }

        .table-card {
            background: white;
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
        }

        .table {
            margin-bottom: 0;
        }

        .table thead th {
            background: linear-gradient(135deg, #f7fafc, #edf2f7);
            color: #2d3748;
            font-weight: 700;
            text-transform: uppercase;
            font-size: 0.85rem;
            letter-spacing: 0.5px;
            border: none;
            padding: 18px 15px;
        }

        .table tbody td {
            padding: 18px 15px;
            vertical-align: middle;
            border-bottom: 1px solid #f0f0f0;
            color: #2d3748;
        }

        .table tbody tr:last-child td {
            border-bottom: none;
        }

        .table tbody tr:hover {
            background: #f7fafc;
        }

        .position-name {
            font-weight: 600;
            color: #1a202c;
            font-size: 1.05rem;
        }

        .position-salary {
            font-weight: 600;
            color: #667eea;
        }

        .action-buttons {
            display: flex;
            gap: 8px;
        }

        .btn-action {
            width: 38px;
            height: 38px;
            border-radius: 8px;
            border: none;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
            cursor: pointer;
            font-size: 0.9rem;
        }

        .btn-action:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .btn-view {
            background: linear-gradient(135deg, #4facfe, #00f2fe);
            color: white;
        }

        .btn-edit {
            background: linear-gradient(135deg, #f093fb, #f5576c);
            color: white;
        }

        .btn-delete {
            background: linear-gradient(135deg, #fa709a, #fee140);
            color: white;
        }

        .alert {
            border-radius: 12px;
            border: none;
            padding: 16px 20px;
            margin-bottom: 25px;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .alert-success {
            background: linear-gradient(135deg, #d4fc79, #96e6a1);
            color: #155724;
        }

        .pagination {
            margin-top: 25px;
        }

        .empty-state {
            text-align: center;
            padding: 60px 20px;
        }

        .empty-state i {
            font-size: 4rem;
            color: #cbd5e0;
            margin-bottom: 20px;
        }
    </style>

    <div class="positions-container">
        <div class="container">
            <!-- Header -->
            <div class="page-header">
                <h1><i class="fas fa-briefcase"></i> Daftar Jabatan</h1>
                <a href="{{ route('positions.create') }}" class="btn-add">
                    <i class="fas fa-plus-circle"></i> Tambah Jabatan
                </a>
            </div>

            <!-- Alert Success -->
            @if ($message = Session::get('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle"></i>
                    <span>{{ $message }}</span>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <!-- Table -->
            <div class="table-card">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th style="width: 5%;">#</th>
                                <th style="width: 35%;">Nama Jabatan</th>
                                <th style="width: 35%;">Gaji Pokok</th>
                                <th style="width: 25%;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($positions as $index => $position)
                                <tr>
                                    <td>{{ $positions->firstItem() + $index }}</td>
                                    <td>
                                        <span class="position-name">{{ $position->nama_jabatan }}</span>
                                    </td>
                                    <td>
                                        <span class="position-salary">Rp
                                            {{ number_format($position->gaji_pokok, 0, ',', '.') }}</span>
                                    </td>
                                    <td>
                                        <div class="action-buttons">
                                            <a href="{{ route('positions.show', $position->id) }}"
                                                class="btn-action btn-view" title="Lihat Detail">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('positions.edit', $position->id) }}"
                                                class="btn-action btn-edit" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('positions.destroy', $position->id) }}" method="POST"
                                                style="display: inline;"
                                                onsubmit="return confirm('Yakin ingin menghapus jabatan {{ $position->nama_jabatan }}?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn-action btn-delete" title="Hapus">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4">
                                        <div class="empty-state">
                                            <i class="fas fa-briefcase"></i>
                                            <h4 class="text-muted mb-3">Belum Ada Jabatan</h4>
                                            <p class="text-muted">Silakan tambahkan jabatan baru untuk memulai.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if ($positions->hasPages())
                    <div class="d-flex justify-content-center">
                        {!! $positions->links() !!}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
