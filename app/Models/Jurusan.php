<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jurusan extends Model
{
    use HasFactory;

    protected $fillable = [
        'bidang_keahlian_id',
        'jurusan_id',
        'nama',
        'singkatan',
    ];

    public function bidangKeahlian()
    {
        return $this->belongsTo(BidangKeahlian::class);
    }

    public function jurusan()
    {
        return $this->belongsTo(Jurusan::class);
    }

    public function jurusans()
    {
        return $this->hasMany(Jurusan::class);
    }

    public function capaianPembelajaran()
    {
        return $this->hasMany(CapaianPembelajaran::class);
    }

    public function kuotaIndustris()
    {
        return $this->hasMany(KuotaIndustri::class);
    }
}
