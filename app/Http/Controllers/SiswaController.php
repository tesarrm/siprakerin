<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\Ortu;
use App\Models\OrtuSiswa;
use App\Models\Pengaturan;
use App\Models\Siswa;
use App\Models\TemporaryFile;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class SiswaController extends Controller
{
    protected $model;
    public function __construct(Siswa $a)
    {
        $this->model = $a;

        $this->middleware('can:c_siswa')->only(['create', 'store']);
        $this->middleware('can:r_siswa')->only(['index', 'show']);
        $this->middleware('can:u_siswa')->only(['edit', 'update']);
        $this->middleware('can:d_siswa')->only('destroy');
    }

    public function index()
    {
        $data = $this->model->with(['kelas', 'user'])->where('aktif', 1)->get();
        $pengaturan = Pengaturan::first();

        return view('siswa.index', [
            'data' => $data,
            'pengaturan' => $pengaturan
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $kelas = Kelas::with('jurusan.bidangKeahlian')->get();

        return view('siswa.add', [
            'kelas' => $kelas,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi input
        $validatedData = $request->validate([
            'kelas_id' => 'required|string',
            'aktif' => 'nullable|string',
            'gambar' => 'nullable|string',
            'nis' => 'required|unique:siswas,nis',
            'nisn' => 'nullable|string',
            'nama_lengkap' => 'nullable|string',
            'nama' => 'required|string|max:255',
            'tempat_lahir' => 'nullable|string',
            'tanggal_lahir' => 'nullable|string',
            'jenis_kelamin' => 'required',
            'agama' => 'nullable|string',
            'alamat' => 'nullable|string',
            'no_telp' => 'nullable|string',
            'email' => 'required|string|unique:users,email|max:255',
            'password' => 'required',
        ]);


        // buat data user
        $user = User::create([
            'name' => $validatedData['nama'], 
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']), 
        ]);

        // assign role
        $user->assignRole('siswa');

        // colect data sesaui dengan fillable
        $create = collect($validatedData);

        // kondisi cek gambar
        if (!empty($validatedData['gambar'])) {
            $tmp_file = TemporaryFile::where('folder', $validatedData['gambar'])->first();

            if ($tmp_file) {
                Storage::copy('posts/tmp/' . $tmp_file->folder . '/'.$tmp_file->file, 'posts/' . $tmp_file->folder . '/' . $tmp_file->file);

                $create->put('gambar', $tmp_file->folder . '/' . $tmp_file->file);

                Storage::deleteDirectory('posts/tmp/' . $tmp_file->folder);
                $tmp_file->delete();
            }
        } else {
            $create->put('gambar', null); // atau $create->forget('gambar');
        }

        // create siswa 
        $create->put('user_id', $user->id);
        Siswa::create($create->toArray());

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
        $ortu = Ortu::with(['siswas', 'user'])->get();

        // $siswa_ortu = Siswa::whereIn('id', $siswa->id)->with(['ortus.user'])->get();
        $siswa_ortu = Siswa::with('ortus.user')->findOrFail($siswa->id);

        return view('siswa.edit', [
            'data' => $siswa,
            'kelas' => $kelas,
            'ortu' => $ortu,
            'siswa_ortu' => $siswa_ortu,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($id, Request $request)
    {
        $data = Siswa::findOrFail($id);

        // Validasi input
        $validatedData = $request->validate([
            'data.*.ortu_id' => 'required|string',
            'kelas_id' => 'required|string',
            'aktif' => 'nullable|string',
            'gambar' => 'nullable|string',
            'nis' => 'required|unique:siswas,nis,' . $id,
            'nisn' => 'nullable|string',
            'nama_lengkap' => 'nullable|string',
            'nama' => 'required|string|max:255',
            'tempat_lahir' => 'nullable|string',
            'tanggal_lahir' => 'nullable|string',
            'jenis_kelamin' => 'required',
            'agama' => 'nullable|string',
            'alamat' => 'nullable|string',
            'no_telp' => 'nullable|string',
        ]);

        // $update = collect($validatedData);
        $update = collect($validatedData)->except('data');

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

        if(isset($validatedData['data'])) {
            OrtuSiswa::where('siswa_id', $id)
                        ->delete();
            foreach ($validatedData['data'] as $item) {
                OrtuSiswa::updateOrCreate([
                        'siswa_id' => $id,
                        'ortu_id' => $item['ortu_id'],
                    ],
                );
            }
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

    public function resetPassword($user_id)
    {
        $user = User::find($user_id);

        if ($user) {
            $user->password = Hash::make('password');
            $user->save();

            return response()->json(['success' => true]);
        } else {
            return response()->json(['success' => false]);
        }
    }

    public function nonaktif($id){
        $data = $this->model->find($id);

        if ($data) {
            $data->aktif = 0;
            $data->save();

            return response()->json(['success' => true]);
        } else {
            return response()->json(['success' => false]);
        }
    }

    public function aktif($id){
        $data = $this->model->find($id);

        if ($data) {
            $data->aktif = 1;
            $data->save();

            return response()->json(['success' => true]);
        } else {
            return response()->json(['success' => false]);
        }
    }

}
