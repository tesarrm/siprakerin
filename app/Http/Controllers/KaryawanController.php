<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use App\Models\TemporaryFile;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class KaryawanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data= Karyawan::with(['user.roles'])
            ->where('aktif', 1)
            ->join('users', 'karyawans.user_id', '=', 'users.id') // Menyambungkan dengan tabel users
            ->orderBy('users.name', 'asc') // Mengurutkan berdasarkan nama di tabel users
            ->select('karyawans.*') // Memilih kolom dari tabel gurus agar tidak terjadi duplikasi
            ->paginate(100);

        return view('karyawan.index', [
            'data' => $data,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('karyawan.add');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
       $validatedData = $request->validate([
            'aktif' => 'nullable|string',
            'gambar' => 'nullable|string',
            'nama' => 'required|string|max:255',
            'tempat_lahir' => 'nullable|string',
            'tanggal_lahir' => 'nullable|string',
            'jenis_kelamin' => 'required',
            'alamat' => 'nullable|string',
            'no_telp' => 'nullable|string',
            'no_hp' => 'nullable|string',
            'agama' => 'nullable|string',

            'email' => 'required|string|unique:users,email|max:255',
            'password' => 'required',
        ]);

        // Create user data
        $userData = [
            'name' => $validatedData['nama'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
        ];

        // kondisi cek gambar
        if (!empty($validatedData['gambar'])) {
            $tmp_file = TemporaryFile::where('folder', $validatedData['gambar'])->first();

            if ($tmp_file) {
                Storage::copy('posts/tmp/' . $tmp_file->folder . '/'.$tmp_file->file, 'posts/' . $tmp_file->folder . '/' . $tmp_file->file);

                $userData['gambar'] = $tmp_file->folder . '/' . $tmp_file->file;

                Storage::deleteDirectory('posts/tmp/' . $tmp_file->folder);
                $tmp_file->delete();
            }
        } else {
            $userData['gambar'] = null;
        }

        // Create user
        $user = User::create($userData);
        
        // Assign role
        $user->assignRole('karyawan');

        // create 
        $karyawanData = collect($validatedData)->except(['gambar', 'email', 'password'])->toArray();
        $karyawanData['user_id'] = $user->id;
        Karyawan::create($karyawanData);

        return redirect('karyawan')->with('status', 'Data berhasil ditambah!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Karyawan $karyawan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Karyawan $karyawan)
    {
        return view('karyawan.edit', [
            'data' => $karyawan
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($id, Request $request)
    {
        $data = Karyawan::with('user')->findOrFail($id);
        $user = $data->user;

        $validatedData = $request->validate([
            'aktif' => 'nullable|string',
            'gambar' => 'nullable|string',
            'nama' => 'required|string|max:255',
            'tempat_lahir' => 'nullable|string',
            'tanggal_lahir' => 'nullable|string',
            'jenis_kelamin' => 'required',
            'alamat' => 'nullable|string',
            'agama' => 'nullable|string',
        ]);

        // $update = collect($validatedData);
        $karyawanData = collect($validatedData)->except(['gambar'])->toArray();

        // Cek apakah ada gambar baru
        if (!empty($validatedData['gambar'])) {
            $tmp_file = TemporaryFile::where('folder', $validatedData['gambar'])->first();

            if ($tmp_file) {
                // Hapus gambar lama dari user jika ada
                if ($user->gambar) {
                    Storage::delete('posts/' . $user->gambar);
                }

                // Pindahkan gambar baru ke direktori final
                $path = 'posts/' . $tmp_file->folder . '/' . $tmp_file->file;
                Storage::copy('posts/tmp/' . $tmp_file->folder . '/' . $tmp_file->file, $path);

                // Update gambar pada user
                $user->gambar = $tmp_file->folder . '/' . $tmp_file->file;
                $user->save();

                // Hapus temporary file dan direktori
                Storage::deleteDirectory('posts/tmp/' . $tmp_file->folder);
                $tmp_file->delete();
            }
        } else {
            // Jika tidak ada gambar baru, hapus gambar lama jika ada
            if ($user->gambar) {
                Storage::delete('posts/' . $user->gambar);
                $user->gambar = null;
                $user->save();
            }
        }

        $user->name = $validatedData['nama'];
        $user->save();

        // Update data guru
        $data->update($karyawanData);

        return redirect('karyawan')->with('status', 'Data berhasil diubah!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $data = Karyawan::findOrFail($id);

        // Hapus gambar dan foldernya dari storage
        if ($data->user->gambar) {
            $folderPath = 'posts/' . dirname($data->user->gambar);
            Storage::deleteDirectory($folderPath);
        }
        $data->delete();

        // return redirect('guru')->with('status', 'Data berhasil dihapus!');
        return response()->json(['success' => true]);
    }

    public function resetPassword($id)
    {
        $user = User::find($id);

        if ($user) {
            $user->password = Hash::make('password');
            $user->save();

            return response()->json(['success' => true]);
        } else {
            return response()->json(['success' => false]);
        }
    }

    public function nonaktif($id){
        $data = Karyawan::find($id);

        if ($data) {
            $data->aktif = 0;
            $data->save();

            return response()->json(['success' => true]);
        } else {
            return response()->json(['success' => false]);
        }
    }

    public function deleteMultiple(Request $request)
    {
        $ids = $request->input('ids');

        // Ambil semua data guru berdasarkan ID yang dipilih
        $datas = Karyawan::whereIn('id', $ids)->get();

        foreach ($datas as $data) {
            // Hapus gambar dan foldernya dari storage
            if ($data->user->gambar) {
                $folderPath = 'posts/' . dirname($data->user->gambar);
                Storage::deleteDirectory($folderPath);
            }

            // Hapus datadata 
            $data->delete();
        }

        return response()->json(['success' => true]);
    }
}
