<?php

namespace App\Http\Controllers;

use App\Models\BiodataSiswa;
use App\Models\Guru;
use App\Models\Industri;
use App\Models\Kelas;
use App\Models\Kota;
use App\Models\Siswa;
use App\Models\TemporaryFile;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    // Menampilkan semua data User
    // public function index()
    // {
    //     $data = User::all();
    //     return view('user.index', compact('data'));
    // }

    public function index()
    {
        // $data = User::all()->map(function ($user) {
        //     // Cek apakah user memiliki role, jika tidak, isi dengan "-"
        //     $user->peran = $user->roles->isNotEmpty() 
        //         ? $user->roles->pluck('name')->implode(', ') 
        //         : '-';
        //     return $user;
        // });

        $data = User::paginate(250)->through(function ($user) {
            // Cek apakah user memiliki role, jika tidak, isi dengan "-"
            $user->peran = $user->roles->isNotEmpty() 
                ? $user->roles->pluck('name')->implode(', ') 
                : '-';
            return $user;
        });

        return view('user.index', compact('data'));
    }

    // Menampilkan form untuk membuat user baru
    public function create()
    {
        return view('user.add');
    }

    // Menyimpan user baru
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);
        // dd($request);

        User::create([
            'name' => $validatedData['nama'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
        ]);

        return redirect()->route('user.index')->with('success', 'User created successfully.');
    }

    // Menampilkan form untuk mengedit user
    public function edit($id)
    {
        $data = User::findOrFail($id);
        return view('user.edit', compact('data'));
    }

    // Memperbarui data user
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validatedData = $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $user->update([
            'name' => $validatedData['nama'],
            'email' => $validatedData['email'],
            'password' => $request->password ? Hash::make($request->password) : $user->password,
        ]);

        return redirect()->route('user.index')->with('success', 'User updated successfully.');
    }

    public function destroy($id)
    {
        $data = User::findOrFail($id);
        $data->delete();
        return response()->json(['success' => true]);
    }

    public function editProfile()
    {
        $siswa = Siswa::where('user_id', auth()->user()->id)->with(['kelas', 'user'])->first();
        $kelas = Kelas::with('jurusan.bidangKeahlian')->get();
        $biodata = BiodataSiswa::with('siswa')->where('siswa_id', $siswa->id)->first();

        return view('user.profile', [
            'siswa' => $siswa,
            'kelas' => $kelas,
            'data' => $biodata,
        ]);

    }

    public function updateProfile(Request $request)
    {
        $siswa = Siswa::where('user_id', auth()->user()->id)->first();
        $siswa_id = $siswa->id;

        BiodataSiswa::where('siswa_id', $siswa_id)
            ->delete();

        $update = collect($request);
        $update->put('siswa_id', $siswa_id);
        $update->forget('_token');
        $update->forget('gambar');
        $update->forget('pas_foto');
        $update->forget('nama_lengkap');
        $update->forget('nama');
        $update->forget('nis');
        $update->forget('nisn');
        $update->forget('tempat_lahir');
        $update->forget('tanggal_lahir');
        $update->forget('agama');
        $update->forget('alamat');
        $update->forget('no_telp');
        $update->forget('jenis_kelamin');


        BiodataSiswa::updateOrCreate($update->toArray());

        // ======================

        $update2 = collect($request)->except([
            'siswa_id',
            'kode_pos',
            'golongan_darah',
            'tinggi_badan',
            'hobi',
            'keahlian',
            'organisasi',
            'tahun_awal_1',
            'tahun_akhir_1',
            'tempat_1',
            'berijasah_1',
            'tahun_awal_2',
            'tahun_akhir_2',
            'tempat_2',
            'berijasah_2',
            'tahun_awal_3',
            'tahun_akhir_3',
            'tempat_3',
            'berijasah_3',
            'ayah_nama',
            'ibu_nama',
            'ayah_usia',
            'ibu_usia',
            'ayah_pendidikan_terakhir',
            'ibu_pendidikan_terakhir',
            'ayah_pekerjaan',
            'ibu_pekerjaan',
            'ayah_alamat',
            'ibu_alamat',
            'ayah_no_telp',
            'ibu_no_telp',
            'nama_0',
            'alamat_0',
            'no_telp_0',
            'hub_keluarga_0',
            'nama_1',
            'alamat_1',
            'no_telp_1',
            'hub_keluarga_1',
            'nama_2',
            'alamat_2',
            'no_telp_2',
            'hub_keluarga_2',
            'penyakit',
        ]);

        // Cek apakah ada gambar baru
        if (!empty($request->gambar)) {
            // Proses gambar baru
            $tmp_file = TemporaryFile::where('folder', $request->gambar)->first();

            if ($tmp_file) {
                // Hapus gambar lama jika ada
                if ($siswa->gambar) {
                    Storage::delete('posts/' . $siswa->gambar);
                }

                // Pindahkan gambar baru ke direktori final
                Storage::copy('posts/tmp/' . $tmp_file->folder . '/' . $tmp_file->file, 'posts/' . $tmp_file->folder . '/' . $tmp_file->file);

                // Update path gambar di database
                $update2->put('gambar', $tmp_file->folder . '/' . $tmp_file->file);

                // Hapus temporary file dan direktori
                Storage::deleteDirectory('posts/tmp/' . $tmp_file->folder);
                $tmp_file->delete();
            }
        } else {
            // Jika tidak ada gambar baru, set gambar menjadi null
            if ($siswa->gambar) {
                Storage::delete('posts/' . $siswa->gambar); // Hapus gambar lama
            }
            $update2->put('gambar', null);
        }

        // Cek apakah ada gambar baru
        if (!empty($request->pas_foto)) {
            // Proses gambar baru
            $tmp_file = TemporaryFile::where('folder', $request->pas_foto)->first();

            if ($tmp_file) {
                // Hapus gambar lama jika ada
                if ($siswa->pas_foto) {
                    Storage::delete('posts/' . $siswa->pas_foto);
                }

                // Pindahkan gambar baru ke direktori final
                Storage::copy('posts/tmp/' . $tmp_file->folder . '/' . $tmp_file->file, 'posts/' . $tmp_file->folder . '/' . $tmp_file->file);

                // Update path gambar di database
                $update2->put('pas_foto', $tmp_file->folder . '/' . $tmp_file->file);

                // Hapus temporary file dan direktori
                Storage::deleteDirectory('posts/tmp/' . $tmp_file->folder);
                $tmp_file->delete();
            }
        } else {
            // Jika tidak ada gambar baru, set gambar menjadi null
            if ($siswa->pas_foto) {
                Storage::delete('posts/' . $siswa->pas_foto); // Hapus gambar lama
            }
            $update2->put('pas_foto', null);
        }

        $siswa->update($update2->toArray());

        return redirect('profile')->with('status', 'Data berhasil ditambah!');
    }

    public function role($id, Request $request)
    {
        $user = User::findOrFail($id);

        $roles = [];

        if ($request->admin) {
            $roles[] = 'admin';
        }
        if ($request->pembimbing) {
            $roles[] = 'pembimbing';
        }
        if ($request->guru) {
            $roles[] = 'guru';
        }
        if ($request->koordinator) {
            $roles[] = 'koordinator';
        }
        if ($request->wali_kelas) {
            $roles[] = 'wali_kelas';
        }
        if ($request->siswa) {
            $roles[] = 'siswa';
        }

        $user->syncRoles($roles);

        return redirect('user')->with('status', 'Data berhasil diperbarui!');
    }

    // public function guruIndustriIndex()
    // {
    //     $data = Guru::where('aktif', 1)->with('industris')->get();
    //     $industri = Industri::where('aktif', 1)->get();

    //     return view('user.index_gi', compact('data', 'industri'));
    // }

