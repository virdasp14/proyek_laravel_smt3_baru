@extends('employees.master')

@section('title', 'Tambah Department')

@section('content')
    <style>
        .create-container {
            padding: 40px 0;
        }

        .create-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 20px;
            padding: 40px;
            color: white;
            box-shadow: 0 10px 30px rgba(102, 126, 234, 0.3);
            margin-bottom: 30px;
        }

        .create-header h1 {
            font-size: 2.5rem;
            font-weight: 800;
            margin-bottom: 10px;
        }

        .create-header .subtitle {
            font-size: 1.1rem;
            opacity: 0.9;
        }

        .form-card {
            background: white;
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
        }

        .form-group {
            margin-bottom: 25px;
        }

        .form-label {
            font-weight: 600;
            color: #2d3748;
            margin-bottom: 10px;
            font-size: 0.95rem;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .form-label i {
            color: #667eea;
        }

        .form-control,
        .form-select {
            border: 2px solid #e2e8f0;
            border-radius: 10px;
            padding: 12px 18px;
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
            outline: none;
        }

        textarea.form-control {
            min-height: 120px;
            resize: vertical;
        }

        .btn-modern {
            padding: 12px 30px;
            border-radius: 10px;
            font-weight: 600;
            transition: all 0.3s ease;
            border: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-modern:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }

        .btn-primary.btn-modern {
            background: linear-gradient(135deg, #667eea, #764ba2);
        }

        .action-buttons {
            display: flex;
            gap: 15px;
            margin-top: 30px;
        }

        .alert {
            border-radius: 10px;
            border: none;
            padding: 15px 20px;
            margin-bottom: 25px;
        }
    </style>

    <div class="create-container">
        <div class="container">
            <!-- Header -->
            <div class="create-header">
                <h1><i class="fas fa-plus-circle"></i> Tambah Department Baru</h1>
                <p class="subtitle mb-0">Tambahkan department baru ke dalam sistem</p>
            </div>

            <div class="form-card">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <strong><i class="fas fa-exclamation-circle"></i> Terdapat kesalahan:</strong>
                        <ul class="mb-0 mt-2">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('departments.store') }}" method="POST">
                    @csrf

                    <div class="form-group">
                        <label for="nama_departemen" class="form-label">
                            <i class="fas fa-building"></i>
                            Nama Department
                        </label>
                        <input type="text" class="form-control @error('nama_departemen') is-invalid @enderror"
                            id="nama_departemen" name="nama_departemen" value="{{ old('nama_departemen') }}"
                            placeholder="Contoh: IT Department, Finance, HR" required>
                        @error('nama_departemen')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="kepala_departemen" class="form-label">
                            <i class="fas fa-user-tie"></i>
                            Kepala Department
                        </label>
                        <input type="text" class="form-control @error('kepala_departemen') is-invalid @enderror"
                            id="kepala_departemen" name="kepala_departemen" value="{{ old('kepala_departemen') }}"
                            placeholder="Masukkan nama kepala department" required>
                        @error('kepala_departemen')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="deskripsi" class="form-label">
                            <i class="fas fa-align-left"></i>
                            Deskripsi
                        </label>
                        <textarea class="form-control @error('deskripsi') is-invalid @enderror" id="deskripsi" name="deskripsi"
                            placeholder="Masukkan deskripsi department" required>{{ old('deskripsi') }}</textarea>
                        @error('deskripsi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="status" class="form-label">
                            <i class="fas fa-toggle-on"></i>
                            Status
                        </label>
                        <select class="form-select @error('status') is-invalid @enderror" id="status" name="status"
                            required>
                            <option value="Aktif" {{ old('status') == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                            <option value="Nonaktif" {{ old('status') == 'Nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                        </select>
                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="action-buttons">
                        <button type="submit" class="btn btn-primary btn-modern">
                            <i class="fas fa-save"></i> Simpan Department
                        </button>
                        <a href="{{ route('departments.index') }}" class="btn btn-secondary btn-modern">
                            <i class="fas fa-times"></i> Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
