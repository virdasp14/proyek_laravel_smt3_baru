<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Attendance extends Model
{
    use HasFactory;

    /**
     * Nama tabel di database
     */
    protected $table = 'attendances';

    /**
     * Primary key
     */
    protected $primaryKey = 'id';

    /**
     * Field yang bisa diisi mass assignment
     */
    protected $fillable = [
        'employee_id',
        'tanggal',
        'jam_masuk',
        'jam_keluar',
        'total_jam',
        'status',
        'keterangan'
    ];

    /**
     * Field yang di-cast ke tipe data tertentu
     */
    protected $casts = [
        'tanggal' => 'date',
        'jam_masuk' => 'datetime:H:i:s',
        'jam_keluar' => 'datetime:H:i:s',
        'total_jam' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Default values
     */
    protected $attributes = [
        'status' => 'hadir',
        'total_jam' => 0,
    ];

    /**
     * Relationship dengan Employee
     */
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    /**
     * Scope untuk absensi hari ini
     */
    public function scopeToday($query)
    {
        return $query->whereDate('tanggal', Carbon::today());
    }

    /**
     * Scope untuk absensi bulan ini
     */
    public function scopeThisMonth($query)
    {
        return $query->whereMonth('tanggal', Carbon::now()->month)
                     ->whereYear('tanggal', Carbon::now()->year);
    }

    /**
     * Scope untuk absensi tahun ini
     */
    public function scopeThisYear($query)
    {
        return $query->whereYear('tanggal', Carbon::now()->year);
    }

    /**
     * Scope untuk filter berdasarkan status
     */
    public function scopeHadir($query)
    {
        return $query->where('status', 'hadir');
    }

    public function scopeIzin($query)
    {
        return $query->where('status', 'izin');
    }

    public function scopeSakit($query)
    {
        return $query->where('status', 'sakit');
    }

    public function scopeAlpha($query)
    {
        return $query->where('status', 'alpha');
    }

    public function scopeTerlambat($query)
    {
        return $query->where('status', 'terlambat');
    }

    /**
     * Scope untuk filter berdasarkan tanggal range
     */
    public function scopeDateRange($query, $startDate, $endDate)
    {
        return $query->whereBetween('tanggal', [$startDate, $endDate]);
    }

    /**
     * Accessor untuk format jam masuk
     */
    public function getFormattedJamMasukAttribute()
    {
        return $this->jam_masuk ? Carbon::parse($this->jam_masuk)->format('H:i') : '-';
    }

    /**
     * Accessor untuk format jam keluar
     */
    public function getFormattedJamKeluarAttribute()
    {
        return $this->jam_keluar ? Carbon::parse($this->jam_keluar)->format('H:i') : '-';
    }

    /**
     * Accessor untuk format tanggal
     */
    public function getFormattedTanggalAttribute()
    {
        return $this->tanggal ? Carbon::parse($this->tanggal)->format('d-m-Y') : '-';
    }

    /**
     * Accessor untuk format tanggal lengkap
     */
    public function getFormattedTanggalLengkapAttribute()
    {
        return $this->tanggal ? Carbon::parse($this->tanggal)->isoFormat('dddd, D MMMM Y') : '-';
    }

    /**
     * Accessor untuk status badge class
     */
    public function getStatusBadgeAttribute()
    {
        $badges = [
            'hadir' => 'badge-hadir',
            'izin' => 'badge-izin',
            'sakit' => 'badge-sakit',
            'alpha' => 'badge-alpha',
            'terlambat' => 'badge-terlambat'
        ];

        return $badges[$this->status] ?? 'badge-hadir';
    }

    /**
     * Accessor untuk status text
     */
    public function getStatusTextAttribute()
    {
        $texts = [
            'hadir' => 'Hadir',
            'izin' => 'Izin',
            'sakit' => 'Sakit',
            'alpha' => 'Alpha',
            'terlambat' => 'Terlambat'
        ];

        return $texts[$this->status] ?? 'Hadir';
    }

    /**
     * Cek apakah pegawai terlambat
     */
    public function isTerlambat()
    {
        if (!$this->jam_masuk) {
            return false;
        }

        $jamMasuk = Carbon::parse($this->jam_masuk);
        $batasWaktu = Carbon::parse('08:00');

        return $jamMasuk->gt($batasWaktu);
    }

    /**
     * Hitung total jam kerja
     */
    public function calculateTotalJam()
    {
        if (!$this->jam_masuk || !$this->jam_keluar) {
            return 0;
        }

        $masuk = Carbon::parse($this->jam_masuk);
        $keluar = Carbon::parse($this->jam_keluar);

        if ($keluar->gt($masuk)) {
            return $masuk->diffInHours($keluar);
        }

        return 0;
    }

    /**
     * Get status color
     */
    public function getStatusColor()
    {
        $colors = [
            'hadir' => '#48bb78',
            'izin' => '#ecc94b',
            'sakit' => '#ed8936',
            'alpha' => '#f56565',
            'terlambat' => '#9f7aea'
        ];

        return $colors[$this->status] ?? '#48bb78';
    }

    /**
     * Boot method
     */
    protected static function boot()
    {
        parent::boot();

        // Event sebelum create
        static::creating(function ($attendance) {
            // Auto hitung total jam jika ada jam keluar
            if ($attendance->jam_keluar) {
                $attendance->total_jam = $attendance->calculateTotalJam();
            }

            // Auto set status terlambat
            if ($attendance->status == 'hadir' && $attendance->isTerlambat()) {
                $attendance->status = 'terlambat';
            }
        });

        // Event sebelum update
        static::updating(function ($attendance) {
            // Auto hitung ulang total jam jika ada perubahan
            if ($attendance->jam_keluar) {
                $attendance->total_jam = $attendance->calculateTotalJam();
            }
        });
    }
}
