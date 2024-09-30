<?php

namespace App\Http\Controllers;

use App\Models\Industri;
use App\Models\Kota;
use App\Models\Pengaturan;
use Illuminate\Http\Request;

class IndustriController extends Controller
{
    protected $model;
    public function __construct(Industri $a)
    {
        $this->model = $a;

        $this->middleware('can:c_industri')->only(['create', 'store']);
        $this->middleware('can:r_industri')->only(['index', 'show']);
        $this->middleware('can:u_industri')->only(['edit', 'update']);
        $this->middleware('can:d_industri')->only('destroy');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = $this->model->with('kota')->where('aktif', 1)->get();

        return view('industri.index', [
            'data' => $data
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $kota = Kota::get();
        $pengaturan = Pengaturan::first();

        return view('industri.add', [
            'kota' => $kota,
            'pengaturan' => $pengaturan
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama' => 'required|string',
            'alamat' => 'required|string',
            'kota_id' => 'required|string',
            'tahun_ajaran' => 'required|string',
        ]);

        $create = collect($validatedData);

        $this->model->create($create->toArray());

        return redirect('industri')->with('status', 'Data berhasil ditambah!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Industri $industri)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Industri $industri)
    {
        $kota = Kota::get();

        return view('industri.edit', [
            'data' => $industri,
            'kota' => $kota
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($id, Request $request)
    {
        $data = $this->model->findOrFail($id);

        $validatedData = $request->validate([
            'nama' => 'required|string',
            'alamat' => 'required|string',
            'kota_id' => 'required|string',
            'tahun_ajaran' => 'required|string',
        ]);

        $update = collect($validatedData);

        $data->update($update->toArray());

        return redirect('industri')->with('status', 'Data berhasil diedit!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $data = $this->model->findOrFail($id);
        $data->delete();
        return response()->json(['success' => true]);
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
