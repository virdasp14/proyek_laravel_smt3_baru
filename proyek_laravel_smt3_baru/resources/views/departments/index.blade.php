<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        :root {
            --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --secondary-gradient: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            --success-gradient: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        }

        body {
            background: linear-gradient(135deg, #bbbcbe 0%, #764ba2 100%);
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            padding-bottom: 50px;
        }

        .container {
            animation: fadeIn 0.6s ease-out;
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

        .d-flex.justify-content-between {
            background: rgba(255, 255, 255, 0.95);
            padding: 25px 30px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            backdrop-filter: blur(10px);
        }

        h1 {
            color: #35424f;
            font-weight: 700;
            font-size: 2rem;
            margin: 0;
            position: relative;
            padding-left: 15px;
        }

        h1::before {
            content: '';
            position: absolute;
            left: 0;
            top: 50%;
            transform: translateY(-50%);
            width: 5px;
            height: 35px;
            background: var(--primary-gradient);
            border-radius: 3px;
        }

        .btn-primary {
            background: var(--primary-gradient);
            border: none;
            padding: 10px 25px;
            border-radius: 10px;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
        }

        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.5);
        }

        .alert-success {
            background: linear-gradient(135deg, #d4fc79 0%, #96e6a1 100%);
            border: none;
            border-radius: 12px;
            color: #155724;
            font-weight: 500;
            box-shadow: 0 5px 15px rgba(150, 230, 161, 0.3);
            animation: slideDown 0.5s ease-out;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .card {
            background: rgba(252, 251, 251, 0.98);
            border-radius: 20px;
            border: none;
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
            overflow: hidden;
        }

        .card-body {
            padding: 30px;
        }

        .table {
            margin-bottom: 0;
        }

        .table-light {
            background: var(--primary-gradient);
        }

        .table-light th {
            color: rgb(8, 8, 8);
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.85rem;
            letter-spacing: 0.5px;
            padding: 18px 15px;
            border: none;
        }

        .table tbody tr {
            transition: all 0.3s ease;
            border-bottom: 1px solid #e9ecef;
        }

        .table tbody tr:hover {
            background: linear-gradient(90deg, #f7fafc 0%, #edf2f7 100%);
            transform: scale(1.01);
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.1);
        }

        .table tbody tr:last-child {
            border-bottom: none;
        }

        .table tbody td {
            padding: 18px 15px;
            vertical-align: middle;
            color: #4a5568;
            font-size: 0.95rem;
        }

        .table tbody td:nth-child(1) {
            font-weight: 600;
            color: #06070b;
            font-size: 1rem;
        }

        .table tbody td:nth-child(2) {
            font-weight: 600;
            color: #2d3748;
        }

        .btn-info {
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            border: none;
            color: white;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .btn-info:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(79, 172, 254, 0.4);
            color: white;
        }

        .btn-warning {
            background: linear-gradient(135deg, #ffd89b 0%, #19547b 100%);
            border: none;
            color: white;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .btn-warning:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(255, 193, 7, 0.4);
            color: white;
        }

        .btn-danger {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            border: none;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .btn-danger:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(220, 53, 69, 0.4);
        }

        .btn-sm {
            padding: 6px 15px;
            border-radius: 8px;
            font-size: 0.875rem;
        }

        .d-flex.gap-2 {
            gap: 8px !important;
        }

        /* Empty state styling */
        .text-center {
            color: #718096;
            font-style: italic;
            padding: 40px 0;
        }

        /* Pagination styling */
        .pagination {
            margin-top: 20px;
        }

        .pagination .page-link {
            color: #fdfdfe;
            border: 2px solid #e2e8f0;
            border-radius: 8px;
            margin: 0 4px;
            padding: 8px 16px;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .pagination .page-link:hover {
            background: var(--primary-gradient);
            color: rgb(8, 8, 8);
            border-color: transparent;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
        }

        .pagination .page-item.active .page-link {
            background: var(--primary-gradient);
            border-color: transparent;
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
        }

        /* Icon styling */
        .bi {
            font-size: 1rem;
            vertical-align: middle;
        }

        /* Responsive design */
        @media (max-width: 768px) {
            .d-flex.justify-content-between {
                flex-direction: column;
                gap: 15px;
                text-align: center;
            }

            h1 {
                font-size: 1.5rem;
                padding-left: 0;
            }

            h1::before {
                display: none;
            }

            .card-body {
                padding: 20px 15px;
            }

            .table-light th,
            .table tbody td {
                padding: 12px 10px;
                font-size: 0.85rem;
            }

            .btn-sm {
                font-size: 0.8rem;
                padding: 5px 10px;
            }

            .d-flex.gap-2 {
                flex-wrap: wrap;
            }
        }

        @media (max-width: 576px) {
            .d-flex.gap-2 {
                flex-direction: column;
            }

            .d-flex.gap-2 .btn {
                width: 100%;
            }

            h1 {
                font-size: 1.25rem;
            }

            .table {
                font-size: 0.8rem;
            }
        }

        /* Loading animation for buttons */
        .btn:active {
            transform: scale(0.98);
        }

        /* Alert close button */
        .btn-close {
            filter: brightness(0) invert(1);
        }

        /* Table responsive wrapper */
        .table-responsive {
            border-radius: 12px;
            overflow: hidden;
        }
    </style>
</head>

<body>
    @extends('employees.master')

    @section('title', 'Daftar Department')

    @section('content')
        <div class="container mt-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1>Daftar Department</h1>
                <a href="{{ route('departments.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle"></i> Tambah Department
                </a>
            </div>

            @if ($message = Session::get('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ $message }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Nama Department</th>
                                    <th scope="col" style="width: 20%;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($departments as $index => $department)
                                    <tr>
                                        <td>{{ $departments->firstItem() + $index }}</td>
                                        <td>{{ $department->nama_departemen }}</td>
                                        <td>
                                            <form action="{{ route('departments.destroy', $department->id) }}"
                                                method="POST" class="d-flex gap-2">
                                                <a href="{{ route('departments.show', $department->id) }}"
                                                    class="btn btn-info btn-sm">
                                                    <i class="bi bi-eye"></i> Detail
                                                </a>
                                                <a href="{{ route('departments.edit', $department->id) }}"
                                                    class="btn btn-warning btn-sm">
                                                    <i class="bi bi-pencil-square"></i> Edit
                                                </a>
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm"
                                                    onclick="return confirm('Yakin ingin menghapus department ini?')">
                                                    <i class="bi bi-trash"></i> Delete
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center">
                                            Data department masih kosong.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex justify-content-center">
                        {!! $departments->links() !!}
                    </div>
                </div>
            </div>
        </div>
    @endsection

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
