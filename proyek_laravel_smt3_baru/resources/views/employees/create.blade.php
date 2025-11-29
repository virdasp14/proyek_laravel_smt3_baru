<!DOCTYPE html>
<html>

<head>
    <title>Form Input Pegawai</title>
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

        .form-wrapper {
            background: rgba(255, 255, 255, 0.98);
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            padding: 45px;
            max-width: 750px;
            width: 100%;
            backdrop-filter: blur(10px);
            animation: fadeInUp 0.6s ease-out;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        h1 {
            color: #2d3748;
            font-weight: 700;
            font-size: 2.2rem;
            margin-bottom: 35px;
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
            width: 90px;
            height: 4px;
            background: linear-gradient(90deg, #667eea, #764ba2);
            border-radius: 2px;
        }

        h1::before {
            content: '\f007';
            font-family: "Font Awesome 6 Free";
            font-weight: 900;
            margin-right: 12px;
            color: #667eea;
        }

        form {
            width: 100%;
        }

        table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0 18px;
        }

        table tr td {
            padding: 8px 0;
            vertical-align: top;
        }

        table tr td:first-child {
            width: 180px;
            padding-right: 20px;
        }

        label {
            font-weight: 600;
            color: #4a5568;
            font-size: 0.95rem;
            display: block;
            margin-bottom: 5px;
        }

        label::before {
            font-family: "Font Awesome 6 Free";
            font-weight: 900;
            margin-right: 8px;
            color: #667eea;
        }

        label[for="nama_lengkap"]::before {
            content: '\f007';
            /* user */
        }

        label[for="email"]::before {
            content: '\f0e0';
            /* envelope */
        }

        label[for="nomor_telepon"]::before {
            content: '\f095';
            /* phone */
        }

        label[for="tanggal_lahir"]::before {
            content: '\f1fd';
            /* birthday cake */
        }

        label[for="alamat"]::before {
            content: '\f3c5';
            /* map marker */
        }

        label[for="tanggal_masuk"]::before {
            content: '\f133';
            /* calendar */
        }

        label[for="status"]::before {
            content: '\f058';
            /* check circle */
        }

        input[type="text"],
        input[type="email"],
        input[type="date"],
        select,
        textarea {
            width: 100%;
            padding: 12px 18px;
            border: 2px solid #e2e8f0;
            border-radius: 10px;
            font-size: 0.95rem;
            color: #2d3748;
            background: white;
            transition: all 0.3s ease;
            outline: none;
            font-family: inherit;
        }

        input[type="text"]:focus,
        input[type="email"]:focus,
        input[type="date"]:focus,
        select:focus,
        textarea:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
            transform: translateY(-2px);
        }

        input[type="text"]:hover,
        input[type="email"]:hover,
        input[type="date"]:hover,
        select:hover,
        textarea:hover {
            border-color: #cbd5e0;
        }

        textarea {
            min-height: 100px;
            resize: vertical;
            font-family: inherit;
        }

        select {
            cursor: pointer;
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%234a5568' d='M6 9L1 4h10z'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 15px center;
            padding-right: 45px;
        }

        button[type="submit"] {
            padding: 14px 40px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
            min-width: 160px;
        }

        button[type="submit"]:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.5);
            background: linear-gradient(135deg, #764ba2 0%, #667eea 100%);
        }

        button[type="submit"]:active {
            transform: translateY(-1px);
        }

        button[type="submit"]::before {
            content: '\f0c7';
            font-family: "Font Awesome 6 Free";
            font-weight: 900;
            margin-right: 8px;
        }

        /* Button container alignment */
        table tr:last-child td {
            padding-top: 25px;
        }

        /* Responsive design */
        @media (max-width: 768px) {
            .form-wrapper {
                padding: 30px 20px;
            }

            h1 {
                font-size: 1.75rem;
                margin-bottom: 30px;
            }

            table {
                border-spacing: 0 15px;
            }

            table tr td {
                display: block;
                width: 100%;
                padding: 5px 0;
            }

            table tr td:first-child {
                width: 100%;
                padding-right: 0;
                padding-bottom: 8px;
            }

            table tr:last-child td {
                text-align: center !important;
                padding-top: 20px;
            }

            button[type="submit"] {
                width: 100%;
            }

            input[type="text"],
            input[type="email"],
            input[type="date"],
            select,
            textarea {
                font-size: 16px;
                /* Prevents zoom on iOS */
            }
        }

        @media (max-width: 480px) {
            .form-wrapper {
                padding: 25px 15px;
            }

            h1 {
                font-size: 1.5rem;
                margin-bottom: 25px;
            }

            button[type="submit"] {
                padding: 12px 30px;
                font-size: 1rem;
            }
        }

        /* Animation for input fields */
        input[type="text"],
        input[type="email"],
        input[type="date"],
        select,
        textarea {
            animation: slideIn 0.5s ease-out backwards;
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateX(-20px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        table tr:nth-child(1) input {
            animation-delay: 0.1s;
        }

        table tr:nth-child(2) input {
            animation-delay: 0.15s;
        }

        table tr:nth-child(3) input {
            animation-delay: 0.2s;
        }

        table tr:nth-child(4) input {
            animation-delay: 0.25s;
        }

        table tr:nth-child(5) textarea {
            animation-delay: 0.3s;
        }

        table tr:nth-child(6) input {
            animation-delay: 0.35s;
        }

        table tr:nth-child(7) select {
            animation-delay: 0.4s;
        }

        table tr:nth-child(8) button {
            animation-delay: 0.45s;
        }
    </style>
</head>

<body>
    <div class="form-wrapper">
        <h1 class="mb-4">Form Pegawai</h1>

        @if ($errors->any())
            <div class="alert alert-danger"
                style="background: #fee; border: 2px solid #fcc; color: #c33; padding: 15px; border-radius: 10px; margin-bottom: 20px;">
                <strong>Error:</strong>
                <ul style="margin: 10px 0 0 20px;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('employees.store') }}" method="POST">
            @csrf
            <table>
                <tr>
                    <td><label for="nama_lengkap">Nama Lengkap:</label></td>
                    <td><input type="text" id="nama_lengkap" name="nama_lengkap" required
                            value="{{ old('nama_lengkap') }}"></td>
                </tr>
                <tr>
                    <td><label for="email">Email:</label></td>
                    <td><input type="email" id="email" name="email" required value="{{ old('email') }}"></td>
                </tr>
                <tr>
                    <td><label for="nomor_telepon">Nomor Telepon:</label></td>
                    <td><input type="text" id="nomor_telepon" name="nomor_telepon" required
                            value="{{ old('nomor_telepon') }}"></td>
                </tr>
                <tr>
                    <td><label for="tanggal_lahir">Tanggal Lahir:</label></td>
                    <td><input type="date" id="tanggal_lahir" name="tanggal_lahir" required
                            value="{{ old('tanggal_lahir') }}"></td>
                </tr>
                <tr>
                    <td><label for="alamat">Alamat:</label></td>
                    <td>
                        <textarea id="alamat" name="alamat" required>{{ old('alamat') }}</textarea>
                    </td>
                </tr>
                <tr>
                    <td><label for="tanggal_masuk">Tanggal Masuk:</label></td>
                    <td><input type="date" id="tanggal_masuk" name="tanggal_masuk" required
                            value="{{ old('tanggal_masuk') }}"></td>
                </tr>
                <tr>
                    <td><label for="status">Status:</label></td>
                    <td>
                        <select id="status" name="status" required>
                            <option value="">Pilih Status</option>
                            <option value="Aktif">Aktif</option>
                            <option value="Cuti">Cuti</option>
                            <option value="Nonaktif">Nonaktif</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" style="text-align:right;">
                        <button type="submit">Simpan</button>
                    </td>
                </tr>
            </table>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
