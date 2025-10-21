@extends('layouts.app')
@section('content')
<div class="container mt-5 p-4 bg-white shadow rounded">
    <h2 class="mb-4 text-center text-primary">Tambah Data Absensi</h2>
    <form action="{{ route('attendance.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label>Karyawan</label>
            <select name="karyawan_id" class="form-select">
                @foreach($employees as $e)
                    <option value="{{ $e->id }}">{{ $e->nama_lengkap }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label>Tanggal</label>
            <input type="date" name="tanggal" class="form-control">
        </div>
        <div class="mb-3">
            <label>Waktu Masuk</label>
            <input type="time" name="waktu_masuk" class="form-control">
        </div>
        <div class="mb-3">
            <label>Waktu Keluar</label>
            <input type="time" name="waktu_keluar" class="form-control">
        </div>
        <div class="mb-3">
            <label>Status Absensi</label>
            <select name="status_absensi" class="form-select">
                <option value="hadir">Hadir</option>
                <option value="izin">Izin</option>
                <option value="sakit">Sakit</option>
                <option value="alpha">Alpha</option>
            </select>
        </div>
        <button class="btn btn-gradient">Simpan</button>
        <a href="{{ route('attendance.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection
