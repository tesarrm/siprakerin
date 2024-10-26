<?php

namespace App\Http\Controllers;

use App\Models\BidangKeahlian;
use App\Models\Jurusan;
use Illuminate\Http\Request;

class JurusanController extends Controller
{
    protected $model;
    public function __construct(Jurusan $a)
    {
        $this->model = $a;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Jurusan::with('bidangKeahlian')->orderBy('nama', 'asc')->get();

        return view('jurusan.index', [
            'data' => $data
        ]);
    }

    public function create()
    {
        $bk = BidangKeahlian::get();

        return view('jurusan.add', [
            'bk' => $bk
        ]);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama' => 'required|string',
            'singkatan' => 'required|string',
            'bidang_keahlian_id' => 'required',
        ]);

        $create = collect($validatedData);

        $this->model->create($create->toArray());

        return redirect('jurusan')->with('status', 'Data berhasil ditambah!');
    }

    public function edit(Jurusan $jurusan)
    {
        $bk = BidangKeahlian::get();

        return view('jurusan.edit', [
            'data' => $jurusan,
            'bk' => $bk
        ]);
    }

    public function update($id, Request $request)
    {
        $data = $this->model->findOrFail($id);

        $validatedData = $request->validate([
            'nama' => 'required|string',
            'singkatan' => 'required|string',
            'bidang_keahlian_id' => 'required',
        ]);

        $update = collect($validatedData);

        $data->update($update->toArray());

        return redirect('jurusan')->with('status', 'Data berhasil ditambah!');
    }

    public function destroy($id)
    {
        $data = $this->model->findOrFail($id);
        $data->delete();
        return response()->json(['success' => true]);
    }

    public function deleteMultiple(Request $request)
    {
        $ids = $request->input('ids');

        // Ambil semua data guru berdasarkan ID yang dipilih
        $datas = Jurusan::whereIn('id', $ids)->get();

        foreach ($datas as $data) {
            $data->delete();
        }

        return response()->json(['success' => true]);
    }
}
