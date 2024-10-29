<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jurusan extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'singkatan',
        'bidang_keahlian_id'
    ];

    public function bidangKeahlian()
    {
        return $this->belongsTo(BidangKeahlian::class);
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
