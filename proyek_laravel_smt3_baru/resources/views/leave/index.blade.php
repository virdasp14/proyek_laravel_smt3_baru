@extends('employees.master')

@section('title', 'Manajemen Cuti & Izin')

@section('content')
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
            padding: 30px 0;
        }

        .container {
            max-width: 1600px;
            background: rgba(255, 255, 255, 0.98);
            border-radius: 25px;
            box-shadow: 0 25px 70px rgba(0, 0, 0, 0.3);
            padding: 40px;
            backdrop-filter: blur(15px);
            animation: fadeIn 0.6s ease-in;
        }

        @keyframes fadeIn {
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
            color: #1a202c;
            font-weight: 800;
            font-size: 2.8rem;
            margin-bottom: 15px;
            text-align: center;
            position: relative;
            padding-bottom: 20px;
            background: linear-gradient(135deg, #667eea, #764ba2);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        h1::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 150px;
            height: 5px;
            background: linear-gradient(90deg, #667eea, #764ba2);
            border-radius: 3px;
            box-shadow: 0 2px 10px rgba(102, 126, 234, 0.5);
        }

        /* Stats Cards */
        .stats-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 35px;
        }

        .stat-card {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            padding: 25px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(102, 126, 234, 0.3);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            cursor: pointer;
        }

        .stat-card:hover {
            transform: translateY(-8px) scale(1.02);
            box-shadow: 0 15px 40px rgba(102, 126, 234, 0.4);
        }

        .stat-card h3 {
            font-size: 0.9rem;
            font-weight: 600;
            margin-bottom: 10px;
            opacity: 0.95;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .stat-card .number {
            font-size: 2.5rem;
            font-weight: 800;
            margin-bottom: 5px;
        }

        .stat-card .icon {
            font-size: 3rem;
            opacity: 0.25;
            position: absolute;
            right: 20px;
            top: 50%;
            transform: translateY(-50%);
        }

        /* Who's On Leave Section */
        .on-leave-section {
            background: linear-gradient(135deg, #f7fafc, #edf2f7);
            padding: 25px;
            border-radius: 15px;
            margin-bottom: 30px;
        }

        .on-leave-section h3 {
            color: #2d3748;
            font-size: 1.3rem;
            font-weight: 700;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .on-leave-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 15px;
        }

        .on-leave-card {
            background: white;
            padding: 15px;
            border-radius: 12px;
            box-shadow: 0 3px 15px rgba(0, 0, 0, 0.1);
            display: flex;
            align-items: center;
            gap: 12px;
            transition: all 0.3s ease;
        }

        .on-leave-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 20px rgba(102, 126, 234, 0.2);
        }

        .on-leave-card .avatar {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: linear-gradient(135deg, #667eea, #764ba2);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.5rem;
            font-weight: 700;
            flex-shrink: 0;
        }

        .on-leave-card .info h4 {
            font-size: 0.95rem;
            font-weight: 700;
            color: #2d3748;
            margin-bottom: 3px;
        }

        .on-leave-card .info p {
            font-size: 0.8rem;
            color: #718096;
            margin: 0;
        }

        /* Action Section */
        .action-section {
            display: flex;
            gap: 15px;
            margin-bottom: 30px;
            flex-wrap: wrap;
            justify-content: space-between;
            align-items: center;
        }

        .btn-primary-custom {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            border: none;
            padding: 14px 28px;
            border-radius: 12px;
            font-weight: 600;
            font-size: 0.95rem;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 5px 20px rgba(102, 126, 234, 0.4);
        }

        .btn-primary-custom:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 30px rgba(102, 126, 234, 0.6);
        }

        .back-btn {
            background: linear-gradient(135deg, #718096, #4a5568);
            color: white;
            padding: 12px 24px;
            border-radius: 10px;
            text-decoration: none;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s ease;
        }

        .back-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(113, 128, 150, 0.4);
            color: white;
        }

        /* Filter Section */
        .filter-section {
            background: linear-gradient(135deg, #f7fafc, #edf2f7);
            padding: 20px;
            border-radius: 15px;
            margin-bottom: 30px;
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
        }

        .filter-section select {
            padding: 12px 20px;
            border: 2px solid #e2e8f0;
            border-radius: 10px;
            font-size: 0.95rem;
            cursor: pointer;
            transition: all 0.3s ease;
            background: white;
        }

        /* Table Styling */
        table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 5px 25px rgba(0, 0, 0, 0.08);
        }

        thead {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        thead tr th {
            color: white;
            font-weight: 700;
            text-transform: uppercase;
            font-size: 0.8rem;
            letter-spacing: 1px;
            padding: 18px 12px;
            text-align: left;
            border: none;
        }

        tbody tr {
            transition: all 0.3s ease;
            border-bottom: 1px solid #e2e8f0;
        }

        tbody tr:hover {
            background: linear-gradient(90deg, #f7fafc 0%, #edf2f7 100%);
            transform: scale(1.002);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.1);
        }

        tbody td {
            padding: 16px 12px;
            color: #4a5568;
            font-size: 0.9rem;
            vertical-align: middle;
        }

        tbody td:first-child {
            font-weight: 700;
            color: #2d3748;
        }

        /* Badge Styling */
        .badge {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
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

        /* Action Buttons */
        .action-btn {
            color: #667eea;
            text-decoration: none;
            font-weight: 600;
            padding: 6px 12px;
            border-radius: 8px;
            transition: all 0.3s ease;
            display: inline-block;
            font-size: 0.85rem;
            background: transparent;
            border: none;
            cursor: pointer;
        }

        .action-btn:hover {
            background: #667eea;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        }

        .action-btn.approve {
            color: #48bb78;
        }

        .action-btn.approve:hover {
            background: #48bb78;
            color: white;
        }

        .action-btn.reject {
            color: #f56565;
        }

        .action-btn.reject:hover {
            background: #f56565;
            color: white;
        }

        /* Modal styling sama seperti sebelumnya */
        .modal {
            display: none;
            position: fixed;
            z-index: 9999;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.6);
            backdrop-filter: blur(5px);
        }

        .modal.active {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .modal-content {
            background: white;
            padding: 35px;
            border-radius: 20px;
            width: 90%;
            max-width: 600px;
            max-height: 85vh;
            overflow-y: auto;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            animation: slideUp 0.3s ease;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
            padding-bottom: 15px;
            border-bottom: 2px solid #e2e8f0;
        }

        .modal-header h2 {
            color: #2d3748;
            font-size: 1.8rem;
            font-weight: 700;
            background: linear-gradient(135deg, #667eea, #764ba2);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .close-btn {
            background: #f56565;
            color: white;
            border: none;
            width: 35px;
            height: 35px;
            border-radius: 50%;
            cursor: pointer;
            font-size: 1.2rem;
            transition: all 0.3s ease;
        }

        .close-btn:hover {
            background: #e53e3e;
            transform: rotate(90deg);
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: #2d3748;
            font-weight: 600;
            font-size: 0.9rem;
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
            font-family: inherit;
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

        .submit-btn {
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
            margin-top: 10px;
        }

        .submit-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(102, 126, 234, 0.4);
        }

        /* Responsive */
        @media (max-width: 768px) {
            .container {
                padding: 25px 15px;
            }

            h1 {
                font-size: 2rem;
            }

            table {
                font-size: 0.8rem;
            }
        }
    </style>

    <div class="container">
        <h1><i class="fas fa-calendar-alt"></i> Manajemen Cuti & Izin</h1>

        <!-- Stats Cards -->
        <div class="stats-container">
            <div class="stat-card">
                <h3><i class="fas fa-clock"></i> Menunggu Persetujuan</h3>
                <div class="number">{{ isset($leaves) ? $leaves->where('status', 'pending')->count() : 0 }}</div>
                <i class="fas fa-clock icon"></i>
            </div>
            <div class="stat-card" style="background: linear-gradient(135deg, #48bb78, #38a169);">
                <h3><i class="fas fa-check-circle"></i> Disetujui</h3>
                <div class="number">{{ isset($leaves) ? $leaves->where('status', 'disetujui')->count() : 0 }}</div>
                <i class="fas fa-check-circle icon"></i>
            </div>
            <div class="stat-card" style="background: linear-gradient(135deg, #f56565, #e53e3e);">
                <h3><i class="fas fa-times-circle"></i> Ditolak</h3>
                <div class="number">{{ isset($leaves) ? $leaves->where('status', 'ditolak')->count() : 0 }}</div>
                <i class="fas fa-times-circle icon"></i>
            </div>
            <div class="stat-card" style="background: linear-gradient(135deg, #4facfe, #00f2fe);">
                <h3><i class="fas fa-users"></i> Sedang Cuti</h3>
                <div class="number">{{ isset($employees) ? $employees->where('status', 'Cuti')->count() : 0 }}</div>
                <i class="fas fa-users icon"></i>
            </div>
        </div>

        <!-- Who's On Leave Today -->
        <div class="on-leave-section">
            <h3><i class="fas fa-user-clock"></i> Pegawai yang Sedang Cuti Hari Ini</h3>
            <div class="on-leave-grid">
                @if (isset($employees))
                    @php
                        $cutiEmployees = $employees->where('status', 'Cuti')->take(8);
                    @endphp
                    @if (count($cutiEmployees) > 0)
                        @foreach ($cutiEmployees as $emp)
                            <div class="on-leave-card">
                                <div class="avatar">{{ substr($emp->nama_lengkap, 0, 1) }}</div>
                                <div class="info">
                                    <h4>{{ $emp->nama_lengkap }}</h4>
                                    <p><i class="fas fa-calendar"></i> Cuti sampai 27 Nov 2025</p>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <p style="color:#718096;text-align:center;grid-column:1/-1;">Tidak ada pegawai yang sedang cuti
                            hari ini</p>
                    @endif
                @endif
            </div>
        </div>

        <!-- Action Section -->
        <div class="action-section">
            <div>
                <a href="{{ route('employees.index') }}" class="back-btn">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
            </div>
            <div style="display: flex; gap: 10px; flex-wrap: wrap;">
                <button class="btn-primary-custom" onclick="openModal('leaveModal')">
                    <i class="fas fa-plus"></i> Ajukan Cuti/Izin
                </button>
                <button class="btn-primary-custom" style="background: linear-gradient(135deg, #f093fb, #f5576c);"
                    onclick="window.print()">
                    <i class="fas fa-print"></i> Cetak
                </button>
            </div>
        </div>

        <!-- Filter Section -->
        <div class="filter-section">
            <select id="statusFilter" onchange="filterByStatus()">
                <option value="">Semua Status</option>
                <option value="pending">Pending</option>
                <option value="disetujui">Disetujui</option>
                <option value="ditolak">Ditolak</option>
            </select>
            <select id="jenisFilter" onchange="filterByJenis()">
                <option value="">Semua Jenis</option>
                <option value="cuti_tahunan">Cuti Tahunan</option>
                <option value="cuti_sakit">Cuti Sakit</option>
                <option value="izin_pribadi">Izin Pribadi</option>
                <option value="cuti_melahirkan">Cuti Melahirkan</option>
                <option value="cuti_menikah">Cuti Menikah</option>
            </select>
        </div>

        <!-- Leave Table -->
        <table id="leaveTable">
            <thead>
                <tr>
                    <th><i class="fas fa-user"></i> Nama</th>
                    <th><i class="fas fa-list"></i> Jenis</th>
                    <th><i class="fas fa-calendar-day"></i> Mulai</th>
                    <th><i class="fas fa-calendar-day"></i> Selesai</th>
                    <th><i class="fas fa-calculator"></i> Hari</th>
                    <th><i class="fas fa-comment"></i> Alasan</th>
                    <th><i class="fas fa-info-circle"></i> Status</th>
                    <th><i class="fas fa-cogs"></i> Aksi</th>
                </tr>
            </thead>
            <tbody>
                @if (isset($leaves) && count($leaves) > 0)
                    @foreach ($leaves as $leave)
                        <tr>
                            <td>{{ $leave->employee->nama_lengkap ?? '-' }}</td>
                            <td>{{ $leave->jenis_name ?? ucfirst(str_replace('_', ' ', $leave->jenis)) }}</td>
                            <td>{{ \Carbon\Carbon::parse($leave->tanggal_mulai)->format('d M Y') }}</td>
                            <td>{{ \Carbon\Carbon::parse($leave->tanggal_selesai)->format('d M Y') }}</td>
                            <td>{{ $leave->jumlah_hari }} Hari</td>
                            <td>{{ Str::limit($leave->alasan, 30) }}</td>
                            <td>
                                <span class="badge badge-{{ $leave->status }}">
                                    {{ ucfirst($leave->status) }}
                                </span>
                            </td>
                            <td>
                                <button class="action-btn" onclick="viewDetail({{ $leave->id }})" title="Detail">
                                    <i class="fas fa-eye"></i>
                                </button>
                                @if ($leave->status == 'pending')
                                    <form action="{{ route('leave.approve', $leave->id) }}" method="POST"
                                        style="display:inline;">
                                        @csrf
                                        <button type="submit" class="action-btn approve"
                                            onclick="return confirm('Setujui pengajuan ini?')" title="Setujui">
                                            <i class="fas fa-check"></i>
                                        </button>
                                    </form>
                                    <form action="{{ route('leave.reject', $leave->id) }}" method="POST"
                                        style="display:inline;">
                                        @csrf
                                        <button type="submit" class="action-btn reject"
                                            onclick="return confirm('Tolak pengajuan ini?')" title="Tolak">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </form>
                                @endif
                                <form action="{{ route('leave.destroy', $leave->id) }}" method="POST"
                                    style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="action-btn" onclick="return confirm('Yakin hapus?')"
                                        title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="8" style="text-align:center;padding:40px;">
                            <i class="fas fa-inbox" style="font-size:3rem;color:#cbd5e0;"></i>
                            <p style="color:#718096;margin-top:10px;">Belum ada pengajuan cuti/izin</p>
                        </td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>

    <!-- Modal Add Leave -->
    <div id="leaveModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2><i class="fas fa-calendar-alt"></i> Ajukan Cuti/Izin</h2>
                <button class="close-btn" onclick="closeModal('leaveModal')"><i class="fas fa-times"></i></button>
            </div>
            <form action="{{ route('leave.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label><i class="fas fa-user"></i> Pilih Pegawai</label>
                    <select name="employee_id" required>
                        <option value="">Pilih Pegawai</option>
                        @if (isset($employees))
                            @foreach ($employees->where('status', 'Aktif') as $emp)
                                <option value="{{ $emp->id }}">{{ $emp->nama_lengkap }}</option>
                            @endforeach
                        @endif
                    </select>
                </div>
                <div class="form-group">
                    <label><i class="fas fa-list"></i> Jenis Cuti/Izin</label>
                    <select name="jenis" required>
                        <option value="">Pilih Jenis</option>
                        <option value="cuti_tahunan">Cuti Tahunan</option>
                        <option value="cuti_sakit">Cuti Sakit</option>
                        <option value="izin_pribadi">Izin Pribadi</option>
                        <option value="cuti_melahirkan">Cuti Melahirkan</option>
                        <option value="cuti_menikah">Cuti Menikah</option>
                    </select>
                </div>
                <div class="form-group">
                    <label><i class="fas fa-calendar-day"></i> Tanggal Mulai</label>
                    <input type="date" name="tanggal_mulai" required id="tanggalMulai" onchange="hitungHari()">
                </div>
                <div class="form-group">
                    <label><i class="fas fa-calendar-day"></i> Tanggal Selesai</label>
                    <input type="date" name="tanggal_selesai" required id="tanggalSelesai" onchange="hitungHari()">
                </div>
                <div class="form-group">
                    <label><i class="fas fa-calculator"></i> Jumlah Hari (Otomatis)</label>
                    <input type="text" id="jumlahHari" readonly style="background:#f7fafc;font-weight:700;">
                </div>
                <div class="form-group">
                    <label><i class="fas fa-comment"></i> Alasan</label>
                    <textarea name="alasan" placeholder="Jelaskan alasan pengajuan cuti/izin..." required></textarea>
                </div>
                <div class="form-group">
                    <label><i class="fas fa-file-upload"></i> Dokumen Pendukung (Opsional)</label>
                    <input type="file" name="dokumen" accept=".pdf,.jpg,.jpeg,.png" style="padding:10px;">
                    <small style="color:#718096;display:block;margin-top:8px;">Format: PDF, JPG, PNG (Max 2MB)</small>
                </div>
                <button type="submit" class="submit-btn">
                    <i class="fas fa-paper-plane"></i> Ajukan Permohonan
                </button>
            </form>
        </div>
    </div>

    <script>
        function openModal(modalId) {
            document.getElementById(modalId).classList.add('active');
            document.body.style.overflow = 'hidden';
        }

        function closeModal(modalId) {
            document.getElementById(modalId).classList.remove('active');
            document.body.style.overflow = 'auto';
        }

        window.onclick = function(event) {
            if (event.target.classList.contains('modal')) {
                event.target.classList.remove('active');
                document.body.style.overflow = 'auto';
            }
        }

        function hitungHari() {
            const mulai = new Date(document.getElementById('tanggalMulai').value);
            const selesai = new Date(document.getElementById('tanggalSelesai').value);

            if (mulai && selesai && selesai >= mulai) {
                const diffTime = Math.abs(selesai - mulai);
                const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24)) + 1;
                document.getElementById('jumlahHari').value = diffDays + ' Hari';
            }
        }

        function filterByStatus() {
            const select = document.getElementById('statusFilter');
            const filter = select.value.toUpperCase();
            const table = document.getElementById('leaveTable');
            const tr = table.getElementsByTagName('tr');

            for (let i = 1; i < tr.length; i++) {
                const td = tr[i].getElementsByTagName('td')[6];
                if (td) {
                    const txtValue = td.textContent || td.innerText;
                    if (filter === '' || txtValue.toUpperCase().indexOf(filter) > -1) {
                        tr[i].style.display = '';
                    } else {
                        tr[i].style.display = 'none';
                    }
                }
            }
        }

        function filterByJenis() {
            const select = document.getElementById('jenisFilter');
            const filter = select.value.toUpperCase();
            const table = document.getElementById('leaveTable');
            const tr = table.getElementsByTagName('tr');

            for (let i = 1; i < tr.length; i++) {
                const td = tr[i].getElementsByTagName('td')[1];
                if (td) {
                    const txtValue = td.textContent || td.innerText;
                    if (filter === '' || txtValue.toUpperCase().indexOf(filter.replace('_', ' ')) > -1) {
                        tr[i].style.display = '';
                    } else {
                        tr[i].style.display = 'none';
                    }
                }
            }
        }

        function viewDetail(id) {
            window.location.href = '/leave/' + id;
        }
    </script>
@endsection
