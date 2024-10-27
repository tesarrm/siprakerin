<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\HasilMonitoring;
use App\Models\Industri;
use App\Models\Kelas;
use App\Models\Monitoring;
use App\Models\MonitoringImage;
use App\Models\PenempatanIndustri;
use App\Models\Siswa;
use App\Models\TemporaryFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
        // dd(auth()->user()->getRoleNames());

        if(auth()->user()->hasRole('pembimbing')){
            $guru = Guru::where('user_id', auth()->user()->id)->first();
            $data = Monitoring::with(['guru', 'industri'])
                ->where('guru_id', $guru->id )
                ->get();

            $data->each(function ($d) {
                $hasil = HasilMonitoring::where('monitoring_id', $d->id)
                    ->first();
                $d->status = $hasil ? 'Sudah Monitoring' : 'Belum Monitoring';
            });
        } else {
            $data = Monitoring::with([
                    'guru', 
                    'industri',
                    'hasilMonitoring'
                    ])
                ->orderBy('created_at', 'desc')
                ->get()
                ->map(function ($item) {
                    // Menambahkan key status berdasarkan kondisi whereHas hasilMonitoring
                    $item->status = $item->hasilMonitoring()
                        ->exists() ? 'Sudah Monitoring' : 'Belum Monitoring';
                    return $item;
                });
        }

        if(auth()->user()->hasRole('siswa')) {
            $siswa = Siswa::where('user_id', auth()->user()->id)->first();
            $siswa_id = $siswa->id;
            $hasil = HasilMonitoring::where('siswa_id', $siswa_id)
                ->with([
                    'siswa.kelas.jurusan', 
                    'monitoring.guru',
                    'siswa.penempatan.industri',
                    ])
                ->get();
        } else if (auth()->user()->hasRole('koordinator')) {
            $hasil = HasilMonitoring::with([
                    'siswa.kelas.jurusan', 
                    'monitoring.guru',
                    'siswa.penempatan.industri',
                    ])
                ->orderBy('created_at', 'desc') // Urutkan berdasarkan created_at desc
                ->paginate(250);
        } else if (auth()->user()->hasRole('wali_kelas')) {
            $guru = Guru::where('user_id', auth()->user()->id)
                ->with('hoKelas')  // Ambil kelas yang berelasi dengan guru
                ->first();

            // Ambil ID kelas yang berelasi dengan guru
            $kelasId = $guru->hoKelas->id;

            $hasil = HasilMonitoring::with([
                    'siswa.kelas.jurusan', 
                    'monitoring.guru',
                    'siswa.penempatan.industri',
                    ])
                ->whereHas('siswa.kelas', function ($query) use ($kelasId) {
                    $query->where('id', $kelasId);
                })
                ->orderBy('created_at', 'desc') // Urutkan berdasarkan created_at desc
                ->paginate(250);
        } else {
            $hasil = HasilMonitoring::with([
                    'siswa.kelas.jurusan', 
                    'monitoring.guru',
                    'siswa.penempatan.industri',
                ])
                ->orderBy('created_at', 'desc') // Urutkan berdasarkan created_at desc
                ->paginate(250);
        }

        $kelas = Kelas::where('aktif', 1)->get();
        $industri = Industri::where('aktif', 1)
            ->whereHas('monitorings')
            ->get();

        return view('hasil_monitoring.index', [
            'data' => $data,
            'hasil' => $hasil,
            'kelas' => $kelas,
            'industri' => $industri,
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
        $jadwal_monitoring= Monitoring::with(['guru', 'industri'])
            ->findOrFail($jadwal_monitoring_id);
        $monitoring_image = MonitoringImage::where('monitoring_id', $jadwal_monitoring_id)
            ->first();
        $hasil_monitoring = HasilMonitoring::where('monitoring_id', $jadwal_monitoring_id)
            ->with(['siswa', 'monitoring'])
            ->get();

        $penempatan = PenempatanIndustri::where(
            'industri_id', $jadwal_monitoring->industri->id)
            ->with('siswa.kelas.jurusan')
            ->get();

        return view('hasil_monitoring.edit', [
            'monitoring_image' => $monitoring_image,
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
            'gambar' => 'required|string',
            'data.*.siswa_id' => 'required|string',
            'data.*.hadir' => 'required|string',
            'data.*.izin' => 'required|string',
            'data.*.alpa' => 'required|string',
            'data.*.catatan' => 'required|string',
        ]);
        // dd($request);

        $monitoring_id = $validated['monitoring_id'];

        // kondisi cek gambar
        if (!empty($validated['gambar'])) {
            $tmp_file = TemporaryFile::where('folder', $validated['gambar'])->first();

            if ($tmp_file) {
                Storage::copy('posts/tmp/' . $tmp_file->folder . '/'.$tmp_file->file, 'posts/' . $tmp_file->folder . '/' . $tmp_file->file);

                // $create->put('gambar', $tmp_file->folder . '/' . $tmp_file->file);
                $path_gambar = $tmp_file->folder . '/' . $tmp_file->file;

                // update gambar di monitoring
                MonitoringImage::updateOrCreate(
                    [
                        'monitoring_id' => $monitoring_id,
                    ],
                    [
                        'monitoring_id' => $monitoring_id,
                        'gambar' => $path_gambar,
                    ]
                );

                Storage::deleteDirectory('posts/tmp/' . $tmp_file->folder);
                $tmp_file->delete();
            } 
        }

        HasilMonitoring::where('monitoring_id', $monitoring_id)
                    ->delete();
                

        foreach ($validated['data'] as $data) {
            HasilMonitoring::updateOrCreate([
                    'monitoring_id' => $monitoring_id,
                    'siswa_id' => $data['siswa_id'],
                    'hadir' => $data['hadir'],
                    'izin' => $data['izin'],
                    'alpa' => $data['alpa'],
                    'catatan' => $data['catatan'],
                ],
            );
        }

        return redirect('hasilmonitoring')->with('status', 'Data berhasil diubah!');
    }
}
