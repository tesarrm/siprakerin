<?php

namespace App\Http\Controllers;

use App\Models\BidangKeahlian;
use Illuminate\Http\Request;

class BidangKeahlianController extends Controller
{
    protected $bModel;
    public function __construct(BidangKeahlian $b)
    {
        $this->bModel = $b;

        $this->middleware('can:c_bidang_keahlian')->only(['create', 'store']);
        $this->middleware('can:r_bidang_keahlian')->only(['index', 'show']);
        $this->middleware('can:u_bidang_keahlian')->only(['edit', 'update']);
        $this->middleware('can:d_bidang_keahlian')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = BidangKeahlian::orderBy('nama', 'asc')->get();

        return view('bidang_keahlian.index', [
            'data' => $data
        ]);
    }

    public function create()
    {
        return view('bidang_keahlian.add');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama' => 'required|string',
        ]);

        $create = collect($validatedData);

        $this->bModel->create($create->toArray());

        return redirect('bidangkeahlian')->with('status', 'Data berhasil ditambah!');
    }

    public function edit($id)
    {
        $data = BidangKeahlian::findOrFail($id);
        return view('bidang_keahlian.edit', [
            'data' => $data,
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

        return redirect('bidangkeahlian')->with('status', 'Data berhasil ditambah!');
    }

    public function destroy($id)
    {
        $data = $this->bModel->findOrFail($id);
        $data->delete();
        return response()->json(['success' => true]);
    }

    public function deleteMultiple(Request $request)
    {
        $ids = $request->input('ids');

        // Ambil semua data guru berdasarkan ID yang dipilih
        $datas = BidangKeahlian::whereIn('id', $ids)->get();

        foreach ($datas as $data) {
            $data->delete();
        }

        return response()->json(['success' => true]);
    }
}
