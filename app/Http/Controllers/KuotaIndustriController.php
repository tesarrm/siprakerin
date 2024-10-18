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

        $this->middleware('can:c_kuota_industri')->only(['create', 'store']);
        $this->middleware('can:r_kuota_industri')->only(['index', 'show', 'storeOrUpdate']);
        $this->middleware('can:u_kuota_industri')->only(['edit', 'update', 'storeOrUpdate']);
        $this->middleware('can:d_kuota_industri')->only('destroy');
    }

    public function index()
    {
        $data = Industri::where('aktif', 1)->with(['kuotaIndustri', 'kuotaIndustri.jurusan', 'kota'])->get();
        $jurusan = Jurusan::get();

        return view('kuota_industri.index', [
            'data' => $data,
            'jurusan' => $jurusan
        ]);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show(KuotaIndustri $kuotaIndustri)
    {
        //
    }

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

    public function update(Request $request, KuotaIndustri $kuotaIndustri)
    {
        //
    }

    public function destroy(KuotaIndustri $kuotaIndustri)
    {
        //
    }

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