// public function guruIndustriIndex()
// {
//     // Ambil data guru beserta industri yang terhubung
//     $data = Guru::where('aktif', 1)
//                 ->with(['industris', 'user'])
//                 ->get()
//                 ->map(function ($guru) {
//                     // Gabungkan ID industri menjadi satu string yang dipisahkan koma dan spasi
//                     $guru->industri = $guru->industris->pluck('id')->implode(', ');
//                     return $guru;
//                 });
                
//     $industri = Industri::where('aktif', 1)->get();

//     // dd($data);

//     return view('user.index_gi', compact('data', 'industri'));
// }

public function guruIndustriIndex()
{
    // Ambil data guru yang user-nya memiliki role 'pembimbing' dan industri yang terhubung
    $data = Guru::where('aktif', 1)
                ->whereHas('user', function($query) {
                    $query->role('pembimbing'); // Filter berdasarkan role 'pembimbing'
                })
                ->with(['industris', 'user'])
                ->get()
                ->map(function ($guru) {
                    // Gabungkan ID industri menjadi satu string yang dipisahkan koma dan spasi
                    $guru->industri = $guru->industris->pluck('id')->implode(', ');
                    return $guru;
                });

    $industri = Industri::where('aktif', 1)
        ->orderBy('nama', 'asc')
        ->whereHas('penempatanIndustri')
        ->get();

    return view('user.index_gi', compact('data', 'industri'));
}


    public function storeGuruIndustri(Request $request, $guruId)
    {
        $validated = $request->validate([
            'industri_id' => 'required|array|min:1',
            'industri_id.*' => 'required|exists:industris,id',
        ]);

        $guru = Guru::findOrFail($guruId);

        // Sinkronisasi industri ke guru (jika ada relasi many-to-many)
        $guru->industris()->sync($validated['industri_id']); 

        return redirect('guruindustri')->with('success', 'Industri berhasil ditambahkan!');
    }

    public function editPengaturanAkun()
    {
        if(auth()->user()->hasRole('admin')){
            $user = User::
                findOrFail(auth()->user()->id);
            return view('user.pengaturan_akun', compact(
                'user',
            ));
        } else if(auth()->user()->hasRole('siswa')){
            $siswa = Siswa::
                where('user_id', auth()->user()->id)
                ->with(['kelas.jurusan', 'user'])
                ->first();

            return view('user.pengaturan_akun', compact(
                'siswa',
            ));
        } else if(auth()->user()->hasRole('guru')){
            $guru = Guru::
                where('user_id', auth()->user()->id)
                ->with(['user'])
                ->first();

            return view('user.pengaturan_akun', compact(
                'guru',
            ));
        }
    }

    public function updatePengaturanAkun(Request $request)
    {
        if(auth()->user()->hasRole('admin')){
            $user = User::findOrFail(auth()->user()->id);

            $validatedData = $request->validate([
                'gambar' => 'nullable|string',
                'nama' => 'required|string|max:255',
            ]);

            // Cek apakah ada gambar baru
            if (!empty($validatedData['gambar'])) {
                $tmp_file = TemporaryFile::
                    where('folder', $validatedData['gambar'])
                    ->first();

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

            // update user
            $user->name = $validatedData['nama'];
            $user->save();

            return redirect()->back()->with('success', 'Data berhasil diubah!');
        } else if(auth()->user()->hasRole('guru')){
            $user = User::findOrFail(auth()->user()->id);
            $guru = Guru::with('user')
                ->where('user_id', auth()->user()->id)
                ->first();

            $validatedData = $request->validate([
                'gambar' => 'nullable|string',
                'nip' => 'required|unique:gurus,nip,' . $guru->id,
                'no_ktp' => 'nullable|string',
                'nama' => 'required|string|max:255',
                'tempat_lahir' => 'nullable|string',
                'tanggal_lahir' => 'nullable|string',
                'golongan_darah' => 'nullable|string',
                'kecamatan' => 'nullable|string',
                'alamat' => 'nullable|string',
                'rt' => 'nullable|string',
                'rw' => 'nullable|string',
                'kode_pos' => 'nullable|string',
                'no_telp' => 'nullable|string',
                'no_hp' => 'nullable|string',
                'agama' => 'nullable|string',
            ]);

            $guruData = collect($validatedData)
                ->except(['gambar'])->toArray();

            // Cek apakah ada gambar baru
            if (!empty($validatedData['gambar'])) {
                $tmp_file = TemporaryFile::
                    where('folder', $validatedData['gambar'])
                    ->first();

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

            // update user
            $guru->update($guruData);

            return redirect()->back()->with('success', 'Data berhasil diubah!');
        } else if(auth()->user()->hasRole('siswa')){
            $user = User::findOrFail(auth()->user()->id);
            $siswa = Siswa::with('user')
                ->where('user_id', auth()->user()->id)
                ->first();

            // Validasi input
            $validatedData = $request->validate([
                'gambar' => 'nullable|string',
                'nis' => 'required|unique:siswas,nis,' . $siswa->id,
                'nisn' => 'nullable|string',
                'nama_lengkap' => 'nullable|string',
                'nama' => 'required|string|max:255',
                'tempat_lahir' => 'nullable|string',
                'tanggal_lahir' => 'nullable|string',
                'agama' => 'nullable|string',
                'alamat' => 'nullable|string',
                'no_telp' => 'nullable|string',
            ]);

            $siswaData = collect($validatedData)
                ->except(['gambar'])->toArray();

            // Cek apakah ada gambar baru
            if (!empty($validatedData['gambar'])) {
                $tmp_file = TemporaryFile::
                    where('folder', $validatedData['gambar'])
                    ->first();

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

            // update user
            $siswa->update($siswaData);

            return redirect()->back()->with('success', 'Data berhasil diubah!');
        }
    }
}
