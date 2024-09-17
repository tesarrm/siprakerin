<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KuotaIndustri extends Model
{
    use HasFactory;

    protected $fillable = [
        'industri_id',
        'jenis_kelamin',
        'jurusan_id',
        'kuota',
    ];

    public function industri()
    {
        return $this->belongsTo(Industri::class);
    }
    public function jurusan()
    {
        return $this->belongsTo(Jurusan::class);
    }
}
