<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BerhentiPrakerin extends Model
{
    use HasFactory;

    protected $fillable = [
        'siswa_id',
        'industri_lama_id',
        'industri_baru_id',
        'tanggal_berhenti',
        'tanggal_lanjut',
        'alasan_berhenti',
    ];
}
