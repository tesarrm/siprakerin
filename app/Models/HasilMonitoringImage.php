<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HasilMonitoringImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'jadwal_monitoring_id',
        'gambar',
    ];

    /**
     * Relasi ke model Monitoring
     */
    public function jadwalMonitoring()
    {
        return $this->belongsTo(JadwalMonitoring::class);
    }
}
