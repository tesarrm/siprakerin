<?php

namespace App\Http\Controllers;

use App\Models\Pengaturan;
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
        
        return view('pengaturan.index', [
            'data' => $data
        ]);
    }

    // public function store(Request $request)
    // {
    //     $validatedData = $request->validate([
    //         'tahun_ajaran' => 'required|string',
    //     ]);

    //     $data = $this->pModel->first();
    //     $update = collect($validatedData);
    //     $data->update($update->toArray());
    // }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'tahun_ajaran' => 'required|string',
            'penilaian_2' => 'nullable',
        ]);

        $data = $this->pModel->first();

        if ($data) {
            $data->update($validatedData);
        } else {
            return redirect()->back()->with('error', 'Data tidak ditemukan.');
        }

        return redirect()->route('pengaturan.index')->with('success', 'Data berhasil diperbarui.');
    }

}
