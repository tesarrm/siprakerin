<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Industri extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'alamat',
        'kota_id',
        'tanggal_awal',
        'tanggal_akhir',
        'keterangan',

        'user_id',
        'no_telp',
        'no_hp',
    ];

    public function kuotaIndustri()
    {
        return $this->hasMany(KuotaIndustri::class);
    }
    public function penempatanIndustri()
    {
        return $this->hasMany(PenempatanIndustri::class);
    }
    public function kota()
    {
        return $this->belongsTo(Kota::class);
    }
    public function libur()
    {
        return $this->hasOne(LiburMingguan::class);
    }
    public function gurus()
    {
        return $this->belongsToMany(Guru::class, 'guru_industri');
    }
    public function jadwalMonitorings()
    {
        return $this->hasMany(JadwalMonitoring::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
