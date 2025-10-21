<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #bfe8f9 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 40px 0;
        }

        .container {
            max-width: 1400px;
            background: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            padding: 40px;
            backdrop-filter: blur(10px);
            animation: fadeIn 0.6s ease-in;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        h1 {
            color: #01060f;
            font-weight: 700;
            font-size: 2.5rem;
            margin-bottom: 30px;
            text-align: center;
            position: relative;
            padding-bottom: 15px;
        }

        h1::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 100px;
            height: 4px;
            background: linear-gradient(90deg, #667eea, #764ba2);
            border-radius: 2px;
        }

        table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
        }

        thead {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        thead tr th {
            color: white;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.85rem;
            letter-spacing: 1px;
            padding: 18px 15px;
            text-align: left;
            border: none;
        }

        tbody tr {
            transition: all 0.3s ease;
            border-bottom: 1px solid #e2e8f0;
        }

        tbody tr:hover {
            background: linear-gradient(90deg, #f7fafc 0%, #edf2f7 100%);
            transform: scale(1.01);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.1);
        }

        tbody tr:last-child {
            border-bottom: none;
        }

        tbody td {
            padding: 16px 15px;
            color: #4a5568;
            font-size: 0.95rem;
            vertical-align: middle;
        }

        tbody td:first-child {
            font-weight: 600;
            color: #2d3748;
        }

        a {
            color: #000508;
            text-decoration: none;
            font-weight: 500;
            padding: 6px 12px;
            border-radius: 6px;
            transition: all 0.3s ease;
            display: inline-block;
        }

        a:hover {
            background: #667eea;
            color: rgb(255, 255, 255);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(61, 90, 215, 0.4);
        }

        button {
            background: linear-gradient(135deg, #fc5c7d, #6a82fb);
            color: rgb(255, 255, 255);
            border: none;
            padding: 6px 14px;
            border-radius: 6px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: 0.9rem;
        }

        button:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(252, 92, 125, 0.4);
            background: linear-gradient(135deg, #6a82fb, #fc5c7d);
        }

        button:active {
            transform: translateY(0);
        }

        form {
            display: inline;
            margin: 0;
        }

        /* Status styling */
        tbody td:nth-child(7) {
            font-weight: 600;
        }

        /* Action column styling */
        tbody td:last-child {
            white-space: nowrap;
        }

        /* Responsive design */
        @media (max-width: 1200px) {
            .container {
                padding: 30px 20px;
            }

            table {
                font-size: 0.85rem;
            }

            h1 {
                font-size: 2rem;
            }
        }

        @media (max-width: 768px) {
            .container {
                padding: 20px 15px;
                border-radius: 15px;
            }

            h1 {
                font-size: 1.75rem;
            }

            table {
                font-size: 0.8rem;
            }

            thead tr th,
            tbody td {
                padding: 12px 8px;
            }

            a, button {
                padding: 5px 10px;
                font-size: 0.85rem;
            }
        }

        /* Separator between actions */
        tbody td:last-child {
            color: #cbd5e0;
        }

        /* Icon styling for actions (optional enhancement) */
        .action-separator {
            color: #cbd5e0;
            margin: 0 5px;
        }
    </style>
</head>
<body>
@extends('employees.master')
@section('title', 'Daftar Pegawai')
@section('content')
    <div class="container mt-5">
        <h1 class="mb-4">Daftar Pegawai</h1>
        <table border="1" cellpadding="5" cellspacing="0">
            <thead>
                <tr>
                    <th>Nama Lengkap</th>
                    <th>Email</th>
                    <th>Nomor Telepon</th>
                    <th>Tanggal Lahir</th>
                    <th>Alamat</th>
                    <th>Tanggal Masuk</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($employees as $employee)
                <tr>
                    <td>{{ $employee->nama_lengkap }}</td>
                    <td>{{ $employee->email }}</td>
                    <td>{{ $employee->nomor_telepon }}</td>
                    <td>{{ $employee->tanggal_lahir }}</td>
                    <td>{{ $employee->alamat }}</td>
                    <td>{{ $employee->tanggal_masuk }}</td>
                    <td>{{ $employee->status }}</td>
                    <td>
                        <a href="{{ route('employees.show', $employee->id) }}">Detail</a> |
                        <a href="{{ route('employees.edit', $employee->id) }}">Edit</a> |
                        <form action="{{ route('employees.destroy', $employee->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('Yakin ingin menghapus?')">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
