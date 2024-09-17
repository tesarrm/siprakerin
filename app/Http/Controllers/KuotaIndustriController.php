<?php

namespace App\Http\Controllers;

use App\Models\Industri;
use App\Models\Jurusan;
use App\Models\KuotaIndustri;
use Illuminate\Http\Request;

class KuotaIndustriController extends Controller
{
    protected $model;
    public function __construct(KuotaIndustri $a)
    {
        $this->model = $a;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Industri::with(['kuotaIndustri', 'kuotaIndustri.jurusan'])->get();
        $jurusan = Jurusan::get();

        return view('kuota_industri.index', [
            'data' => $data,
            'jurusan' => $jurusan
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
    public function show(KuotaIndustri $kuotaIndustri)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    // public function edit($id)
    // {
    //     $jurusan = Jurusan::get();

    //     return view('kuota_industri.edit', [
    //         'industri_id' => $id,
    //         'jurusans' => $jurusan
    //     ]);
    // }

    public function edit($industri_id)
    {
        // Ambil semua jurusan
        $jurusans = Jurusan::all();

        // Ambil kuota yang sudah ada untuk industri tertentu
        $kuotaIndustri = KuotaIndustri::where('industri_id', $industri_id)->get();

        // Buat array untuk menyimpan kuota berdasarkan jenis kelamin
        $kuotas = [];
        foreach ($jurusans as $jurusan) {
            // Cari kuota laki-laki
            $kuotaLaki = $kuotaIndustri->where('jurusan_id', $jurusan->id)->where('jenis_kelamin', 'Laki-laki')->first();
            // Cari kuota perempuan
            $kuotaPerempuan = $kuotaIndustri->where('jurusan_id', $jurusan->id)->where('jenis_kelamin', 'Perempuan')->first();

            // Simpan nilai kuota, jika tidak ada, beri nilai 0
            $kuotas[$jurusan->id]['laki'] = $kuotaLaki ? $kuotaLaki->kuota : 0;
            $kuotas[$jurusan->id]['perempuan'] = $kuotaPerempuan ? $kuotaPerempuan->kuota : 0;
        }

        // Kirim data ke view
        return view('kuota_industri.edit', compact('jurusans', 'kuotas', 'industri_id'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, KuotaIndustri $kuotaIndustri)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(KuotaIndustri $kuotaIndustri)
    {
        //
    }

    // public function storeOrUpdate(Request $request)
    // {
    //     $validated = $request->validate([
    //         'industri_id' => 'required|exists:industris,id',
    //         'kuota.*.jurusan_id' => 'required|exists:jurusans,id',
    //         'kuota.*.kuota' => 'required|integer|min:0',
    //     ]);

    //     $industri_id = $validated['industri_id'];

    //     dd($validated);
        
    //     // Handle Laki-laki
    //     foreach ($validated['kuota'] as $data) {
    //         if (isset($data['jenis_kelamin']) && $data['jenis_kelamin'] == 'Laki-laki') {
    //             KuotaIndustri::updateOrCreate(
    //                 ['industri_id' => $industri_id, 'jurusan_id' => $data['jurusan_id'], 'jenis_kelamin' => 'Laki-laki'],
    //                 ['kuota' => $data['kuota']]
    //             );
    //         }
    //     }

    //     // Handle Perempuan
    //     foreach ($validated['kuota'] as $data) {
    //         if (isset($data['jenis_kelamin']) && $data['jenis_kelamin'] == 'Perempuan') {
    //             KuotaIndustri::updateOrCreate(
    //                 ['industri_id' => $industri_id, 'jurusan_id' => $data['jurusan_id'], 'jenis_kelamin' => 'Perempuan'],
    //                 ['kuota' => $data['kuota']]
    //             );
    //         }
    //     }
        
    //     return redirect('kuotaindustri')->with('success', 'Data kuota industri berhasil disimpan.');
    // }

// public function storeOrUpdate(Request $request)
// {
//     dd($request);

//     $validated = $request->validate([
//         'industri_id' => 'required|exists:industris,id',
//         'kuota.*.jurusan_id' => 'required|exists:jurusans,id',
//         'kuota.*.jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
//         'kuota.*.kuota' => 'required|integer|min:0',
//     ]);

//     $industri_id = $validated['industri_id'];

    
//     foreach ($validated['kuota'] as $data) {
//         $kuota = KuotaIndustri::updateOrCreate(
//             ['industri_id' => $industri_id, 'jurusan_id' => $data['jurusan_id'], 'jenis_kelamin' => $data['jenis_kelamin']],
//             ['kuota' => $data['kuota']]
//         );
//     }
    
//     return redirect()->back()->with('success', 'Data kuota industri berhasil disimpan.');
// }

public function storeOrUpdate(Request $request)
{
    $validated = $request->validate([
        'industri_id' => 'required|exists:industris,id',
        'kuota.*.jurusan_id' => 'required|exists:jurusans,id',
        'kuota.*.laki_kuota' => 'nullable|integer|min:0',
        'kuota.*.perempuan_kuota' => 'nullable|integer|min:0',
    ]);

    $industri_id = $validated['industri_id'];

    foreach ($validated['kuota'] as $data) {
        // Laki-laki
        if (isset($data['laki_kuota'])) {
            KuotaIndustri::updateOrCreate(
                ['industri_id' => $industri_id, 'jurusan_id' => $data['jurusan_id'], 'jenis_kelamin' => 'Laki-laki'],
                ['kuota' => $data['laki_kuota']]
            );
        }
        
        // Perempuan
        if (isset($data['perempuan_kuota'])) {
            KuotaIndustri::updateOrCreate(
                ['industri_id' => $industri_id, 'jurusan_id' => $data['jurusan_id'], 'jenis_kelamin' => 'Perempuan'],
                ['kuota' => $data['perempuan_kuota']]
            );
        }
    }

    return redirect('kuotaindustri')->with('success', 'Data kuota industri berhasil disimpan.');
}
}
