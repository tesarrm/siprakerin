<?php

namespace App\Http\Controllers;

use App\Models\Pengaturan;
use App\Models\TahunAjaran;
use Illuminate\Http\Request;

class PengaturanController extends Controller
{
    protected $pModel;
    public function __construct(Pengaturan $p)
    {
        $this->pModel = $p;
    }

    public function index()
    {
        $data= $this->pModel->first();
        $tahun_ajaran = TahunAjaran::get();
        
        return view('pengaturan.index', [
            'data' => $data,
            'tahun_ajaran' => $tahun_ajaran,
        ]);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'tahun_ajaran_id' => 'required',
            'penilaian_2' => 'nullable',
        ]);

        $data = Pengaturan::first();

        if ($data) {
            $data->update($validatedData);
        } else {
            return redirect()->back()->with('error', 'Data tidak ditemukan.');
        }

        return redirect()->route('pengaturan.index')->with('success', 'Data berhasil diperbarui.');
    }

}
