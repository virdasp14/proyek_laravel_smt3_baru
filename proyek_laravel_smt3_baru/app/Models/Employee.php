<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $table = 'employees';
    protected $primaryKey = 'id';

    protected $fillable = [
        'nama_lengkap',
        'email',
        'nomor_telepon',
        'tanggal_lahir',
        'alamat',
        'tanggal_masuk',
        'status',
        'department_id'
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
        'tanggal_masuk' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    protected $attributes = [
        'status' => 'Aktif',
    ];

    // TAMBAHAN: Relationship dengan Department
    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    // TAMBAHAN: Relationship dengan Payroll
    public function payrolls()
    {
        return $this->hasMany(Payroll::class);
    }

    // TAMBAHAN: Relationship dengan Leave
    public function leaves()
    {
        return $this->hasMany(Leave::class);
    }

    // Scope untuk filter pegawai aktif
    public function scopeAktif($query)
    {
        return $query->where('status', 'Aktif');
    }

    public function scopeCuti($query)
    {
        return $query->where('status', 'Cuti');
    }

    public function scopeNonaktif($query)
    {
        return $query->where('status', 'Nonaktif');
    }

    // Accessor untuk format nomor telepon
    public function getFormattedPhoneAttribute()
    {
        return $this->nomor_telepon;
    }

    // Accessor untuk umur
    public function getUmurAttribute()
    {
        return $this->tanggal_lahir ? $this->tanggal_lahir->age : null;
    }

    // Accessor untuk lama kerja
    public function getLamaKerjaAttribute()
    {
        if (!$this->tanggal_masuk) {
            return null;
        }

        $diff = $this->tanggal_masuk->diff(now());
        $years = $diff->y;
        $months = $diff->m;

        if ($years > 0) {
            return $years . ' tahun ' . $months . ' bulan';
        } else {
            return $months . ' bulan';
        }
    }
}
