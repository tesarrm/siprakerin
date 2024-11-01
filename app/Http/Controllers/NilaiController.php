<?php

namespace App\Http\Controllers;

use App\Models\CapaianPembelajaran;
use App\Models\Guru;
use App\Models\Industri;
use App\Models\Nilai;
use App\Models\PenempatanIndustri;
use App\Models\Pengaturan;
use App\Models\Siswa;
use App\Models\WaliSiswa;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NilaiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if(auth()->user()->hasRole('pembimbing')){
            $guru = Guru::where('user_id', auth()->user()->id)
                ->with('industris')
                ->first();

            // Filter industri berdasarkan industri yang berelasi dengan guru
            $data = Industri::with('kota')
                ->where('aktif', 1)
                ->whereHas('gurus', function ($query) use ($guru) {
                    $query->where('guru_id', $guru->id);
                })
                ->withCount('penempatanIndustri')
                ->get();

            return view('nilai.index', [
                'data' => $data
            ]);
        } else if (auth()->user()->hasRole('wali_kelas')){

            $guru = Guru::where('user_id', auth()->user()->id)
                ->with('hoKelas')  // Ambil kelas yang berelasi dengan guru
                ->first();

            // Ambil ID kelas yang berelasi dengan guru
            $kelasId = $guru->hoKelas->id;

            $nilai = Nilai::select('siswa_id')
                ->groupBy('siswa_id')
                ->whereHas('siswa.kelas', function ($query) use ($kelasId) {
                    $query->where('id', $kelasId);
                })
                ->with(['siswa.kelas.jurusan', 'siswa.penempatan.industri'])
                ->get();

            return view('nilai.index', [
                'nilai' => $nilai
            ]);
        } else if (auth()->user()->hasRole('siswa')){
            $siswa = Siswa::where('user_id', auth()->user()->id)->first();
            $siswa_id = $siswa->id;

            $pengaturan = Pengaturan::first();

            $urutan = 1;

            $siswa = Siswa::where('id', $siswa_id)->with('penempatan.industri')->first();
            $industri_id = $siswa->penempatan->industri->id;

            // Ambil data penempatan berdasarkan industri_id
            $penempatan = PenempatanIndustri::where('industri_id', $industri_id)
                ->where('siswa_id', $siswa_id)
                ->with(['siswa.kelas.jurusan', 'industri'])
                ->get();

            // Ambil industri dari salah satu penempatan (asumsi industri sama)
            $item_penempatan = $penempatan->first();
            $industri = $item_penempatan->industri;

            // Ambil capaian yang dikelompokkan berdasarkan jurusan
            $capaianGrouped = CapaianPembelajaran::with('tujuanPembelajaran.nilai')->get()->groupBy('jurusan_id');

            // Susun data sesuai dengan format yang diinginkan
            $data = $penempatan->map(function($penempatan) use ($capaianGrouped, $urutan) {
                $siswa = $penempatan->siswa;
                $jurusanId = $siswa->kelas->jurusan->id;

                // Ambil capaian berdasarkan jurusan siswa
                $capaianForJurusan = $capaianGrouped->get($jurusanId) ?? collect([]);

                return [
                    'siswa' => [
                        'id' => $siswa->id,
                        'nama_lengkap' => $siswa->user->name,
                        'jenis_kelamin' => $siswa->jenis_kelamin,
                        'kelas' => [
                            'nama' => $siswa->kelas->nama,
                            'klasifikasi' => $siswa->kelas->klasifikasi,
                            'jurusan' => [
                                'nama' => $siswa->kelas->jurusan->nama,
                                'singkatan' => $siswa->kelas->jurusan->singkatan,
                            ],
                        ],
                    ],
                    'capaian' => $capaianForJurusan->map(function($capaian) use ($siswa) {
                        return [
                            'nama' => $capaian->nama,
                            'tujuan' => $capaian->tujuanPembelajaran->map(function($tujuan) use ($siswa) {
                                $nilaiObj = $tujuan->nilai
                                    ->where('siswa_id', $siswa->id)
                                    ->where('tujuan_pembelajaran_id', $tujuan->id)
                                    ->where('urutan', 1)
                                    ->first();
                                $nilai = $nilaiObj ? $nilaiObj->nilai : null; 

                                return [
                                    'id' => $tujuan->id,
                                    'nama' => $tujuan->nama,
                                    'nilai' => $nilai, // Nilai null jika tidak ditemukan
                                ];
                            })->toArray(),
                        ];
                    })->toArray(),
                ];
            });

            $urutan2 = 2;

            // Susun data sesuai dengan format yang diinginkan
            $data2 = $penempatan->map(function($penempatan) use ($capaianGrouped, $urutan2) {
                $siswa = $penempatan->siswa;
                $jurusanId = $siswa->kelas->jurusan->id;

                // Ambil capaian berdasarkan jurusan siswa
                $capaianForJurusan = $capaianGrouped->get($jurusanId) ?? collect([]);

                return [
                    'siswa' => [
                        'id' => $siswa->id,
                        'nama_lengkap' => $siswa->user->name,
                        'jenis_kelamin' => $siswa->jenis_kelamin,
                        'kelas' => [
                            'nama' => $siswa->kelas->nama,
                            'klasifikasi' => $siswa->kelas->klasifikasi,
                            'jurusan' => [
                                'nama' => $siswa->kelas->jurusan->nama,
                                'singkatan' => $siswa->kelas->jurusan->singkatan,
                            ],
                        ],
                    ],
                    'capaian' => $capaianForJurusan->map(function($capaian) use ($siswa) {
                        return [
                            'nama' => $capaian->nama,
                            'tujuan' => $capaian->tujuanPembelajaran->map(function($tujuan) use ($siswa) {
                                $nilaiObj = $tujuan->nilai
                                    ->where('siswa_id', $siswa->id)
                                    ->where('tujuan_pembelajaran_id', $tujuan->id)
                                    ->where('urutan', 2)
                                    ->first();
                                $nilai = $nilaiObj ? $nilaiObj->nilai : null; 

                                return [
                                    'id' => $tujuan->id,
                                    'nama' => $tujuan->nama,
                                    'nilai' => $nilai, // Nilai null jika tidak ditemukan
                                ];
                            })->toArray(),
                        ];
                    })->toArray(),
                ];
            });

            return view('nilai.index', [
                'penempatan' => $data,
                'penempatan2' => $data2,
                'industri' => $industri,
                'urutan' => $urutan,
            ]);

        } else if (auth()->user()->hasRole('wali_siswa')){
            $wali_siswa = WaliSiswa::where('user_id', auth()->user()->id)
                ->with(['siswa.kelas.jurusan', 'siswa.izin', 'siswa.user', 'siswa.penempatan.industri'])
                ->first();
            $siswa = $wali_siswa->siswa;
            $siswa_id = $siswa->id;
            $industri_id = $siswa->penempatan->industri->id;

            // ================================
            // untuk urutan 1
            // ================================

            // Ambil data penempatan berdasarkan industri_id
            $penempatan = PenempatanIndustri::where('industri_id', $industri_id)
                ->where('siswa_id', $siswa_id)
                ->with(['siswa.kelas.jurusan', 'industri'])
                ->get();

            // Ambil industri dari salah satu penempatan (asumsi industri sama)
            $item_penempatan = $penempatan->first();
            $industri = $item_penempatan->industri;

            // Ambil capaian yang dikelompokkan berdasarkan jurusan
            $capaianGrouped = CapaianPembelajaran::with('tujuanPembelajaran.nilai')->get()->groupBy('jurusan_id');

            // Susun data sesuai dengan format yang diinginkan
            $data = $penempatan->map(function($penempatan) use ($capaianGrouped) {
                $siswa = $penempatan->siswa;
                $jurusanId = $siswa->kelas->jurusan->id;

                // Ambil capaian berdasarkan jurusan siswa
                $capaianForJurusan = $capaianGrouped->get($jurusanId) ?? collect([]);

                return [
                    'siswa' => [
                        'id' => $siswa->id,
                        'nama_lengkap' => $siswa->user->name,
                        'jenis_kelamin' => $siswa->jenis_kelamin,
                        'kelas' => [
                            'nama' => $siswa->kelas->nama,
                            'klasifikasi' => $siswa->kelas->klasifikasi,
                            'jurusan' => [
                                'nama' => $siswa->kelas->jurusan->nama,
                                'singkatan' => $siswa->kelas->jurusan->singkatan,
                            ],
                        ],
                    ],
                    'capaian' => $capaianForJurusan->map(function($capaian) use ($siswa) {
                        return [
                            'nama' => $capaian->nama,
                            'tujuan' => $capaian->tujuanPembelajaran->map(function($tujuan) use ($siswa) {
                                $nilaiObj = $tujuan->nilai
                                    ->where('siswa_id', $siswa->id)
                                    ->where('tujuan_pembelajaran_id', $tujuan->id)
                                    ->where('urutan', 1)
                                    ->first();
                                $nilai = $nilaiObj ? $nilaiObj->nilai : null; 

                                return [
                                    'id' => $tujuan->id,
                                    'nama' => $tujuan->nama,
                                    'nilai' => $nilai, // Nilai null jika tidak ditemukan
                                ];
                            })->toArray(),
                        ];
                    })->toArray(),
                ];
            });

            // ================================
            // untuk urutan 2 
            // ================================

            // Susun data sesuai dengan format yang diinginkan
            $data2 = $penempatan->map(function($penempatan) use ($capaianGrouped) {
                $siswa = $penempatan->siswa;
                $jurusanId = $siswa->kelas->jurusan->id;

                // Ambil capaian berdasarkan jurusan siswa
                $capaianForJurusan = $capaianGrouped->get($jurusanId) ?? collect([]);

                return [
                    'siswa' => [
                        'id' => $siswa->id,
                        'nama_lengkap' => $siswa->user->name,
                        'jenis_kelamin' => $siswa->jenis_kelamin,
                        'kelas' => [
                            'nama' => $siswa->kelas->nama,
                            'klasifikasi' => $siswa->kelas->klasifikasi,
                            'jurusan' => [
                                'nama' => $siswa->kelas->jurusan->nama,
                                'singkatan' => $siswa->kelas->jurusan->singkatan,
                            ],
                        ],
                    ],
                    'capaian' => $capaianForJurusan->map(function($capaian) use ($siswa) {
                        return [
                            'nama' => $capaian->nama,
                            'tujuan' => $capaian->tujuanPembelajaran->map(function($tujuan) use ($siswa) {
                                $nilaiObj = $tujuan->nilai
                                    ->where('siswa_id', $siswa->id)
                                    ->where('tujuan_pembelajaran_id', $tujuan->id)
                                    ->where('urutan', 2)
                                    ->first();
                                $nilai = $nilaiObj ? $nilaiObj->nilai : null; 

                                return [
                                    'id' => $tujuan->id,
                                    'nama' => $tujuan->nama,
                                    'nilai' => $nilai, // Nilai null jika tidak ditemukan
                                ];
                            })->toArray(),
                        ];
                    })->toArray(),
                ];
            });

            return view('nilai.index', [
                'penempatan' => $data,
                'penempatan2' => $data2,
                'industri' => $industri,
            ]);
        } else {
            $data = Industri::with('kota')
                ->where('aktif', 1)
                ->with('penempatanIndustri')
                ->whereHas('penempatanIndustri')
                ->withCount('penempatanIndustri')
                ->get();

            return view('nilai.index', [
                'data' => $data
            ]);
        }
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
        $pengaturan = Pengaturan::first();

        $urutan = 1;

        $siswa = Siswa::where('id', $siswa_id)->with('penempatan.industri')->first();
        $industri_id = $siswa->penempatan->industri->id;

        // Ambil data penempatan berdasarkan industri_id
        $penempatan = PenempatanIndustri::where('industri_id', $industri_id)
            ->with(['siswa.kelas.jurusan', 'industri'])
            ->get();

        // Ambil industri dari salah satu penempatan (asumsi industri sama)
        $item_penempatan = $penempatan->first();
        $industri = $item_penempatan->industri;

        // Ambil capaian yang dikelompokkan berdasarkan jurusan
        $capaianGrouped = CapaianPembelajaran::with('tujuanPembelajaran.nilai')->get()->groupBy('jurusan_id');

        // Susun data sesuai dengan format yang diinginkan
        $data = $penempatan->map(function($penempatan) use ($capaianGrouped, $urutan) {
            $siswa = $penempatan->siswa;
            $jurusanId = $siswa->kelas->jurusan->id;

            // Ambil capaian berdasarkan jurusan siswa
            $capaianForJurusan = $capaianGrouped->get($jurusanId) ?? collect([]);

            return [
                'siswa' => [
                    'id' => $siswa->id,
                    'nama' => $siswa->nama,
                    'jenis_kelamin' => $siswa->jenis_kelamin,
                    'kelas' => [
                        'nama' => $siswa->kelas->nama,
                        'jurusan' => [
                            'nama' => $siswa->kelas->jurusan->nama,
                            'singkatan' => $siswa->kelas->jurusan->singkatan,
                        ],
                    ],
                ],
                'capaian' => $capaianForJurusan->map(function($capaian) use ($urutan) {
                    return [
                        'nama' => $capaian->nama,
                        'tujuan' => $capaian->tujuanPembelajaran->map(function($tujuan) use ($urutan) {
                            $nilaiObj = $tujuan->nilai->where('urutan', $urutan)->first();
                            $nilai = $nilaiObj ? $nilaiObj->nilai : null; // Cek apakah objeknya null
                            return [
                                'id' => $tujuan->id,
                                'nama' => $tujuan->nama,
                                'nilai' => $nilai, // Nilai null jika tidak ditemukan
                            ];
                        })->toArray(),
                    ];
                })->toArray(),
            ];
        });

        $urutan2 = 2;

        // Susun data sesuai dengan format yang diinginkan
        $data2 = $penempatan->map(function($penempatan) use ($capaianGrouped, $urutan2) {
            $siswa = $penempatan->siswa;
            $jurusanId = $siswa->kelas->jurusan->id;

            // Ambil capaian berdasarkan jurusan siswa
            $capaianForJurusan = $capaianGrouped->get($jurusanId) ?? collect([]);

            return [
                'siswa' => [
                    'id' => $siswa->id,
                    'nama' => $siswa->nama,
                    'jenis_kelamin' => $siswa->jenis_kelamin,
                    'kelas' => [
                        'nama' => $siswa->kelas->nama,
                       'jurusan' => [
                            'nama' => $siswa->kelas->jurusan->nama,
                            'singkatan' => $siswa->kelas->jurusan->singkatan,
                        ],
                    ],
                ],
                'capaian' => $capaianForJurusan->map(function($capaian) use ($urutan2) {
                    return [
                        'nama' => $capaian->nama,
                        'tujuan' => $capaian->tujuanPembelajaran->map(function($tujuan) use ($urutan2) {
                            $nilaiObj = $tujuan->nilai->where('urutan', $urutan2)->first();
                            $nilai = $nilaiObj ? $nilaiObj->nilai : null; // Cek apakah objeknya null
                            return [
                                'id' => $tujuan->id,
                                'nama' => $tujuan->nama,
                                'nilai' => $nilai, // Nilai null jika tidak ditemukan
                            ];
                        })->toArray(),
                    ];
                })->toArray(),
            ];
        });

        return view('nilai.show', [
            'penempatan' => $data,
            'penempatan2' => $data2,
            'industri' => $industri,
            'urutan' => $urutan,
        ]);
    }

    public function edit($industri_id) 
    {
        $urutan = null;
        $pengaturan = Pengaturan::first();

        if($pengaturan->penilaian_2 == "off"){
            $urutan = 1;
        } else {
            $urutan = 2;
        }

        // Ambil data penempatan berdasarkan industri_id
        $penempatan = PenempatanIndustri::where('industri_id', $industri_id)
            ->with(['siswa.kelas.jurusan', 'industri'])
            ->get();

        // Ambil industri dari salah satu penempatan (asumsi industri sama)
        $item_penempatan = $penempatan->first();
        $industri = $item_penempatan->industri;

        // Urutkan penempatan berdasarkan nama jurusan
        $penempatan = $penempatan->sortBy(function($item) {
            return $item->siswa->kelas->jurusan->nama;
        })->values();

        // Ambil capaian yang dikelompokkan berdasarkan jurusan
        $capaianGrouped = CapaianPembelajaran::with('tujuanPembelajaran.nilai')
            ->get()
            ->groupBy('jurusan_id');

        // Susun data sesuai dengan format yang diinginkan
        $data = $penempatan->map(function($penempatan) use ($capaianGrouped, $urutan) {
            $siswa = $penempatan->siswa;
            $jurusanId = $siswa->kelas->jurusan->id;

            // Ambil capaian berdasarkan jurusan siswa
            $capaianForJurusan = $capaianGrouped->get($jurusanId) ?? collect([]);

            return [
                'siswa' => [
                    'id' => $siswa->id,
                    'nama_lengkap' => $siswa->user->name,
                    'jenis_kelamin' => $siswa->jenis_kelamin,
                    'kelas' => [
                        'nama' => $siswa->kelas->nama,
                        'klasifikasi' => $siswa->kelas->klasifikasi,
                        'jurusan' => [
                            'nama' => $siswa->kelas->jurusan->nama,
                            'singkatan' => $siswa->kelas->jurusan->singkatan,
                        ],
                    ],
                ],
                'capaian' => $capaianForJurusan->map(function($capaian) use ($siswa, $urutan) {
                    return [
                        'nama' => $capaian->nama,
                        'tujuan' => $capaian->tujuanPembelajaran->map(function($tujuan) use ($siswa, $urutan) {
                            $nilaiObj = $tujuan->nilai
                                ->where('siswa_id', $siswa->id)
                                ->where('tujuan_pembelajaran_id', $tujuan->id)
                                ->where('urutan', $urutan)
                                ->first();
                            $nilai = $nilaiObj ? $nilaiObj->nilai : null; 

                            return [
                                'id' => $tujuan->id,
                                'nama' => $tujuan->nama,
                                'nilai' => $nilai, 
                            ];
                        })->toArray(),
                    ];
                })->toArray(),
            ];
        });

        // dd($data);

        return view('nilai.edit', [
            'penempatan' => $data,
            'industri' => $industri,
            'urutan' => $urutan,
        ]);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Nilai $nilai)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Nilai $nilai)
    {
        //
    }

    public function storeOrUpdate(Request $request)
    {
        // Validasi input data
        $request->validate([
            'data.*.siswa_id' => 'required|exists:siswas,id',
            'data.*.capaian.*.tujuan.*' => 'required',
        ]);



        $urutan = null;
        $pengaturan = Pengaturan::first();

        if($pengaturan->penilaian_2 == "off"){
            $urutan = 1;
        } else {
            $urutan = 2;
        }

        // $siswa_id = $request['data'][0]['siswa_id'];
        // Nilai::where([
        //     'siswa_id' => $siswa_id, 
        //     'urutan' => $urutan
        //     ])->delete();


        // Iterasi setiap baris data siswa
        foreach ($request->input('data') as $dataSiswa) {
            $siswaId = $dataSiswa['siswa_id'];

            // Iterasi capaian
            foreach ($dataSiswa['capaian'] as $capaian) {
                foreach ($capaian['tujuan'] as $tujuanIndex => $nilaiTujuan) {

                    // Cek jika nilai tujuan tidak kosong
                    if (isset($nilaiTujuan)) {
                        $tujuanPembelajaranId = $capaian['tujuan'][$tujuanIndex]['id'];

                        // Update atau buat data nilai
                        Nilai::updateOrCreate(
                            [
                                'siswa_id' => $siswaId,
                                'tujuan_pembelajaran_id' => $tujuanPembelajaranId,
                                'urutan' => $urutan,
                            ],
                            [
                                'siswa_id' => $siswaId,
                                'tujuan_pembelajaran_id' => $tujuanPembelajaranId,
                                'urutan' => $urutan,
                                'nilai' => $nilaiTujuan['nilai'],
                            ]
                        );
                    }
                }
            }
        }

        return redirect()->back()->with('success', 'Nilai berhasil disimpan atau diperbarui.');
    }

}
