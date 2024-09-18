<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    use HasFactory;

    protected $fillable = [
        'gambar',
        'nis',
        'nama',
        'jenis_kelamin',
        'kelas_id',
        'username',
        'password'
    ];

    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }
    public function pilihankota()
    {
        return $this->hasOne(PilihanKota::class);
    }
}
