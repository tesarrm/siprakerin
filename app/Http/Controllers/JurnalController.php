<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\Jurnal;
use App\Models\Kelas;
use App\Models\Siswa;
use Illuminate\Http\Request;

class JurnalController extends Controller
{
    protected $model;
    public function __construct(Jurnal $a)
    {
        $this->model = $a;

        $this->middleware('can:c_jurnal')->only(['create', 'store']);
        $this->middleware('can:r_jurnal')->only(['index', 'show']);
        $this->middleware('can:u_jurnal')->only(['edit', 'update']);
        $this->middleware('can:d_jurnal')->only('destroy');
    }

    public function index()
    {
        if(auth()->user()->hasRole('wali_siswa')){
            $guru = Guru::where('user_id', auth()->user()->id)->first();
            $kelas = Kelas::where('guru_id', $guru->id)->first();

            // Filter jurnal berdasarkan kelas
            $data = Jurnal::whereHas('siswa.kelas', function ($query) use ($kelas) {
                $query->where('kelas.id', $kelas->id);
            })->with('siswa.kelas')->get();
        } else if(auth()->user()->hasRole('siswa')) {
            $siswa = Siswa::where('user_id', auth()->user()->id)->first();
            $siswa_id = $siswa->id;

            $data = Jurnal::with('siswa.kelas')->where('siswa_id', $siswa_id)->get();
        } else {
            $data = Jurnal::with('siswa.kelas')->get();
        }

        return view('jurnal.index', [
            'data' => $data
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('jurnal.add');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'tanggal' => 'required|string',
            'time_start' => 'required|string',
            'time_end' => 'required|string',
            'kegiatan' => 'required',
            'keterangan' => 'required',
        ]);

        $siswa= Siswa::where('user_id', auth()->user()->id)->first();
        $siswa_id = $siswa->id;

        $create = collect($validatedData);
        $create->put('tanggal_waktu', $validatedData['tanggal'] . " " . $validatedData['time_start'] . " - " . $validatedData['time_end']);
        $create->put('siswa_id', $siswa_id);
        $this->model->create($create->toArray());

        return redirect('jurnal')->with('status', 'Data berhasil ditambah!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Jurnal $jurnal)
    {

        return view('jurusan.edit', [
            'data' => $jurnal,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */

public function edit($id)
{
    // Ambil data berdasarkan ID
    $data = $this->model->findOrFail($id);

    // Misalkan 'tanggal_waktu' adalah field yang menyimpan data dalam format "14 September 2024 08:11 - 08:11"
    $tanggalWaktu = $data->tanggal_waktu;

    // Pisahkan tanggal dan waktu
    $parts = explode(' ', $tanggalWaktu);

    // Misalkan format yang benar adalah "14 September 2024 08:11 - 08:11"
    $tanggal = implode(' ', array_slice($parts, 0, 3)); // Mengambil "14 September 2024"
    $timeStart = $parts[3]; // Mengambil "08:11"
    $timeEnd = explode(' - ', $parts[5])[0]; // Mengambil "08:11"

    // Siapkan data untuk dikirim ke view
    $data = [
        'id' => $data->id,
        'tanggal' => $tanggal,
        'time_start' => $timeStart,
        'time_end' => $timeEnd,
        'kegiatan' => $data->kegiatan,
        'keterangan' => $data->keterangan,
    ];

    return view('jurnal.edit', [
        'data' => $data,
    ]);
}

    /**
     * Update the specified resource in storage.
     */
    public function update($id, Request $request)
    {
        $data = $this->model->findOrFail($id);

        $validatedData = $request->validate([
            // 'siswa_id' => 'required',
            'tanggal' => 'required|string',
            'time_start' => 'required|string',
            'time_end' => 'required|string',
            'kegiatan' => 'required',
            'keterangan' => 'required',
        ]);

        $siswa = Siswa::where('user_id', auth()->user()->id)->first();
        $siswa_id = $siswa->id;

        $update = collect($validatedData);
        $update->put('tanggal_waktu', $validatedData['tanggal'] . " " . $validatedData['time_start'] . " - " . $validatedData['time_end']);
        $update->put('siswa_id', $siswa_id);
        $data->update($update->toArray());

        return redirect('jurnal')->with('status', 'Data berhasil ditambah!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $data = $this->model->findOrFail($id);
        $data->delete();
        return response()->json(['success' => true]);
    }
}
