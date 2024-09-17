<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenempatanIndustri extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'industri_id',
        'siswa_id',
        'tahun_ajaran'
    ];

    public function industri()
    {
        return $this->belongsTo(Industri::class);
    }
    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }
}
