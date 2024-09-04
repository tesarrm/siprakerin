<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guru extends Model
{
    use HasFactory;
    protected $fillable = [
        'gambar',
        'nip', 
        'nama_guru',
        'jenis_kelamin',
        'peran',
        'wali_kelas',
        'username',
        'password'
    ];

    public $timestamps = false;

    // public function peserta()
    // {
    //     return $this->belongsTo(Peserta::class, 'id_peserta');
    // }
}
