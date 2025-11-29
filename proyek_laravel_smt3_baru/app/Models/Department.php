<?php

// ============================================
// Department.php (Model)
// ============================================

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;

    protected $table = 'departments';

    protected $fillable = [
        'nama_departemen',
        'kepala_departemen',
        'deskripsi',
        'status'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Relationship dengan Employee
    public function employees()
    {
        return $this->hasMany(Employee::class, 'department_id');
    }

    // Scope untuk departemen aktif
    public function scopeAktif($query)
    {
        return $query->where('status', 'Aktif');
    }
}
