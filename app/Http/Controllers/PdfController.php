<?php

namespace App\Http\Controllers;

use App\Models\BiodataSiswa;
use App\Models\Kota;
use App\Models\Pengaturan;
use App\Models\PilihanKota;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Barryvdh\DomPDF\Facade\Pdf;


class PdfController extends Controller
{
    public function siswa()
    {
        $siswa = Siswa::where('user_id', auth()->user()->id)->first();
        $data = BiodataSiswa::with('siswa.kelas.jurusan')->where('siswa_id', $siswa->id)->first();
        $pengaturan = Pengaturan::first();

        $pdf = Pdf::loadView('siswa.pdf', compact(['data', 'pengaturan']))
                ->setPaper([0, 0, 610.525, 935.55], 'portrait');
                
        return $pdf->download('siswa.pdf');

        // return view('siswa.pdf', compact(['data', 'pengaturan']));
    }

    public function pilihankota()
    {
        $siswa = Siswa::with('kelas.jurusan')->where('user_id', auth()->user()->id)->first();
        $pilihan = PilihanKota::with(['kota1', 'kota2', 'kota3'])->where('siswa_id', $siswa->id)->first();
        // $kota = Kota::get();
        $kota = Kota::whereIn('id', [
                $pilihan->kota1->id ?? null,
                $pilihan->kota2->id ?? null,
                $pilihan->kota3->id ?? null,
            ])
            ->orderBy('nama', 'asc')
            ->get();

        $pdf = Pdf::loadView('pdf.pilihankota', compact(['kota', 'pilihan', 'siswa']))
                ->setPaper([0, 0, 610.525, 935.55], 'portrait');
                
        return $pdf->download('pilihan_kota.pdf');

        // return view('pdf.pilihankota', compact(['kota', 'pilihan', 'siswa']));
    }
    
    public function pernyataan()
    {
        $siswa = Siswa::with('kelas.jurusan')->where('user_id', auth()->user()->id)->first();
        $biodata= BiodataSiswa::with('siswa.kelas.jurusan')->where('siswa_id', $siswa->id)->first();

        $pdf = Pdf::loadView('pdf.pernyataan', compact(['siswa', 'biodata']))
                ->setPaper([0, 0, 610.525, 935.55], 'portrait');
                
        return $pdf->download('pernyataan.pdf');
        // return view('pdf.pernyataan', compact(['siswa', 'biodata']));
    }
}
