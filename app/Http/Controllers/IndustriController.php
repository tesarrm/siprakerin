<?php

namespace App\Http\Controllers;

use App\Models\Industri;
use App\Models\Kota;
use Illuminate\Http\Request;

class IndustriController extends Controller
{
    protected $model;
    public function __construct(Industri $a)
    {
        $this->model = $a;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = $this->model->with('kota')->get();

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

        return view('industri.add', [
            'kota' => $kota
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
            'kota' => 'required|string',
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
        $kota = Kota::with('kota')->get();

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
            'kota' => 'required|string',
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