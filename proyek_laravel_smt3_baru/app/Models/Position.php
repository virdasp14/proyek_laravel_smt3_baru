<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
    use HasFactory;

    // TAMBAHKAN INI
    protected $fillable = [
        'nama_jabatan',
        'gaji_pokok',
    ];

    /**
     * Get all employees for this position
     */
    public function employees()
    {
        return $this->hasMany(Employee::class, 'position_id');
    }
}
