<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Pegawai</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            font-family: 'Poppins', sans-serif;
            color: #333;
            min-height: 100vh;
            padding: 40px 0;
        }

        h1 {
            color: #1e293b;
            font-weight: 700;
            text-align: center;
            margin-bottom: 40px;
            position: relative;
        }

        h1::after {
            content: "";
            display: block;
            width: 120px;
            height: 4px;
            background: linear-gradient(to right, #6366f1, #8b5cf6);
            margin: 10px auto 0;
            border-radius: 2px;
        }

        table {
            background-color: #ffffff;
            border-collapse: collapse;
            margin: 0 auto;
            width: 70%;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }

        th {
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            color: #fff;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            padding: 15px;
            width: 30%;
        }

        td {
            padding: 15px;
            background-color: #fafafa;
        }

        tr:nth-child(even) td {
            background-color: #f1f1ff;
        }

        tr:last-child td {
            border-bottom: none;
        }

        .card-container {
            background: #f8fafc;
            margin: 0 auto;
            width: 85%;
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
        }

        .btn-back {
            display: block;
            margin: 30px auto 0;
            background: linear-gradient(90deg, #6366f1, #8b5cf6);
            color: white;
            border: none;
            padding: 10px 25px;
            border-radius: 8px;
            font-weight: 500;
            transition: all 0.3s;
        }

        .btn-back:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 12px rgba(99, 102, 241, 0.4);
        }
    </style>
</head>

<body>
    <div class="card-container">
        <h1>Detail Pegawai</h1>
        <table border="1" cellpadding="8" cellspacing="0">
            <tr>
                <th>Nama Lengkap</th>
                <td>{{ $employee->nama_lengkap }}</td>
            </tr>
            <tr>
                <th>Email</th>
                <td>{{ $employee->email }}</td>
            </tr>
            <tr>
                <th>Nomor Telepon</th>
                <td>{{ $employee->nomor_telepon }}</td>
            </tr>
            <tr>
                <th>Tanggal Lahir</th>
                <td>{{ $employee->tanggal_lahir }}</td>
            </tr>
            <tr>
                <th>Alamat</th>
                <td>{{ $employee->alamat }}</td>
            </tr>
            <tr>
                <th>Tanggal Masuk</th>
                <td>{{ $employee->tanggal_masuk }}</td>
            </tr>
            <tr>
                <th>Status</th>
                <td>
                    @if ($employee->status == 'Aktif')
                        <span class="badge bg-success">Aktif</span>
                    @elseif($employee->status == 'Cuti')
                        <span class="badge bg-warning">Cuti</span>
                    @else
                        <span class="badge bg-secondary">Nonaktif</span>
                    @endif
                </td>
            </tr>
        </table>

        <a href="{{ route('employees.index') }}" class="btn-back">← Kembali ke Daftar Pegawai</a>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
