<!-- ============================================ -->
<!-- leave/edit.blade.php - Edit Cuti/Izin -->
<!-- ============================================ -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Cuti/Izin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 30px 0;
        }

        .container {
            max-width: 800px;
            background: rgba(255, 255, 255, 0.98);
            border-radius: 25px;
            box-shadow: 0 25px 70px rgba(0, 0, 0, 0.3);
            padding: 40px;
            animation: fadeIn 0.6s ease-in;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }

        h1 {
            color: #1a202c;
            font-weight: 800;
            font-size: 2.5rem;
            margin-bottom: 30px;
            text-align: center;
            background: linear-gradient(135deg, #667eea, #764ba2);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .form-group {
            margin-bottom: 25px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: #2d3748;
            font-weight: 600;
            font-size: 0.95rem;
        }

        .form-group input,
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #e2e8f0;
            border-radius: 10px;
            font-size: 0.95rem;
            transition: all 0.3s ease;
        }

        .form-group input:focus,
        .form-group select:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        .form-group textarea {
            resize: vertical;
            min-height: 100px;
        }

        .btn-submit {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            border: none;
            padding: 14px 30px;
            border-radius: 10px;
            font-weight: 600;
            font-size: 1rem;
            cursor: pointer;
            width: 100%;
            transition: all 0.3s ease;
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(102, 126, 234, 0.4);
        }

        .btn-back {
            background: linear-gradient(135deg, #718096, #4a5568);
            color: white;
            padding: 12px 24px;
            border-radius: 10px;
            text-decoration: none;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 20px;
        }

        .btn-back:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(113, 128, 150, 0.4);
            color: white;
        }

        .alert {
            padding: 15px 20px;
            border-radius: 10px;
            margin-bottom: 20px;
        }

        .alert-danger {
            background: #fee;
            color: #c53030;
            border: 1px solid #fc8181;
        }

        .info-box {
            background: #e6fffa;
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 20px;
            border-left: 4px solid #48bb78;
        }

        .info-box p {
            margin: 0;
            color: #2d3748;
        }
    </style>
</head>
<body>
    <div class="container">
        <a href="{{ route('leave.index') }}" class="btn-back">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>

        <h1><i class="fas fa-edit"></i> Edit Cuti/Izin</h1>

        @if($errors->any())
            <div class="alert alert-danger">
                <ul style="margin:0;padding-left:20px;">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="info-box">
            <p><i class="fas fa-info-circle"></i> <strong>Catatan:</strong> Hanya pengajuan dengan status "Pending" yang dapat diedit.</p>
        </div>

        <form action="{{ route('leave.update', $leave->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label><i class="fas fa-user"></i> Nama Pegawai</label>
                <input type="text" value="{{ $leave->employee->nama_lengkap }}" readonly style="background:#f7fafc;cursor:not-allowed;">
            </div>

            <div class="form-group">
                <label><i class="fas fa-list"></i> Jenis Cuti/Izin *</label>
                <select name="jenis" required>
                    <option value="">Pilih Jenis</option>
                    <option value="cuti_tahunan" {{ $leave->jenis == 'cuti_tahunan' ? 'selected' : '' }}>Cuti Tahunan</option>
                    <option value="cuti_sakit" {{ $leave->jenis == 'cuti_sakit' ? 'selected' : '' }}>Cuti Sakit</option>
                    <option value="izin_pribadi" {{ $leave->jenis == 'izin_pribadi' ? 'selected' : '' }}>Izin Pribadi</option>
                    <option value="cuti_melahirkan" {{ $leave->jenis == 'cuti_melahirkan' ? 'selected' : '' }}>Cuti Melahirkan</option>
                    <option value="cuti_menikah" {{ $leave->jenis == 'cuti_menikah' ? 'selected' : '' }}>Cuti Menikah</option>
                </select>
            </div>

            <div class="form-group">
                <label><i class="fas fa-calendar-day"></i> Tanggal Mulai *</label>
                <input type="date" name="tanggal_mulai" id="tanggalMulai" value="{{ old('tanggal_mulai', \Carbon\Carbon::parse($leave->tanggal_mulai)->format('Y-m-d')) }}" required onchange="hitungHari()">
            </div>

            <div class="form-group">
                <label><i class="fas fa-calendar-day"></i> Tanggal Selesai *</label>
                <input type="date" name="tanggal_selesai" id="tanggalSelesai" value="{{ old('tanggal_selesai', \Carbon\Carbon::parse($leave->tanggal_selesai)->format('Y-m-d')) }}" required onchange="hitungHari()">
            </div>

            <div class="form-group">
                <label><i class="fas fa-calculator"></i> Jumlah Hari (Otomatis)</label>
                <input type="text" id="jumlahHari" readonly style="background:#f7fafc;font-weight:700;" value="{{ $leave->jumlah_hari }} Hari">
            </div>

            <div class="form-group">
                <label><i class="fas fa-comment"></i> Alasan *</label>
                <textarea name="alasan" placeholder="Jelaskan alasan pengajuan cuti/izin..." required>{{ old('alasan', $leave->alasan) }}</textarea>
            </div>

            <button type="submit" class="btn-submit">
                <i class="fas fa-save"></i> Simpan Perubahan
            </button>
        </form>
    </div>

    <script>
        function hitungHari() {
            const mulai = new Date(document.getElementById('tanggalMulai').value);
            const selesai = new Date(document.getElementById('tanggalSelesai').value);

            if (mulai && selesai && selesai >= mulai) {
                const diffTime = Math.abs(selesai - mulai);
                const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24)) + 1;
                document.getElementById('jumlahHari').value = diffDays + ' Hari';
            }
        }

        // Hitung hari saat halaman dimuat
        window.onload = function() {
            hitungHari();
        }
    </script>
</body>
</html>
