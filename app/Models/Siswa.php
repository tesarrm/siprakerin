<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'kelas_id',
        'tahun_ajaran_id',
        'aktif',
        'pas_foto',
        'nis',
        'nisn',
        'tempat_lahir',
        'tanggal_lahir',
        'jenis_kelamin',
        'agama',
        'alamat',
        'no_telp',
    ];

    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }
    public function pilihankota()
    {
        return $this->hasOne(PilihanKota::class);
    }
    public function walisiswa()
    {
        return $this->hasOne(WaliSiswa::class);
    }
    public function penempatan()
    {
        return $this->hasOne(PenempatanIndustri::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function kehadirans()
    {
        return $this->hasMany(Attendance::class);
    }
    public function tahunAjaran()
    {
        return $this->belongsTo(TahunAjaran::class);
    }
}
