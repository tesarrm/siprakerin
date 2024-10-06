<?php

namespace App\Http\Controllers;

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
        $data = PelanggaranSiswa::with(['siswa.kelas.jurusan', 'siswa.penempatan.industri'])->get();

        return view('pelanggaran.index', [
            'data' => $data,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $siswa = Siswa::get();

        return view('pelanggaran.add', compact(['siswa']));
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
    public function edit($id, PelanggaranSiswa $pelanggaraSiswa)
    {
        $siswa = Siswa::get();
        $pelanggaran = PelanggaranSiswa::findOrFail($id);

        return view('pelanggaran.edit', [
            'data' => $pelanggaran,
            'siswa' => $siswa
        ]);
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
