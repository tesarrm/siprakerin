<?php

namespace App\Http\Controllers;

use App\Models\Kota;
use Illuminate\Http\Request;

class KotaController extends Controller
{
    protected $bModel;
    public function __construct(Kota $b)
    {
        $this->bModel = $b;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = $this->bModel->get();

        return view('kota.index', [
            'data' => $data
        ]);
    }

    public function create()
    {
        return view('kota.add');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama' => 'required|string',
        ]);

        $create = collect($validatedData);

        $this->bModel->create($create->toArray());

        return redirect('kota')->with('status', 'Data berhasil ditambah!');
    }

    public function edit($id)
    {
        $kota = Kota::findOrFail($id);

        return view('kota.edit', [
            'data' => $kota
        ]);
    }

    public function update($id, Request $request)
    {
        $data = $this->bModel->findOrFail($id);

        $validatedData = $request->validate([
            'nama' => 'required|string',
        ]);

        $update = collect($validatedData);

        $data->update($update->toArray());

        return redirect('kota')->with('status', 'Data berhasil ditambah!');
    }

    public function destroy($id)
    {
        $data = $this->bModel->findOrFail($id);
        $data->delete();
        return response()->json(['success' => true]);
    }
}
