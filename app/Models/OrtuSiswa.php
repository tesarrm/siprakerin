<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrtuSiswa extends Model
{
    use HasFactory;

    protected $table = 'ortu_siswa';

    protected $fillable =  [
        'siswa_id', 
        'ortu_id',
    ];
}
