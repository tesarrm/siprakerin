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
        'aktif',
        'pas_foto',
        'nis',
        'nisn',
        'nama_lengkap',
        'nama',
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
    public function penempatan()
    {
        return $this->hasOne(PenempatanIndustri::class);
    }
    public function ortus()
    {
        return $this->belongsToMany(Ortu::class, 'ortu_siswa');
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function kehadirans()
    {
        return $this->hasMany(Attendance::class);
    }
}
