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
                ->get();
        } else if(auth()->user()->hasRole('siswa')) {
            $siswa = Siswa::where('user_id', auth()->user()->id)
                ->first();

            // Filter pelanggaran siswa yang hanya terjadi pada siswa di kelas tersebut
            $data = PelanggaranSiswa::where('siswa_id', $siswa->id)
                ->with(['siswa.kelas.jurusan', 'siswa.penempatan.industri'])
                ->get();
        } else {
            $data = PelanggaranSiswa::with(['siswa.kelas.jurusan', 'siswa.penempatan.industri'])->get();
        }

        return view('pelanggaran.index', [
            'data' => $data,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $siswa = Siswa::with('kelas')->orderBy('nama', 'asc')->get();
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

    /**
     * Show the form for editing the specified resource.
     */
    // public function edit($id, PelanggaranSiswa $pelanggaraSiswa)
    // {
    //     $siswa = Siswa::get();
    //     $pelanggaran = PelanggaranSiswa::findOrFail($id);

    //     return view('pelanggaran.edit', [
    //         'data' => $pelanggaran,
    //         'siswa' => $siswa
    //     ]);
    // }

public function edit($id)
{
    $data = PelanggaranSiswa::with('siswa.kelas')->findOrFail($id); // Ambil data pelanggaran dan relasinya
    $kelas = Kelas::with('jurusan')->get(); // Semua kelas
    $siswa = Siswa::with('kelas')->orderBy('nama', 'asc')->get();   // Semua siswa

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
