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
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Facades\Excel;

class GuruController extends Controller
{
    protected $model;
    public function __construct(Guru $guru)
    {
        $this->model = $guru;

        $this->middleware('can:c_guru')->only(['create', 'store']);
        $this->middleware('can:r_guru')->only(['index', 'show']);
        $this->middleware('can:u_guru')->only(['edit', 'update']);
        $this->middleware('can:d_guru')->only('destroy');

    }

    public function index()
    {
        // Ambil semua data guru beserta user dan role terkait
        $guru = Guru::with(['user.roles', 'hoKelas.jurusan'])
            ->where('aktif', 1)
            ->orderBy('nama', 'asc')
            ->paginate(100);

        // Kirim data ke view
        return view('guru.index', [
            'data' => $guru
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
        $user->assignRole('guru');

        // create guru
        $guruData = collect($validatedData)->except(['gambar', 'email', 'password'])->toArray();
        $guruData['user_id'] = $user->id;
        Guru::create($guruData);

        return redirect('guru')->with('status', 'Data berhasil ditambah!');
    }



    public function show($id)
    {

    }


    public function edit(Guru $guru)
    {
        return view('guru.edit', [
            'data' => $guru
        ]);
    }


    public function update($id, Request $request)
    {
        $guru = Guru::with('user')->findOrFail($id);
        $user = $guru->user;

        $validatedData = $request->validate([
            'aktif' => 'nullable|string',
            'gambar' => 'nullable|string',
            'nip' => 'required|unique:gurus,nip,' . $id,
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
        ]);

        // $update = collect($validatedData);
        $guruData = collect($validatedData)->except(['gambar'])->toArray();

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

        // Update data guru
        $guru->update($guruData);

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

        if($request->hasFile('pas_foto')){
            $gambar = $request->file('pas_foto');
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
        // Excel::import(new GuruImport, $request->file('excel'));
        // return redirect('guru');

        try {
            Excel::import(new GuruImport, $request->file('excel'));
            return redirect()->back()->with('status', 'Data guru berhasil diimpor!');
        } catch (ValidationException $e) {
            // Ambil pesan error dari exception
            $errors = $e->validator->errors()->getMessages();

            // Redirect ke halaman dengan pesan error
            return redirect()->back()->withErrors($errors)->withInput();
        }
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

    public function downloadTemplate()
    {
        $filePath = public_path('files/guru.xlsx'); 
        return Response::download($filePath);
    }
}
