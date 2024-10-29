<?php

namespace App\Models;

use Illuminate\Contracts\Queue\Monitor;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guru extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'aktif',
        'nip', //
        'no_ktp',
        'nama', //
        'tempat_lahir',
        'tanggal_lahir',
        'jenis_kelamin', //
        'golongan_darah',
        'kecamatan',
        'alamat',
        'rt',
        'rw',
        'kode_pos',
        'no_telp',
        'no_hp',
        'agama',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function monitorings()
    {
        return $this->hasMany(Monitoring::class);
    }
    public function hoKelas()
    {
        return $this->hasOne(Kelas::class);
    }
    public function industris()
    {
        return $this->belongsToMany(Industri::class, 'guru_industri');
    }
}
