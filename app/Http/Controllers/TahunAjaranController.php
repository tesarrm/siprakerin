<?php

namespace App\Http\Controllers;

use App\Models\TahunAjaran;
use Illuminate\Http\Request;

class TahunAjaranController extends Controller
{
    public function index()
    {
        $data = TahunAjaran::orderBy('nama', 'asc')->get();

        return view('tahun_ajaran.index', [
            'data' => $data
        ]);
    }

    public function create()
    {
        return view('tahun_ajaran.add');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama' => 'required|string',
        ]);

        $create = collect($validatedData);

        TahunAjaran::create($create->toArray());

        return redirect('tahunajaran')->with('status', 'Data berhasil ditambah!');
    }

    public function edit($id)
    {
        $data = TahunAjaran::findOrFail($id);
        return view('tahun_ajaran.edit', [
            'data' => $data,
        ]);
    }

    public function update($id, Request $request)
    {
        $data = TahunAjaran::findOrFail($id);

        $validatedData = $request->validate([
            'nama' => 'required|string',
        ]);

        $update = collect($validatedData);

        $data->update($update->toArray());

        return redirect('tahunajaran')->with('status', 'Data berhasil ditambah!');
    }

    public function destroy($id)
    {
        $data = TahunAjaran::findOrFail($id);
        $data->delete();
        return response()->json(['success' => true]);
    }
}
