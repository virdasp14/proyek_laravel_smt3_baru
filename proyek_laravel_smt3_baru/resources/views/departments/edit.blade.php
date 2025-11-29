@extends('employees.master')

@section('title', 'Edit Department')

@section('content')
    <style>
        .edit-container {
            padding: 40px 0;
        }

        .form-card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .form-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 40px;
            color: white;
        }

        .form-header h1 {
            font-size: 2rem;
            font-weight: 800;
            margin-bottom: 10px;
        }

        .form-header p {
            opacity: 0.9;
            margin-bottom: 0;
        }

        .form-body {
            padding: 40px;
        }

        .form-group-modern {
            margin-bottom: 25px;
        }

        .form-group-modern label {
            font-weight: 600;
            color: #2d3748;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .form-group-modern label i {
            color: #667eea;
        }

        .form-control-modern {
            border: 2px solid #e2e8f0;
            border-radius: 10px;
            padding: 12px 18px;
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        .form-control-modern:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
            outline: none;
        }

        .form-select-modern {
            border: 2px solid #e2e8f0;
            border-radius: 10px;
            padding: 12px 18px;
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        .form-select-modern:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
            outline: none;
        }

        textarea.form-control-modern {
            min-height: 120px;
            resize: vertical;
        }

        .btn-modern {
            padding: 14px 35px;
            border-radius: 10px;
            font-weight: 600;
            font-size: 1rem;
            transition: all 0.3s ease;
            border: none;
        }

        .btn-modern:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }

        .alert-modern {
            border-radius: 10px;
            border: none;
            padding: 15px 20px;
        }
    </style>

    <div class="edit-container">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="form-card">
                        <div class="form-header">
                            <h1><i class="fas fa-edit"></i> Edit Department</h1>
                            <p>Perbarui informasi department yang sudah ada</p>
                        </div>
                        <div class="form-body">
                            @if ($errors->any())
                                <div class="alert alert-danger alert-modern">
                                    <h5><i class="fas fa-exclamation-triangle"></i> Terjadi Kesalahan!</h5>
                                    <ul class="mb-0 mt-2">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <form action="{{ route('departments.update', $department->id) }}" method="POST">
                                @csrf
                                @method('PUT')

                                <div class="form-group-modern">
                                    <label for="nama_departemen">
                                        <i class="fas fa-building"></i> Nama Departemen
                                    </label>
                                    <input type="text" name="nama_departemen" class="form-control form-control-modern"
                                        id="nama_departemen"
                                        value="{{ old('nama_departemen', $department->nama_departemen) }}"
                                        placeholder="Contoh: IT Department" required>
                                </div>

                                <div class="form-group-modern">
                                    <label for="kepala_departemen">
                                        <i class="fas fa-user-tie"></i> Kepala Departemen
                                    </label>
                                    <input type="text" name="kepala_departemen" class="form-control form-control-modern"
                                        id="kepala_departemen"
                                        value="{{ old('kepala_departemen', $department->kepala_departemen) }}"
                                        placeholder="Nama kepala departemen" required>
                                </div>

                                <div class="form-group-modern">
                                    <label for="deskripsi">
                                        <i class="fas fa-align-left"></i> Deskripsi Department
                                    </label>
                                    <textarea name="deskripsi" class="form-control form-control-modern" id="deskripsi"
                                        placeholder="Jelaskan tugas dan tanggung jawab department ini..." required>{{ old('deskripsi', $department->deskripsi) }}</textarea>
                                </div>

                                <div class="form-group-modern">
                                    <label for="status">
                                        <i class="fas fa-toggle-on"></i> Status Department
                                    </label>
                                    <select name="status" class="form-select form-select-modern" id="status" required>
                                        <option value="Aktif"
                                            {{ old('status', $department->status) == 'Aktif' ? 'selected' : '' }}>Aktif
                                        </option>
                                        <option value="Nonaktif"
                                            {{ old('status', $department->status) == 'Nonaktif' ? 'selected' : '' }}>
                                            Nonaktif</option>
                                    </select>
                                </div>

                                <div class="d-flex gap-3 justify-content-end mt-4">
                                    <a href="{{ route('departments.index') }}" class="btn btn-secondary btn-modern">
                                        <i class="fas fa-times"></i> Batal
                                    </a>
                                    <button type="submit" class="btn btn-primary btn-modern">
                                        <i class="fas fa-save"></i> Update Department
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection
