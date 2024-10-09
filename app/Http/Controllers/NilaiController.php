<?php

namespace App\Http\Controllers;

use App\Models\CapaianPembelajaran;
use App\Models\HasilMonitoring;
use App\Models\Industri;
use App\Models\Jurusan;
use App\Models\Kota;
use App\Models\Monitoring;
use App\Models\Nilai;
use App\Models\PenempatanIndustri;
use App\Models\Siswa;
use Illuminate\Http\Request;

class NilaiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Industri::with('kota')->where('aktif', 1)->get();

        return view('nilai.index', [
            'data' => $data
        ]);
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
    public function show(Nilai $nilai)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function _edit($jadwal_monitoring_id)
    {
        $penempatan = PenempatanIndustri::where('industri_id', $jadwal_monitoring_id)->with(['siswa.kelas.jurusan', 'industri'])->get();
        $item_penempatan = $penempatan->first();
        $industri = $item_penempatan->industri->nama;

        $capaian = CapaianPembelajaran::get()->groupBy('jurusan_id');


        $penempatan = [
            [
                'siswa' => [
                    'id' => 1,
                    'nama' => 'Siswa 1',
                    'jenis_kelamin' => 'Laki-laki',
                    'kelas' => [
                        'nama' => 'Kelas 10',
                        'jurusan' => [
                            'nama' => 'Jurusan Teknik',
                            'singkatan' => 'TK',
                        ],
                    ],
                ],
                'capaian' => [
                    [
                        'nama' => 'ini adalah judul materi',
                        'tujuan' => [
                            [
                                'nama' => 'Lorem inpusmaljflasjfd laskjf lsajf lsajf lsadjfC aslkjflsajf lsajflsa flksajf lsajf lsajf lsajf lsajflds alksjf lasjf lsajf saljf sa;ljf ;lsajflsjf saljf lsakjf lsad jf;ldsa jf;lsa jflsa jflsajf lsajf lksajflksa jfjs flks jf;ldsj fa flsa jfdapaian',
                            ], 
                            [
                                'nama' => 'Lorem inpusmaljflasjfd laskjf lsajf lsajf lsadjfC aslkjflsajf lsajflsa flksajf lsajf lsajf lsajf lsajflds alksjf lasjf lsajf saljf sa;ljf ;lsajflsjf saljf lsakjf lsad jf;ldsa jf;lsa jflsa jflsajf lsajf lksajflksa jfjs flks jf;ldsj fa flsa jfdapaian',
                            ], 
                            [
                                'nama' => 'Lorem inpusmaljflasjfd laskjf lsajf lsajf lsadjfC aslkjflsajf lsajflsa flksajf lsajf lsajf lsajf lsajflds alksjf lasjf lsajf saljf sa;ljf ;lsajflsjf saljf lsakjf lsad jf;ldsa jf;lsa jflsa jflsajf lsajf lksajflksa jfjs flks jf;ldsj fa flsa jfdapaian',
                            ], 
                            [
                                'nama' => 'Lorem inpusmaljflasjfd laskjf lsajf lsajf lsadjfC aslkjflsajf lsajflsa flksajf lsajf lsajf lsajf lsajflds alksjf lasjf lsajf saljf sa;ljf ;lsajflsjf saljf lsakjf lsad jf;ldsa jf;lsa jflsa jflsajf lsajf lksajflksa jfjs flks jf;ldsj fa flsa jfdapaian',
                            ], 
                        ],
                    ],
                    [
                        'nama' => 'ini adalah judul materi',
                        'tujuan' => [
                            [
                                'nama' => 'Lorem inpusmaljflasjfd laskjf lsajf lsajf lsadjfC aslkjflsajf lsajflsa flksajf lsajf lsajf lsajf lsajflds alksjf lasjf lsajf saljf sa;ljf ;lsajflsjf saljf lsakjf lsad jf;ldsa jf;lsa jflsa jflsajf lsajf lksajflksa jfjs flks jf;ldsj fa flsa jfdapaian',
                            ], 
                            [
                                'nama' => 'Lorem inpusmaljflasjfd laskjf lsajf lsajf lsadjfC aslkjflsajf lsajflsa flksajf lsajf lsajf lsajf lsajflds alksjf lasjf lsajf saljf sa;ljf ;lsajflsjf saljf lsakjf lsad jf;ldsa jf;lsa jflsa jflsajf lsajf lksajflksa jfjs flks jf;ldsj fa flsa jfdapaian',
                            ], 
                        ],
                    ],
                ],
            ],
            [
                'siswa' => [
                    'id' => 2,
                    'nama' => 'Siswa 2',
                    'jenis_kelamin' => 'Perempuan',
                    'kelas' => [
                        'nama' => 'Kelas 11',
                        'jurusan' => [
                            'nama' => 'Jurusan Akuntansi',
                            'singkatan' => 'AK',
                        ],
                    ],
                ],
                'capaian' => [
                    [
                        'nama' => 'ini adalah judul materi',
                        'tujuan' => [
                            [
                                'nama' => 'Lorem inpusmaljflasjfd laskjf lsajf lsajf lsadjfC aslkjflsajf lsajflsa flksajf lsajf lsajf lsajf lsajflds alksjf lasjf lsajf saljf sa;ljf ;lsajflsjf saljf lsakjf lsad jf;ldsa jf;lsa jflsa jflsajf lsajf lksajflksa jfjs flks jf;ldsj fa flsa jfdapaian',
                            ], 
                            [
                                'nama' => 'Lorem inpusmaljflasjfd laskjf lsajf lsajf lsadjfC aslkjflsajf lsajflsa flksajf lsajf lsajf lsajf lsajflds alksjf lasjf lsajf saljf sa;ljf ;lsajflsjf saljf lsakjf lsad jf;ldsa jf;lsa jflsa jflsajf lsajf lksajflksa jfjs flks jf;ldsj fa flsa jfdapaian',
                            ], 
                        ],
                    ],
                    [
                        'nama' => 'ini adalah judul materi',
                        'tujuan' => [
                            [
                                'nama' => 'Lorem inpusmaljflasjfd laskjf lsajf lsajf lsadjfC aslkjflsajf lsajflsa flksajf lsajf lsajf lsajf lsajflds alksjf lasjf lsajf saljf sa;ljf ;lsajflsjf saljf lsakjf lsad jf;ldsa jf;lsa jflsa jflsajf lsajf lksajflksa jfjs flks jf;ldsj fa flsa jfdapaian',
                            ], 
                        ],
                    ],
                ],
            ],
        ];

        return view('nilai.edit', [
            'penempatan' => $penempatan,
            'industri' => $industri,
            // 'capaian' => $capaian,
        ]);
    }

    public function edit($jadwal_monitoring_id) 
    {
        // Ambil data penempatan berdasarkan industri_id
        $penempatan = PenempatanIndustri::where('industri_id', $jadwal_monitoring_id)
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
                'capaian' => $capaianForJurusan->map(function($capaian) {
                    return [
                        'nama' => $capaian->nama,
                        'tujuan' => $capaian->tujuanPembelajaran->map(function($tujuan) {
                            return [
                                'id' => $tujuan->id,
                                'nama' => $tujuan->nama,
                                'nilai' => $tujuan->nilai->nilai,
                            ];
                        })->toArray(),
                    ];
                })->toArray(),
            ];
        });

        return view('nilai.edit', [
            'penempatan' => $data,
            'industri' => $industri,
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

    $siswa = Siswa::where('user_id', auth()->user()->id)->first();
    Nilai::where('siswa_id', $siswa->id)
        ->delete();

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
                        ],
                        [
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
