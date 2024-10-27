<?php

namespace App\Http\Controllers;

use App\Models\CapaianPembelajaran;
use App\Models\Jurusan;
use App\Models\TujuanPembelajaran;
use Illuminate\Http\Request;

class CapaianPembelajaranController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $jurusan = Jurusan::with([
            'bidangKeahlian', 
            'capaianPembelajaran.tujuanPembelajaran'])
            ->orderBy('nama', 'asc')
            ->get();

        return view('capaian.index', compact(['jurusan']));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'capaian_pembelajaran' => 'required|array|min:1',
            'capaian_pembelajaran.*' => 'required|string',
            'tujuan_pembelajaran' => 'required|array',
            'tujuan_pembelajaran.*' => 'required|array|min:1',
            'tujuan_pembelajaran.*.*' => 'required|string',
        ]);


        foreach ($validated['capaian_pembelajaran'] as $index => $capaian) {
            // Simpan Capaian Pembelajaran
            $capaianPembelajaran = CapaianPembelajaran::create([
                'jurusan_id' => $request->jurusan_id,
                'nama' => $capaian,
            ]);

            // Simpan Tujuan Pembelajaran terkait
            foreach ($validated['tujuan_pembelajaran'][$index] as $tujuan) {
                TujuanPembelajaran::create([
                    'capaian_pembelajaran_id' => $capaianPembelajaran->id,
                    'nama' => $tujuan,
                ]);
            }
        }

        return redirect()->back()->with('success', 'Data berhasil disimpan');
    }


    /**
     * Display the specified resource.
     */
    public function show(CapaianPembelajaran $capaianPembelajaran)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    // public function edit($jurusan_id)
    // {
    //     $jurusan = Jurusan::findOrFail($jurusan_id);
    //     return view('capaian.edit', compact(['jurusan']));
    // }

    public function edit($jurusan_id)
    {
        $jurusan = Jurusan::with('capaianPembelajaran.tujuanPembelajaran')
            ->findOrFail($jurusan_id);
        $capaian = CapaianPembelajaran::where('jurusan_id', $jurusan->id)
            ->get();
        $capaianCount = $capaian->count();

        return view('capaian.edit', compact([
            'jurusan', 
            'capaian',
            'capaianCount'
        ]));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CapaianPembelajaran $capaianPembelajaran)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CapaianPembelajaran $capaianPembelajaran)
    {
        //
    }
 
    public function storeOrUpdate(Request $request)
    {
        // Validasi input data
        $validated = $request->validate([
            'jurusan_id' => 'required|integer', 
            'capaian_pembelajaran' => 'required|array|min:1',
            'capaian_pembelajaran.*.nama' => 'required|string',
            'capaian_pembelajaran.*.tujuan_pembelajaran' => 'required|array|min:1',
            'capaian_pembelajaran.*.tujuan_pembelajaran.*' => 'required|string',
        ]);

        // Hapus Capaian Pembelajaran lama berdasarkan jurusan_id
        CapaianPembelajaran::where('jurusan_id', $validated['jurusan_id'])->delete();

        // Simpan Capaian Pembelajaran baru dan Tujuan Pembelajaran terkait
        foreach ($validated['capaian_pembelajaran'] as $capaian) {
            // Simpan Capaian Pembelajaran
            $capaianPembelajaran = CapaianPembelajaran::create([
                'jurusan_id' => $validated['jurusan_id'],
                'nama' => $capaian['nama'],
            ]);

            // Simpan Tujuan Pembelajaran terkait
            foreach ($capaian['tujuan_pembelajaran'] as $tujuan) {
                TujuanPembelajaran::create([
                    'capaian_pembelajaran_id' => $capaianPembelajaran->id,
                    'nama' => $tujuan,
                ]);
            }
        }

        return redirect('capaian')->with('success', 'Data berhasil disimpan');
    }
}

