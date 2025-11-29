<!-- ============================================ -->
<!-- payroll/edit.blade.php - Edit Penggajian -->
<!-- ============================================ -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Penggajian</title>
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

        .total-display {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            padding: 20px;
            border-radius: 15px;
            text-align: center;
            margin: 25px 0;
        }

        .total-display h3 {
            font-size: 0.9rem;
            margin-bottom: 10px;
            opacity: 0.9;
        }

        .total-display .amount {
            font-size: 2.5rem;
            font-weight: 800;
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
    </style>
</head>
<body>
    <div class="container">
        <a href="{{ route('payroll.index') }}" class="btn-back">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>

        <h1><i class="fas fa-edit"></i> Edit Penggajian</h1>

        @if($errors->any())
            <div class="alert alert-danger">
                <ul style="margin:0;padding-left:20px;">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('payroll.update', $payroll->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label><i class="fas fa-user"></i> Nama Pegawai</label>
                <input type="text" value="{{ $payroll->employee->nama_lengkap }}" readonly style="background:#f7fafc;cursor:not-allowed;">
            </div>

            <div class="form-group">
                <label><i class="fas fa-money-bill"></i> Gaji Pokok (Rp) *</label>
                <input type="number" name="gaji_pokok" id="gajiPokok" value="{{ old('gaji_pokok', $payroll->gaji_pokok) }}" required min="0" step="1000" onchange="hitungTotal()">
            </div>

            <div class="form-group">
                <label><i class="fas fa-plus-circle"></i> Tunjangan (Rp)</label>
                <input type="number" name="tunjangan" id="tunjangan" value="{{ old('tunjangan', $payroll->tunjangan) }}" min="0" step="1000" onchange="hitungTotal()">
            </div>

            <div class="form-group">
                <label><i class="fas fa-minus-circle"></i> Potongan (Rp)</label>
                <input type="number" name="potongan" id="potongan" value="{{ old('potongan', $payroll->potongan) }}" min="0" step="1000" onchange="hitungTotal()">
            </div>

            <div class="total-display">
                <h3><i class="fas fa-wallet"></i> TOTAL GAJI BERSIH</h3>
                <div class="amount" id="totalGaji">Rp 0</div>
            </div>

            <div class="form-group">
                <label><i class="fas fa-info-circle"></i> Status Pembayaran *</label>
                <select name="status_pembayaran" required>
                    <option value="pending" {{ $payroll->status_pembayaran == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="dibayar" {{ $payroll->status_pembayaran == 'dibayar' ? 'selected' : '' }}>Dibayar</option>
                </select>
            </div>

            <div class="form-group">
                <label><i class="fas fa-sticky-note"></i> Keterangan</label>
                <textarea name="keterangan" rows="3" placeholder="Catatan tambahan...">{{ old('keterangan', $payroll->keterangan) }}</textarea>
            </div>

            <button type="submit" class="btn-submit">
                <i class="fas fa-save"></i> Simpan Perubahan
            </button>
        </form>
    </div>

    <script>
        function hitungTotal() {
            const gaji = parseFloat(document.getElementById('gajiPokok').value) || 0;
            const tunjangan = parseFloat(document.getElementById('tunjangan').value) || 0;
            const potongan = parseFloat(document.getElementById('potongan').value) || 0;
            const total = gaji + tunjangan - potongan;
            document.getElementById('totalGaji').textContent = 'Rp ' + total.toLocaleString('id-ID');
        }

        // Hitung total saat halaman dimuat
        window.onload = function() {
            hitungTotal();
        }
    </script>
</body>
</html>
