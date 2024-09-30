<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\HasilMonitoring;
use App\Models\Monitoring;
use App\Models\PenempatanIndustri;
use App\Models\Siswa;
use Illuminate\Http\Request;

class HasilMonitoringController extends Controller
{
    protected $model;
    public function __construct(HasilMonitoring $a)
    {
        $this->model = $a;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if(auth()->user()->hasRole('wali_siswa')){
            $guru = Guru::where('user_id', auth()->user()->id)->first();
            $data = Monitoring::with(['guru', 'industri'])->where('guru_id', $guru->id )->get();
        } else {
            $data = Monitoring::with(['guru', 'industri'])->get();
        }

        if(auth()->user()->hasRole('siswa')) {
            $siswa = Siswa::where('user_id', auth()->user()->id)->first();
            $siswa_id = $siswa->id;
            $hasil = HasilMonitoring::where('siswa_id', $siswa_id)->with(['siswa.kelas.jurusan', 'monitoring.guru'])->get();
        } else {
            $hasil = HasilMonitoring::with(['siswa.kelas.jurusan', 'monitoring.guru'])->get();
        }

        return view('hasil_monitoring.index', [
            'data' => $data,
            'hasil' => $hasil,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(HasilMonitoring $hasilMonitoring)
    {
        // $data = HasilMonitoring::with(['siswa.kelas'])->get();
        
        // return view('hasil_monitoring.show', [
        //     'data' => $data,
        // ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($jadwal_monitoring_id)
    {
        //
        $jadwal_monitoring = Monitoring::with(['guru', 'industri'])->findOrFail($jadwal_monitoring_id);
        $hasil_monitoring = HasilMonitoring::where('monitoring_id', $jadwal_monitoring_id)->with('siswa')->get();
        $penempatan = PenempatanIndustri::where('industri_id', $jadwal_monitoring->industri_id)->with('siswa.kelas.jurusan')->get();

        return view('hasil_monitoring.edit', [
            'jadwal_monitoring' => $jadwal_monitoring,
            'penempatan' => $penempatan,
            'hasil_monitoring' => $hasil_monitoring,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, HasilMonitoring $hasilMonitoring)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(HasilMonitoring $hasilMonitoring)
    {
        //
    }

    public function storeOrUpdate(Request $request)
    {
        $validated = $request->validate([
            'monitoring_id' => 'required|string',
            'data.*.siswa_id' => 'required|string',
            'data.*.kedisiplinan' => 'required|string',
            'data.*.sikap' => 'required|string',
            'data.*.kerjasama' => 'required|string',
            'data.*.catatan' => 'required|string',
        ]);

        $monitoring_id = $validated['monitoring_id'];


        HasilMonitoring::where('monitoring_id', $monitoring_id)
                    ->delete();

        foreach ($validated['data'] as $data) {
            HasilMonitoring::updateOrCreate([
                    'monitoring_id' => $monitoring_id,
                    'siswa_id' => $data['siswa_id'],
                    'kedisiplinan' => $data['kedisiplinan'],
                    'sikap' => $data['sikap'],
                    'kerjasama' => $data['kerjasama'],
                    'catatan' => $data['catatan'],
                ],
            );
        }

        return redirect('hasilmonitoring')->with('status', 'Data berhasil diubah!');
    }
}
