<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\Industri;
use App\Models\Jurusan;
use App\Models\Kelas;
use App\Models\Kota;
use App\Models\PenempatanIndustri;
use App\Models\Pengaturan;
use App\Models\PilihanKota;
use App\Models\Siswa;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PenempatanIndustriController extends Controller
{
    protected $model;
    public function __construct(PenempatanIndustri $a)
    {
        $this->model = $a;

        $this->middleware('can:c_penempatan_industri')->only(['create', 'store']);
        $this->middleware('can:r_penempatan_industri')->only(['index', 'show']);
        $this->middleware('can:u_penempatan_industri')->only(['edit', 'update']);
        $this->middleware('can:d_penempatan_industri')->only('destroy');
    }


    public function index()
    {
        if(auth()->user()->hasRole('wali_kelas')){
            $guru = Guru::where('user_id', auth()->user()->id)->first();
            $kelas = Kelas::where('guru_id', $guru->id)->first();

            // Filter jurnal berdasarkan kelas
            $penempatan = PenempatanIndustri::whereHas('siswa.kelas.jurusan', function ($query) use ($kelas) {
                $query->where('kelas.id', $kelas->id);
            })->with(['siswa.kelas', 'industri.kota'])->get();
        } else {
            $penempatan = PenempatanIndustri::with([
                    'siswa.kelas.jurusan', 
                    'industri.kota', 
                    'siswa.tahunAjaran'
                    ])
                ->paginate(250);
        }

        $data = Industri::where('aktif', 1)
            ->with(['kuotaIndustri', 'kuotaIndustri.jurusan'])
            ->withCount(['penempatanIndustri as total_terisi' => function($query) {
                $query->select(DB::raw('count(*)'));
            }])
            ->orderBy('nama', 'asc')
            ->paginate(100);

        // $jurusan = Jurusan::get();
        $jurusan = Jurusan::doesntHave('jurusans')->get();
        $kota = Kota::get();
        $kelas = Kelas::with('jurusan')->get();

        return view('penempatan_industri.index', [
            'data' => $data,
            'kelas' => $kelas,
            'kota' => $kota,
            'jurusan' => $jurusan,
            'penempatan' => $penempatan,
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
    public function show($industri_id)
    {
        $industri = Industri::with('kota')->findOrFail($industri_id);
        $siswa = Siswa::with(['kelas.jurusan'])->get();
        $pengaturan = Pengaturan::first();

        $data = Industri::with(['kuotaIndustri', 'kuotaIndustri.jurusan'])
                    ->where('id', $industri_id)->get();
        $jurusan = Jurusan::get();
        // $jurusan = Jurusan::doesntHave('jurusans')->get();
        $penempatan = PenempatanIndustri::where('industri_id', $industri_id)->get();
        $siswaIds = $penempatan->pluck('siswa_id')->toArray();
        $siswaTerfilter = Siswa::whereIn('id', $siswaIds)
                            ->with('kelas.jurusan')->get();

        return view('penempatan_industri.show', compact([
            'penempatan', 
            'pengaturan',
            'industri', 
            'siswa', 
            'siswaTerfilter', 
            'data', 
            'jurusan'
        ]));
    }

    public function show2($industri_id)
    {
        $data = PenempatanIndustri::with(['siswa', 'industri'])->findOrFail($industri_id);
        $pilihan_kota = PilihanKota::with(['kota1','kota2','kota3'])->where('siswa_id', $data->siswa_id)->first();
        $penempatan = PenempatanIndustri::with(['industri.kota'])->where('siswa_id', $data->siswa_id)->first();

        return view('penempatan_industri.show2', compact([
            'data', 
            'pilihan_kota', 
            'penempatan', 
        ]));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($industri_id)
    {
        $industri = Industri::with(['kota', 'libur'])->findOrFail($industri_id);
        // $siswa = Siswa::with(['kelas.jurusan', 'tahunAjaran'])->get();
        $kota_id = $industri->kota->id;

        // // Filter siswa berdasarkan pilihan_kotas yang kota_id_1, kota_id_2, atau kota_id_3 cocok dengan kota_id industri
        $siswa = Siswa::with([
            'user', 
            'kelas.jurusan', 
            'pilihankota.kota1', 
            'pilihankota.kota2', 
            'pilihankota.kota3', 
            'penempatan',
            'tahunAjaran'
            ])
            ->whereHas('pilihankota', function ($query) use ($kota_id) {
                // $query->where('kota_id_1', $kota_id)
                //     ->orWhere('kota_id_2', $kota_id)
                //     ->orWhere('kota_id_3', $kota_id);
                $query->whereNotNull('status') // Menambah kondisi status tidak null
                    ->where(function ($query) use ($kota_id) {
                        $query->where('kota_id_1', $kota_id)
                            ->orWhere('kota_id_2', $kota_id)
                            ->orWhere('kota_id_3', $kota_id);
                    });
            })
            ->get();

        $data = Industri::with(['kuotaIndustri', 'kuotaIndustri.jurusan'])
                    ->where('id', $industri_id)->get();
        // $jurusan = Jurusan::get();
        $jurusan = Jurusan::doesntHave('jurusans')->get();
        $penempatan = PenempatanIndustri::where('industri_id', $industri_id)->get();
        $siswaIds = $penempatan->pluck('siswa_id')->toArray();
        $siswaTerfilter = Siswa::whereIn('id', $siswaIds)
                            ->with([
                                'penempatan', 
                                'kelas.jurusan', 
                                'pilihankota.kota1', 
                                'pilihankota.kota2', 
                                'pilihankota.kota3',
                                'tahunAjaran',
                                ])
                            ->get();

        $noLiburIndustri = 
            $industri->libur &&
            !$industri->libur->senin &&
            !$industri->libur->selasa &&
            !$industri->libur->rabu &&
            !$industri->libur->kamis &&
            !$industri->libur->jumat &&
            !$industri->libur->sabtu &&
            !$industri->libur->minggu;


        return view('penempatan_industri.edit', compact([
            'penempatan', 
            'industri', 
            'noLiburIndustri', 
            'siswa', 
            'siswaTerfilter', 
            'data', 
            'jurusan'
        ]));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PenempatanIndustri $penempatanIndustri)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PenempatanIndustri $penempatanIndustri)
    {
        //
    }

    public function storeOrUpdate(Request $request){
        // $validated = $request->validate([
        $validated = Validator::make($request->all(), [
            'industri_id' => 'required|string',
            'data.*.id_siswa' => 'required|string',
            'pilihan' => 'nullable|string',
            // 'tahun_ajaran' => 'nullable|string',
        ]);

        if ($validated->fails()) {
            // Mengembalikan dengan status pesan "Error" jika id_siswa gagal validasi
            return back()->with('error', 'Pastikan data tidak kosong!');
        }

        $industri_id = $request->industri_id;
        // $tahun_ajaran = $validated['tahun_ajaran'];

        PenempatanIndustri::where('industri_id', $industri_id)
                    // ->where('tahun_ajaran', $tahun_ajaran)
                    ->delete();

        if(isset($request->data)) {
            foreach ($request->data as $data) {
                PenempatanIndustri::updateOrCreate([
                        'industri_id' => $industri_id,
                        'siswa_id' => $data['id_siswa'],
                        'pilihan' => $request->pilihan,
                        // 'tahun_ajaran' => $request->tahun_ajaran
                    ],
                );
            }
        }

        return redirect('penempatan')->with('status', 'Data berhasil diubah!');
    }
}
