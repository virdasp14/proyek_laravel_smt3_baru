<?php

// ============================================
// Payroll.php (Model)
// ============================================

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payroll extends Model
{
    use HasFactory;

    protected $table = 'payrolls';

    protected $fillable = [
        'employee_id',
        'gaji_pokok',
        'tunjangan',
        'potongan',
        'total_gaji',
        'periode',
        'status_pembayaran',
        'keterangan'
    ];

    protected $casts = [
        'gaji_pokok' => 'decimal:2',
        'tunjangan' => 'decimal:2',
        'potongan' => 'decimal:2',
        'total_gaji' => 'decimal:2',
        'periode' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Relationship dengan Employee
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    // Accessor untuk format rupiah
    public function getFormattedGajiPokokAttribute()
    {
        return 'Rp ' . number_format($this->gaji_pokok, 0, ',', '.');
    }

    public function getFormattedTunjanganAttribute()
    {
        return 'Rp ' . number_format($this->tunjangan, 0, ',', '.');
    }

    public function getFormattedPotonganAttribute()
    {
        return 'Rp ' . number_format($this->potongan, 0, ',', '.');
    }

    public function getFormattedTotalGajiAttribute()
    {
        return 'Rp ' . number_format($this->total_gaji, 0, ',', '.');
    }

    // Scope untuk filter berdasarkan periode
    public function scopePeriode($query, $month, $year)
    {
        return $query->whereYear('periode', $year)
                     ->whereMonth('periode', $month);
    }
}
