<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\Industri;
use App\Models\JadwalMonitoring;
use App\Models\Pengaturan;
use Illuminate\Http\Request;

class JadwalMonitoringController extends Controller
{
    protected $model;
    public function __construct(JadwalMonitoring $a)
    {
        $this->model = $a;

        // $this->middleware('can:c_jadwal_monitoring`')->only(['create', 'store']);
        // $this->middleware('can:r_jadwal_monitoring`')->only(['index', 'show']);
        // $this->middleware('can:u_jadwal_monitoring`')->only(['edit', 'update']);
        // $this->middleware('can:d_jadwal_monitoring`')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = JadwalMonitoring::with(['guru', 'industri', 'tahunAjaran'])
            ->orderBy('created_at', 'desc')
            ->get();

        $guru = Guru::where('aktif', 1)
            ->whereHas('jadwalMonitorings')
            ->with('user')
            ->get();
        $industri = Industri::where('aktif', 1)
            ->whereHas('jadwalMonitorings')
            ->get();

        return view('jadwal_monitoring.index', [
            'data' => $data,
            'guru' => $guru,
            'industri' => $industri,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $guru = Guru::with('user')->get();
        $industri = Industri::with('gurus.user')
            ->whereHas('penempatanIndustri')
            ->get();
        $pengaturan = Pengaturan::first();

        return view('jadwal_monitoring.add', [
            'guru' => $guru,
            'industri' => $industri,
            'pengaturan' => $pengaturan,
        ]);
    }

    public function store(Request $request)
    {
        // Validasi input
        $validatedData = $request->validate([
            'guru' => 'required',
            'industri_id' => 'required',
            'tanggal' => 'required',
            'tahun_ajaran_id' => 'required',
        ]);

        // Cari guru berdasarkan nama
        $guru = Guru::where('id', $validatedData['guru'])->first();

        if (!$guru) {
            return redirect()->back()->withErrors(['guru' => 'Guru tidak ditemukan'])->withInput();
        }

        // Tambahkan guru_id ke data yang akan disimpan
        $validatedData['guru_id'] = $guru->id;

        // Buat record baru menggunakan model dan data yang sudah ditambah guru_id
        JadwalMonitoring::create($validatedData);

        // Redirect dengan pesan sukses
        return redirect('jadwalmonitoring')->with('status', 'Data berhasil ditambah!');
    }

    /**
     * Display the specified resource.
     */
    public function show(JadwalMonitoring $jadwal_monitoring)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $guru = Guru::get();
        $industri = Industri::with('gurus.user')
            ->whereHas('penempatanIndustri')
            ->get();
        $jadwal_monitoring = JadwalMonitoring::with(['guru.user', 'tahunAjaran'])
            ->findOrFail($id);
        
        return view('jadwal_monitoring.edit', [
            'data' => $jadwal_monitoring,
            'guru' => $guru,
            'industri' => $industri,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($id, Request $request)
    {
        $data = JadwalMonitoring::with('guru.user')->findOrFail($id);

        $validatedData = $request->validate([
            'guru' => 'required',
            'industri_id' => 'required',
            'tanggal' => 'required',
        ]);

        $guru = Guru::where('id', $validatedData['guru'])->first();

        if (!$guru) {
            return redirect()->back()->withErrors(['guru' => 'Guru tidak ditemukan'])->withInput();
        }


        $validatedData['guru_id'] = $guru->id;

        // update 
        $update = collect($validatedData);
        $data->update($update->toArray());

        return redirect('jadwalmonitoring')->with('status', 'Data berhasil ditambah!');
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

    public function deleteMultiple(Request $request)
    {
        $ids = $request->input('ids');

        // Ambil semua data guru berdasarkan ID yang dipilih
        $datas = $this->model->whereIn('id', $ids)->get();

        foreach ($datas as $data) {
            // Hapus datadata 
            $data->delete();
        }

        return response()->json(['success' => true]);
    }
}