<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ortu extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'pekerjaan',
        'no_telp',
        'jenis_kelamin',
    ];

    public function siswas()
    {
        return $this->belongsToMany(Siswa::class, 'ortu_siswa');
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
