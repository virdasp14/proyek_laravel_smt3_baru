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
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px 20px;
        }

        .form-container {
            background: rgba(255, 255, 255, 0.98);
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            padding: 40px;
            max-width: 700px;
            width: 100%;
            backdrop-filter: blur(10px);
            animation: slideIn 0.5s ease-out;
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(-30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        h2 {
            color: #2d3748;
            font-weight: 700;
            font-size: 2rem;
            margin-bottom: 35px;
            text-align: center;
            position: relative;
            padding-bottom: 15px;
        }

        h2::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 80px;
            height: 4px;
            background: linear-gradient(90deg, #667eea, #764ba2);
            border-radius: 2px;
        }

        form {
            width: 100%;
        }

        table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0 15px;
        }

        table tr td {
            padding: 8px 0;
            vertical-align: middle;
        }

        table tr td:first-child {
            font-weight: 600;
            color: #4a5568;
            font-size: 0.95rem;
            padding-right: 20px;
            width: 180px;
        }

        input[type="text"],
        input[type="email"],
        input[type="date"],
        select {
            width: 100%;
            padding: 12px 18px;
            border: 2px solid #e2e8f0;
            border-radius: 10px;
            font-size: 0.95rem;
            color: #2d3748;
            background: white;
            transition: all 0.3s ease;
            outline: none;
        }

        input[type="text"]:focus,
        input[type="email"]:focus,
        input[type="date"]:focus,
        select:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
            transform: translateY(-2px);
        }

        input[type="text"]:hover,
        input[type="email"]:hover,
        input[type="date"]:hover,
        select:hover {
            border-color: #cbd5e0;
        }

        select {
            cursor: pointer;
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%234a5568' d='M6 9L1 4h10z'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 15px center;
            padding-right: 40px;
        }

        button[type="submit"] {
            width: 100%;
            padding: 14px 30px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 20px;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
        }

        button[type="submit"]:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.5);
            background: linear-gradient(135deg, #764ba2 0%, #667eea 100%);
        }

        button[type="submit"]:active {
            transform: translateY(-1px);
        }

        /* Icon enhancement */
        table tr td:first-child::before {
            font-family: "Font Awesome 6 Free";
            font-weight: 900;
            margin-right: 8px;
            color: #667eea;
        }

        table tr:nth-child(1) td:first-child::before {
            content: "\f007"; /* user icon */
        }

        table tr:nth-child(2) td:first-child::before {
            content: "\f0e0"; /* envelope icon */
        }

        table tr:nth-child(3) td:first-child::before {
            content: "\f095"; /* phone icon */
        }

        table tr:nth-child(4) td:first-child::before {
            content: "\f1fd"; /* birthday cake icon */
        }

        table tr:nth-child(5) td:first-child::before {
            content: "\f3c5"; /* map marker icon */
        }

        table tr:nth-child(6) td:first-child::before {
            content: "\f133"; /* calendar icon */
        }

        table tr:nth-child(7) td:first-child::before {
            content: "\f058"; /* check circle icon */
        }

        /* Responsive design */
        @media (max-width: 768px) {
            .form-container {
                padding: 30px 20px;
            }

            h2 {
                font-size: 1.75rem;
            }

            table {
                border-spacing: 0 12px;
            }

            table tr td {
                display: block;
                width: 100%;
                padding: 5px 0;
            }

            table tr td:first-child {
                padding-right: 0;
                padding-bottom: 8px;
                width: 100%;
            }

            input[type="text"],
            input[type="email"],
            input[type="date"],
            select {
                font-size: 16px; /* Prevents zoom on iOS */
            }
        }

        @media (max-width: 480px) {
            .form-container {
                padding: 25px 15px;
            }

            h2 {
                font-size: 1.5rem;
                margin-bottom: 25px;
            }

            button[type="submit"] {
                padding: 12px 25px;
                font-size: 1rem;
            }
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Edit Data Pegawai</h2>
        <form action="{{ route('employees.update', $employee->id) }}" method="POST">
            @csrf
            @method('PUT')
            <table>
                <tr>
                    <td>Nama Lengkap</td>
                    <td><input type="text" name="nama_lengkap" value="{{ old('nama_lengkap', $employee->nama_lengkap) }}"></td>
                </tr>
                <tr>
                    <td>Email</td>
                    <td><input type="email" name="email" value="{{ old('email', $employee->email) }}"></td>
                </tr>
                <tr>
                    <td>Nomor Telepon</td>
                    <td><input type="text" name="nomor_telepon" value="{{ old('nomor_telepon', $employee->nomor_telepon) }}"></td>
                </tr>
                <tr>
                    <td>Tanggal Lahir</td>
                    <td><input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir', $employee->tanggal_lahir) }}"></td>
                </tr>
                <tr>
                    <td>Alamat</td>
                    <td><input type="text" name="alamat" value="{{ old('alamat', $employee->alamat) }}"></td>
                </tr>
                <tr>
                    <td>Tanggal Masuk</td>
                    <td><input type="date" name="tanggal_masuk" value="{{ old('tanggal_masuk', $employee->tanggal_masuk) }}"></td>
                </tr>
                <tr>
                    <td>Status</td>
                    <td>
                        <select name="status">
                            <option value="aktif" {{ old('status', $employee->status) == 'aktif' ? 'selected' : '' }}>Aktif</option>
                            <option value="tidak aktif" {{ old('status', $employee->status) == 'tidak aktif' ? 'selected' : '' }}>Tidak
                            Aktif</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <button type="submit">Update</button>
                    </td>
                </tr>
            </table>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
