<?php

namespace App\Http\Controllers;

use App\Exports\GuruExport;
use App\Imports\GuruImport;
use App\Models\Guru;
use App\Models\TemporaryFile;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx\Rels;

class GuruController extends Controller
{
    protected $guruModel;
    public function __construct(Guru $guru)
    {
        $this->guruModel = $guru;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $guru = $this->guruModel->with(['peserta'])->get();

        // return Controller::success('Berhasil Menampilkan Laporan', $guru);

        $guru = $this->guruModel->get();

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
    // public function store(Request $request)
    // {
    //     $validatedData = $request->validate([
    //         'gambar' => 'required|string',
    //         'nip' => 'required|digits:18|unique:gurus,nip',
    //         'nama_guru' => 'required|string|max:255',
    //         'jenis_kelamin' => 'required|in:L,P',
    //         'peran' => 'required|string|max:50',
    //         'wali_kelas' => 'nullable|string|max:50',
    //         'username' => 'required|string|unique:gurus,username|max:255',
    //         'password' => 'required|string|min:8|confirmed',
    //     ]);

    //     // $tmp_file = TemporaryFile::where('folder', $request->gambar)->first();
    //     $tmp_file = TemporaryFile::where('folder', $validatedData['gambar'])->first();


    //     if($tmp_file){
    //         Storage::copy('posts/tmp/' . $tmp_file->folder . '/'.$tmp_file->file, 'posts/' . $tmp_file->folder . '/' . $tmp_file->file);

    //         $create = collect($request->only($this->guruModel->getFillable()))
    //             ->put('gambar', $tmp_file->folder . '/' . $tmp_file->file)
    //             ->toArray();
    //         $this->guruModel->create($create);

    //         Storage::deleteDirectory('posts/tmp/' . $tmp_file->folder);
    //         $tmp_file->delete();

    //         return redirect('guru')->with('status', 'Data berhasil ditambah!');
    //     }

    // }

    public function store(Request $request)
    {
        // Validasi input
        $validatedData = $request->validate([
            'gambar' => 'nullable|string',
            'nip' => 'required|unique:gurus,nip',
            'nama_guru' => 'required|string|max:255',
            'jenis_kelamin' => 'required',
            'peran' => 'required|string|max:50',
            'wali_kelas' => 'nullable|string|max:50',
            'username' => 'required|string|unique:gurus,username|max:255',
            // 'password' => 'required|string|min:8|confirmed',
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

        $this->guruModel->create($create->toArray());

        return redirect('guru')->with('status', 'Data berhasil ditambah!');
    }


    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $laporan = $this->guruModel->with(['peserta'])->findOrFail($id);

        // return Controller::success('Berhasil Menampilkan Laporan', $laporan);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Guru $guru)
    {
        //
        return view('guru.edit', [
            'guru' => $guru
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    // public function update($id, Request $request)
    // {
    //     $guru = $this->guruModel->findOrFail($id);

    //     $update = collect($request->only($this->guruModel->getFillable()))
    //         ->toArray();
    //     $guru->update($update);

    //     return redirect('guru')->with('status', 'Data berhasil diubah!');
    // }

    public function update($id, Request $request)
    {
        $guru = $this->guruModel->findOrFail($id);

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


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $guru = $this->guruModel->findOrFail($id);

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

    // public function deleteMultiple(Request $request)
    // {
    //     $ids = $request->input('ids');
    //     if (!empty($ids)) {
    //         Guru::whereIn('id', $ids)->delete();
    //         return response()->json(['success' => true]);
    //     } else {
    //         return response()->json(['success' => false, 'message' => 'Tidak ada data yang dipilih.']);
    //     }
    // }

    public function deleteMultiple(Request $request)
    {
        $ids = $request->input('ids');

        // Ambil semua data guru berdasarkan ID yang dipilih
        $gurus = $this->guruModel->whereIn('id', $ids)->get();

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
}
