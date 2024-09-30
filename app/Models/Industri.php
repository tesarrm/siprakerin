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
        'tahun_ajaran'
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
}
