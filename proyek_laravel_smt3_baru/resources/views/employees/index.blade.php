@extends('employees.master')
@section('title', 'Daftar Pegawai')

@section('styles')
    <style>
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
            cursor: pointer;
            position: relative;
            overflow: hidden;
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.1), rgba(255, 255, 255, 0));
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .stat-card:hover::before {
            opacity: 1;
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

        /* Feature Buttons */
        .features-section {
            display: flex;
            gap: 15px;
            margin-bottom: 35px;
            flex-wrap: wrap;
            justify-content: center;
        }

        .feature-btn {
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
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .feature-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 30px rgba(102, 126, 234, 0.6);
        }

        /* Search and Filter */
        .control-section {
            display: flex;
            gap: 15px;
            margin-bottom: 30px;
            flex-wrap: wrap;
            align-items: center;
            background: linear-gradient(135deg, #f7fafc, #edf2f7);
            padding: 20px;
            border-radius: 15px;
            box-shadow: 0 3px 15px rgba(0, 0, 0, 0.05);
        }

        .search-box {
            flex: 1;
            min-width: 250px;
            position: relative;
        }

        .search-box input {
            width: 100%;
            padding: 12px 20px 12px 45px;
            border: 2px solid #e2e8f0;
            border-radius: 10px;
            font-size: 0.95rem;
            transition: all 0.3s ease;
        }

        .search-box i {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #a0aec0;
        }

        .search-box input:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        .filter-box select {
            padding: 12px 20px;
            border: 2px solid #e2e8f0;
            border-radius: 10px;
            font-size: 0.95rem;
            cursor: pointer;
            transition: all 0.3s ease;
            background: white;
        }

        /* Tab Navigation */
        .tab-navigation {
            display: flex;
            gap: 10px;
            margin-bottom: 30px;
            border-bottom: 3px solid #e2e8f0;
            overflow-x: auto;
        }

        .tab-btn {
            padding: 15px 25px;
            background: transparent;
            border: none;
            border-bottom: 3px solid transparent;
            color: #718096;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            white-space: nowrap;
        }

        .tab-btn.active {
            color: #667eea;
            border-bottom-color: #667eea;
        }

        .tab-btn:hover {
            color: #667eea;
            background: rgba(102, 126, 234, 0.05);
        }

        .tab-content {
            display: none;
            animation: slideIn 0.4s ease;
        }

        .tab-content.active {
            display: block;
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

        /* Table Styling */
        table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 5px 25px rgba(0, 0, 0, 0.08);
            margin-bottom: 30px;
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

        .badge-aktif {
            background: linear-gradient(135deg, #48bb78, #38a169);
            color: white;
        }

        .badge-cuti {
            background: linear-gradient(135deg, #ecc94b, #d69e2e);
            color: white;
        }

        .badge-nonaktif {
            background: linear-gradient(135deg, #f56565, #e53e3e);
            color: white;
        }

        .badge-pending {
            background: linear-gradient(135deg, #ed8936, #dd6b20);
            color: white;
        }

        .badge-approved {
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
        }

        .action-btn:hover {
            background: #667eea;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        }

        button.action-btn {
            background: linear-gradient(135deg, #fc5c7d, #6a82fb);
            color: white;
            border: none;
            cursor: pointer;
        }

        button.action-btn:hover {
            background: linear-gradient(135deg, #6a82fb, #fc5c7d);
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
            animation: fadeIn 0.3s ease;
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
            position: relative;
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
            display: flex;
            align-items: center;
            justify-content: center;
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

        /* Breadcrumb */
        .breadcrumb-section {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 25px;
            padding: 15px 20px;
            background: rgba(255, 255, 255, 0.6);
            border-radius: 12px;
            font-size: 0.9rem;
            color: #4a5568;
        }

        .breadcrumb-section a {
            color: #667eea;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .breadcrumb-section a:hover {
            color: #764ba2;
            text-decoration: underline;
        }

        .breadcrumb-separator {
            color: #a0aec0;
        }

        /* Header Section */
        .header-section {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            padding: 25px;
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.1), rgba(118, 75, 162, 0.05));
            border-radius: 15px;
            border-left: 5px solid #667eea;
        }

        .header-title {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .header-title h1 {
            font-size: 2.2rem;
            margin: 0;
            padding: 0;
            text-align: left;
        }

        .header-subtitle {
            color: #718096;
            font-size: 1rem;
            font-weight: 500;
        }

        .header-actions {
            display: flex;
            gap: 12px;
        }

        .quick-action-btn {
            padding: 12px 20px;
            border-radius: 10px;
            border: 2px solid #667eea;
            background: white;
            color: #667eea;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .quick-action-btn:hover {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 5px 20px rgba(102, 126, 234, 0.3);
        }

        .quick-action-btn.primary {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            border: none;
        }

        .quick-action-btn.primary:hover {
            transform: translateY(-3px) scale(1.05);
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4);
        }

        /* Responsive */
        @media (max-width: 768px) {
            .container {
                padding: 25px 15px;
            }

            .header-section {
                flex-direction: column;
                gap: 20px;
            }

            .header-title h1 {
                font-size: 1.8rem;
            }

            .header-actions {
                width: 100%;
                flex-direction: column;
            }

            .quick-action-btn {
                width: 100%;
                justify-content: center;
            }

            .stat-card .number {
                font-size: 2rem;
            }

            .feature-btn {
                padding: 12px 20px;
                font-size: 0.85rem;
            }

            .modal-content {
                padding: 25px;
                width: 95%;
            }
        }
    </style>
@endsection

@section('content')
    <div class="container mt-4">
        <!-- Breadcrumb -->
        <div class="breadcrumb-section">
            <i class="fas fa-home"></i>
            <a href="{{ route('employees.index') }}">Home</a>
            <span class="breadcrumb-separator">/</span>
            <span>Sistem Manajemen Pegawai</span>
        </div>

        <!-- Header Section -->
        <div class="header-section">
            <div class="header-title">
                <h1><i class="fas fa-users"></i> Sistem Manajemen Pegawai</h1>
                <p class="header-subtitle">Kelola data pegawai, departemen, dan informasi karyawan</p>
            </div>
            <div class="header-actions">
                <button class="quick-action-btn" onclick="window.location.reload()">
                    <i class="fas fa-sync-alt"></i> Refresh
                </button>
                <button class="quick-action-btn primary" data-bs-toggle="modal" data-bs-target="#addEmployeeModal">
                    <i class="fas fa-user-plus"></i> Tambah Pegawai
                </button>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="stats-container">
            <div class="stat-card">
                <h3><i class="fas fa-user-check"></i> Total Pegawai Aktif</h3>
                <div class="number">{{ isset($employees) ? $employees->where('status', 'Aktif')->count() : 0 }}</div>
                <i class="fas fa-users icon"></i>
            </div>
            <div class="stat-card" style="background: linear-gradient(135deg, #f093fb, #f5576c);">
                <h3><i class="fas fa-user-clock"></i> Pegawai Cuti</h3>
                <div class="number">{{ isset($employees) ? $employees->where('status', 'Cuti')->count() : 0 }}</div>
                <i class="fas fa-calendar-alt icon"></i>
            </div>
            <a href="{{ route('departments.index') }}" style="text-decoration: none;">
                <div class="stat-card"
                    style="background: linear-gradient(135deg, #4facfe, #00f2fe); cursor: pointer; transition: transform 0.2s;">
                    <h3><i class="fas fa-briefcase"></i> Total Departemen</h3>
                    <div class="number">{{ isset($departments) ? count($departments) : 5 }}</div>
                    <i class="fas fa-building icon"></i>
                </div>
            </a>
            <div class="stat-card" style="background: linear-gradient(135deg, #43e97b, #38f9d7);">
                <h3><i class="fas fa-chart-line"></i> Absensi Hari Ini</h3>
                <div class="number">{{ isset($employees) ? $employees->where('status', 'Aktif')->count() : 0 }}</div>
                <i class="fas fa-clipboard-check icon"></i>
            </div>
        </div>

        <!-- Who's On Leave Section - TAMBAHAN BARU -->
        <div
            style="background: linear-gradient(135deg, #f7fafc, #edf2f7); padding: 25px; border-radius: 15px; margin-bottom: 35px;">
            <h3
                style="color: #2d3748; font-size: 1.3rem; font-weight: 700; margin-bottom: 15px; display: flex; align-items: center; gap: 10px;">
                <i class="fas fa-user-clock"></i> Pegawai yang Sedang Cuti/Izin Hari Ini
            </h3>
            <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); gap: 15px;">
                @if (isset($employees))
                    @php
                        $cutiEmployees = $employees->where('status', 'Cuti')->take(8);
                    @endphp
                    @if (count($cutiEmployees) > 0)
                        @foreach ($cutiEmployees as $emp)
                            <div
                                style="background: white; padding: 15px; border-radius: 12px; box-shadow: 0 3px 15px rgba(0, 0, 0, 0.1); display: flex; align-items: center; gap: 12px; transition: all 0.3s ease;">
                                <div
                                    style="width: 50px; height: 50px; border-radius: 50%; background: linear-gradient(135deg, #ecc94b, #d69e2e); display: flex; align-items: center; justify-content: center; color: white; font-size: 1.5rem; font-weight: 700; flex-shrink: 0;">
                                    {{ substr($emp->nama_lengkap, 0, 1) }}
                                </div>
                                <div style="flex:1;">
                                    <h4 style="font-size: 0.95rem; font-weight: 700; color: #2d3748; margin-bottom: 3px;">
                                        {{ $emp->nama_lengkap }}</h4>
                                    <p style="font-size: 0.8rem; color: #718096; margin: 0;">
                                        <i class="fas fa-calendar-alt"></i> Sedang Cuti
                                    </p>
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

        <!-- Feature Buttons -->
        <div class="features-section">
            <button class="feature-btn" data-bs-toggle="modal" data-bs-target="#addEmployeeModal">
                <i class="fas fa-user-plus"></i> Tambah Pegawai
            </button>
            <button class="feature-btn" style="background: linear-gradient(135deg, #f093fb, #f5576c);"
                onclick="openModal('exportModal')">
                <i class="fas fa-file-export"></i> Export Data
            </button>
            <button class="feature-btn" style="background: linear-gradient(135deg, #4facfe, #00f2fe);"
                onclick="openModal('importModal')">
                <i class="fas fa-file-import"></i> Import Data
            </button>
            <button class="feature-btn" style="background: linear-gradient(135deg, #43e97b, #38f9d7);"
                onclick="openModal('printModal')">
                <i class="fas fa-print"></i> Cetak Laporan
            </button>
        </div>

        <!-- Search and Filter -->
        <div class="control-section">
            <div class="search-box">
                <i class="fas fa-search"></i>
                <input type="text" id="searchInput" placeholder="Cari pegawai..." onkeyup="searchTable()">
            </div>
            <div class="filter-box">
                <select id="statusFilter" onchange="filterByStatus()">
                    <option value="">Semua Status</option>
                    <option value="Aktif">Aktif</option>
                    <option value="Cuti">Cuti</option>
                    <option value="Nonaktif">Nonaktif</option>
                </select>
                <select id="sortBy" onchange="sortTable()">
                    <option value="">Urutkan</option>
                    <option value="name-asc">Nama A-Z</option>
                    <option value="name-desc">Nama Z-A</option>
                    <option value="date-newest">Terbaru</option>
                    <option value="date-oldest">Terlama</option>
                </select>
            </div>
        </div>

        <!-- Tab Navigation -->
        <div class="tab-navigation">
            <button class="tab-btn active" onclick="openTab('employees')">
                <i class="fas fa-users"></i> Data Pegawai
            </button>
            <button class="tab-btn" onclick="openTab('attendance')">
                <i class="fas fa-clipboard-check"></i> Absensi
            </button>
            <button class="tab-btn" onclick="openTab('payroll')">
                <i class="fas fa-money-bill-wave"></i> Penggajian
            </button>
            <button class="tab-btn" onclick="openTab('leave')">
                <i class="fas fa-calendar-alt"></i> Cuti & Izin
            </button>
        </div>

        <!-- Tab 1: Employee Table -->
        <div id="employees" class="tab-content active">
            <table id="employeeTable">
                <thead>
                    <tr>
                        <th><i class="fas fa-user"></i> Nama</th>
                        <th><i class="fas fa-envelope"></i> Email</th>
                        <th><i class="fas fa-phone"></i> Telepon</th>
                        <th><i class="fas fa-birthday-cake"></i> Tgl Lahir</th>
                        <th><i class="fas fa-map-marker-alt"></i> Alamat</th>
                        <th><i class="fas fa-calendar-plus"></i> Tgl Masuk</th>
                        <th><i class="fas fa-info-circle"></i> Status</th>
                        <th><i class="fas fa-cogs"></i> Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @if (isset($employees) && count($employees) > 0)
                        @foreach ($employees as $employee)
                            <tr>
                                <td>{{ $employee->nama_lengkap ?? '-' }}</td>
                                <td>{{ $employee->email ?? '-' }}</td>
                                <td>{{ $employee->nomor_telepon ?? '-' }}</td>
                                <td>{{ $employee->tanggal_lahir ?? '-' }}</td>
                                <td>{{ Str::limit($employee->alamat ?? '-', 30) }}</td>
                                <td>{{ $employee->tanggal_masuk ?? '-' }}</td>
                                <td>
                                    <span class="badge badge-{{ strtolower($employee->status ?? 'aktif') }}">
                                        {{ $employee->status ?? 'Aktif' }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('employees.show', $employee->id) }}" class="action-btn"
                                        title="Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('employees.edit', $employee->id) }}" class="action-btn"
                                        title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('employees.destroy', $employee->id) }}" method="POST"
                                        style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="action-btn"
                                            onclick="return confirm('Yakin hapus?')" title="Hapus">
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
                                <p style="color:#718096;margin-top:10px;">Belum ada data pegawai</p>
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>

        <!-- Tab 2: Attendance -->
        <div id="attendance" class="tab-content">
            <table>
                <thead>
                    <tr>
                        <th><i class="fas fa-user"></i> Nama</th>
                        <th><i class="fas fa-calendar"></i> Tanggal</th>
                        <th><i class="fas fa-clock"></i> Masuk</th>
                        <th><i class="fas fa-clock"></i> Keluar</th>
                        <th><i class="fas fa-hourglass-half"></i> Total Jam</th>
                        <th><i class="fas fa-check-circle"></i> Status</th>
                        <th><i class="fas fa-sticky-note"></i> Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    @if (isset($employees) && count($employees) > 0)
                        @foreach ($employees->take(10) as $employee)
                            <tr>
                                <td>{{ $employee->nama_lengkap ?? '-' }}</td>
                                <td>{{ date('d-m-Y') }}</td>
                                <td>08:00</td>
                                <td>17:00</td>
                                <td>9 Jam</td>
                                <td><span class="badge badge-aktif">Hadir</span></td>
                                <td>-</td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="7" style="text-align:center;padding:40px;">Belum ada data absensi</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>

        <!-- Tab 4: Payroll -->
        <div id="payroll" class="tab-content">
            <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:25px;">
                <h3 style="color:#2d3748;font-size:1.5rem;font-weight:700;">Data Penggajian</h3>
                <button class="feature-btn" onclick="openModal('payrollModal')">
                    <i class="fas fa-plus"></i> Tambah Penggajian
                </button>
            </div>
            <table>
                <thead>
                    <tr>
                        <th><i class="fas fa-user"></i> Nama</th>
                        <th><i class="fas fa-briefcase"></i> Jabatan</th>
                        <th><i class="fas fa-money-bill"></i> Gaji Pokok</th>
                        <th><i class="fas fa-plus-circle"></i> Tunjangan</th>
                        <th><i class="fas fa-minus-circle"></i> Potongan</th>
                        <th><i class="fas fa-wallet"></i> Total</th>
                        <th><i class="fas fa-calendar"></i> Periode</th>
                        <th><i class="fas fa-check"></i> Status</th>
                    </tr>
                </thead>
                <tbody>
                    @if (isset($employees) && count($employees) > 0)
                        @foreach ($employees->take(10) as $employee)
                            <tr>
                                <td>{{ $employee->nama_lengkap ?? '-' }}</td>
                                <td>Staff</td>
                                <td>Rp 5.000.000</td>
                                <td>Rp 1.000.000</td>
                                <td>Rp 500.000</td>
                                <td><strong>Rp 5.500.000</strong></td>
                                <td>November 2025</td>
                                <td><span class="badge badge-aktif">Dibayar</span></td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="8" style="text-align:center;padding:40px;">Belum ada data penggajian</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>

        <!-- Tab 5: Leave Management -->
        <div id="leave" class="tab-content">
            <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:25px;">
                <h3 style="color:#2d3748;font-size:1.5rem;font-weight:700;">Manajemen Cuti & Izin</h3>
                <button class="feature-btn" onclick="openModal('leaveModal')">
                    <i class="fas fa-plus"></i> Ajukan Cuti/Izin
                </button>
            </div>
            <table>
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
                    @if (isset($employees) && count($employees) > 0)
                        @php
                            $cutiEmployees = $employees->where('status', 'Cuti')->take(3);
                            $aktifEmployees = $employees->where('status', 'Aktif')->take(2);
                        @endphp

                        @foreach ($cutiEmployees as $employee)
                            <tr>
                                <td>{{ $employee->nama_lengkap ?? '-' }}</td>
                                <td>Cuti Tahunan</td>
                                <td>2025-11-20</td>
                                <td>2025-11-25</td>
                                <td>5 Hari</td>
                                <td>Liburan keluarga</td>
                                <td><span class="badge badge-approved">Disetujui</span></td>
                                <td>
                                    <button class="action-btn" onclick="alert('Detail cuti')"><i
                                            class="fas fa-eye"></i></button>
                                    <button class="action-btn" onclick="return confirm('Batalkan cuti?')"><i
                                            class="fas fa-times"></i></button>
                                </td>
                            </tr>
                        @endforeach

                        @foreach ($aktifEmployees as $employee)
                            <tr>
                                <td>{{ $employee->nama_lengkap ?? '-' }}</td>
                                <td>Izin Sakit</td>
                                <td>2025-11-23</td>
                                <td>2025-11-23</td>
                                <td>1 Hari</td>
                                <td>Sakit demam</td>
                                <td><span class="badge badge-pending">Pending</span></td>
                                <td>
                                    <button class="action-btn" onclick="alert('Detail izin')"><i
                                            class="fas fa-eye"></i></button>
                                    <button class="action-btn"
                                        style="background: linear-gradient(135deg, #43e97b, #38f9d7);"
                                        onclick="return confirm('Setujui?')"><i class="fas fa-check"></i></button>
                                    <button class="action-btn" onclick="return confirm('Tolak?')"><i
                                            class="fas fa-times"></i></button>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="8" style="text-align:center;padding:40px;">Belum ada pengajuan cuti</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal Export Data -->
    <div id="exportModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2><i class="fas fa-file-export"></i> Export Data</h2>
                <button class="close-btn" onclick="closeModal('exportModal')"><i class="fas fa-times"></i></button>
            </div>
            <form action="{{ route('employees.export') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label><i class="fas fa-file"></i> Format Export</label>
                    <select name="format" required>
                        <option value="">Pilih Format</option>
                        <option value="excel">Excel (.xlsx)</option>
                        <option value="csv">CSV (.csv)</option>
                        <option value="pdf">PDF (.pdf)</option>
                    </select>
                </div>
                <div class="form-group">
                    <label><i class="fas fa-filter"></i> Data yang Diexport</label>
                    <select name="data_type" required>
                        <option value="all">Semua Pegawai</option>
                        <option value="Aktif">Pegawai Aktif</option>
                        <option value="Cuti">Pegawai Cuti</option>
                        <option value="Nonaktif">Pegawai Nonaktif</option>
                    </select>
                </div>
                <div class="form-group">
                    <label><i class="fas fa-calendar"></i> Periode (Opsional)</label>
                    <div style="display:flex;gap:10px;">
                        <input type="date" name="start_date" placeholder="Dari">
                        <input type="date" name="end_date" placeholder="Sampai">
                    </div>
                </div>
                <button type="submit" class="submit-btn">
                    <i class="fas fa-download"></i> Export Data
                </button>
            </form>
        </div>
    </div>

    <!-- Modal Import Data -->
    <div id="importModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2><i class="fas fa-file-import"></i> Import Data</h2>
                <button class="close-btn" onclick="closeModal('importModal')"><i class="fas fa-times"></i></button>
            </div>
            <form action="{{ route('employees.import') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label><i class="fas fa-file-upload"></i> Upload File</label>
                    <input type="file" name="file" accept=".xlsx,.xls,.csv" required style="padding:10px;">
                    <small style="color:#718096;display:block;margin-top:8px;">Format: Excel (.xlsx, .xls) atau CSV
                        (.csv)</small>
                </div>
                <div class="form-group">
                    <label><i class="fas fa-info-circle"></i> Catatan</label>
                    <textarea readonly style="background:#f7fafc;cursor:not-allowed;">File harus memiliki kolom: Nama Lengkap, Email, Nomor Telepon, Tanggal Lahir, Alamat, Tanggal Masuk, Status</textarea>
                </div>
                <div class="form-group">
                    <a href="{{ route('employees.template') }}" class="action-btn"
                        style="display:inline-block;margin-bottom:10px;">
                        <i class="fas fa-download"></i> Download Template
                    </a>
                </div>
                <button type="submit" class="submit-btn">
                    <i class="fas fa-upload"></i> Import Data
                </button>
            </form>
        </div>
    </div>

    <!-- Modal Print Report -->
    <div id="printModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2><i class="fas fa-print"></i> Cetak Laporan</h2>
                <button class="close-btn" onclick="closeModal('printModal')"><i class="fas fa-times"></i></button>
            </div>
            <form action="{{ route('employees.print') }}" method="POST" target="_blank">
                @csrf
                <div class="form-group">
                    <label><i class="fas fa-file-alt"></i> Jenis Laporan</label>
                    <select name="report_type" required>
                        <option value="">Pilih Jenis Laporan</option>
                        <option value="employee_list">Daftar Pegawai</option>
                        <option value="attendance">Laporan Absensi</option>
                        <option value="payroll">Laporan Penggajian</option>
                        <option value="leave">Laporan Cuti & Izin</option>
                        <option value="department">Laporan per Departemen</option>
                    </select>
                </div>
                <div class="form-group">
                    <label><i class="fas fa-calendar-alt"></i> Periode Laporan</label>
                    <select name="period" required>
                        <option value="">Pilih Periode</option>
                        <option value="today">Hari Ini</option>
                        <option value="this_week">Minggu Ini</option>
                        <option value="this_month">Bulan Ini</option>
                        <option value="this_year">Tahun Ini</option>
                        <option value="custom">Custom</option>
                    </select>
                </div>
                <div class="form-group" id="customPeriod" style="display:none;">
                    <label><i class="fas fa-calendar"></i> Tanggal Custom</label>
                    <div style="display:flex;gap:10px;">
                        <input type="date" name="custom_start" placeholder="Dari">
                        <input type="date" name="custom_end" placeholder="Sampai">
                    </div>
                </div>
                <div class="form-group">
                    <label><i class="fas fa-file-pdf"></i> Format Output</label>
                    <select name="output_format" required>
                        <option value="pdf">PDF</option>
                        <option value="excel">Excel</option>
                    </select>
                </div>
                <button type="submit" class="submit-btn">
                    <i class="fas fa-print"></i> Cetak Laporan
                </button>
            </form>
        </div>
    </div>



    <!-- Modal Add Payroll -->
    <div id="payrollModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2><i class="fas fa-money-bill-wave"></i> Tambah Data Penggajian</h2>
                <button class="close-btn" onclick="closeModal('payrollModal')"><i class="fas fa-times"></i></button>
            </div>
            <form action="{{ route('payroll.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label><i class="fas fa-user"></i> Pilih Pegawai</label>
                    <select name="employee_id" required>
                        <option value="">Pilih Pegawai</option>
                        @if (isset($employees))
                            @foreach ($employees as $emp)
                                <option value="{{ $emp->id }}">{{ $emp->nama_lengkap }}</option>
                            @endforeach
                        @endif
                    </select>
                </div>
                <div class="form-group">
                    <label><i class="fas fa-money-bill"></i> Gaji Pokok</label>
                    <input type="number" name="gaji_pokok" placeholder="5000000" required>
                </div>
                <div class="form-group">
                    <label><i class="fas fa-plus-circle"></i> Tunjangan</label>
                    <input type="number" name="tunjangan" placeholder="1000000" value="0">
                </div>
                <div class="form-group">
                    <label><i class="fas fa-minus-circle"></i> Potongan</label>
                    <input type="number" name="potongan" placeholder="500000" value="0">
                </div>
                <div class="form-group">
                    <label><i class="fas fa-calendar"></i> Periode</label>
                    <input type="month" name="periode" required>
                </div>
                <div class="form-group">
                    <label><i class="fas fa-sticky-note"></i> Keterangan</label>
                    <textarea name="keterangan" placeholder="Catatan tambahan..."></textarea>
                </div>
                <button type="submit" class="submit-btn">
                    <i class="fas fa-save"></i> Simpan Data Gaji
                </button>
            </form>
        </div>
    </div>

    <!-- Modal Add Leave -->
    <div id="leaveModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2><i class="fas fa-calendar-alt"></i> Ajukan Cuti / Izin</h2>
                <button class="close-btn" onclick="closeModal('leaveModal')"><i class="fas fa-times"></i></button>
            </div>
            <form action="{{ route('leave.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label><i class="fas fa-user"></i> Pilih Pegawai</label>
                    <select name="employee_id" required>
                        <option value="">Pilih Pegawai</option>
                        @if (isset($employees))
                            @foreach ($employees as $emp)
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
                    <input type="date" name="tanggal_mulai" required>
                </div>
                <div class="form-group">
                    <label><i class="fas fa-calendar-day"></i> Tanggal Selesai</label>
                    <input type="date" name="tanggal_selesai" required>
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
        // Modal Functions
        function openModal(modalId) {
            document.getElementById(modalId).classList.add('active');
            document.body.style.overflow = 'hidden';
        }

        function closeModal(modalId) {
            document.getElementById(modalId).classList.remove('active');
            document.body.style.overflow = 'auto';
        }

        // Close modal when clicking outside
        window.onclick = function(event) {
            if (event.target.classList.contains('modal')) {
                event.target.classList.remove('active');
                document.body.style.overflow = 'auto';
            }
        }

        // Tab Switching
        function openTab(tabName) {
            var tabcontent = document.getElementsByClassName("tab-content");
            for (var i = 0; i < tabcontent.length; i++) {
                tabcontent[i].classList.remove("active");
            }
            var tabbtns = document.getElementsByClassName("tab-btn");
            for (var i = 0; i < tabbtns.length; i++) {
                tabbtns[i].classList.remove("active");
            }
            document.getElementById(tabName).classList.add("active");
            event.currentTarget.classList.add("active");
        }

        // Search Function
        function searchTable() {
            var input = document.getElementById("searchInput");
            var filter = input.value.toUpperCase();
            var table = document.getElementById("employeeTable");
            var tr = table.getElementsByTagName("tr");

            for (var i = 1; i < tr.length; i++) {
                tr[i].style.display = "none";
                var td = tr[i].getElementsByTagName("td");
                for (var j = 0; j < 3; j++) {
                    if (td[j]) {
                        var txtValue = td[j].textContent || td[j].innerText;
                        if (txtValue.toUpperCase().indexOf(filter) > -1) {
                            tr[i].style.display = "";
                            break;
                        }
                    }
                }
            }
        }

        // Filter by Status
        function filterByStatus() {
            var select = document.getElementById("statusFilter");
            var filter = select.value.toUpperCase();
            var table = document.getElementById("employeeTable");
            var tr = table.getElementsByTagName("tr");

            for (var i = 1; i < tr.length; i++) {
                var td = tr[i].getElementsByTagName("td")[6];
                if (td) {
                    var txtValue = td.textContent || td.innerText;
                    if (filter === "" || txtValue.toUpperCase().indexOf(filter) > -1) {
                        tr[i].style.display = "";
                    } else {
                        tr[i].style.display = "none";
                    }
                }
            }
        }

        // Sort Table
        function sortTable() {
            var select = document.getElementById("sortBy");
            var value = select.value;
            var table = document.getElementById("employeeTable");
            var rows = Array.from(table.querySelectorAll('tbody tr'));

            if (value === 'name-asc' || value === 'name-desc') {
                rows.sort(function(a, b) {
                    var nameA = a.cells[0].textContent.toUpperCase();
                    var nameB = b.cells[0].textContent.toUpperCase();
                    if (value === 'name-asc') {
                        return nameA.localeCompare(nameB);
                    } else {
                        return nameB.localeCompare(nameA);
                    }
                });
            } else if (value === 'date-newest' || value === 'date-oldest') {
                rows.sort(function(a, b) {
                    var dateA = new Date(a.cells[5].textContent);
                    var dateB = new Date(b.cells[5].textContent);
                    if (value === 'date-newest') {
                        return dateB - dateA;
                    } else {
                        return dateA - dateB;
                    }
                });
            }

            var tbody = table.querySelector('tbody');
            rows.forEach(function(row) {
                tbody.appendChild(row);
            });
        }

        // Show custom period when selected
        document.addEventListener('DOMContentLoaded', function() {
            var printForm = document.querySelector('#printModal form');
            if (printForm) {
                var periodSelect = printForm.querySelector('select[name="period"]');
                if (periodSelect) {
                    periodSelect.addEventListener('change', function() {
                        var customPeriod = document.getElementById('customPeriod');
                        if (this.value === 'custom') {
                            customPeriod.style.display = 'block';
                        } else {
                            customPeriod.style.display = 'none';
                        }
                    });
                }
            }
        });
    </script>

    <!-- Modal Tambah Pegawai -->
    <div class="modal fade" id="addEmployeeModal" tabindex="-1" aria-hidden="true" style="z-index: 9999;">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content" style="border-radius: 20px; border: none; overflow: hidden;">
                <div class="modal-header"
                    style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border: none; padding: 25px 30px;">
                    <h5 class="modal-title" style="font-weight: 700; font-size: 1.5rem;">
                        <i class="fas fa-user-plus me-2"></i>Tambah Pegawai Baru
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body" style="padding: 30px;">
                    <form action="{{ route('employees.store') }}" method="POST" id="addEmployeeForm">
                        @csrf

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label" style="font-weight: 600; color: #2d3748;">
                                    <i class="fas fa-user text-primary me-2"></i>Nama Lengkap
                                </label>
                                <input type="text" class="form-control" name="nama_lengkap" required
                                    style="border-radius: 10px; border: 2px solid #e2e8f0; padding: 12px;"
                                    placeholder="Masukkan nama lengkap">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label" style="font-weight: 600; color: #2d3748;">
                                    <i class="fas fa-envelope text-primary me-2"></i>Email
                                </label>
                                <input type="email" class="form-control" name="email" required
                                    style="border-radius: 10px; border: 2px solid #e2e8f0; padding: 12px;"
                                    placeholder="contoh@email.com">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label" style="font-weight: 600; color: #2d3748;">
                                    <i class="fas fa-phone text-primary me-2"></i>Nomor Telepon
                                </label>
                                <input type="text" class="form-control" name="nomor_telepon" required
                                    style="border-radius: 10px; border: 2px solid #e2e8f0; padding: 12px;"
                                    placeholder="08xxxxxxxxxx">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label" style="font-weight: 600; color: #2d3748;">
                                    <i class="fas fa-birthday-cake text-primary me-2"></i>Tanggal Lahir
                                </label>
                                <input type="date" class="form-control" name="tanggal_lahir" required
                                    style="border-radius: 10px; border: 2px solid #e2e8f0; padding: 12px;">
                            </div>

                            <div class="col-md-12 mb-3">
                                <label class="form-label" style="font-weight: 600; color: #2d3748;">
                                    <i class="fas fa-map-marker-alt text-primary me-2"></i>Alamat
                                </label>
                                <textarea class="form-control" name="alamat" rows="3" required
                                    style="border-radius: 10px; border: 2px solid #e2e8f0; padding: 12px;" placeholder="Masukkan alamat lengkap"></textarea>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label" style="font-weight: 600; color: #2d3748;">
                                    <i class="fas fa-building text-primary me-2"></i>Department
                                </label>
                                <select class="form-select" name="department_id" required
                                    style="border-radius: 10px; border: 2px solid #e2e8f0; padding: 12px;">
                                    <option value="">Pilih Department</option>
                                    @foreach ($departments as $department)
                                        <option value="{{ $department->id }}">{{ $department->nama_departemen }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label" style="font-weight: 600; color: #2d3748;">
                                    <i class="fas fa-briefcase text-primary me-2"></i>Posisi
                                </label>
                                <select class="form-select" name="position_id" required
                                    style="border-radius: 10px; border: 2px solid #e2e8f0; padding: 12px;">
                                    <option value="">Pilih Posisi</option>
                                    @foreach ($positions as $position)
                                        <option value="{{ $position->id }}">{{ $position->nama_jabatan }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label" style="font-weight: 600; color: #2d3748;">
                                    <i class="fas fa-calendar-check text-primary me-2"></i>Tanggal Masuk
                                </label>
                                <input type="date" class="form-control" name="tanggal_masuk" required
                                    style="border-radius: 10px; border: 2px solid #e2e8f0; padding: 12px;">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label" style="font-weight: 600; color: #2d3748;">
                                    <i class="fas fa-toggle-on text-primary me-2"></i>Status
                                </label>
                                <select class="form-select" name="status" required
                                    style="border-radius: 10px; border: 2px solid #e2e8f0; padding: 12px;">
                                    <option value="Aktif">Aktif</option>
                                    <option value="Cuti">Cuti</option>
                                    <option value="Nonaktif">Nonaktif</option>
                                </select>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer" style="border: none; padding: 20px 30px; background: #f7fafc;">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                        style="border-radius: 10px; padding: 12px 24px; font-weight: 600;">
                        <i class="fas fa-times me-2"></i>Batal
                    </button>
                    <button type="submit" form="addEmployeeForm" class="btn btn-primary"
                        style="background: linear-gradient(135deg, #667eea, #764ba2); border: none; border-radius: 10px; padding: 12px 24px; font-weight: 600;">
                        <i class="fas fa-save me-2"></i>Simpan Pegawai
                    </button>
                </div>
            </div>
        </div>
    </div>

    <style>
        .modal-backdrop {
            z-index: 9998 !important;
        }

        .modal {
            z-index: 9999 !important;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #667eea !important;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1) !important;
        }
    </style>

@endsection
