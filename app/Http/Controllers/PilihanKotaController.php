<?php

namespace App\Http\Controllers;

use App\Models\Jurusan;
use App\Models\Kelas;
use App\Models\Kota;
use App\Models\PilihanKota;
use App\Models\Siswa;
use Illuminate\Http\Request;

class PilihanKotaController extends Controller
{
    protected $model;
    public function __construct(PilihanKota $a)
    {
        $this->model = $a;

        $this->middleware('can:r_pilihan_kota')->only(['index', 'show']);
        $this->middleware('can:c_pilihan_kota')->only(['create', 'store']);
        $this->middleware('can:u_pilihan_kota')->only(['edit', 'update']);
        $this->middleware('can:d_pilihan_kota')->only('destroy');
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
    $siswa = Siswa::with(['pilihanKota', 'user'])
        ->join('users', 'siswas.user_id', '=', 'users.id') // Menyambungkan dengan tabel users
        ->orderBy('users.name', 'asc') // Mengurutkan berdasarkan nama di tabel users
        ->select('siswas.*') // Memilih kolom dari tabel gurus agar tidak terjadi duplikasi
        ->paginate(250);
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
    $data = [];

    return view('pilihan_kota.index', [
        'data' => $data,
        'kelas' => $kelas
    ]);
}

public function index2(Request $request)
{
    $kelas = $request->kelas; // Ambil parameter kelas dari request
    

    $kelas = Kelas::with('jurusan.bidangKeahlian')
        ->get()
        ->first(function ($k) use ($kelas) {
            // Gabungkan nama kelas dengan jurusan dan klasifikasi untuk dibandingkan
            $nama = $k->nama . " " . $k->jurusan->singkatan . " " . $k->klasifikasi;
            return $kelas == $nama; // Bandingkan nama yang sudah dibentuk dengan row
        });

    // Ambil semua data siswa
    $siswa = Siswa::with(['pilihanKota', 'user'])
        ->whereHas('pilihankota')
        ->where('kelas_id', $kelas->id) 
        ->join('users', 'siswas.user_id', '=', 'users.id') // Menyambungkan dengan tabel users
        ->orderBy('users.name', 'asc') // Mengurutkan berdasarkan nama di tabel users
        ->select('siswas.*') // Memilih kolom dari tabel gurus agar tidak terjadi duplikasi
        ->paginate(250);
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

    $items = [];
    foreach ($data as $d) {
        $items[] = [
            'siswa' => $d['siswa']->user->name,
            'kelas' => $d['siswa']->kelas->nama . " " . $d['siswa']->kelas->jurusan->singkatan . " " . $d['siswa']->kelas->klasifikasi,
            'kota_1' => $d['kota1'],
            'kota_2' => $d['kota2'],
            'kota_3' => $d['kota3'],
            'status' => $d['status'],
            'action' => $d['siswa']->id, // Gunakan ID ini untuk aksi
        ];
    }

    // dd($data);

    return response()->json($items);
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

    public function buat()
    {
        $user_id = auth()->user()->id;


        $siswa = Siswa::where('user_id', $user_id)
            ->with('kelas.jurusan2')
            ->with('kelas.jurusan')
            ->first();
        $data = PilihanKota::where('siswa_id', $siswa->id)->first();
        
        if (!$data) {
            $data = new PilihanKota(); // Jika data tidak ada, buat instance kosong
            $data->kota_id_1 = '';
            $data->kota_id_2 = '';
            $data->kota_id_3 = '';
        }

        // // Ambil jurusan siswa beserta kuota industrinya yang memiliki relasi dengan kota industri
        // $jurusan = Jurusan::with('kuotaIndustris.industri.kota')
        //     ->whereHas('kuotaIndustris')
        //     ->findOrFail($siswa->kelas->jurusan->id);
            // ->whereHas('kuotaIndustris', function ($query) use ($siswa) {
            //     $query->where('jenis_kelamin', $siswa->jenis_kelamin);
            // })

        // Cek jurusan yang tersedia: gunakan jurusan2 jika ada, jika tidak, gunakan jurusan
        $jurusanId = $siswa->kelas->jurusan2->id ?? $siswa->kelas->jurusan->id;

        // Ambil jurusan siswa beserta kuota industrinya yang memiliki relasi dengan kota industri
        // $jurusan = Jurusan::with('kuotaIndustris.industri.kota')
        //     ->whereHas('kuotaIndustris')
        //     ->findOrFail($jurusanId);

        // Ambil jurusan siswa beserta kuota industrinya yang sesuai jenis kelamin siswa
        $jurusan = Jurusan::with([
            'kuotaIndustris' => function ($query) use ($siswa) {
                $query->where('jenis_kelamin', $siswa->jenis_kelamin);
            },
            'kuotaIndustris.industri.kota'
        ])->whereHas('kuotaIndustris', function ($query) use ($siswa) {
            $query->where('jenis_kelamin', $siswa->jenis_kelamin);
        })->findOrFail($jurusanId);

        if($jurusan) {
            // Ambil ID kota yang terkait dengan kuotaIndustris.industri.kota
            $kotaIds = $jurusan->kuotaIndustris
                ->pluck('industri.kota.id') // Ambil ID kota secara langsung
                ->filter() // Hilangkan null values jika ada industri tanpa kota
                ->unique(); // Hilangkan ID kota yang duplikat

            // Ambil data kota berdasarkan ID yang diperoleh
            $kota = Kota::whereIn('id', $kotaIds)->get();
        } else {
            $kota = Kota::get();
        }

        // Pass data and kota to the view
        return view('pilihan_kota.buat', [
            'data' => $data,
            'siswa' => $siswa,
            'kota' => $kota
        ]);
    }

    public function membuat($siswa_id, Request $request)
    {
        $request->validate([
            'siswa_id' => 'required',
            'kota_id_1' => 'required|exists:kotas,id',
            'kota_id_2' => 'required|exists:kotas,id',
            'kota_id_3' => 'required|exists:kotas,id',
        ]);


        PilihanKota::where('siswa_id', $request->input('siswa_id'))
            ->delete();

        PilihanKota::updateOrCreate([
                'siswa_id' => $request->input('siswa_id'),
                'kota_id_1' => $request->input('kota_id_1'),
                'kota_id_2' => $request->input('kota_id_2'),
                'kota_id_3' => $request->input('kota_id_3'),
                'status' => $request->input('status'),
                'alasan' => $request->input('alasan'),
            ]
        );

        // Redirect back with success message
        return redirect('pilihankota-buat')->with('status', 'Data Pilihan Kota berhasil diperbarui!');
    }
}
