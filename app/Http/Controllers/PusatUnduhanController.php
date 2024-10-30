<?php

namespace App\Http\Controllers;

use App\Models\PusatUnduhan;
use App\Models\TemporaryFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PusatUnduhanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = PusatUnduhan::get();
        return view('pusat_unduhan.index', compact('data'));
    }

    public function view()
    {
        $data = PusatUnduhan::get();
        return view('pusat_unduhan.i', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pusat_unduhan.add');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama' => 'required|string',
            'file' => 'required|string',
        ]);

        $create = collect($validatedData);

        // kondisi cek gambar
        if (!empty($validatedData['file'])) {
            $tmp_file = TemporaryFile::where('folder', $validatedData['file'])->first();

            if ($tmp_file) {
                Storage::copy('posts/tmp/' . $tmp_file->folder . '/'.$tmp_file->file, 'posts/' . $tmp_file->folder . '/' . $tmp_file->file);

                $create['file'] = $tmp_file->folder . '/' . $tmp_file->file;

                Storage::deleteDirectory('posts/tmp/' . $tmp_file->folder);
                $tmp_file->delete();
            }
        } else {
            $create['file'] = null;
        }

        PusatUnduhan::create($create->toArray());

        return redirect('pusatunduhan')->with('status', 'Data berhasil ditambah!');
    }


    /**
     * Display the specified resource.
     */
    public function show(PusatUnduhan $pusatUnduhan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $data = PusatUnduhan::findOrFail($id);
        return view('pusat_unduhan.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PusatUnduhan $pusatUnduhan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $data = PusatUnduhan::findOrFail($id);

        // Hapus gambar dan foldernya dari storage
        if ($data->file) {
            $folderPath = 'posts/' . dirname($data->file);
            Storage::deleteDirectory($folderPath);
        }
        $data->delete();

        return response()->json(['success' => true]);
    }

    public function deleteMultiple(Request $request)
    {
        $ids = $request->input('ids');

        // Ambil semua data guru berdasarkan ID yang dipilih
        $datas = PusatUnduhan::whereIn('id', $ids)->get();

        foreach ($datas as $data) {
            // Hapus gambar dan foldernya dari storage
            if ($data->file) {
                $folderPath = 'posts/' . dirname($data->file);
                Storage::deleteDirectory($folderPath);
            }

            // Hapus datadata 
            $data->delete();
        }

        return response()->json(['success' => true]);
    }

    public function tmpUpload(Request $request) {
        if($request->hasFile('file')){
            $file = $request->file('file');
            $file_name = $file->getClientOriginalName();
            $folder = uniqid('post', true);
            $file->storeAs(
                'posts/tmp/'.$folder, $file_name
            );

            TemporaryFile::create([
                'folder' => $folder,
                'file' => $file_name,
            ]);

            return $folder;
        } 
        
        return response()->json(['error' => 'File not found'], 400);
    }

    public function tmpDelete(){
        $tmp_file = TemporaryFile::where('folder', request()->getContent())->first();

        if($tmp_file){
            Storage::deleteDirectory('posts/tmp/' . $tmp_file->folder);
            $tmp_file->delete();
            
            return response('');
        }

        return response()->json(['error' => 'File not found'], 404);
    }

    public function download(Request $request)
    {

        // Cek apakah file ada di storage
        $filePath = 'posts/' . $request->file;
        
        if (Storage::exists($filePath)) {
            return Storage::download($filePath);
        }

        return redirect()->back()->with('error', 'File tidak ditemukan!');
    }

}
