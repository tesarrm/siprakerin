<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PelanggaranSiswa extends Model
{
    use HasFactory;

    protected $fillable = [
        'siswa_id',
        'tanggal',
        'pelanggaran',
        'solusi'
    ];

    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }
}
