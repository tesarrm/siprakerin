<?php

namespace App\Http\Controllers;

use App\Exports\GuruExport;
use App\Imports\GuruImport;
use App\Models\Guru;
use App\Models\TemporaryFile;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class GuruController extends Controller
{
    protected $model;
    public function __construct(Guru $guru)
    {
        $this->model = $guru;

        // $this->middleware('can:c_guru')->only(['index', 'show']);
        // $this->middleware('can:r_guru')->only(['create', 'store']);
        // $this->middleware('can:u_guru')->only(['edit', 'update']);
        // $this->middleware('can:d_guru')->only('destroy');

    }

        // dd(auth()->user()->getRoleNames());
        // dd(auth()->user()->getAllPermissions());
    public function index()
    {
        // Ambil semua data guru beserta user dan role terkait
        $guru = $this->model->with(['user.roles', 'hoKelas'])->where('aktif', 1)->get()->map(function ($guru) {
            // Ambil peran dari user yang terkait dengan guru
            $guru->user->peran = $guru->user->roles->isNotEmpty() 
                ? $guru->user->roles->pluck('name')->implode(', ')
                : '-';
            return $guru;
        });

        // Kirim data ke view
        return view('guru.index', [
            'guru' => $guru
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('guru.add');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'aktif' => 'nullable|string',
            'gambar' => 'nullable|string',
            'nip' => 'required|unique:gurus,nip',
            'no_ktp' => 'nullable|string',
            'nama' => 'required|string|max:255',
            'tempat_lahir' => 'nullable|string',
            'tanggal_lahir' => 'nullable|string',
            'jenis_kelamin' => 'required',
            'golongan_darah' => 'nullable|string',
            'kecamatan' => 'nullable|string',
            'alamat' => 'nullable|string',
            'rt' => 'nullable|string',
            'rw' => 'nullable|string',
            'kode_pos' => 'nullable|string',
            'no_telp' => 'nullable|string',
            'no_hp' => 'nullable|string',
            'agama' => 'nullable|string',
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
        $user->assignRole('guru');
        if (!empty($request->peran_admin)) {
            $user->assignRole('admin');
        }
        if (!empty($request->peran_kabeng)) {
            $user->assignRole('kabeng');
        }
        if (!empty($request->peran_ortu)) {
            $user->assignRole('ortu');
        }

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

        // create guru
        $create->put('user_id', $user->id);
        Guru::create($create->toArray());

        return redirect('guru')->with('status', 'Data berhasil ditambah!');
    }



    public function show($id)
    {

    }


    public function edit(Guru $guru)
    {
        //
        return view('guru.edit', [
            'guru' => $guru
        ]);
    }


    public function update($id, Request $request)
    {
        $guru = $this->model->findOrFail($id);

        $validatedData = $request->validate([
            'gambar' => 'nullable|string',
            'nip' => 'required|unique:gurus,nip,' . $id,
            'nama_guru' => 'required|string|max:255',
            'jenis_kelamin' => 'required',
            'peran' => 'required|string|max:50',
            'wali_kelas' => 'nullable|string|max:50',
            'username' => 'required|string|unique:gurus,username,' . $id,
            'password' => 'required',
        ]);

        $update = collect($validatedData);

        // Cek apakah ada gambar baru
        if (!empty($validatedData['gambar'])) {
            // Proses gambar baru
            $tmp_file = TemporaryFile::where('folder', $validatedData['gambar'])->first();

            if ($tmp_file) {
                // Hapus gambar lama jika ada
                if ($guru->gambar) {
                    Storage::delete('posts/' . $guru->gambar);
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
            if ($guru->gambar) {
                Storage::delete('posts/' . $guru->gambar); // Hapus gambar lama
            }
            $update->put('gambar', null);
        }

        // Update data guru di database
        $guru->update($update->toArray());

        return redirect('guru')->with('status', 'Data berhasil diubah!');
    }

 
    public function destroy($id)
    {
        $guru = $this->model->findOrFail($id);

        // Hapus gambar dan foldernya dari storage
        if ($guru->gambar) {
            $folderPath = 'posts/' . dirname($guru->gambar);
            Storage::deleteDirectory($folderPath);
        }
        $guru->delete();

        // return redirect('guru')->with('status', 'Data berhasil dihapus!');
        return response()->json(['success' => true]);
    }

    public function tmpUpload(Request $request){

        if($request->hasFile('gambar')){
            $gambar = $request->file('gambar');
            $file_name = $gambar->getClientOriginalName();
            $folder = uniqid('post', true);
            $gambar->storeAs('posts/tmp/'.$folder, $file_name);
            TemporaryFile::create([
                'folder' => $folder,
                'file' => $file_name,
            ]);

            return $folder;
        }
    }

    public function tmpDelete(){
        $tmp_file = TemporaryFile::where('folder', request()->getContent())->first();
        if($tmp_file){
            Storage::deleteDirectory('posts/tmp/' . $tmp_file->folder);
            $tmp_file->delete();

            return response('');
        }
    }

    public function deleteMultiple(Request $request)
    {
        $ids = $request->input('ids');

        // Ambil semua data guru berdasarkan ID yang dipilih
        $gurus = $this->model->whereIn('id', $ids)->get();

        foreach ($gurus as $guru) {
            // Hapus gambar dan foldernya dari storage
            if ($guru->gambar) {
                $folderPath = 'posts/' . dirname($guru->gambar);
                Storage::deleteDirectory($folderPath);
            }

            // Hapus data guru
            $guru->delete();
        }

        return response()->json(['success' => true]);
    }

    public function export() 
    {
        // return Excel::download(new GuruExport, 'guru'.Carbon::now()->timestamp.'.xlsx');
        return (new GuruExport)->download('guru-'.Carbon::now()->timestamp.'.xlsx');
    }

    public function import(Request $request){
        Excel::import(new GuruImport, $request->file('excel'));
        return redirect('guru');
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
