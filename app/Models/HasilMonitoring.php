<?php

namespace App\Models;

use Illuminate\Contracts\Queue\Monitor;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HasilMonitoring extends Model
{
    use HasFactory;

    protected $fillable = [
        'jadwal_monitoring_id',
        'siswa_id',
        'hadir',
        'izin',
        'alpa',
        'catatan'
    ];

    public function jadwalMonitoring()
    {
        return $this->belongsTo(JadwalMonitoring::class);
    }

    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }
}
