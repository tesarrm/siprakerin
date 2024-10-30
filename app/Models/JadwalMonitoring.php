<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JadwalMonitoring extends Model
{
    use HasFactory;

    protected $fillable = [
        'guru_id',
        'tahun_ajaran_id',
        'industri_id',
        'gambar',
        'tanggal'
    ];

    public function guru()
    {
        return $this->belongsTo(Guru::class);
    }

    public function industri()
    {
        return $this->belongsTo(Industri::class);
    }

    public function hasilMonitoring()
    {
        return $this->hasOne(HasilMonitoring::class);
    }
    public function tahunAjaran()
    {
        return $this->belongsTo(TahunAjaran::class);
    }
}
