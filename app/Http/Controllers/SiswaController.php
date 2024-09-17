<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\Siswa;
use App\Models\TemporaryFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SiswaController extends Controller
{
    protected $model;
    public function __construct(Siswa $a)
    {
        $this->model = $a;
    }

    public function index()
    {
        $data = $this->model->with('kelas')->get();

        return view('siswa.index', [
            'data' => $data
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $kelas = Kelas::get();

        return view('siswa.add', [
            'kelas' => $kelas
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi input
        $validatedData = $request->validate([
            'gambar' => 'nullable|string',
            'nis' => 'required|unique:siswas,nis',
            'nama' => 'required|string|max:255',
            'jenis_kelamin' => 'required',
            'kelas_id' => 'required',
            'username' => 'required|string|unique:siswas,username|max:255',
            'password' => 'required',
        ]);

        $create = collect($validatedData);

        // Jika ada gambar, proses seperti biasa
        if (!empty($validatedData['gambar'])) {
            $tmp_file = TemporaryFile::where('folder', $validatedData['gambar'])->first();

            if ($tmp_file) {
                Storage::copy('posts/tmp/' . $tmp_file->folder . '/'.$tmp_file->file, 'posts/' . $tmp_file->folder . '/' . $tmp_file->file);

                $create->put('gambar', $tmp_file->folder . '/' . $tmp_file->file);

                Storage::deleteDirectory('posts/tmp/' . $tmp_file->folder);
                $tmp_file->delete();
            }
        } else {
            // Jika tidak ada gambar, Anda bisa menetapkan nilai default atau membiarkan gambar kosong
            $create->put('gambar', null); // atau $create->forget('gambar');
        }

        $this->model->create($create->toArray());

        return redirect('siswa')->with('status', 'Data berhasil ditambah!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Siswa $siswa)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Siswa $siswa)
    {
        $kelas = Kelas::get();

        return view('siswa.edit', [
            'data' => $siswa,
            'kelas' => $kelas
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($id, Request $request)
    {
        $data = $this->model->findOrFail($id);

        // Validasi input
        $validatedData = $request->validate([
            'gambar' => 'nullable|string',
            'nis' => 'required|unique:siswas,nis,' . $id,
            'nama' => 'required|string|max:255',
            'jenis_kelamin' => 'required',
            'kelas_id' => 'required',
            'username' => 'required|string|unique:siswas,username,' . $id,
            'password' => 'required',
        ]);

        $update = collect($validatedData);

        // Cek apakah ada gambar baru
        if (!empty($validatedData['gambar'])) {
            // Proses gambar baru
            $tmp_file = TemporaryFile::where('folder', $validatedData['gambar'])->first();

            if ($tmp_file) {
                // Hapus gambar lama jika ada
                if ($data->gambar) {
                    Storage::delete('posts/' . $data->gambar);
                }

                // Pindahkan gambar baru ke direktori final
                Storage::copy('posts/tmp/' . $tmp_file->folder . '/' . $tmp_file->file, 'posts/' . $tmp_file->folder . '/' . $tmp_file->file);

                // Update path gambar di database
                $update->put('gambar', $tmp_file->folder . '/' . $tmp_file->file);

                // Hapus temporary file dan direktori
                Storage::deleteDirectory('posts/tmp/' . $tmp_file->folder);
                $tmp_file->delete();
            }
        } else {
            // Jika tidak ada gambar baru, set gambar menjadi null
            if ($data->gambar) {
                Storage::delete('posts/' . $data->gambar); // Hapus gambar lama
            }
            $update->put('gambar', null);
        }

        $data->update($update->toArray());

        return redirect('siswa')->with('status', 'Data berhasil diubah!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $data = $this->model->findOrFail($id);

        // Hapus gambar dan foldernya dari storage
        if ($data->gambar) {
            $folderPath = 'posts/' . dirname($data->gambar);
            Storage::deleteDirectory($folderPath);
        }
        $data->delete();

        return response()->json(['success' => true]);
    }

    public function deleteMultiple(Request $request)
    {
        $ids = $request->input('ids');

        // Ambil semua data guru berdasarkan ID yang dipilih
        $datas = $this->model->whereIn('id', $ids)->get();

        foreach ($datas as $data) {
            // Hapus gambar dan foldernya dari storage
            if ($data->gambar) {
                $folderPath = 'posts/' . dirname($data->gambar);
                Storage::deleteDirectory($folderPath);
            }

            // Hapus datadata 
            $data->delete();
        }

        return response()->json(['success' => true]);
    }
}
