@extends('employees.master')

@section('title', 'Data Penggajian')

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

        /* Action Buttons */
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

        .filter-section select:focus {
            outline: none;
            border-color: #667eea;
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

        .badge-dibayar {
            background: linear-gradient(135deg, #48bb78, #38a169);
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

        /* Modal Styling */
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
        .form-group select:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
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

            thead tr th,
            tbody td {
                padding: 12px 8px;
            }
        }
    </style>

    <div class="container">
        <h1><i class="fas fa-money-bill-wave"></i> Data Penggajian Pegawai</h1>

        <!-- Stats Cards -->
        <div class="stats-container">
            <div class="stat-card">
                <h3><i class="fas fa-wallet"></i> Total Gaji Bulan Ini</h3>
                <div class="number">Rp {{ isset($totalGaji) ? number_format($totalGaji, 0, ',', '.') : '0' }}</div>
                <i class="fas fa-money-bill-wave icon"></i>
            </div>
            <div class="stat-card" style="background: linear-gradient(135deg, #f093fb, #f5576c);">
                <h3><i class="fas fa-check-circle"></i> Sudah Dibayar</h3>
                <div class="number">
                    {{ isset($payrolls) ? $payrolls->where('status_pembayaran', 'dibayar')->count() : 0 }}</div>
                <i class="fas fa-check-circle icon"></i>
            </div>
            <div class="stat-card" style="background: linear-gradient(135deg, #4facfe, #00f2fe);">
                <h3><i class="fas fa-clock"></i> Pending</h3>
                <div class="number">
                    {{ isset($payrolls) ? $payrolls->where('status_pembayaran', 'pending')->count() : 0 }}</div>
                <i class="fas fa-clock icon"></i>
            </div>
            <div class="stat-card" style="background: linear-gradient(135deg, #43e97b, #38f9d7);">
                <h3><i class="fas fa-users"></i> Total Pegawai</h3>
                <div class="number">{{ isset($payrolls) ? $payrolls->count() : 0 }}</div>
                <i class="fas fa-users icon"></i>
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
                <button class="btn-primary-custom" onclick="openModal('payrollModal')">
                    <i class="fas fa-plus"></i> Tambah Penggajian
                </button>
                <button class="btn-primary-custom" style="background: linear-gradient(135deg, #f093fb, #f5576c);"
                    onclick="window.print()">
                    <i class="fas fa-print"></i> Cetak
                </button>
                <button class="btn-primary-custom" style="background: linear-gradient(135deg, #43e97b, #38f9d7);">
                    <i class="fas fa-file-excel"></i> Export Excel
                </button>
            </div>
        </div>

        <!-- Filter Section -->
        <div class="filter-section">
            <select id="monthFilter" onchange="filterByMonth()">
                <option value="">Semua Bulan</option>
                <option value="01">Januari</option>
                <option value="02">Februari</option>
                <option value="03">Maret</option>
                <option value="04">April</option>
                <option value="05">Mei</option>
                <option value="06">Juni</option>
                <option value="07">Juli</option>
                <option value="08">Agustus</option>
                <option value="09">September</option>
                <option value="10">Oktober</option>
                <option value="11" selected>November</option>
                <option value="12">Desember</option>
            </select>
            <select id="yearFilter" onchange="filterByYear()">
                <option value="">Semua Tahun</option>
                <option value="2023">2023</option>
                <option value="2024">2024</option>
                <option value="2025" selected>2025</option>
            </select>
            <select id="statusFilter" onchange="filterByStatus()">
                <option value="">Semua Status</option>
                <option value="dibayar">Sudah Dibayar</option>
                <option value="pending">Pending</option>
            </select>
        </div>

        <!-- Payroll Table -->
        <table id="payrollTable">
            <thead>
                <tr>
                    <th><i class="fas fa-user"></i> Nama Pegawai</th>
                    <th><i class="fas fa-briefcase"></i> Jabatan</th>
                    <th><i class="fas fa-money-bill"></i> Gaji Pokok</th>
                    <th><i class="fas fa-plus-circle"></i> Tunjangan</th>
                    <th><i class="fas fa-minus-circle"></i> Potongan</th>
                    <th><i class="fas fa-wallet"></i> Total Gaji</th>
                    <th><i class="fas fa-calendar"></i> Periode</th>
                    <th><i class="fas fa-info-circle"></i> Status</th>
                    <th><i class="fas fa-cogs"></i> Aksi</th>
                </tr>
            </thead>
            <tbody>
                @if (isset($payrolls) && count($payrolls) > 0)
                    @foreach ($payrolls as $payroll)
                        <tr>
                            <td>{{ $payroll->employee->nama_lengkap ?? '-' }}</td>
                            <td>Staff</td>
                            <td>Rp {{ number_format($payroll->gaji_pokok, 0, ',', '.') }}</td>
                            <td>Rp {{ number_format($payroll->tunjangan, 0, ',', '.') }}</td>
                            <td>Rp {{ number_format($payroll->potongan, 0, ',', '.') }}</td>
                            <td><strong>Rp {{ number_format($payroll->total_gaji, 0, ',', '.') }}</strong></td>
                            <td>{{ \Carbon\Carbon::parse($payroll->periode)->format('F Y') }}</td>
                            <td>
                                <span class="badge badge-{{ $payroll->status_pembayaran }}">
                                    {{ ucfirst($payroll->status_pembayaran) }}
                                </span>
                            </td>
                            <td>
                                <button class="action-btn"
                                    onclick="window.location.href='{{ route('payroll.show', $payroll->id) }}'"
                                    title="Detail">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button class="action-btn"
                                    onclick="window.location.href='{{ route('payroll.edit', $payroll->id) }}'"
                                    title="Edit">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <form action="{{ route('payroll.destroy', $payroll->id) }}" method="POST"
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
                        <td colspan="9" style="text-align:center;padding:40px;">
                            <i class="fas fa-inbox" style="font-size:3rem;color:#cbd5e0;"></i>
                            <p style="color:#718096;margin-top:10px;">Belum ada data penggajian</p>
                        </td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>

    <!-- Modal Add Payroll -->
    <div id="payrollModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2><i class="fas fa-money-bill-wave"></i> Tambah Penggajian</h2>
                <button class="close-btn" onclick="closeModal('payrollModal')"><i class="fas fa-times"></i></button>
            </div>
            <form action="{{ route('payroll.store') }}" method="POST">
                @csrf

                @if ($errors->any())
                    <div
                        style="background:#fee;border:2px solid #f56565;border-radius:10px;padding:15px;margin-bottom:20px;">
                        <strong style="color:#c53030;">Error:</strong>
                        <ul style="margin:10px 0 0 20px;color:#c53030;">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="form-group">
                    <label><i class="fas fa-user"></i> Pilih Pegawai *</label>
                    <select name="employee_id" required value="{{ old('employee_id') }}">
                        <option value="">Pilih Pegawai</option>
                        @if (isset($employees))
                            @foreach ($employees as $emp)
                                <option value="{{ $emp->id }}"
                                    {{ old('employee_id') == $emp->id ? 'selected' : '' }}>
                                    {{ $emp->nama_lengkap }}
                                </option>
                            @endforeach
                        @endif
                    </select>
                    @error('employee_id')
                        <small style="color:#f56565;display:block;margin-top:5px;">{{ $message }}</small>
                    @enderror
                </div>
                <div class="form-group">
                    <label><i class="fas fa-money-bill"></i> Gaji Pokok (Rp) *</label>
                    <input type="number" name="gaji_pokok" placeholder="5000000" required id="gajiPokok"
                        value="{{ old('gaji_pokok') }}" min="0" step="1000" onchange="hitungTotal()">
                    @error('gaji_pokok')
                        <small style="color:#f56565;display:block;margin-top:5px;">{{ $message }}</small>
                    @enderror
                </div>
                <div class="form-group">
                    <label><i class="fas fa-plus-circle"></i> Tunjangan (Rp)</label>
                    <input type="number" name="tunjangan" placeholder="1000000" value="{{ old('tunjangan', 0) }}"
                        min="0" step="1000" id="tunjangan" onchange="hitungTotal()">
                    @error('tunjangan')
                        <small style="color:#f56565;display:block;margin-top:5px;">{{ $message }}</small>
                    @enderror
                </div>
                <div class="form-group">
                    <label><i class="fas fa-minus-circle"></i> Potongan (Rp)</label>
                    <input type="number" name="potongan" placeholder="500000" value="{{ old('potongan', 0) }}"
                        min="0" step="1000" id="potongan" onchange="hitungTotal()">
                    @error('potongan')
                        <small style="color:#f56565;display:block;margin-top:5px;">{{ $message }}</small>
                    @enderror
                </div>
                <div class="form-group">
                    <label><i class="fas fa-wallet"></i> Total Gaji (Otomatis)</label>
                    <input type="text" id="totalGaji" readonly
                        style="background:#f7fafc;font-weight:700;font-size:1.1rem;" value="Rp 0">
                </div>
                <div class="form-group">
                    <label><i class="fas fa-calendar"></i> Periode *</label>
                    <input type="month" name="periode" required value="{{ old('periode', date('Y-m')) }}">
                    @error('periode')
                        <small style="color:#f56565;display:block;margin-top:5px;">{{ $message }}</small>
                    @enderror
                </div>
                <div class="form-group">
                    <label><i class="fas fa-sticky-note"></i> Keterangan</label>
                    <textarea name="keterangan" placeholder="Catatan tambahan..." rows="3"></textarea>
                </div>
                <button type="submit" class="submit-btn">
                    <i class="fas fa-save"></i> Simpan Data Gaji
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

        function hitungTotal() {
            const gaji = parseFloat(document.getElementById('gajiPokok').value) || 0;
            const tunjangan = parseFloat(document.getElementById('tunjangan').value) || 0;
            const potongan = parseFloat(document.getElementById('potongan').value) || 0;
            const total = gaji + tunjangan - potongan;
            document.getElementById('totalGaji').value = 'Rp ' + total.toLocaleString('id-ID');
        }

        function filterByMonth() {
            // Implementasi filter
            console.log('Filter by month');
        }

        function filterByYear() {
            // Implementasi filter
            console.log('Filter by year');
        }

        function filterByStatus() {
            const select = document.getElementById('statusFilter');
            const filter = select.value.toUpperCase();
            const table = document.getElementById('payrollTable');
            const tr = table.getElementsByTagName('tr');

            for (let i = 1; i < tr.length; i++) {
                const td = tr[i].getElementsByTagName('td')[7];
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

        function viewDetail(id) {
            alert('Melihat detail penggajian ID: ' + id);
        }

        function editPayroll(id) {
            alert('Edit penggajian ID: ' + id);
        }

        // Auto open modal if there are validation errors
        @if ($errors->any() && old('_token'))
            document.addEventListener('DOMContentLoaded', function() {
                openModal('payrollModal');
                // Calculate total if old values exist
                setTimeout(hitungTotal, 100);
            });
        @endif
    </script>
@endsection
