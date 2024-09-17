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
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = $this->bModel->get();

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

        return redirect('bidang-keahlian')->with('status', 'Data berhasil ditambah!');
    }

    public function edit(BidangKeahlian $bidang_keahlian)
    {
        return view('bidang_keahlian.edit', [
            'data' => $bidang_keahlian
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

        return redirect('bidang-keahlian')->with('status', 'Data berhasil ditambah!');
    }

    public function destroy($id)
    {
        $data = $this->bModel->findOrFail($id);
        $data->delete();
        return response()->json(['success' => true]);
    }
}
