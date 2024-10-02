<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PilihanKota extends Model
{
    use HasFactory;

    protected $fillable = [
        'siswa_id',
        'kota_id_1',
        'kota_id_2',
        'kota_id_3',
        'status',
        'alasan'
    ];

    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }
    public function kota1()
    {
        return $this->belongsTo(Kota::class, 'kota_id_1');
    }
    public function kota2()
    {
        return $this->belongsTo(Kota::class, 'kota_id_2');
    }
    public function kota3()
    {
        return $this->belongsTo(Kota::class, 'kota_id_3');
    }
}
