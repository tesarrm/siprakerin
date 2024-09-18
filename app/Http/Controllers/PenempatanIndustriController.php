<?php

namespace App\Http\Controllers;

use App\Models\Industri;
use App\Models\Jurusan;
use App\Models\Kota;
use App\Models\PenempatanIndustri;
use App\Models\Pengaturan;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PenempatanIndustriController extends Controller
{
    protected $model;
    public function __construct(PenempatanIndustri $a)
    {
        $this->model = $a;
    }

    /**
     * Display a listing of the resource.
     */
    // public function index()
    // {
    //     $data = Industri::with(['kuotaIndustri', 'kuotaIndustri.jurusan'])->get();
    //     $jurusan = Jurusan::get();
    //     $penempatan = PenempatanIndustri::get();

    //     return view('penempatan_industri.index', [
    //         'data' => $data,
    //         'jurusan' => $jurusan,
    //         'penempatan' => $penempatan,
    //     ]);
    // }
    public function index()
    {
        $penempatan = PenempatanIndustri::with(['siswa', 'industri'])->get();
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
    public function show(PenempatanIndustri $penempatanIndustri)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($industri_id)
    {
        $industri = Industri::with('kota')->findOrFail($industri_id);
        $siswa = Siswa::with(['kelas.jurusan'])->get();
        $pengaturan = Pengaturan::first();

        // $kota_id = $industri->kota->id;

        // // Filter siswa berdasarkan pilihan_kotas yang kota_id_1, kota_id_2, atau kota_id_3 cocok dengan kota_id industri
        // $siswa = Siswa::with(['kelas.jurusan'])
        //     ->whereHas('pilihankota', function ($query) use ($kota_id) {
        //         $query->where('kota_id_1', $kota_id)
        //             ->orWhere('kota_id_2', $kota_id)
        //             ->orWhere('kota_id_3', $kota_id);
        //     })
        //     ->get();

        $data = Industri::with(['kuotaIndustri', 'kuotaIndustri.jurusan'])->where('id', $industri_id)->get();
        $jurusan = Jurusan::get();

        $penempatan = PenempatanIndustri::where('industri_id', $industri_id)->get();
        $siswaIds = $penempatan->pluck('siswa_id')->toArray();
        // $siswa = Siswa::whereHas('pilihanKota')
        //     ->whereIn('id', $siswaIds) 
        //     ->with('kelas.jurusan')
        //     ->get();
        $siswaTerfilter = Siswa::whereIn('id', $siswaIds)->with('kelas.jurusan')->get();

        return view('penempatan_industri.edit', compact(['penempatan', 'pengaturan','industri', 'siswa', 'siswaTerfilter', 'data', 'jurusan']));
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
                    'tahun_ajaran' => $validated['tahun_ajaran']
                ],
            );
        }
    }
}
