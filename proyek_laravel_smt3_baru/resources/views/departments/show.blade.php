@extends('employees.master')

@section('title', 'Detail Department')

@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Detail Department</h5>
                    <a href="{{ route('departments.index') }}" class="btn btn-light btn-sm">
                        <i class="bi bi-arrow-left"></i> Kembali
                    </a>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between">
                            <strong>ID:</strong>
                            <span>{{ $department->id }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between">
                            <strong>Nama Department:</strong>
                            <span>{{ $department->nama_department }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between">
                            <strong>Dibuat Pada:</strong>
                            <span>{{ $department->created_at->format('d/m/Y H:i:s') }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between">
                            <strong>Diperbarui Pada:</strong>
                            <span>{{ $department->updated_at->format('d/m/Y H:i:s') }}</span>
                        </li>
                    </ul>
                </div>
                <div class="card-footer text-end">
                    <a href="{{ route('departments.edit', $department->id) }}" class="btn btn-warning">
                        <i class="bi bi-pencil-square"></i> Edit
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
