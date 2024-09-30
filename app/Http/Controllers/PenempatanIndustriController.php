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
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PenempatanIndustriController extends Controller
{
    protected $model;
    public function __construct(PenempatanIndustri $a)
    {
        $this->model = $a;

        $this->middleware('can:c_penempatan_prakerin')->only(['create', 'store']);
        $this->middleware('can:r_penempatan_prakerin')->only(['index', 'show']);
        $this->middleware('can:u_penempatan_prakerin')->only(['edit', 'update']);
        $this->middleware('can:d_penempatan_prakerin')->only('destroy');
    }


    public function index()
    {
        if(auth()->user()->hasRole('wali_siswa')){
            $guru = Guru::where('user_id', auth()->user()->id)->first();
            $kelas = Kelas::where('guru_id', $guru->id)->first();

            // Filter jurnal berdasarkan kelas
            $penempatan = PenempatanIndustri::whereHas('siswa.kelas', function ($query) use ($kelas) {
                $query->where('kelas.id', $kelas->id);
            })->with(['siswa.kelas', 'industri.kota'])->get();
        } else {
            $penempatan = PenempatanIndustri::with(['siswa.kelas', 'industri.kota'])->get();
        }
        $data = Industri::with(['kuotaIndustri', 'kuotaIndustri.jurusan'])
            ->withCount(['penempatanIndustri as total_terisi' => function($query) {
                $query->select(DB::raw('count(*)'));
            }])->get();

        $jurusan = Jurusan::get();
        return view('penempatan_industri.index', [
            'data' => $data,
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
        $industri = Industri::with('kota')->findOrFail($industri_id);
        $siswa = Siswa::with(['kelas.jurusan'])->get();
        $pengaturan = Pengaturan::first();

        $kota_id = $industri->kota->id;

        // // Filter siswa berdasarkan pilihan_kotas yang kota_id_1, kota_id_2, atau kota_id_3 cocok dengan kota_id industri
        $siswa = Siswa::with(['kelas.jurusan', 'pilihankota.kota1', 'pilihankota.kota2', 'pilihankota.kota3'])
            ->whereHas('pilihankota', function ($query) use ($kota_id) {
                $query->where('kota_id_1', $kota_id)
                    ->orWhere('kota_id_2', $kota_id)
                    ->orWhere('kota_id_3', $kota_id);
            })
            ->get();

        $data = Industri::with(['kuotaIndustri', 'kuotaIndustri.jurusan'])
                    ->where('id', $industri_id)->get();
        $jurusan = Jurusan::get();
        $penempatan = PenempatanIndustri::where('industri_id', $industri_id)->get();
        $siswaIds = $penempatan->pluck('siswa_id')->toArray();
        // $siswa = Siswa::whereHas('pilihanKota')
        //     ->whereIn('id', $siswaIds) 
        //     ->with('kelas.jurusan')
        //     ->get();
        $siswaTerfilter = Siswa::whereIn('id', $siswaIds)
                            ->with(['penempatan', 'kelas.jurusan', 'pilihankota.kota1', 'pilihankota.kota2', 'pilihankota.kota3'])->get();

        return view('penempatan_industri.edit', compact([
            'penempatan', 
            'pengaturan',
            'industri', 
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
        $validated = $request->validate([
            'industri_id' => 'required|string',
            'data.*.id_siswa' => 'required|string',
            'pilihan' => 'required|string',
            'tahun_ajaran' => 'required|string',
        ]);

        $industri_id = $validated['industri_id'];
        $tahun_ajaran = $validated['tahun_ajaran'];

        PenempatanIndustri::where('industri_id', $industri_id)
                    ->where('tahun_ajaran', $tahun_ajaran)
                    ->delete();

        foreach ($validated['data'] as $data) {
            PenempatanIndustri::updateOrCreate([
                    'industri_id' => $industri_id,
                    'siswa_id' => $data['id_siswa'],
                    'pilihan' => $validated['pilihan'],
                    'tahun_ajaran' => $validated['tahun_ajaran']
                ],
            );
        }

        return redirect('penempatan')->with('status', 'Data berhasil diubah!');
    }
}
