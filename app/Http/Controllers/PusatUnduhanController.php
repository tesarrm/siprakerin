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
        return view('pusat_unduhan.index');
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
    'file' => 'required|file|mimes:jpg,jpeg,png,gif,doc,docx,dot,pdf|max:2048',
        ]);

        dd($validatedData);

        // dd($request->all());

        $create = collect($validatedData);

        // Cek file dan pindahkan ke direktori yang diinginkan
        // if ($request->hasFile('file')) {
            $file = $request->file('file');
            $timestamp = now()->format('Ymd_His'); // Mendapatkan timestamp
            $fileName = $timestamp . '_' . $file->getClientOriginalName(); // Menambahkan timestamp ke nama file
            $filePath = $file->storeAs('posts', $fileName); // Simpan file di direktori 'posts' dengan nama baru
            $create->put('file', $filePath); // Menyimpan path file ke dalam data yang akan disimpan
        // } else {
        //     $create->put('file', null); // Jika tidak ada file, simpan null
        // }

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
    public function edit(PusatUnduhan $pusatUnduhan)
    {
        //
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
    public function destroy(PusatUnduhan $pusatUnduhan)
    {
        //
    }

    // public function tmpUpload(Request $request){
    //     if($request->hasFile('file')){
    //         $file = $request->file('file');
    //         $file_name = $file->getClientOriginalName();
    //         $folder = uniqid('post', true);
    //         $file->storeAs(
    //             'posts/tmp/'.$folder, $file_name
    //         );

    //         TemporaryFile::create([
    //             'folder' => $folder,
    //             'file' => $file_name,
    //         ]);

    //         return $folder;
    //     } 
    // }

    // public function tmpDelete(){
    //     $tmp_file = TemporaryFile::
    //         where('folder', request()
    //         ->getContent())
    //         ->first();

    //     if($tmp_file){
    //         Storage::deleteDirectory(
    //             'posts/tmp/' . $tmp_file->folder
    //         );
    //         $tmp_file->delete();

    //         return response('');
    //     }
    // }

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

        // Mengembalikan response JSON
        return response()->json(['folder' => $folder]);
    } 
    
    return response()->json(['error' => 'File not found'], 400);
}

public function tmpDelete(){
    $tmp_file = TemporaryFile::where('folder', request()->getContent())->first();

    if($tmp_file){
        Storage::deleteDirectory('posts/tmp/' . $tmp_file->folder);
        $tmp_file->delete();
        
        return response()->json(['status' => 'success']);
    }

    return response()->json(['error' => 'File not found'], 404);
}


}
