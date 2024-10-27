<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MonitoringImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'monitoring_id',
        'gambar',
    ];

    /**
     * Relasi ke model Monitoring
     */
    public function monitoring()
    {
        return $this->belongsTo(Monitoring::class);
    }
}
