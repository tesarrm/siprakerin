<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\BerhentiPrakerin;
use App\Models\CapaianPembelajaran;
use App\Models\Guru;
use App\Models\Industri;
use App\Models\Kelas;
use App\Models\PelanggaranSiswa;
use App\Models\PenempatanIndustri;
use App\Models\PindahPrakerin;
use App\Models\Prakerin;
use App\Models\Siswa;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PrakerinController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // public function index()
    // {
    //     $months = [
    //         'Januari' => 'January',
    //         'Februari' => 'February',
    //         'Maret' => 'March',
    //         'April' => 'April',
    //         'Mei' => 'May',
    //         'Juni' => 'June',
    //         'Juli' => 'July',
    //         'Agustus' => 'August',
    //         'September' => 'September',
    //         'Oktober' => 'October',
    //         'November' => 'November',
    //         'Desember' => 'December',
    //     ];

    //     // $siswa = Siswa::with(['penempatan.industri', 'pilihankota.kota1', 'pilihankota.kota2', 'pilihankota.kota3'])->get();
    //     $siswa = Siswa::with(['penempatan.industri', 'pilihankota.kota1', 'pilihankota.kota2', 'pilihankota.kota3'])
    //         ->whereHas('penempatan')
    //         ->get();
    //     $industri = Industri::with('kota')->get();

    //     // Tambahkan perhitungan sisa hari pada setiap siswa
    //     foreach ($siswa as $s) {
    //         if ($s->penempatan && $s->penempatan->industri) {
    //             $tanggal_akhir = strtr($s->penempatan->industri->tanggal_akhir, $months);
    //             $tanggal_akhir = Carbon::createFromFormat('j F Y', $tanggal_akhir);
    //             // $sisa_hari = Carbon::now()->diffInDays($tanggal_akhir, false); // false untuk menghitung jika tanggal sudah lewat
    //             $now = Carbon::now();
                
    //             // Hitung selisih bulan dan hari
    //             $diff = $now->diff($tanggal_akhir);

    //             // Buat format yang lebih jelas untuk bulan dan hari
    //             if ($diff->invert == 0) { // Jika tanggal akhir belum terlewati
    //                 $sisa_waktu = '';
    //                 if ($diff->m > 0) {
    //                     $sisa_waktu .= $diff->m . ' bulan ';
    //                 }
    //                 if ($diff->d > 0) {
    //                     $sisa_waktu .= $diff->d . ' hari';
    //                 }
    //                 if (empty($sisa_waktu)) {
    //                     $sisa_waktu = 'Hari ini berakhir';
    //                 }
    //             } else {
    //                 $sisa_waktu = 'Sudah berakhir';
    //             }

                
    //             // status
    //             // Cek apakah penempatan sudah selesai
    //             $selesai = $tanggal_akhir->lessThan($now);

    //             // Cek status berhenti
    //             // $berhenti = BerhentiPrakerin::where('siswa_id', $s->id)
    //             //                 ->whereNull('tanggal_lanjut')
    //             //                 ->exists();

    //             // Cek status lanjut
    //             // $lanjut = BerhentiPrakerin::where('siswa_id', $s->id)
    //             //                 ->whereNotNull('tanggal_berhenti')
    //             //                 ->whereNotNull('tanggal_lanjut')
    //             //                 ->exists();

    //             // Tentukan status
    //             $status = '';

    //             // if ($berhenti) {
    //             //     $status = 'berhenti';
    //             // } else if ($selesai) {
    //             //     $status = 'selesai';
    //             // } else if ($lanjut) {
    //             //     $status = 'lanjut';
    //             // } else {
    //             //     $status = 'prakerin';
    //             // }

    //             // if ($berhenti) {
    //             //     $status = 'berhenti';
    //             } if ($selesai) {
    //                 $status = 'selesai';
    //             } else {
    //                 $status = 'prakerin';
    //             }

    //             // Simpan status dalam properti tambahan jika dibutuhkan
    //             $s->penempatan->status = $status;
    //             if($status == 'berhenti') {
    //                 $s->penempatan->sisa_waktu = null;
    //             } else {
    //                 $s->penempatan->sisa_waktu = $sisa_waktu;
    //             }
    //         }
    //     }

    //     return view('pkl.index', compact(['siswa', 'industri']));
    // }

    public function index()
    {
        if(auth()->user()->hasRole('wali_kelas')) {
            $months = [
                'Januari' => 'January',
                'Februari' => 'February',
                'Maret' => 'March',
                'April' => 'April',
                'Mei' => 'May',
                'Juni' => 'June',
                'Juli' => 'July',
                'Agustus' => 'August',
                'September' => 'September',
                'Oktober' => 'October',
                'November' => 'November',
                'Desember' => 'December',
            ];

            $guru = Guru::where('user_id', auth()->user()->id)
                ->with('hoKelas')  // Ambil kelas yang berelasi dengan guru
                ->first();

            // Ambil ID kelas yang berelasi dengan guru
            $kelasId = $guru->hoKelas->id;

            $siswa = Siswa::with([
                    'penempatan.industri', 
                    'pilihankota.kota1', 
                    'pilihankota.kota2', 
                    'pilihankota.kota3'])
                ->whereHas('penempatan')
                ->whereHas('kelas', function ($query) use ($kelasId) {
                    $query->where('id', $kelasId);
                })
                ->get();


            // Tambahkan perhitungan sisa hari pada setiap siswa
            foreach ($siswa as $s) {
                if ($s->penempatan && $s->penempatan->industri) {
                    $tanggal_akhir = strtr($s->penempatan->industri->tanggal_akhir, $months);
                    $tanggal_akhir = Carbon::createFromFormat('j F Y', $tanggal_akhir);
                    // $sisa_hari = Carbon::now()->diffInDays($tanggal_akhir, false); // false untuk menghitung jika tanggal sudah lewat
                    $now = Carbon::now();
                    
                    // Hitung selisih bulan dan hari
                    $diff = $now->diff($tanggal_akhir);

                    // Buat format yang lebih jelas untuk bulan dan hari
                    if ($diff->invert == 0) { // Jika tanggal akhir belum terlewati
                        $sisa_waktu = '';
                        if ($diff->m > 0) {
                            $sisa_waktu .= $diff->m . ' bulan ';
                        }
                        if ($diff->d > 0) {
                            $sisa_waktu .= $diff->d . ' hari';
                        }
                        if (empty($sisa_waktu)) {
                            $sisa_waktu = 'Hari ini berakhir';
                        }
                    } else {
                        $sisa_waktu = 'Sudah berakhir';
                    }

                    
                    // status
                    // Cek apakah penempatan sudah selesai
                    $selesai = $tanggal_akhir->lessThan($now);

                    // Cek status berhenti
                    $berhenti = BerhentiPrakerin::where('siswa_id', $s->id)
                                    ->whereNull('tanggal_lanjut')
                                    ->exists();

                    // Cek status lanjut
                    $lanjut = BerhentiPrakerin::where('siswa_id', $s->id)
                                    ->whereNotNull('tanggal_berhenti')
                                    ->whereNotNull('tanggal_lanjut')
                                    ->exists();

                    // Tentukan status
                    $status = '';

                    // if ($berhenti) {
                    //     $status = 'berhenti';
                    // } else if ($selesai) {
                    //     $status = 'selesai';
                    // } else if ($lanjut) {
                    //     $status = 'lanjut';
                    // } else {
                    //     $status = 'prakerin';
                    // }

                    if ($selesai) {
                        $status = 'selesai';
                    } else {
                        $status = 'prakerin';
                    }

                    // Simpan status dalam properti tambahan jika dibutuhkan
                    $s->penempatan->status = $status;
                    if($status == 'berhenti') {
                        $s->penempatan->sisa_waktu = null;
                    } else {
                        $s->penempatan->sisa_waktu = $sisa_waktu;
                    }
                }
            }

            $kelas = Kelas::get();
            $industri = Industri::with('kota')->get();

            return view('pkl.index', compact(['siswa', 'industri', 'kelas', ]));

        } else if(auth()->user()->hasRole('siswa')) {

            $siswa = Siswa::where('user_id', auth()->user()->id)
                ->with('kelas.jurusan')
                ->first();

            $siswa_id = $siswa->id;

            // $siswa = Siswa::with('kelas.jurusan')->findOrFail($siswa_id);

            $hadir = Attendance::where([
                'siswa_id' => $siswa->id, 
                'status' => 'hadir'
                ])->get();
            $izin = Attendance::where([
                'siswa_id' => $siswa->id, 
                'status' => 'izin'
                ])->get();
            $libur = Attendance::where([
                'siswa_id' => $siswa->id, 
                'status' => 'libur'
                ])->get();
            $alpa = Attendance::where([
                'siswa_id' => $siswa->id, 
                'status' => 'alpa'
                ])->get();

            $months = [
                'Januari' => 'January',
                'Februari' => 'February',
                'Maret' => 'March',
                'April' => 'April',
                'Mei' => 'May',
                'Juni' => 'June',
                'Juli' => 'July',
                'Agustus' => 'August',
                'September' => 'September',
                'Oktober' => 'October',
                'November' => 'November',
                'Desember' => 'December',
            ];

            $penempatan = PenempatanIndustri::with('industri.libur')->where('siswa_id', $siswa->id)->first();

            $tanggalAkhir = strtr($penempatan->industri->tanggal_akhir, $months);
            $tanggalAkhir = Carbon::createFromFormat('j F Y', $tanggalAkhir);
            $tanggalHariIni = Carbon::now();
            $sisa_hari = $tanggalHariIni->diffInDays($tanggalAkhir);

            $attendances = Attendance::where('siswa_id', $siswa->id)->get();

            $pelanggaran = PelanggaranSiswa::with(['siswa.kelas.jurusan', 'siswa.penempatan.industri'])->where('siswa_id', $siswa->id)->get();

            $nilai = CapaianPembelajaran::whereHas('tujuanPembelajaran.nilai', function ($query) use ($siswa_id) {
                $query->where('siswa_id', $siswa_id);
            })->with('tujuanPembelajaran.nilai')->get();

            return view('pkl.show', compact([
                'siswa',
                'hadir',
                'izin',
                'libur',
                'alpa',
                'sisa_hari',
                'attendances',
                'pelanggaran',
                'nilai',
            ]));

        } else {
            $siswa = [];
            $kelas = Kelas::get();
            $industri = Industri::with('kota')->get();

            return view('pkl.index', compact(['siswa', 'industri', 'kelas', ]));
        }

    }
    
    public function filter(Request $request)
    {
        $months = [
            'Januari' => 'January',
            'Februari' => 'February',
            'Maret' => 'March',
            'April' => 'April',
            'Mei' => 'May',
            'Juni' => 'June',
            'Juli' => 'July',
            'Agustus' => 'August',
            'September' => 'September',
            'Oktober' => 'October',
            'November' => 'November',
            'Desember' => 'December',
        ];

        $kelas = $request->kelas;


        $siswa = Siswa::with([
                'penempatan.industri', 
                'pilihankota.kota1', 
                'pilihankota.kota2', 
                'pilihankota.kota3'])
            ->whereHas('penempatan')
            ->where('kelas_id', $kelas)
            ->get();

        // $industri = Industri::with('kota')->get();

        // Tambahkan perhitungan sisa hari pada setiap siswa
        foreach ($siswa as $s) {
            if ($s->penempatan && $s->penempatan->industri) {
                $tanggal_akhir = strtr($s->penempatan->industri->tanggal_akhir, $months);
                $tanggal_akhir = Carbon::createFromFormat('j F Y', $tanggal_akhir);
                // $sisa_hari = Carbon::now()->diffInDays($tanggal_akhir, false); // false untuk menghitung jika tanggal sudah lewat
                $now = Carbon::now();
                
                // Hitung selisih bulan dan hari
                $diff = $now->diff($tanggal_akhir);

                // Buat format yang lebih jelas untuk bulan dan hari
                if ($diff->invert == 0) { // Jika tanggal akhir belum terlewati
                    $sisa_waktu = '';
                    if ($diff->m > 0) {
                        $sisa_waktu .= $diff->m . ' bulan ';
                    }
                    if ($diff->d > 0) {
                        $sisa_waktu .= $diff->d . ' hari';
                    }
                    if (empty($sisa_waktu)) {
                        $sisa_waktu = 'Hari ini berakhir';
                    }
                } else {
                    $sisa_waktu = 'Sudah berakhir';
                }

                
                // status
                // Cek apakah penempatan sudah selesai
                $selesai = $tanggal_akhir->lessThan($now);

                // Cek status berhenti
                $berhenti = BerhentiPrakerin::where('siswa_id', $s->id)
                                ->whereNull('tanggal_lanjut')
                                ->exists();

                // Cek status lanjut
                $lanjut = BerhentiPrakerin::where('siswa_id', $s->id)
                                ->whereNotNull('tanggal_berhenti')
                                ->whereNotNull('tanggal_lanjut')
                                ->exists();

                // Tentukan status
                $status = '';

                // if ($berhenti) {
                //     $status = 'berhenti';
                // } else if ($selesai) {
                //     $status = 'selesai';
                // } else if ($lanjut) {
                //     $status = 'lanjut';
                // } else {
                //     $status = 'prakerin';
                // }

                if ($selesai) {
                    $status = 'selesai';
                } else {
                    $status = 'prakerin';
                }

                // Simpan status dalam properti tambahan jika dibutuhkan
                $s->penempatan->status = $status;
                if($status == 'berhenti') {
                    $s->penempatan->sisa_waktu = null;
                } else {
                    $s->penempatan->sisa_waktu = $sisa_waktu;
                }
            }
        }


        $items = [];
        foreach ($siswa as $d) {
            $items[] = [
                'nama' => $d->nama_lengkap ?? '-',
                'kelas' => $d->kelas->nama . " " . $d->kelas->jurusan->singkatan . " " . $d->kelas->klasifikasi ?? '-',
                'industri' => $d->penempatan->industri->nama ?? '-',
                'tanggal_awal' => $d->penempatan->industri->tanggal_awal ?? '-',
                'tanggal_akhir' => $d->penempatan->industri->tanggal_akhir ?? '-',
                'siswa_waktu' => $d->penempatan->sisa_waktu ?? '-',
                'status' => $d->penempatan->status ?? '-',
                'action' => $d->id ?? '-', 

                'kota1' => $d->pilihankota->kota1->nama ?? '-', 
                'kota2' => $d->pilihankota->kota2->nama ?? '-', 
                'kota3' => $d->pilihankota->kota3->nama ?? '-', 
                'industri_id' => $d->penempatan->industri->id ?? '-',
            ];
        }

        return response()->json($items);

        // $kelas = Kelas::get();

        // return view('pkl.index', compact(['siswa', 'industri', 'kelas', ]));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($siswa_id)
    {
        $siswa = Siswa::with('kelas.jurusan')->findOrFail($siswa_id);

        $hadir = Attendance::where([
            'siswa_id' => $siswa->id, 
            'status' => 'hadir'
            ])->get();
        $izin = Attendance::where([
            'siswa_id' => $siswa->id, 
            'status' => 'izin'
            ])->get();
        $libur = Attendance::where([
            'siswa_id' => $siswa->id, 
            'status' => 'libur'
            ])->get();
        $alpa = Attendance::where([
            'siswa_id' => $siswa->id, 
            'status' => 'alpa'
            ])->get();

        $months = [
            'Januari' => 'January',
            'Februari' => 'February',
            'Maret' => 'March',
            'April' => 'April',
            'Mei' => 'May',
            'Juni' => 'June',
            'Juli' => 'July',
            'Agustus' => 'August',
            'September' => 'September',
            'Oktober' => 'October',
            'November' => 'November',
            'Desember' => 'December',
        ];

        $penempatan = PenempatanIndustri::with('industri.libur')->where('siswa_id', $siswa->id)->first();

        $tanggalAkhir = strtr($penempatan->industri->tanggal_akhir, $months);
        $tanggalAkhir = Carbon::createFromFormat('j F Y', $tanggalAkhir);
        $tanggalHariIni = Carbon::now();
        $sisa_hari = $tanggalHariIni->diffInDays($tanggalAkhir);

        $attendances = Attendance::where('siswa_id', $siswa->id)->get();

        $pelanggaran = PelanggaranSiswa::with(['siswa.kelas.jurusan', 'siswa.penempatan.industri'])->where('siswa_id', $siswa->id)->get();

        $nilai = CapaianPembelajaran::whereHas('tujuanPembelajaran.nilai', function ($query) use ($siswa_id) {
            $query->where('siswa_id', $siswa_id);
        })->with('tujuanPembelajaran.nilai')->get();

        return view('pkl.show', compact([
            'siswa',
            'hadir',
            'izin',
            'libur',
            'alpa',
            'sisa_hari',
            'attendances',
            'pelanggaran',
            'nilai',
        ]));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Prakerin $prakerin)
    {
        //
    }

    // pindah
    public function update($siswa_id, Request $request)
    {
        $penempatan = PenempatanIndustri::where('siswa_id', $siswa_id)->first();

        PindahPrakerin::create([
            'siswa_id' => $siswa_id,
            'industri_lama_id' => $penempatan->industri_id,
            'industri_baru_id' => $request->industri_id,
            'tanggal' => Carbon::now(),
            'alasan' => $request->alasan,
        ]);

        $penempatan->update([
            'industri_id' => $request->industri_id
        ]);

        return redirect('pkl')->with('status', 'Data berhasil diedit!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Prakerin $prakerin)
    {
        //
    }

    public function berhenti($siswa_id, Request $request)
    {
        $penempatan = PenempatanIndustri::where('siswa_id', $siswa_id)->first();

        BerhentiPrakerin::create([
            'siswa_id' => $siswa_id,
            'industri_lama_id' => $penempatan->industri_id,
            'tanggal_berhenti' => Carbon::now(),
            'alasan_berhenti' => $request->alasan,
        ]);

        $penempatan->delete();

        return redirect('pkl')->with('status', 'Data berhasil diedit!');
    }

    public function lanjut($siswa_id, Request $request)
    {
        $penempatan = PenempatanIndustri::where('siswa_id', $siswa_id)->first();

        $berhenti = BerhentiPrakerin::where('siswa_id', $siswa_id)->first();

        $berhenti->update([
            'industri_baru_id' => $request->industri_id,
            'tanggal_lanjut' => Carbon::now()
        ]);

        $penempatan->update([
            'industri_id' => $request->industri_id
        ]);

        return redirect('pkl')->with('status', 'Data berhasil diedit!');
    }
}
