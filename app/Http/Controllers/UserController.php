<?php

namespace App\Http\Controllers;

use App\Models\BiodataSiswa;
use App\Models\Kelas;
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
        $data = User::all()->map(function ($user) {
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
}
