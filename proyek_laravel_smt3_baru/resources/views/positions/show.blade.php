@extends('employees.master')

@section('title', 'Detail Position')

@section('content')
    <style>
        .detail-container {
            padding: 40px 0;
        }

        .position-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 20px;
            padding: 40px;
            color: white;
            box-shadow: 0 10px 30px rgba(102, 126, 234, 0.3);
            margin-bottom: 30px;
        }

        .position-header h1 {
            font-size: 2.5rem;
            font-weight: 800;
            margin-bottom: 10px;
        }

        .position-header .subtitle {
            font-size: 1.1rem;
            opacity: 0.9;
        }

        .info-card {
            background: white;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
            margin-bottom: 30px;
        }

        .info-item {
            padding: 20px 0;
            border-bottom: 1px solid #f0f0f0;
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .info-item:last-child {
            border-bottom: none;
        }

        .info-icon {
            width: 50px;
            height: 50px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.3rem;
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            flex-shrink: 0;
        }

        .info-content {
            flex: 1;
        }

        .info-label {
            font-size: 0.85rem;
            color: #718096;
            margin-bottom: 5px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-weight: 600;
        }

        .info-value {
            font-size: 1.1rem;
            color: #2d3748;
            font-weight: 600;
        }

        .employee-card-compact {
            background: white;
            border-radius: 16px;
            padding: 24px;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.06);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border: 1px solid #e2e8f0;
            height: 100%;
            position: relative;
            overflow: hidden;
        }

        .employee-card-compact::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 4px;
            height: 100%;
            background: linear-gradient(135deg, #667eea, #764ba2);
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .employee-card-compact:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 28px rgba(102, 126, 234, 0.15);
            border-color: #667eea;
        }

        .employee-card-compact:hover::before {
            opacity: 1;
        }

        .employee-avatar-small {
            width: 60px;
            height: 60px;
            border-radius: 14px;
            background: linear-gradient(135deg, #667eea, #764ba2);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.6rem;
            flex-shrink: 0;
            box-shadow: 0 4px 14px rgba(102, 126, 234, 0.25);
        }

        .employee-name-compact {
            font-size: 1.15rem;
            font-weight: 700;
            color: #1a202c;
            margin-bottom: 6px;
            line-height: 1.3;
        }

        .employee-department-compact {
            font-size: 0.9rem;
            color: #667eea;
            font-weight: 600;
            margin-bottom: 12px;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .employee-meta {
            display: flex;
            align-items: center;
            gap: 10px;
            flex-wrap: wrap;
        }

        .badge-compact {
            padding: 5px 12px;
            border-radius: 8px;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }

        .meta-icon {
            width: 26px;
            height: 26px;
            border-radius: 6px;
            background: #f7fafc;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #718096;
            font-size: 0.75rem;
        }

        .btn-detail-compact {
            width: 42px;
            height: 42px;
            border-radius: 12px;
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            border: none;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
            cursor: pointer;
            flex-shrink: 0;
        }

        .btn-detail-compact:hover {
            transform: scale(1.08);
            box-shadow: 0 6px 18px rgba(102, 126, 234, 0.45);
        }

        .btn-detail-compact i {
            font-size: 1rem;
        }

        .section-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: #2d3748;
            margin-bottom: 25px;
            padding-bottom: 15px;
            border-bottom: 3px solid #667eea;
        }

        .action-buttons {
            display: flex;
            gap: 15px;
            margin-top: 30px;
        }

        .btn-modern {
            padding: 12px 30px;
            border-radius: 10px;
            font-weight: 600;
            transition: all 0.3s ease;
            border: none;
        }

        .btn-modern:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }

        .empty-state {
            text-align: center;
            padding: 60px 20px;
        }

        .empty-state i {
            font-size: 4rem;
            color: #cbd5e0;
            margin-bottom: 20px;
        }

        .modal-backdrop {
            z-index: 9998 !important;
        }

        .modal {
            z-index: 9999 !important;
        }
    </style>

    <div class="detail-container">
        <div class="container">
            <!-- Header Position -->
            <div class="position-header">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <h1><i class="fas fa-briefcase"></i> {{ $position->nama_jabatan }}</h1>
                        <p class="subtitle mb-0">Gaji Pokok: Rp {{ number_format($position->gaji_pokok, 0, ',', '.') }}</p>
                    </div>
                    <div class="action-buttons">
                        <a href="{{ route('positions.index') }}" class="btn btn-light btn-modern">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                        <a href="{{ route('positions.edit', $position->id) }}" class="btn btn-warning btn-modern">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <!-- Informasi Position -->
                    <div class="info-card">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="info-item">
                                    <div class="info-icon" style="background: linear-gradient(135deg, #4facfe, #00f2fe);">
                                        <i class="fas fa-users"></i>
                                    </div>
                                    <div class="info-content">
                                        <div class="info-label">Total Pegawai</div>
                                        <div class="info-value">{{ $position->employees_count ?? 0 }} Orang</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="info-item">
                                    <div class="info-icon" style="background: linear-gradient(135deg, #43e97b, #38f9d7);">
                                        <i class="fas fa-money-bill-wave"></i>
                                    </div>
                                    <div class="info-content">
                                        <div class="info-label">Gaji Pokok</div>
                                        <div class="info-value">Rp {{ number_format($position->gaji_pokok, 0, ',', '.') }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="info-item">
                                    <div class="info-icon" style="background: linear-gradient(135deg, #fa709a, #fee140);">
                                        <i class="fas fa-history"></i>
                                    </div>
                                    <div class="info-content">
                                        <div class="info-label">Update Terakhir</div>
                                        <div class="info-value" style="font-size: 0.95rem;">
                                            {{ $position->updated_at->format('d M Y') }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Daftar Pegawai -->
                    <div class="info-card mt-4">
                        <h2 class="section-title"><i class="fas fa-users"></i> Pegawai dengan Posisi Ini</h2>
                        @if ($position->employees && $position->employees->count() > 0)
                            <div class="row g-3">
                                @foreach ($position->employees as $employee)
                                    <div class="col-md-6">
                                        <div class="employee-card-compact">
                                            <div class="d-flex align-items-start gap-3">
                                                <div class="employee-avatar-small">
                                                    <i class="fas fa-user"></i>
                                                </div>
                                                <div class="flex-grow-1" style="min-width: 0;">
                                                    <h5 class="employee-name-compact">{{ $employee->nama_lengkap }}</h5>
                                                    <p class="employee-department-compact">
                                                        <i class="fas fa-building"></i>
                                                        <span>{{ $employee->department->nama_departemen ?? 'Department tidak ada' }}</span>
                                                    </p>
                                                    <div class="employee-meta">
                                                        <span
                                                            class="badge-compact {{ $employee->status == 'Aktif' ? 'bg-success' : 'bg-secondary' }}">
                                                            {{ $employee->status }}
                                                        </span>
                                                        @if ($employee->email)
                                                            <span class="meta-icon" title="Email tersedia">
                                                                <i class="fas fa-envelope"></i>
                                                            </span>
                                                        @endif
                                                        @if ($employee->nomor_telepon)
                                                            <span class="meta-icon" title="Telepon tersedia">
                                                                <i class="fas fa-phone"></i>
                                                            </span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div>
                                                    <button type="button" class="btn-detail-compact" data-bs-toggle="modal"
                                                        data-bs-target="#employeeDetailModal"
                                                        data-nama="{{ $employee->nama_lengkap }}"
                                                        data-position="{{ $position->nama_jabatan }}"
                                                        data-department="{{ $employee->department->nama_departemen ?? 'Department tidak ada' }}"
                                                        data-email="{{ $employee->email ?? '-' }}"
                                                        data-phone="{{ $employee->nomor_telepon ?? '-' }}"
                                                        data-birth="{{ $employee->tanggal_lahir ?? '-' }}"
                                                        data-address="{{ $employee->alamat ?? '-' }}"
                                                        data-joindate="{{ $employee->tanggal_masuk ?? '-' }}"
                                                        data-status="{{ $employee->status }}"
                                                        onclick="showEmployeeDetail(this)">
                                                        <i class="fas fa-eye"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="empty-state">
                                <i class="fas fa-users-slash"></i>
                                <h4 class="text-muted mb-3">Belum Ada Pegawai</h4>
                                <p class="text-muted mb-4">Posisi ini belum memiliki pegawai. Silakan tambahkan pegawai
                                    baru.</p>
                                <a href="{{ route('employees.index') }}" class="btn btn-primary btn-modern">
                                    <i class="fas fa-plus"></i> Tambah Pegawai
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Detail Pegawai -->
    <div class="modal fade" id="employeeDetailModal" tabindex="-1" aria-hidden="true" style="z-index: 9999;">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="border-radius: 20px; border: none; overflow: hidden;">
                <div class="modal-header"
                    style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border: none; padding: 25px 30px;">
                    <h5 class="modal-title" style="font-weight: 700; font-size: 1.3rem;">
                        <i class="fas fa-user-circle me-2"></i>Detail Pegawai
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body" style="padding: 30px;">
                    <div class="text-center mb-4">
                        <div
                            style="width: 100px; height: 100px; margin: 0 auto; border-radius: 50%; background: linear-gradient(135deg, #667eea, #764ba2); display: flex; align-items: center; justify-content: center; box-shadow: 0 10px 30px rgba(102, 126, 234, 0.3);">
                            <i class="fas fa-user" style="font-size: 3rem; color: white;"></i>
                        </div>
                        <h4 id="modalEmployeeName" class="mt-3 mb-1" style="font-weight: 800; color: #1a202c;"></h4>
                        <p id="modalEmployeePosition" class="text-muted mb-0"
                            style="font-size: 1.1rem; font-weight: 600;"></p>
                    </div>

                    <div class="detail-items">
                        <div class="detail-item">
                            <div class="detail-icon">
                                <i class="fas fa-building"></i>
                            </div>
                            <div class="detail-content">
                                <div class="detail-label">Department</div>
                                <div class="detail-value" id="modalEmployeeDepartment"></div>
                            </div>
                        </div>

                        <div class="detail-item">
                            <div class="detail-icon">
                                <i class="fas fa-envelope"></i>
                            </div>
                            <div class="detail-content">
                                <div class="detail-label">Email</div>
                                <div class="detail-value" id="modalEmployeeEmail"></div>
                            </div>
                        </div>

                        <div class="detail-item">
                            <div class="detail-icon">
                                <i class="fas fa-phone"></i>
                            </div>
                            <div class="detail-content">
                                <div class="detail-label">Telepon</div>
                                <div class="detail-value" id="modalEmployeePhone"></div>
                            </div>
                        </div>

                        <div class="detail-item">
                            <div class="detail-icon">
                                <i class="fas fa-birthday-cake"></i>
                            </div>
                            <div class="detail-content">
                                <div class="detail-label">Tanggal Lahir</div>
                                <div class="detail-value" id="modalEmployeeBirth"></div>
                            </div>
                        </div>

                        <div class="detail-item">
                            <div class="detail-icon">
                                <i class="fas fa-map-marker-alt"></i>
                            </div>
                            <div class="detail-content">
                                <div class="detail-label">Alamat</div>
                                <div class="detail-value" id="modalEmployeeAddress"></div>
                            </div>
                        </div>

                        <div class="detail-item">
                            <div class="detail-icon">
                                <i class="fas fa-calendar-check"></i>
                            </div>
                            <div class="detail-content">
                                <div class="detail-label">Tanggal Masuk</div>
                                <div class="detail-value" id="modalEmployeeJoinDate"></div>
                            </div>
                        </div>

                        <div class="detail-item">
                            <div class="detail-icon">
                                <i class="fas fa-info-circle"></i>
                            </div>
                            <div class="detail-content">
                                <div class="detail-label">Status</div>
                                <div class="detail-value">
                                    <span id="modalEmployeeStatus" class="badge"
                                        style="padding: 8px 16px; font-size: 0.9rem;"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .detail-items {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .detail-item {
            display: flex;
            align-items: center;
            gap: 15px;
            padding: 15px;
            background: #f7fafc;
            border-radius: 12px;
            transition: all 0.3s ease;
        }

        .detail-item:hover {
            background: #edf2f7;
            transform: translateX(5px);
        }

        .detail-icon {
            width: 45px;
            height: 45px;
            border-radius: 10px;
            background: white;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
            flex-shrink: 0;
        }

        .detail-icon i {
            font-size: 1.2rem;
            background: linear-gradient(135deg, #667eea, #764ba2);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .detail-content {
            flex: 1;
        }

        .detail-label {
            font-size: 0.75rem;
            color: #718096;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-weight: 600;
            margin-bottom: 4px;
        }

        .detail-value {
            font-size: 1rem;
            color: #2d3748;
            font-weight: 600;
        }
    </style>

    <script>
        function showEmployeeDetail(button) {
            document.getElementById('modalEmployeeName').textContent = button.getAttribute('data-nama');
            document.getElementById('modalEmployeePosition').textContent = button.getAttribute('data-position');
            document.getElementById('modalEmployeeDepartment').textContent = button.getAttribute('data-department');
            document.getElementById('modalEmployeeEmail').textContent = button.getAttribute('data-email');
            document.getElementById('modalEmployeePhone').textContent = button.getAttribute('data-phone');
            document.getElementById('modalEmployeeBirth').textContent = button.getAttribute('data-birth');
            document.getElementById('modalEmployeeAddress').textContent = button.getAttribute('data-address');
            document.getElementById('modalEmployeeJoinDate').textContent = button.getAttribute('data-joindate');

            const status = button.getAttribute('data-status');
            const statusBadge = document.getElementById('modalEmployeeStatus');
            statusBadge.textContent = status;
            statusBadge.className = 'badge ' + (status === 'Aktif' ? 'bg-success' : 'bg-secondary');
        }
    </script>

@endsection
