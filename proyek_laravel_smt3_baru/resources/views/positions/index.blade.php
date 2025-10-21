@extends('employees.master')
@section('title', 'Daftar Jabatan')
@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Daftar Jabatan</h1>
        <a href="{{ route('positions.create') }}" class="btn btn-primary"><i class="bi bi-plus-circle"></i> Tambah Jabatan</a>
    </div>
    @if ($message = Session::get('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ $message }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    <div class="card shadow-sm border-0">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Nama Jabatan</th>
                            <th scope="col">Gaji Pokok</th>
                            <th scope="col" style="width: 20%;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($positions as $index => $position)
                        <tr>
                            <td>{{ $positions->firstItem() + $index }}</td>
                            <td>{{ $position->nama_jabatan }}</td>
                            <td>Rp {{ number_format($position->gaji_pokok, 2, ',', '.') }}</td>
                            <td>
                                <form action="{{ route('positions.destroy', $position->id) }}" method="POST" class="d-flex gap-2">
                                    <a href="{{ route('positions.show', $position->id) }}" class="btn btn-info btn-sm"><i class="bi bi-eye"></i></a>
                                    <a href="{{ route('positions.edit', $position->id) }}" class="btn btn-warning btn-sm"><i class="bi bi-pencil-square"></i></a>
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin?')"><i class="bi bi-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center">Data jabatan masih kosong.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-center">
                {!! $positions->links() !!}
            </div>
        </div>
    </div>
</div>
@endsection
