<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama', 
        'jurusan_id', 
        'jurusan_id_2', 
        'klasifikasi', 
        'guru_id', 
    ];

    public function jurusan()
    {
        return $this->belongsTo(Jurusan::class);
    }
    public function jurusan2()
    {
        return $this->belongsTo(Jurusan::class, 'jurusan_id_2');
    }
    public function guru()
    {
        return $this->belongsTo(Guru::class);
    }
    public function siswas()
    {
        return $this->hasMany(Siswa::class);
    }
}
