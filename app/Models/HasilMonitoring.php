<?php

namespace App\Models;

use Illuminate\Contracts\Queue\Monitor;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HasilMonitoring extends Model
{
    use HasFactory;

    protected $fillable = [
        'monitoring_id',
        'siswa_id',
        'hadir',
        'izin',
        'alpa',
        'catatan'
    ];

    public function monitoring()
    {
        return $this->belongsTo(Monitoring::class);
    }

    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }
}
