<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TujuanPembelajaran extends Model
{
    use HasFactory;

    protected $fillable = [
        'capaian_pembelajaran_id',
        'nama'
    ];

    public function nilai()
    {
        return $this->hasOne(Nilai::class);
    }
}
