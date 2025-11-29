<?php

// ============================================
// Leave.php (Model)
// ============================================

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Leave extends Model
{
    use HasFactory;

    protected $table = 'leaves';

    protected $fillable = [
        'employee_id',
        'jenis',
        'tanggal_mulai',
        'tanggal_selesai',
        'jumlah_hari',
        'alasan',
        'dokumen',
        'status',
        'approved_by',
        'approved_at',
        'rejected_by',
        'rejected_at'
    ];

    protected $casts = [
        'tanggal_mulai' => 'date',
        'tanggal_selesai' => 'date',
        'approved_at' => 'datetime',
        'rejected_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Relationship dengan Employee
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    // Relationship dengan User yang approve
    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    // Relationship dengan User yang reject
    public function rejector()
    {
        return $this->belongsTo(User::class, 'rejected_by');
    }

    // Accessor untuk nama jenis cuti yang lebih readable
    public function getJenisNameAttribute()
    {
        $jenisMap = [
            'cuti_tahunan' => 'Cuti Tahunan',
            'cuti_sakit' => 'Cuti Sakit',
            'izin_pribadi' => 'Izin Pribadi',
            'cuti_melahirkan' => 'Cuti Melahirkan',
            'cuti_menikah' => 'Cuti Menikah'
        ];

        return $jenisMap[$this->jenis] ?? $this->jenis;
    }

    // Accessor untuk badge status
    public function getStatusBadgeAttribute()
    {
        $badges = [
            'pending' => 'badge-pending',
            'disetujui' => 'badge-approved',
            'ditolak' => 'badge-nonaktif'
        ];

        return $badges[$this->status] ?? 'badge-pending';
    }

    // Scope untuk filter berdasarkan status
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeDisetujui($query)
    {
        return $query->where('status', 'disetujui');
    }

    public function scopeDitolak($query)
    {
        return $query->where('status', 'ditolak');
    }

    // Scope untuk cuti yang sedang berlangsung
    public function scopeActive($query)
    {
        return $query->where('status', 'disetujui')
                     ->where('tanggal_mulai', '<=', now())
                     ->where('tanggal_selesai', '>=', now());
    }
}
