<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CapaianPembelajaran extends Model
{
    use HasFactory;

    protected $fillable = [
        'jurusan_id',
        'nama'
    ];

    public function tujuanPembelajaran()
    {
        return $this->hasMany(TujuanPembelajaran::class);
    }

    public function jurusan()
    {
        return $this->belongsTo(Jurusan::class);
    }
}
