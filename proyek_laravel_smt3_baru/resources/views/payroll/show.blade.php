<!-- ============================================ -->
<!-- payroll/show.blade.php - Detail Penggajian -->
<!-- ============================================ -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Penggajian - {{ $payroll->employee->nama_lengkap }}</title>
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
            max-width: 900px;
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

        .detail-card {
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        .detail-row {
            display: flex;
            justify-content: space-between;
            padding: 15px 0;
            border-bottom: 1px solid #e2e8f0;
        }

        .detail-row:last-child {
            border-bottom: none;
        }

        .detail-label {
            font-weight: 600;
            color: #4a5568;
        }

        .detail-value {
            color: #2d3748;
            font-weight: 700;
        }

        .total-section {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            padding: 25px;
            border-radius: 15px;
            margin-top: 20px;
            text-align: center;
        }

        .total-section h3 {
            font-size: 1rem;
            margin-bottom: 10px;
            opacity: 0.9;
        }

        .total-section .amount {
            font-size: 3rem;
            font-weight: 800;
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
        }

        .btn-back:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(113, 128, 150, 0.4);
            color: white;
        }

        .badge {
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 0.9rem;
            font-weight: 600;
        }

        .badge-dibayar {
            background: linear-gradient(135deg, #48bb78, #38a169);
            color: white;
        }

        .badge-pending {
            background: linear-gradient(135deg, #ed8936, #dd6b20);
            color: white;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1><i class="fas fa-file-invoice-dollar"></i> Detail Penggajian</h1>

        <div class="detail-card">
            <div class="detail-row">
                <span class="detail-label"><i class="fas fa-user"></i> Nama Pegawai</span>
                <span class="detail-value">{{ $payroll->employee->nama_lengkap }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label"><i class="fas fa-envelope"></i> Email</span>
                <span class="detail-value">{{ $payroll->employee->email }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label"><i class="fas fa-briefcase"></i> Jabatan</span>
                <span class="detail-value">Staff</span>
            </div>
            <div class="detail-row">
                <span class="detail-label"><i class="fas fa-calendar"></i> Periode</span>
                <span class="detail-value">{{ \Carbon\Carbon::parse($payroll->periode)->format('F Y') }}</span>
            </div>
        </div>

        <div class="detail-card">
            <h4 style="color:#2d3748;margin-bottom:20px;"><i class="fas fa-calculator"></i> Rincian Gaji</h4>
            <div class="detail-row">
                <span class="detail-label">Gaji Pokok</span>
                <span class="detail-value">Rp {{ number_format($payroll->gaji_pokok, 0, ',', '.') }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label" style="color:#48bb78;"><i class="fas fa-plus-circle"></i> Tunjangan</span>
                <span class="detail-value" style="color:#48bb78;">+ Rp {{ number_format($payroll->tunjangan, 0, ',', '.') }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label" style="color:#f56565;"><i class="fas fa-minus-circle"></i> Potongan</span>
                <span class="detail-value" style="color:#f56565;">- Rp {{ number_format($payroll->potongan, 0, ',', '.') }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label"><i class="fas fa-info-circle"></i> Status Pembayaran</span>
                <span class="badge badge-{{ $payroll->status_pembayaran }}">
                    {{ ucfirst($payroll->status_pembayaran) }}
                </span>
            </div>
            @if($payroll->keterangan)
            <div class="detail-row">
                <span class="detail-label"><i class="fas fa-sticky-note"></i> Keterangan</span>
                <span class="detail-value">{{ $payroll->keterangan }}</span>
            </div>
            @endif
        </div>

        <div class="total-section">
            <h3><i class="fas fa-wallet"></i> TOTAL GAJI BERSIH</h3>
            <div class="amount">Rp {{ number_format($payroll->total_gaji, 0, ',', '.') }}</div>
        </div>

        <div style="margin-top:30px;display:flex;gap:15px;justify-content:center;">
            <a href="{{ route('payroll.index') }}" class="btn-back">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
            <a href="{{ route('payroll.edit', $payroll->id) }}" class="btn-back" style="background: linear-gradient(135deg, #667eea, #764ba2);">
                <i class="fas fa-edit"></i> Edit
            </a>
        </div>
    </div>
</body>
</html>
