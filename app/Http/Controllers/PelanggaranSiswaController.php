<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\Kelas;
use App\Models\PelanggaranSiswa;
use App\Models\Siswa;
use Illuminate\Http\Request;

class PelanggaranSiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if(auth()->user()->hasRole('wali_kelas')) {
            $guru = Guru::where('user_id', auth()->user()->id)
                ->with('hoKelas')  // Ambil kelas yang berelasi dengan guru
                ->first();

            // Ambil ID kelas yang berelasi dengan guru
            $kelasId = $guru->hoKelas->id;

            // Filter pelanggaran siswa yang hanya terjadi pada siswa di kelas tersebut
            $data = PelanggaranSiswa::whereHas('siswa.kelas', function ($query) use ($kelasId) {
                    $query->where('id', $kelasId);
                })
                ->with(['siswa.kelas.jurusan', 'siswa.penempatan.industri'])
                ->orderBy('created_at', 'desc')
                ->get();
        } else if(auth()->user()->hasRole('siswa')) {
            $siswa = Siswa::where('user_id', auth()->user()->id)
                ->first();

            // Filter pelanggaran siswa yang hanya terjadi pada siswa di kelas tersebut
            $data = PelanggaranSiswa::where('siswa_id', $siswa->id)
                ->with(['siswa.kelas.jurusan', 'siswa.penempatan.industri'])
                ->orderBy('created_at', 'desc')
                ->get();
        } else {
            $data = PelanggaranSiswa::with(['siswa.kelas.jurusan', 'siswa.penempatan.industri'])
                ->orderBy('created_at', 'desc')
                ->get();
        }
        $kelas = Kelas::where('aktif', 1)->get();

        return view('pelanggaran.index', [
            'data' => $data,
            'kelas' => $kelas,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $siswa = Siswa::with(['kelas', 'user'])
            ->join('users', 'siswas.user_id', '=', 'users.id') // Menyambungkan dengan tabel users
            ->orderBy('users.name', 'asc') // Mengurutkan berdasarkan nama di tabel users
            ->select('siswas.*') // Memilih kolom dari tabel gurus agar tidak terjadi duplikasi
            ->get();
        $kelas = Kelas::get();

        return view('pelanggaran.add', compact([
            'siswa',
            'kelas',
        ]));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'siswa_id' => 'required|string',
            'tanggal' => 'required|string',
            'pelanggaran' => 'required|string',
            'solusi' => 'nullable|string',
        ]);

        $create = collect($validatedData);

        PelanggaranSiswa::create($create->toArray());

        return redirect('pelanggaran')->with('status', 'Data berhasil ditambah!');
    }

    /**
     * Display the specified resource.
     */
    public function show(PelanggaranSiswa $pelanggaranSiswa)
    {
        //
    }


    public function edit($id)
    {
        $data = PelanggaranSiswa::with('siswa.kelas')
            ->findOrFail($id); 
        $kelas = Kelas::with('jurusan')
            ->get(); 
        $siswa = Siswa::with('kelas')
            ->orderBy('nama', 'asc')
            ->get();   

        return view('pelanggaran.edit', compact('data', 'kelas', 'siswa'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update($id, Request $request)
    {
        $data = PelanggaranSiswa::findOrFail($id);

        $validatedData = $request->validate([
            'siswa_id' => 'required|string',
            'tanggal' => 'required|string',
            'pelanggaran' => 'required|string',
            'solusi' => 'nullable|string',
        ]);

        $update = collect($validatedData);

        $data->update($update->toArray());

        return redirect('pelanggaran')->with('status', 'Data berhasil ditambah!');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $data = PelanggaranSiswa::findOrFail($id);
        $data->delete();
        return response()->json(['success' => true]);
    }
}
