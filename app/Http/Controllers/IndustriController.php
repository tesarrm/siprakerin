<?php

namespace App\Http\Controllers;

use App\Models\Industri;
use App\Models\Kota;
use App\Models\LiburMingguan;
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
            'tanggal_awal' => 'nullable|string',
            'tanggal_akhir' => 'nullable|string',
        ]);

        $create = collect($validatedData);

        $industri = Industri::create($create->toArray());

        $create2 = collect($request)->except([
            'nama',
            'alamat',
            'kota_id',
            'tahun_ajaran',
            'tanggal_awal',
            'tanggal_akhir',
        ]);

        $create2->put('industri_id', $industri->id);

        LiburMingguan::create($create2->toArray());

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
        $libur = LiburMingguan::where('industri_id', $industri->id)->first();

        return view('industri.edit', [
            'data' => $industri,
            'kota' => $kota,
            'libur' => $libur,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
public function update($id, Request $request)
{
    // Ambil data industri berdasarkan id
    $industri = Industri::findOrFail($id);

    // Validasi data industri
    $validatedData = $request->validate([
        'nama' => 'required|string',
        'alamat' => 'required|string',
        'kota_id' => 'required|string',
        'tahun_ajaran' => 'required|string',
        'tanggal_awal' => 'nullable|string',
        'tanggal_akhir' => 'nullable|string',
    ]);

    // Update data industri
    $update = collect($validatedData);
    $industri->update($update->toArray());

    // hapus libur mingguan lama
    $liburI = LiburMingguan::where('industri_id', $industri->id)->get();

    foreach ($liburI as $data) {
        $data->delete();
    }

    // Ambil data libur mingguan yang berhubungan dengan industri
    $libur = LiburMingguan::where('industri_id', $industri->id)->first();

    // Ambil data request untuk hari libur (kecuali field industri yang sudah diupdate)
    $update2 = collect($request)->except([
        'nama',
        'alamat',
        'kota_id',
        'tahun_ajaran',
        'tanggal_awal',
        'tanggal_akhir',
    ]);

    // Tambahkan industri_id ke data libur mingguan
    $update2->put('industri_id', $industri->id);

    // Cek apakah data libur sudah ada atau belum, jika ada update, jika tidak create
    if ($libur) {
        $libur->update($update2->toArray());
    } else {
        LiburMingguan::create($update2->toArray());
    }

    // Redirect dengan pesan status
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
