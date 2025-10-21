<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Data Absensi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            min-height: 100vh;
            font-family: 'Poppins', sans-serif;
            color: #333;
        }
        .container {
            background: #fff;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
            margin-top: 50px;
        }
        h1 {
            text-align: center;
            color: #1e293b;
            font-weight: 700;
            margin-bottom: 30px;
        }
        h1::after {
            content: "";
            display: block;
            width: 100px;
            height: 4px;
            background: linear-gradient(to right, #6366f1, #8b5cf6);
            margin: 10px auto 0;
            border-radius: 2px;
        }
        .btn-gradient {
            background: linear-gradient(90deg, #6366f1, #8b5cf6);
            color: white !important;
            border: none;
            border-radius: 8px;
            padding: 8px 15px;
        }
        .btn-gradient:hover {
            opacity: 0.9;
        }
    </style>
</head>
<body>
<div class="container">
    <h1>Data Absensi Karyawan</h1>

    <a href="{{ route('attendance.create') }}" class="btn btn-gradient mb-3">+ Tambah Data</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered table-striped text-center align-middle">
        <thead class="table-primary">
            <tr>
                <th>Nama Karyawan</th>
                <th>Tanggal</th>
                <th>Waktu Masuk</th>
                <th>Waktu Keluar</th>
                <th>Status Absensi</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($attendances as $a)
            <tr>
                <td>{{ $a->employee->nama_lengkap }}</td>
                <td>{{ $a->tanggal }}</td>
                <td>{{ $a->waktu_masuk ?? '-' }}</td>
                <td>{{ $a->waktu_keluar ?? '-' }}</td>
                <td>
                    @if($a->status_absensi == 'hadir')
                        <span class="badge bg-success">Hadir</span>
                    @elseif($a->status_absensi == 'izin')
                        <span class="badge bg-warning text-dark">Izin</span>
                    @elseif($a->status_absensi == 'sakit')
                        <span class="badge bg-info text-dark">Sakit</span>
                    @else
                        <span class="badge bg-danger">Alpha</span>
                    @endif
                </td>
                <td>
                    <a href="{{ route('attendance.show', $a->id) }}" class="btn btn-info btn-sm text-white">Detail</a>
                    <a href="{{ route('attendance.edit', $a->id) }}" class="btn btn-warning btn-sm text-white">Edit</a>
                    <form action="{{ route('attendance.destroy', $a->id) }}" method="POST" style="display:inline;">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus data ini?')">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
</body>
</html>
