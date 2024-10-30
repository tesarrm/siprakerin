<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WaliSiswa extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'siswa_id',
        'aktif',
        'pekerjaan',
        'no_telp',
        'jenis_kelamin',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }

}
