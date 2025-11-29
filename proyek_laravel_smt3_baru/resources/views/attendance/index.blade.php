@extends('employees.master')

@section('title', 'Data Absensi')

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

        /* Clock Section */
        .clock-section {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            padding: 30px;
            border-radius: 20px;
            margin-bottom: 35px;
            text-align: center;
            box-shadow: 0 10px 30px rgba(102, 126, 234, 0.3);
        }

        .clock-section .time {
            font-size: 4rem;
            font-weight: 800;
            margin-bottom: 10px;
            text-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }

        .clock-section .date {
            font-size: 1.3rem;
            opacity: 0.95;
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

        /* Who's Present Section */
        .present-section {
            background: linear-gradient(135deg, #f7fafc, #edf2f7);
            padding: 25px;
            border-radius: 15px;
            margin-bottom: 30px;
        }

        .present-section h3 {
            color: #2d3748;
            font-size: 1.3rem;
            font-weight: 700;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .present-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
            gap: 15px;
        }

        .present-card {
            background: white;
            padding: 15px;
            border-radius: 12px;
            box-shadow: 0 3px 15px rgba(0, 0, 0, 0.1);
            display: flex;
            align-items: center;
            gap: 12px;
            transition: all 0.3s ease;
        }

        .present-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 20px rgba(102, 126, 234, 0.2);
        }

        .present-card .avatar {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: linear-gradient(135deg, #48bb78, #38a169);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.5rem;
            font-weight: 700;
            flex-shrink: 0;
        }

        .present-card .info h4 {
            font-size: 0.95rem;
            font-weight: 700;
            color: #2d3748;
            margin-bottom: 3px;
        }

        .present-card .info p {
            font-size: 0.8rem;
            color: #718096;
            margin: 0;
        }

        .present-card .status-dot {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background: #48bb78;
            animation: pulse 2s infinite;
        }

        @keyframes pulse {

            0%,
            100% {
                opacity: 1;
            }

            50% {
                opacity: 0.5;
            }
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

        .filter-section input,
        .filter-section select {
            padding: 12px 20px;
            border: 2px solid #e2e8f0;
            border-radius: 10px;
            font-size: 0.95rem;
            transition: all 0.3s ease;
            background: white;
        }

        .filter-section input:focus,
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

        .badge-hadir {
            background: linear-gradient(135deg, #48bb78, #38a169);
            color: white;
        }

        .badge-izin {
            background: linear-gradient(135deg, #ecc94b, #d69e2e);
            color: white;
        }

        .badge-sakit {
            background: linear-gradient(135deg, #ed8936, #dd6b20);
            color: white;
        }

        .badge-alpha {
            background: linear-gradient(135deg, #f56565, #e53e3e);
            color: white;
        }

        .badge-terlambat {
            background: linear-gradient(135deg, #9f7aea, #805ad5);
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

        /* Responsive */
        @media (max-width: 768px) {
            .container {
                padding: 25px 15px;
            }

            h1 {
                font-size: 2rem;
            }

            .clock-section .time {
                font-size: 3rem;
            }

            table {
                font-size: 0.8rem;
            }
        }
    </style>

    <div class="container">
        <h1><i class="fas fa-clipboard-check"></i> Data Absensi Pegawai</h1>

        <!-- Current Time Clock -->
        <div class="clock-section">
            <div class="time" id="currentTime">00:00:00</div>
            <div class="date" id="currentDate">Loading...</div>
        </div>

        <!-- Stats Cards -->
        <div class="stats-container">
            <div class="stat-card">
                <h3><i class="fas fa-check-circle"></i> Hadir Hari Ini</h3>
                <div class="number">{{ isset($employees) ? $employees->where('status', 'Aktif')->count() : 0 }}</div>
                <i class="fas fa-user-check icon"></i>
            </div>
            <div class="stat-card" style="background: linear-gradient(135deg, #ecc94b, #d69e2e);">
                <h3><i class="fas fa-user-clock"></i> Izin</h3>
                <div class="number">0</div>
                <i class="fas fa-user-clock icon"></i>
            </div>
            <div class="stat-card" style="background: linear-gradient(135deg, #ed8936, #dd6b20);">
                <h3><i class="fas fa-procedures"></i> Sakit</h3>
                <div class="number">0</div>
                <i class="fas fa-procedures icon"></i>
            </div>
            <div class="stat-card" style="background: linear-gradient(135deg, #f56565, #e53e3e);">
                <h3><i class="fas fa-user-times"></i> Alpha</h3>
                <div class="number">{{ isset($employees) ? $employees->where('status', 'Cuti')->count() : 0 }}</div>
                <i class="fas fa-user-times icon"></i>
            </div>
        </div>

        <!-- Who's Present Today -->
        <div class="present-section">
            <h3><i class="fas fa-users-cog"></i> Pegawai yang Hadir Hari Ini</h3>
            <div class="present-grid">
                @if (isset($employees))
                    @php
                        $hadirEmployees = $employees->where('status', 'Aktif')->take(12);
                    @endphp
                    @if (count($hadirEmployees) > 0)
                        @foreach ($hadirEmployees as $emp)
                            <div class="present-card">
                                <div class="avatar">{{ substr($emp->nama_lengkap, 0, 1) }}</div>
                                <div class="info" style="flex:1;">
                                    <h4>{{ $emp->nama_lengkap }}</h4>
                                    <p><i class="fas fa-clock"></i> Masuk: 08:00</p>
                                </div>
                                <div class="status-dot"></div>
                            </div>
                        @endforeach
                    @else
                        <p style="color:#718096;text-align:center;grid-column:1/-1;">Belum ada pegawai yang absen hari ini
                        </p>
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
                <button class="btn-primary-custom">
                    <i class="fas fa-user-plus"></i> Input Absensi Manual
                </button>
                <button class="btn-primary-custom" style="background: linear-gradient(135deg, #f093fb, #f5576c);"
                    onclick="window.print()">
                    <i class="fas fa-print"></i> Cetak Rekap
                </button>
                <button class="btn-primary-custom" style="background: linear-gradient(135deg, #43e97b, #38f9d7);">
                    <i class="fas fa-file-excel"></i> Export Excel
                </button>
            </div>
        </div>

        <!-- Filter Section -->
        <div class="filter-section">
            <input type="date" id="dateFilter" value="{{ date('Y-m-d') }}" onchange="filterByDate()">
            <select id="statusFilter" onchange="filterByStatus()">
                <option value="">Semua Status</option>
                <option value="hadir">Hadir</option>
                <option value="izin">Izin</option>
                <option value="sakit">Sakit</option>
                <option value="alpha">Alpha</option>
                <option value="terlambat">Terlambat</option>
            </select>
            <select id="monthFilter" onchange="filterByMonth()">
                <option value="">Pilih Bulan</option>
                @for ($m = 1; $m <= 12; $m++)
                    <option value="{{ $m }}" {{ $m == date('n') ? 'selected' : '' }}>
                        {{ \Carbon\Carbon::create()->month($m)->format('F') }}
                    </option>
                @endfor
            </select>
        </div>

        <!-- Attendance Table -->
        <table id="attendanceTable">
            <thead>
                <tr>
                    <th><i class="fas fa-user"></i> Nama</th>
                    <th><i class="fas fa-calendar"></i> Tanggal</th>
                    <th><i class="fas fa-sign-in-alt"></i> Jam Masuk</th>
                    <th><i class="fas fa-sign-out-alt"></i> Jam Keluar</th>
                    <th><i class="fas fa-hourglass-half"></i> Total Jam</th>
                    <th><i class="fas fa-check-circle"></i> Status</th>
                    <th><i class="fas fa-sticky-note"></i> Keterangan</th>
                    <th><i class="fas fa-cogs"></i> Aksi</th>
                </tr>
            </thead>
            <tbody>
                @if (isset($employees) && count($employees) > 0)
                    @foreach ($employees->where('status', 'Aktif') as $employee)
                        <tr>
                            <td>{{ $employee->nama_lengkap ?? '-' }}</td>
                            <td>{{ date('d-m-Y') }}</td>
                            <td>08:00</td>
                            <td>17:00</td>
                            <td>9 Jam</td>
                            <td>
                                <span class="badge badge-hadir">Hadir</span>
                            </td>
                            <td>-</td>
                            <td>
                                <button class="action-btn" onclick="viewDetail({{ $employee->id }})" title="Detail">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button class="action-btn" onclick="editAttendance({{ $employee->id }})" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </button>
                            </td>
                        </tr>
                    @endforeach

                    @foreach ($employees->where('status', 'Cuti')->take(2) as $employee)
                        <tr>
                            <td>{{ $employee->nama_lengkap ?? '-' }}</td>
                            <td>{{ date('d-m-Y') }}</td>
                            <td>-</td>
                            <td>-</td>
                            <td>-</td>
                            <td>
                                <span class="badge badge-alpha">Cuti</span>
                            </td>
                            <td>Sedang cuti tahunan</td>
                            <td>
                                <button class="action-btn" onclick="viewDetail({{ $employee->id }})" title="Detail">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="8" style="text-align:center;padding:40px;">
                            <i class="fas fa-inbox" style="font-size:3rem;color:#cbd5e0;"></i>
                            <p style="color:#718096;margin-top:10px;">Belum ada data absensi</p>
                        </td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>

    <script>
        // Real-time Clock
        function updateClock() {
            const now = new Date();

            // Time
            const hours = String(now.getHours()).padStart(2, '0');
            const minutes = String(now.getMinutes()).padStart(2, '0');
            const seconds = String(now.getSeconds()).padStart(2, '0');
            document.getElementById('currentTime').textContent = `${hours}:${minutes}:${seconds}`;

            // Date
            const options = {
                weekday: 'long',
                year: 'numeric',
                month: 'long',
                day: 'numeric'
            };
            const dateStr = now.toLocaleDateString('id-ID', options);
            document.getElementById('currentDate').textContent = dateStr;
        }

        // Update clock every second
        updateClock();
        setInterval(updateClock, 1000);

        function filterByDate() {
            const date = document.getElementById('dateFilter').value;
            console.log('Filter by date:', date);
            // Implementasi filter
        }

        function filterByStatus() {
            const select = document.getElementById('statusFilter');
            const filter = select.value.toUpperCase();
            const table = document.getElementById('attendanceTable');
            const tr = table.getElementsByTagName('tr');

            for (let i = 1; i < tr.length; i++) {
                const td = tr[i].getElementsByTagName('td')[5];
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

        function filterByMonth() {
            const month = document.getElementById('monthFilter').value;
            console.log('Filter by month:', month);
            // Implementasi filter
        }

        function viewDetail(id) {
            alert('Melihat detail absensi pegawai ID: ' + id);
        }

        function editAttendance(id) {
            alert('Edit absensi pegawai ID: ' + id);
        }
    </script>
@endsection
