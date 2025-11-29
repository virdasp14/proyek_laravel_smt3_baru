<!-- ============================================ -->
<!-- leave/show.blade.php - Detail Cuti/Izin -->
<!-- ============================================ -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Cuti/Izin</title>
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

        .badge {
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 0.9rem;
            font-weight: 600;
        }

        .badge-pending {
            background: linear-gradient(135deg, #ed8936, #dd6b20);
            color: white;
        }

        .badge-disetujui {
            background: linear-gradient(135deg, #48bb78, #38a169);
            color: white;
        }

        .badge-ditolak {
            background: linear-gradient(135deg, #f56565, #e53e3e);
            color: white;
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

        .alasan-box {
            background: #f7fafc;
            padding: 20px;
            border-radius: 10px;
            margin-top: 20px;
            border-left: 4px solid #667eea;
        }

        .alasan-box h4 {
            color: #2d3748;
            margin-bottom: 10px;
            font-size: 1rem;
        }

        .alasan-box p {
            color: #4a5568;
            line-height: 1.6;
        }

        .dokumen-link {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 20px;
            background: #667eea;
            color: white;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .dokumen-link:hover {
            background: #5568d3;
            transform: translateY(-2px);
            color: white;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1><i class="fas fa-file-alt"></i> Detail Cuti/Izin</h1>

        <div class="detail-card">
            <div class="detail-row">
                <span class="detail-label"><i class="fas fa-user"></i> Nama Pegawai</span>
                <span class="detail-value">{{ $leave->employee->nama_lengkap }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label"><i class="fas fa-list"></i> Jenis Cuti/Izin</span>
                <span class="detail-value">{{ ucfirst(str_replace('_', ' ', $leave->jenis)) }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label"><i class="fas fa-calendar-day"></i> Tanggal Mulai</span>
                <span class="detail-value">{{ \Carbon\Carbon::parse($leave->tanggal_mulai)->format('d F Y') }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label"><i class="fas fa-calendar-day"></i> Tanggal Selesai</span>
                <span class="detail-value">{{ \Carbon\Carbon::parse($leave->tanggal_selesai)->format('d F Y') }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label"><i class="fas fa-calculator"></i> Jumlah Hari</span>
                <span class="detail-value">{{ $leave->jumlah_hari }} Hari</span>
            </div>
            <div class="detail-row">
                <span class="detail-label"><i class="fas fa-info-circle"></i> Status</span>
                <span class="badge badge-{{ $leave->status }}">{{ ucfirst($leave->status) }}</span>
            </div>
            @if($leave->dokumen)
            <div class="detail-row">
                <span class="detail-label"><i class="fas fa-file-pdf"></i> Dokumen Pendukung</span>
                <a href="{{ asset('uploads/leave/' . $leave->dokumen) }}" target="_blank" class="dokumen-link">
                    <i class="fas fa-download"></i> Download Dokumen
                </a>
            </div>
            @endif
        </div>

        <div class="alasan-box">
            <h4><i class="fas fa-comment"></i> Alasan Pengajuan</h4>
            <p>{{ $leave->alasan }}</p>
        </div>

        @if($leave->status == 'disetujui')
        <div class="detail-card" style="background: #e6fffa; border-left: 4px solid #48bb78;">
            <div class="detail-row">
                <span class="detail-label"><i class="fas fa-check-circle"></i> Disetujui Pada</span>
                <span class="detail-value">{{ $leave->approved_at ? \Carbon\Carbon::parse($leave->approved_at)->format('d F Y H:i') : '-' }}</span>
            </div>
        </div>
        @endif

        @if($leave->status == 'ditolak')
        <div class="detail-card" style="background: #fff5f5; border-left: 4px solid #f56565;">
            <div class="detail-row">
                <span class="detail-label"><i class="fas fa-times-circle"></i> Ditolak Pada</span>
                <span class="detail-value">{{ $leave->rejected_at ? \Carbon\Carbon::parse($leave->rejected_at)->format('d F Y H:i') : '-' }}</span>
            </div>
        </div>
        @endif

        <div style="margin-top:30px;display:flex;gap:15px;justify-content:center;flex-wrap:wrap;">
            <a href="{{ route('leave.index') }}" class="btn-back">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
            @if($leave->status == 'pending')
            <a href="{{ route('leave.edit', $leave->id) }}" class="btn-back" style="background: linear-gradient(135deg, #667eea, #764ba2);">
                <i class="fas fa-edit"></i> Edit
            </a>
            <form action="{{ route('leave.approve', $leave->id) }}" method="POST" style="display:inline;">
                @csrf
                <button type="submit" class="btn-back" style="background: linear-gradient(135deg, #48bb78, #38a169);border:none;cursor:pointer;" onclick="return confirm('Setujui pengajuan ini?')">
                    <i class="fas fa-check"></i> Setujui
                </button>
            </form>
            <form action="{{ route('leave.reject', $leave->id) }}" method="POST" style="display:inline;">
                @csrf
                <button type="submit" class="btn-back" style="background: linear-gradient(135deg, #f56565, #e53e3e);border:none;cursor:pointer;" onclick="return confirm('Tolak pengajuan ini?')">
                    <i class="fas fa-times"></i> Tolak
                </button>
            </form>
            @endif
        </div>
    </div>
</body>
</html>
