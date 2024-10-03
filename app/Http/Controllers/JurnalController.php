<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\Industri;
use App\Models\Izin;
use App\Models\Jurnal;
use App\Models\Kelas;
use App\Models\PenempatanIndustri;
use App\Models\Siswa;
use Carbon\Carbon;
use Illuminate\Http\Request;

class JurnalController extends Controller
{
    protected $model;
    public function __construct(Jurnal $a)
    {
        $this->model = $a;

        $this->middleware('can:c_jurnal')->only(['create', 'store']);
        $this->middleware('can:r_jurnal')->only(['index', 'show']);
        $this->middleware('can:u_jurnal')->only(['edit', 'update']);
        $this->middleware('can:d_jurnal')->only('destroy');
    }

    public function index()
    {
        $siswa = Siswa::where('user_id', auth()->user()->id)->first();
        $izin = Izin::with('siswa.kelas.jurusan')->where('siswa_id', $siswa->id)->get();
        $penempatan = PenempatanIndustri::with('industri')->where('siswa_id', $siswa->id)->first();

        $months = [
            'Januari' => 'January',
            'Februari' => 'February',
            'Maret' => 'March',
            'April' => 'April',
            'Mei' => 'May',
            'Juni' => 'June',
            'Juli' => 'July',
            'Agustus' => 'August',
            'September' => 'September',
            'Oktober' => 'October',
            'November' => 'November',
            'Desember' => 'December',
        ];

        // // Ganti nama bulan dalam string tanggal
        // $tanggalAwal = strtr($penempatan->industri->tanggal_awal, $months);
        // $tanggalAkhir = strtr($penempatan->industri->tanggal_akhir, $months);

        // // Mengubah string ke objek Carbon
        // $tanggalAwal = Carbon::createFromFormat('j F Y', $tanggalAwal);
        // $tanggalAkhir = Carbon::createFromFormat('j F Y', $tanggalAkhir);

        // // Hitung selisih hari
        // $selisihHari = $tanggalAkhir->diffInDays($tanggalAwal);

        // // Tampilkan selisih hari
        // dd($selisihHari);

        // Ganti nama bulan dalam string tanggal_akhir
        $tanggalAkhir = strtr($penempatan->industri->tanggal_akhir, $months);

        // Mengubah string ke objek Carbon
        $tanggalAkhir = Carbon::createFromFormat('j F Y', $tanggalAkhir);

        // Mengambil tanggal hari ini
        $tanggalHariIni = Carbon::now();

        // Hitung selisih hari
        $selisihHariDariHariIni = $tanggalHariIni->diffInDays($tanggalAkhir);


        if(auth()->user()->hasRole('wali_siswa')){
            $guru = Guru::where('user_id', auth()->user()->id)->first();
            $kelas = Kelas::where('guru_id', $guru->id)->first();

            // Filter jurnal berdasarkan kelas
            $data = Jurnal::whereHas('siswa.kelas', function ($query) use ($kelas) {
                $query->where('kelas.id', $kelas->id);
            })->with('siswa.kelas')->get();
        } else if(auth()->user()->hasRole('siswa')) {
            $data = Jurnal::with('siswa.kelas')->where('siswa_id', $siswa->id)->get();
        } else {
            $data = Jurnal::with('siswa.kelas')->get();
        }

        return view('jurnal.index', [
            'data' => $data,
            'izin' => $izin,
            'sisa_hari' => $selisihHariDariHariIni,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    // public function create()
    // {
    //     $siswa = Siswa::where('user_id', auth()->user()->id)->first();
    //     $penempatan = PenempatanIndustri::with(['industri.libur'])->where('siswa_id', $siswa->id)->first();

    //     dd($penempatan->industri->libur);

    //     return view('jurnal.add', compact(['penempatan']));

    // }
    
public function create()
{
    // Ambil data siswa berdasarkan user yang login
    $siswa = Siswa::where('user_id', auth()->user()->id)->first();
    $penempatan = PenempatanIndustri::with(['industri.libur'])->where('siswa_id', $siswa->id)->first();

    // Ambil hari ini
    $hariIni = Carbon::now()->isoFormat('dddd'); // Mendapatkan hari dalam format penuh, misalnya: Senin, Selasa, dll.

    // Mapping hari ke dalam bahasa Inggris yang sesuai dengan field database
    $hariMapping = [
        'Monday' => 'senin',
        'Tuesday' => 'selasa',
        'Wednesday' => 'rabu',
        'Thursday' => 'kamis',
        'Friday' => 'jumat',
        'Saturday' => 'sabtu',
        'Sunday' => 'minggu',
    ];

    // Ambil libur hari ini berdasarkan mapping
    $hariField = $hariMapping[$hariIni] ?? null; // Jika hari tidak ada di mapping, set null

    // Deteksi apakah hari ini libur
    $libur = ($hariField && $penempatan->industri->libur->{$hariField} === 'on') ? true : false;

    return view('jurnal.add', compact(['penempatan', 'libur']));
}

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'tanggal' => 'required|string',
            'time_start' => 'required|string',
            'time_end' => 'required|string',
            'kegiatan' => 'required',
            'keterangan' => 'required',
        ]);

        $siswa= Siswa::where('user_id', auth()->user()->id)->first();
        $siswa_id = $siswa->id;

        $create = collect($validatedData);
        $create->put('tanggal_waktu', $validatedData['tanggal'] . " " . $validatedData['time_start'] . " - " . $validatedData['time_end']);
        $create->put('siswa_id', $siswa_id);
        $this->model->create($create->toArray());

        return redirect('jurnal')->with('status', 'Data berhasil ditambah!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Jurnal $jurnal)
    {

        return view('jurusan.edit', [
            'data' => $jurnal,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */

public function edit($id)
{
    // Ambil data berdasarkan ID
    $data = $this->model->findOrFail($id);

    // Misalkan 'tanggal_waktu' adalah field yang menyimpan data dalam format "14 September 2024 08:11 - 08:11"
    $tanggalWaktu = $data->tanggal_waktu;

    // Pisahkan tanggal dan waktu
    $parts = explode(' ', $tanggalWaktu);

    // Misalkan format yang benar adalah "14 September 2024 08:11 - 08:11"
    $tanggal = implode(' ', array_slice($parts, 0, 3)); // Mengambil "14 September 2024"
    $timeStart = $parts[3]; // Mengambil "08:11"
    $timeEnd = explode(' - ', $parts[5])[0]; // Mengambil "08:11"

    // Siapkan data untuk dikirim ke view
    $data = [
        'id' => $data->id,
        'tanggal' => $tanggal,
        'time_start' => $timeStart,
        'time_end' => $timeEnd,
        'kegiatan' => $data->kegiatan,
        'keterangan' => $data->keterangan,
    ];

    return view('jurnal.edit', [
        'data' => $data,
    ]);
}

    /**
     * Update the specified resource in storage.
     */
    public function update($id, Request $request)
    {
        $data = $this->model->findOrFail($id);

        $validatedData = $request->validate([
            // 'siswa_id' => 'required',
            'tanggal' => 'required|string',
            'time_start' => 'required|string',
            'time_end' => 'required|string',
            'kegiatan' => 'required',
            'keterangan' => 'required',
        ]);

        $siswa = Siswa::where('user_id', auth()->user()->id)->first();
        $siswa_id = $siswa->id;

        $update = collect($validatedData);
        $update->put('tanggal_waktu', $validatedData['tanggal'] . " " . $validatedData['time_start'] . " - " . $validatedData['time_end']);
        $update->put('siswa_id', $siswa_id);
        $data->update($update->toArray());

        return redirect('jurnal')->with('status', 'Data berhasil ditambah!');
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

    public function show2($id, Jurnal $jurnal)
    {
        $siswa = Siswa::where('user_id', auth()->user()->id)->first();
        $izin = Izin::with('siswa.kelas.jurusan')->findOrFail($id);


        return view('jurnal.show2', [
            'izin' => $izin,
        ]);
    }
}
