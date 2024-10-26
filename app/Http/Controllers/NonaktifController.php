<?php

namespace App\Http\Controllers;

use App\Models\BidangKeahlian;
use App\Models\Guru;
use App\Models\Industri;
use App\Models\Kelas;
use App\Models\Pengaturan;
use App\Models\Siswa;
use Illuminate\Http\Request;

class NonaktifController extends Controller
{

    public function index()
    {
        $data = BidangKeahlian::get();
        $guru = Guru::with(['user.roles', 'hoKelas.jurusan'])->where('aktif', 0)->get()->map(function ($guru) {
            $guru->user->peran = $guru->user->roles->isNotEmpty() 
                ? $guru->user->roles->pluck('name')->implode(', ')
                : '-';
            return $guru;
        });
        $kelas = Kelas::with(['jurusan.bidangKeahlian', 'guru'])->where('aktif', 0)->get();
        $siswa = Siswa::with(['kelas.jurusan', 'user'])->where('aktif', 0)->get();
        $pengaturan = Pengaturan::first();
        $industri = Industri::with('kota')->where('aktif', 0)->get();

        return view('nonaktif.index', [
            'data' => $data,
            'guru' => $guru,
            'kelas' => $kelas,
            'siswa' => $siswa,
            'pengaturan' => $pengaturan,
            'industri' => $industri,
        ]);
    }

}

