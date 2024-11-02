<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Izin;
use App\Models\Siswa;
use App\Models\TemporaryFile;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class IzinController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'gambar' => 'required|string',
            'tanggal' => 'required|string',
            'catatan' => 'nullable|string',
        ]);

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
        $siswa = Siswa::where('user_id', auth()->user()->id)->first();
        $create->put('siswa_id', $siswa->id);
        Izin::create($create->toArray());

        // buat kehadiran hadir
        // Attendance::create([
        //     'siswa_id' => $siswa->id,
        //     'date' => Carbon::now(),
        //     'status' => 'izin',
        // ]);

        return redirect('jurnal')->with('status', 'Data berhasil ditambah!');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $siswa = Siswa::where('user_id', auth()->user()->id)->first();
        $izin = Izin::with('siswa.kelas.jurusan')->findOrFail($id);

        return view('jurnal.show2', [
            'izin' => $izin,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $siswa = Siswa::where('user_id', auth()->user()->id)->first();
        $izin = Izin::with('siswa.kelas.jurusan')->findOrFail($id);

        return view('jurnal.edit2', [
            'izin' => $izin,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($id, Request $request)
    {
        $data = Izin::findOrFail($id);

        $validatedData = $request->validate([
            'gambar' => 'required|string',
            'tanggal' => 'required|string',
            'catatan' => 'nullable|string',
        ]);

        // colect data sesaui dengan fillable
        $update = collect($validatedData);

        // kondisi cek gambar
        if (!empty($validatedData['gambar'])) {
            $tmp_file = TemporaryFile::where('folder', $validatedData['gambar'])->first();

            if ($tmp_file) {
                Storage::copy('posts/tmp/' . $tmp_file->folder . '/'.$tmp_file->file, 'posts/' . $tmp_file->folder . '/' . $tmp_file->file);

                $update->put('gambar', $tmp_file->folder . '/' . $tmp_file->file);

                Storage::deleteDirectory('posts/tmp/' . $tmp_file->folder);
                $tmp_file->delete();
            }
        } else {
            $update->put('gambar', null); // atau $create->forget('gambar');
        }

        // update siswa 
        $siswa = Siswa::where('user_id', auth()->user()->id)->first();
        $update->put('siswa_id', $siswa->id);
        $data->update($update->toArray());

        return redirect('jurnal')->with('status', 'Data berhasil ditambah!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $data = Izin::findOrFail($id);
        $data->delete();
        return response()->json(['success' => true]);
    }
}
