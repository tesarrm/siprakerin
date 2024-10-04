<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Guru;
use App\Models\Industri;
use App\Models\Izin;
use App\Models\Jurnal;
use App\Models\Kelas;
use App\Models\PenempatanIndustri;
use App\Models\Siswa;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

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
    // pengejekan lebih 1 jam dari pergantian hari

    // if($jurnal) {
    //     // hadir
    // } else if($izin) {
    //     // izin
    // } else {
    //     // antara libur atau alpa
    //     if($tanggal_merah || $libur_mingguan) {
    //         //libur
    //     } else {
    //         // alpa
    //     }
    // }

    public function index()
    {
        $siswa = Siswa::where('user_id', auth()->user()->id)->first();
        $penempatan = PenempatanIndustri::with('industri.libur')->where('siswa_id', $siswa->id)->first();
        $dIzin = Izin::with('siswa.kelas.jurusan')->where('siswa_id', $siswa->id)->get();
        $attendances = Attendance::where('siswa_id', $siswa->id)->get();
        $hadir = Attendance::where([
            'siswa_id' => $siswa->id, 
            'status' => 'hadir'
            ])->get();
        $izin = Attendance::where([
            'siswa_id' => $siswa->id, 
            'status' => 'izin'
            ])->get();
        $libur = Attendance::where([
            'siswa_id' => $siswa->id, 
            'status' => 'libur'
            ])->get();
        $alpa = Attendance::where([
            'siswa_id' => $siswa->id, 
            'status' => 'alpa'
            ])->get();

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

        // Ganti nama bulan dalam string tanggal_akhir
        $tanggalAwal = strtr($penempatan->industri->tanggal_awal, $months);
        $tanggalAkhir = strtr($penempatan->industri->tanggal_akhir, $months);

        // Mengubah string ke objek Carbon
        $tanggalAwal = Carbon::createFromFormat('j F Y', $tanggalAwal);
        $tanggalAkhir = Carbon::createFromFormat('j F Y', $tanggalAkhir);

        // Mengambil tanggal hari ini
        $tanggalHariIni = Carbon::now();

        // Hitung selisih hari
        $selisihHariSampaiHariIni = $tanggalHariIni->diffInDays($tanggalAwal);
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
            'sisa_hari' => $selisihHariDariHariIni,
            'attendances' => $attendances,
            'dataIzin' => $dIzin,
            'hadir' => $hadir,
            'izin' => $izin,
            'libur' => $libur,
            'alpa' => $alpa,
        ]);
    }


    public function _index()
    {
        $siswa = Siswa::where('user_id', auth()->user()->id)->first();
        $izin = Izin::with('siswa.kelas.jurusan')->where('siswa_id', $siswa->id)->get();
        $penempatan = PenempatanIndustri::with('industri.libur')->where('siswa_id', $siswa->id)->first();
        $attendances = Attendance::all();

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

        // alpa = (awal sampai hari ini) - (hadir + izin + libur)
        // libur = total libur mingguan + libur tanggal merah (tanpa double)

        // ==================================================================================
        // 1. ambil tanggal libur mingguan selama pkl sampai hari ini
        // hasil: $liburDates
        // ==================================================================================

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

        $tanggalAwal = strtr($penempatan->industri->tanggal_awal, $months);
        $tanggalAkhir = strtr($penempatan->industri->tanggal_akhir, $months);

        $tanggalAwal = Carbon::createFromFormat('j F Y', $tanggalAwal);
        $tanggalAkhir = Carbon::createFromFormat('j F Y', $tanggalAkhir);

        $tanggalHariIni = Carbon::now();

        // Hitung selisih hari
        $selisihHariSampaiHariIni = $tanggalHariIni->diffInDays($tanggalAwal);
        $selisihHariDariHariIni = $tanggalHariIni->diffInDays($tanggalAkhir);

        // hari libur industri sampai hari ini
        $libur = $penempatan->industri->libur;

        $totalLibur = 0;
        $currentDate = $tanggalAwal->copy(); // Salin tanggal awal untuk iterasi
        $liburDates = []; // Array untuk menyimpan tanggal libur

        // Iterasi dari tanggal awal hingga tanggal hari ini
        while ($currentDate->lte($tanggalHariIni)) {
            // Dapatkan nama hari (contoh: 'Senin', 'Selasa', ...)
            $hari = strtolower($currentDate->locale('id')->isoFormat('dddd')); // Gunakan format sesuai bahasa Indonesia

            // Cek apakah hari tersebut adalah hari libur
            if (isset($libur[$hari]) && $libur[$hari] === 'on') {
                $totalLibur++;
                $liburDates[] = $currentDate->format('d-m-Y'); // Simpan tanggal libur dalam format yang diinginkan
            }

            // Pindah ke tanggal berikutnya
            $currentDate->addDay();
        }

        // return response()->json($liburDates);

        // ==================================================================================
        // 2. ambil tanggal merah selama 3 tahun, tahun lalu, tahun sekarang, tahun depan
        // hasil: allData
        // ==================================================================================

        // Mendapatkan tahun sekarang, tahun lalu, dan tahun depan
        $currentYear = Carbon::now()->year;
        $lastYear = Carbon::now()->subYear()->year;
        $nextYear = Carbon::now()->addYear()->year;

        // Panggil API untuk tahun sekarang
        $responseCurrentYear = Http::get('https://api-harilibur.netlify.app/api', [
            'year' => strval($currentYear),
        ]);
        // Panggil API untuk tahun lalu
        $responseLastYear = Http::get('https://api-harilibur.netlify.app/api', [
            'year' => strval($lastYear),
        ]);
        // Panggil API untuk tahun depan
        $responseNextYear = Http::get('https://api-harilibur.netlify.app/api', [
            'year' => strval($nextYear),
        ]);

        // Cek jika semua request berhasil
        if ($responseCurrentYear->successful() && $responseLastYear->successful() && $responseNextYear->successful()) {
            // Ambil data dari masing-masing response
            $dataCurrentYear = $responseCurrentYear->json();
            $dataLastYear = $responseLastYear->json();
            $dataNextYear = $responseNextYear->json();

            // Gabungkan data menjadi satu array
            $allData = array_merge($dataCurrentYear, $dataLastYear, $dataNextYear);

            // Debug untuk melihat hasil
            // dd($allData);
        } else {
            // Jika salah satu request gagal, tampilkan pesan error
            dd('Error: ' . $responseCurrentYear->status() . ', ' . $responseLastYear->status() . ', ' . $responseNextYear->status());
        }

        // return response()->json($allData);

        // ==================================================================================
        // 3. check apakah libur mingguan ada yang double dengan libur tanggal merah. jika ada maka dikurangi
        // hasil: $totalLiburT
        // ==================================================================================

        $liburDates = array_map(function($date) {
            return \Carbon\Carbon::createFromFormat('d-m-Y', $date)->format('Y-m-d');
        }, $liburDates);

        // Filter hanya hari libur nasional
        $nationalHolidays = array_filter($allData, function($holiday) {
            return $holiday['is_national_holiday'] === true;
        });

        // Ambil tanggal dari hari libur nasional
        $nationalHolidayDates = array_map(function($holiday) {
            return \Carbon\Carbon::parse($holiday['holiday_date'])->format('Y-m-d');
        }, $nationalHolidays);

        // Cek apakah ada tanggal yang sama di $liburDates dan $nationalHolidayDates
        $matchingDates = array_intersect($liburDates, $nationalHolidayDates);

        $totalLiburT = $totalLibur - count($matchingDates);

        // dd($matchingDates);

        // ==================================================================================
        // 4. check apakah ada tanggal merah di luar libur mingguan dalam jangka waktu awal pkl sampai hari ini. jika ada maka tambahkan
        // ==================================================================================

        // ==================================================================================
        // 5. menghitung alpa dari: $alpa = $selisihHariSampaiHariIni - $data->count() #hadir - $izin->count() - $libur
        // ==================================================================================

        $tanggalAwal = Carbon::parse($tanggalAwal);
        $tanggalHariIni = Carbon::parse($tanggalHariIni);

        // Filter $allData berdasarkan tanggal dan hari libur nasional
        $filteredData = array_filter($allData, function ($holiday) use ($tanggalAwal, $tanggalHariIni) {
            // Pastikan format tanggal dari API sesuai, misal 'holiday_date' sebagai contoh
            $holidayDate = Carbon::parse($holiday['holiday_date']); // Sesuaikan dengan kunci tanggal pada data API
            
            // Hanya pilih hari libur yang merupakan hari libur nasional dan berada di antara $tanggalAwal dan $tanggalHariIni
            return $holidayDate->between($tanggalAwal, $tanggalHariIni) && $holiday['is_national_holiday'] === true;
        });

        // Debug untuk melihat hasil filter
        // dd($filteredData);
        
        // TODO: mendapatkan libur (mingguan, dan tanggal merah) tanpa double
        
        // mencari alpa
        $libur = $totalLibur - count($filteredData);

        // dd($libur);
        $alpa = $selisihHariSampaiHariIni - $data->count() - $izin->count() - $libur;

        dd($alpa);


        return view('jurnal.index', [
            'data' => $data,
            'izin' => $izin,
            'sisa_hari' => $selisihHariDariHariIni,
            'attendances' => $attendances,
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
    
// public function create()
// {
//     // Ambil data siswa berdasarkan user yang login
//     $siswa = Siswa::where('user_id', auth()->user()->id)->first();
//     $penempatan = PenempatanIndustri::with(['industri.libur'])->where('siswa_id', $siswa->id)->first();

//     // Ambil hari ini
//     $hariIni = Carbon::now()->isoFormat('dddd'); // Mendapatkan hari dalam format penuh, misalnya: Senin, Selasa, dll.

//     // Mapping hari ke dalam bahasa Inggris yang sesuai dengan field database
//     $hariMapping = [
//         'Monday' => 'senin',
//         'Tuesday' => 'selasa',
//         'Wednesday' => 'rabu',
//         'Thursday' => 'kamis',
//         'Friday' => 'jumat',
//         'Saturday' => 'sabtu',
//         'Sunday' => 'minggu',
//     ];

//     // Ambil libur hari ini berdasarkan mapping
//     $hariField = $hariMapping[$hariIni] ?? null; // Jika hari tidak ada di mapping, set null

//     // Deteksi apakah hari ini libur
//     $libur = ($hariField && $penempatan->industri->libur->{$hariField} === 'on') ? true : false;

//     return view('jurnal.add', compact(['penempatan', 'libur']));
// }

public function create()
{
    $siswa = Siswa::where('user_id', auth()->user()->id)->first();
    $penempatan = PenempatanIndustri::with(['industri.libur'])->where('siswa_id', $siswa->id)->first();

    // Cek apakah hari libur mingguan
    $hariLibur = $penempatan->industri->libur ?? [];
    $hariIni = Carbon::now();
    $dayName = strtolower($hariIni->locale('id')->dayName);

    $isLM = isset($hariLibur[$dayName]) && $hariLibur[$dayName] === 'on';


    // Ambil data libur untuk tahun ini
    $currentYear = Carbon::now()->year;
    $responseCurrentYear = Http::get('https://api-harilibur.vercel.app/api', [
        'year' => strval($currentYear),
    ]);

    if ($responseCurrentYear->successful()) {
        $dataCurrentYear = $responseCurrentYear->json();
    } else {
        dd('Error: ' . $responseCurrentYear->status());
    }

    // Cek apakah tanggal merah
    $isLT = false;
    foreach ($dataCurrentYear as $holiday) {
        if ($holiday['holiday_date'] === $hariIni->toDateString() && $holiday['is_national_holiday']) {
            $isLT = true;
        }
    }

    // apakah libur atau tanggal merah
    $libur = $isLM || $isLT;

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
