<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama', 
        'tahun_ajaran', 
        'jurusan_id', 
        'klasifikasi', 
        'guru_id', 
    ];

    public function jurusan()
    {
        return $this->belongsTo(Jurusan::class);
    }
    public function guru()
    {
        return $this->belongsTo(Guru::class);
    }
}