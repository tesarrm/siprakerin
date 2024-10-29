<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Karyawan extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'aktif',
        'tempat_lahir',
        'tanggal_lahir',
        'jenis_kelamin', //
        'alamat',
        'no_telp',
        'agama',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
