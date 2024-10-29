<?php

namespace App\Http\Controllers;

use App\Models\CapaianPembelajaran;
use App\Models\Guru;
use App\Models\Industri;
use App\Models\JadwalMonitoring;
use App\Models\Kehadiran;
use App\Models\Kelas;
use App\Models\PelanggaranSiswa;
use App\Models\PenempatanIndustri;
use App\Models\Siswa;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index() 
    {
        if(
            auth()->user()->hasRole('admin') || 
            auth()->user()->hasRole('koordinator')
        ){
            // mendapatkan kelas
            // mendapatkan attendance hadir siswa perkelas hari kemarin
            // mendpatkan attendance tidak hadir siswa perkelas hari kemarin
            // dikeluarkan dalam bentuk
            // $kehadiran = [
            //     {
            //         'X RPL A' => [
            //             'hadir' => 23,
            //             'tidak_hadir' => 3,
            //         ]
            //     },
            //     {
            //         'X RPL B' => [
            //             'hadir' => 33,
            //             'tidak_hadir' => 1,
            //         ]
            //     },
            // ]

            $kehadiran = [];

            $kelasList = Kelas::with(['siswas.kehadirans' => function ($query) {
                $query->whereDate('created_at', Carbon::yesterday());
            }])->get();


            // Iterasi melalui setiap kelas
            foreach ($kelasList as $kelas) {
                // Hitung hadir dan tidak hadir
                $jumlahHadir = 0;
                $jumlahTidakHadir = 0;

                foreach ($kelas->siswas as $siswa) {
                    foreach ($siswa->kehadirans as $kehadiranItem) {
                        if ($kehadiranItem->status === 'hadir') {
                            $jumlahHadir++;
                        } else {
                            $jumlahTidakHadir++;
                        }
                    }
                }

                // Menyimpan hasil ke dalam array
                $kehadiran[$kelas->nama . ' ' . $kelas->jurusan->singkatan . ' ' . $kelas->klasifikasi] = [
                    'hadir' => $jumlahHadir,
                    'tidak_hadir' => $jumlahTidakHadir,
                ];
            }


            // get semua pelanggaran
            // kelompokkan berdasarkan bulan pelanggaran dibuat
            // strukturnya:
            // $pelanggaran = [
            //     'jan' => 23,
            //     'feb' => 2,
            //     'mar' => 3,
            //     'apr' => 2,
            //     'mei' => 3,
            //     'jun' => 3,
            //     'jul' => 3,
            //     'agu' => 2,
            //     'sep' => 3,
            //     'okt' => 2,
            //     'nov' => 0,
            //     'des' => 13,
            // ]

            // Ambil semua pelanggaran
            $pelanggarans = PelanggaranSiswa::all();

            // Inisialisasi array dengan bulan
            $pelanggaran = [
                'jan' => 0,
                'feb' => 0,
                'mar' => 0,
                'apr' => 0,
                'mei' => 0,
                'jun' => 0,
                'jul' => 0,
                'agu' => 0,
                'sep' => 0,
                'okt' => 0,
                'nov' => 0,
                'des' => 0,
            ];

            // Iterasi melalui setiap pelanggaran
            foreach ($pelanggarans as $pelanggaranItem) {
                // Ambil bulan dari tanggal dibuatnya pelanggaran
                $month = Carbon::parse($pelanggaranItem->created_at)->format('M'); // Mendapatkan bulan dalam format singkat

                // Tambahkan jumlah pelanggaran pada bulan yang sesuai
                switch ($month) {
                    case 'Jan':
                        $pelanggaran['jan']++;
                        break;
                    case 'Feb':
                        $pelanggaran['feb']++;
                        break;
                    case 'Mar':
                        $pelanggaran['mar']++;
                        break;
                    case 'Apr':
                        $pelanggaran['apr']++;
                        break;
                    case 'May':
                        $pelanggaran['mei']++;
                        break;
                    case 'Jun':
                        $pelanggaran['jun']++;
                        break;
                    case 'Jul':
                        $pelanggaran['jul']++;
                        break;
                    case 'Aug':
                        $pelanggaran['agu']++;
                        break;
                    case 'Sep':
                        $pelanggaran['sep']++;
                        break;
                    case 'Oct':
                        $pelanggaran['okt']++;
                        break;
                    case 'Nov':
                        $pelanggaran['nov']++;
                        break;
                    case 'Dec':
                        $pelanggaran['des']++;
                        break;
                }
            }

            $pelanggaranRecent = PelanggaranSiswa::orderBy('created_at', 'asc')->with('siswa.kelas.jurusan')->get();
            // $monitoringRecent = Monitoring::orderBy('created_at', 'asc')->with('hasilMonitoring')->get();
            $monitoringRecent = JadwalMonitoring::with(['hasilMonitoring', 'guru', 'industri'])
                ->whereHas('hasilMonitoring') // Mengambil hanya monitoring yang memiliki hasilMonitoring
                ->orderBy('created_at', 'asc')
                ->get();
        } else if (auth()->user()->hasRole('pembimbing')) {
            $guru = Guru::where('user_id', auth()->user()->id)
                ->with('industris')
                ->first();

            // Ambil ID industri yang berelasi dengan guru
            $industriIds = $guru->industris->pluck('id')->toArray();


            // kehadiran ===== 

            $kehadiran = [];

            $kelasList = Kelas::whereHas('siswas', function ($query) use ($industriIds) {
                $query->where('aktif', 1)
                    ->whereHas('penempatan.industri', function ($query) use ($industriIds) {
                        $query->whereIn('industri_id', $industriIds);
                    });
                })
                ->distinct()
                ->with(['siswas.kehadirans' => function ($query) {
                    $query->whereDate('created_at', Carbon::today());
                }])->get();

            // Iterasi melalui setiap kelas
            foreach ($kelasList as $kelas) {
                // Hitung hadir dan tidak hadir
                $jumlahHadir = 0;
                $jumlahTidakHadir = 0;

                foreach ($kelas->siswas as $siswa) {
                    foreach ($siswa->kehadirans as $kehadiranItem) {
                        if ($kehadiranItem->status === 'hadir') {
                            $jumlahHadir++;
                        } else {
                            $jumlahTidakHadir++;
                        }
                    }
                }

                // Menyimpan hasil ke dalam array
                $kehadiran[$kelas->nama . ' ' . $kelas->jurusan->singkatan . ' ' . $kelas->klasifikasi] = [
                    'hadir' => $jumlahHadir,
                    'tidak_hadir' => $jumlahTidakHadir,
                ];
            }

            $pelanggaranRecent = PelanggaranSiswa::orderBy('created_at', 'asc')
                ->with('siswa.kelas.jurusan')
                ->whereHas('siswa.penempatan.industri', function ($query) use ($industriIds) {
                    $query->whereIn('industri_id', $industriIds);
                })
                ->get();
        } else if (auth()->user()->hasRole('wali_kelas')) {
            $guru = Guru::where('user_id', auth()->user()->id)
                ->with('hoKelas')  // Mengambil kelas yang berelasi dengan guru
                ->first();

            // Ambil ID kelas yang berelasi dengan guru
            $kelasId = $guru->hoKelas->id;

            $kehadiran = [];

            $kelasList = Kelas::whereHas('siswas', function ($query) use ($kelasId) {
                $query->where('aktif', 1)
                    ->where('kelas_id', $kelasId);  // Filter berdasarkan kelasId yang berelasi dengan guru
            })
            ->distinct()
            ->with(['siswas.kehadirans' => function ($query) {
                $query->whereDate('created_at', Carbon::today());
            }])->get();

            // Iterasi melalui setiap kelas
            foreach ($kelasList as $kelas) {
                // Hitung hadir dan tidak hadir
                $jumlahHadir = 0;
                $jumlahTidakHadir = 0;

                foreach ($kelas->siswas as $siswa) {
                    foreach ($siswa->kehadirans as $kehadiranItem) {
                        if ($kehadiranItem->status === 'hadir') {
                            $jumlahHadir++;
                        } else {
                            $jumlahTidakHadir++;
                        }
                    }
                }

                // Menyimpan hasil ke dalam array
                $kehadiran[$kelas->nama . ' ' . $kelas->jurusan->singkatan . ' ' . $kelas->klasifikasi] = [
                    'hadir' => $jumlahHadir,
                    'tidak_hadir' => $jumlahTidakHadir,
                ];
            }

            $pelanggaranRecent = PelanggaranSiswa::orderBy('created_at', 'asc')
                ->with('siswa.kelas.jurusan')
                ->whereHas('siswa.kelas', function ($query) use ($kelasId) {
                    $query->where('id', $kelasId);  // Menggunakan kelasId untuk filter kelas
                })
                ->get();
        }

        // =====

        if(
            auth()->user()->hasRole('admin') || 
            auth()->user()->hasRole('koordinator')
        ){
            $guruCount = Guru::where('aktif', 1)->get()->count();
            $siswaCount = Siswa::where('aktif', 1)->get()->count();
            $kelasCount = Kelas::where('aktif', 1)->get()->count();
            $industriCount = Industri::where('aktif', 1)->get()->count();


            return view('index', compact(
                'guruCount',
                'siswaCount',
                'kelasCount',
                'industriCount',
                'kehadiran',
                'pelanggaran',
                'pelanggaranRecent',
                'monitoringRecent',
            ));
        } else if (auth()->user()->hasRole('pembimbing')) {
            $guru = Guru::where('user_id', auth()->user()->id)
                ->with('industris')
                ->first();

            // Ambil ID industri yang berelasi dengan guru
            $industriIds = $guru->industris->pluck('id')->toArray();

            // Hitung siswa yang penempatan industrinya sesuai dengan industri guru
            $siswaCount = Siswa::where('aktif', 1)
                ->whereHas('penempatan.industri', function ($query) use ($industriIds) {
                    $query->whereIn('industri_id', $industriIds);
                })
                ->count();

            $kelasCount = Kelas::whereHas('siswas', function ($query) use ($industriIds) {
                    $query->where('aktif', 1)
                        ->whereHas('penempatan.industri', function ($query) use ($industriIds) {
                            $query->whereIn('industri_id', $industriIds);
                        });
                })
                ->distinct()
                ->count('id');

            // Hitung jumlah industri yang berelasi dengan guru
            $industriCount = Industri::whereIn('id', $industriIds)->count();

            return view('index', compact(
                'siswaCount',
                'kelasCount',
                'industriCount',
                'kehadiran',
                'pelanggaranRecent',
            ));
        } else if (auth()->user()->hasRole('wali_kelas')) {
            // $guru = Guru::where('user_id', auth()->user()->id)
            //     ->with('industris')
            //     ->first();

            // // Ambil ID industri yang berelasi dengan guru
            // $industriIds = $guru->industris->pluck('id')->toArray();

            $guru = Guru::where('user_id', auth()->user()->id)
                ->with('hoKelas')  // Mengambil kelas yang berelasi dengan guru
                ->first();

            // Ambil ID kelas yang berelasi dengan guru
            $kelasId = $guru->hoKelas->id;


            $siswaCount = Siswa::where('aktif', 1)
                ->where('kelas_id', $kelasId)  // Filter berdasarkan kelasId
                ->count();


            $kelasCount = Kelas::whereHas('siswas', function ($query) use ($kelasId) {
                    $query->where('aktif', 1)
                        ->where('kelas_id', $kelasId);  // Filter berdasarkan kelasId
                })
                ->distinct()
                ->count('id');

            // Hitung jumlah industri yang berelasi dengan guru
            // $industriCount = Industri::whereIn('id', $industriIds)->count();
            $industriCount = Industri::whereHas('penempatanIndustri.siswa', function ($query) use ($kelasId) {
                $query->where('aktif', 1)
                    ->where('kelas_id', $kelasId);  // Filter siswa berdasarkan kelasId
            })->distinct()->count('industris.id');

            return view('index', compact(
                'siswaCount',
                'kelasCount',
                'industriCount',
                'kehadiran',
                'pelanggaranRecent',
            ));
        } else if (auth()->user()->hasRole('siswa')) {
            $siswa = Siswa::where('user_id', auth()->user()->id)
                ->with(['kelas.jurusan', 'penempatan'])
                ->first();

            $siswa_id = $siswa->id;

            if($siswa->penempatan) {

            // $siswa = Siswa::with('kelas.jurusan')->findOrFail($siswa_id);

                $hadir = Kehadiran::where([
                    'siswa_id' => $siswa->id, 
                    'status' => 'hadir'
                    ])->get();
                $izin = Kehadiran::where([
                    'siswa_id' => $siswa->id, 
                    'status' => 'izin'
                    ])->get();
                $libur = Kehadiran::where([
                    'siswa_id' => $siswa->id, 
                    'status' => 'libur'
                    ])->get();
                $alpa = Kehadiran::where([
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

                $attendances = Kehadiran::where('siswa_id', $siswa->id)->get();

                $pelanggaran = PelanggaranSiswa::with(['siswa.kelas.jurusan', 'siswa.penempatan.industri'])->where('siswa_id', $siswa->id)->get();

                $nilai = CapaianPembelajaran::whereHas('tujuanPembelajaran.nilai', function ($query) use ($siswa_id) {
                    $query->where('siswa_id', $siswa_id);
                })->with('tujuanPembelajaran.nilai')->get();


                $guruCount = Guru::where('aktif', 1)->get()->count();
                $siswaCount = Siswa::where('aktif', 1)->get()->count();
                $kelasCount = Kelas::where('aktif', 1)->get()->count();
                $industriCount = Industri::where('aktif', 1)->get()->count();

                return view('index', compact([
                    'siswa',
                    'hadir',
                    'izin',
                    'libur',
                    'alpa',
                    'sisa_hari',
                    'attendances',
                    'pelanggaran',
                    'nilai',

                    'guruCount',
                    'siswaCount',
                    'kelasCount',
                    'industriCount',
                ]));

            } else {
                $guruCount = Guru::where('aktif', 1)->get()->count();
                $siswaCount = Siswa::where('aktif', 1)->get()->count();
                $kelasCount = Kelas::where('aktif', 1)->get()->count();
                $industriCount = Industri::where('aktif', 1)->get()->count();

                return view('index', compact([
                    'siswa',

                    'guruCount',
                    'siswaCount',
                    'kelasCount',
                    'industriCount',
                ]));

            }

 
        } else {
            return view('index');
        }
    }

    public function indexPusatUnduhan()
    {
        return view('pusat_unduhan.index');
    }
}
