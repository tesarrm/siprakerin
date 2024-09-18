<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\Kota;
use App\Models\PilihanKota;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PilihanKotaController extends Controller
{
    protected $model;
    public function __construct(PilihanKota $a)
    {
        $this->model = $a;
    }

    /**
     * Display a listing of the resource.
     */
    // public function index()
    // {
    //     $data = PilihanKota::with(['siswa', 'kota1', 'kota2', 'kota3'])->get();
    //     $siswa = Siswa::get();

    //     return view('pilihan_kota.index', [
    //         'data' => $data,
    //     ]);
    // }

// apakah id bergantung pada id siswa?
public function index()
{
    // Ambil semua data siswa
    $siswa = Siswa::with('pilihanKota')->get();
    $kelas = Kelas::get();

    // Looping melalui semua siswa untuk memeriksa apakah mereka punya data pemilihan kota
    $data = $siswa->map(function($siswa) {
        if ($siswa->pilihanKota) {
            // Jika siswa memiliki data pemilihan kota
            return [
                'siswa' => $siswa,
                'kota1' => $siswa->pilihanKota->kota1->nama ?? '-',
                'kota2' => $siswa->pilihanKota->kota2->nama ?? '-',
                'kota3' => $siswa->pilihanKota->kota3->nama ?? '-',
                'status' => $siswa->pilihanKota->status ?? 'proses',
            ];
        } else {
            // Jika siswa tidak memiliki data pemilihan kota, beri nilai default
            return [
                'siswa' => $siswa,
                'kota1' => '-',
                'kota2' => '-',
                'kota3' => '-',
                'status' => 'proses',
            ];
        }
    });

    // dd($data);

    return view('pilihan_kota.index', [
        'data' => $data,
        'kelas' => $kelas
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
    public function show(PilihanKota $pilihanKota)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    // public function edit($siswa_id)
    // {
    //     // jika kosong
    //     $siswa = Siswa::with('pilihankota')->findOrFail($siswa_id);
    //     $kota = Kota::get();

    //     return view('jurusan.edit', [
    //         'siswa' => $siswa,
    //         'kota' => $kota,
    //     ]);
    // }

    public function edit($siswa_id)
    {
        $data = PilihanKota::where('siswa_id', $siswa_id)->first();
        $siswa = Siswa::find($siswa_id);

        if (!$data) {
            $data = new PilihanKota(); // Jika data tidak ada, buat instance kosong
            $data->kota_id_1 = '';
            $data->kota_id_2 = '';
            $data->kota_id_3 = '';
        }

        $kota = Kota::all();
        
        // Pass data and kota to the view
        return view('pilihan_kota.edit', [
            'data' => $data,
            'siswa' => $siswa,
            'kota' => $kota
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    // public function update(Request $request, PilihanKota $pilihanKota)
    // {
    //     //
    //     dd($request);
    // }

    // Method to update the data
    public function storeOrUpdate(Request $request)
    {

        // Validate the request
        $request->validate([
            'siswa_id' => 'required',
            'kota_id_1' => 'required|exists:kotas,id',
            'kota_id_2' => 'required|exists:kotas,id',
            'kota_id_3' => 'required|exists:kotas,id',
            'status' => 'required',
        ]);

        PilihanKota::where('siswa_id', $request->input('siswa_id'))
            ->delete();

        PilihanKota::updateOrCreate([
                'siswa_id' => $request->input('siswa_id'),
                'kota_id_1' => $request->input('kota_id_1'),
                'kota_id_2' => $request->input('kota_id_2'),
                'kota_id_3' => $request->input('kota_id_3'),
                'status' => $request->input('status'),
            ]
        );

        // Redirect back with success message
        return redirect()->route('pilihankota.index')->with('status', 'Data Pilihan Kota berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PilihanKota $pilihanKota)
    {
        //
    }
}
