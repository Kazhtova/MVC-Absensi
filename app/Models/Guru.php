<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guru extends Model
{
    use HasFactory;
    protected $table = 'guru';
    protected $fillable = [
        'nama_guru'
    ];

    /**
     * Relasi ke model Siswa (Satu data absensi dimiliki oleh satu Siswa)
     */
}