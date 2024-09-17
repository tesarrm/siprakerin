<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\Jurusan;
use App\Models\Kelas;
use App\Models\Pengaturan;
use Illuminate\Http\Request;

class KelasController extends Controller
{
    protected $model;
    public function __construct(Kelas $a)
    {
        $this->model = $a;
    }

    public function index()
    {
        $data = $this->model->with(['jurusan', 'guru'])->get();

        return view('kelas.index', [
            'data' => $data
        ]);
    }

    public function create()
    {
        $jurusan = Jurusan::get();
        $guru = Jurusan::get();
        $pengaturan = Pengaturan::first();

        return view('kelas.add', [
            'jurusan' => $jurusan,
            'guru' => $guru,
            'pengaturan' => $pengaturan
        ]);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama' => 'required|string',
            'tahun_ajaran' => 'required|string',
            'jurusan_id' => 'required',
            'klasifikasi' => 'required|string',
            'guru_id' => 'required',
        ]);

        $create = collect($validatedData);

        $this->model->create($create->toArray());

        return redirect('kelas')->with('status', 'Data berhasil ditambah!');
    }

    public function edit($id)
    {

        $kelas = Kelas::findOrFail($id);
        $jurusan = Jurusan::get();
        $guru = Guru::get();
        $pengaturan = Pengaturan::first();

        return view('kelas.edit', [
            'data' => $kelas,
            'jurusan' => $jurusan,
            'guru' => $guru,
            'pengaturan' => $pengaturan
        ]);
    }

    public function update($id, Request $request)
    {
        $data = $this->model->findOrFail($id);

        $validatedData = $request->validate([
            'nama' => 'required|string',
            'tahun_ajaran' => 'required|string',
            'jurusan_id' => 'required',
            'klasifikasi' => 'required|string',
            'guru_id' => 'required',
        ]);

        $update = collect($validatedData);

        $data->update($update->toArray());

        return redirect('kelas')->with('status', 'Data berhasil ditambah!');
    }

    public function destroy($id)
    {
        $data = $this->model->findOrFail($id);
        $data->delete();
        return response()->json(['success' => true]);
    }
}
