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
        if(auth()->user()->hasRole('wali_kelas')){
            $guru = Guru::where('user_id', auth()->user()->id)->first();
            $kelas = Kelas::where('guru_id', $guru->id)->first();

            // Filter jurnal berdasarkan kelas
            $data = Jurnal::whereHas('siswa.kelas', function ($query) use ($kelas) {
                $query->where('kelas.id', $kelas->id);
            })->with('siswa.kelas')->get();

            $kelas = Kelas::with('jurusan')->get();

            return view('jurnal.index', [
                'data' => $data,
                'kelas' => $kelas,
            ]);
        } else if(auth()->user()->hasRole('siswa')) {
            $siswa = Siswa::where('user_id', auth()->user()->id)->first();
            $penempatan = PenempatanIndustri::with('industri.libur')->where('siswa_id', $siswa->id)->first();
            $dIzin = Izin::with('siswa.kelas.jurusan')
                ->where('siswa_id', $siswa->id)
                ->orderBy('created_at', 'desc')
                ->get();
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

            $data = Jurnal::with('siswa.kelas')
                ->where('siswa_id', $siswa->id)
                ->orderBy('created_at', 'desc')
                ->get();

            // hanya satu kali dalam sehari
            $jurnalToDay = Jurnal::whereDate('created_at', Carbon::today())->where('siswa_id', $siswa->id)->first();
            $izinToDay = Izin::whereDate('created_at', Carbon::today())->where('siswa_id', $siswa->id)->first();
            $lebih = isset($jurnalToDay) || isset($izinToDay);

            return view('jurnal.index', [
                'data' => $data,
                'lebih' => $lebih,
                'sisa_hari' => $selisihHariDariHariIni,
                'attendances' => $attendances,
                'dataIzin' => $dIzin,
                'hadir' => $hadir,
                'izin' => $izin,
                'libur' => $libur,
                'alpa' => $alpa,
                'penempatan' => $penempatan,
            ]);
        } else {
            // $data = Jurnal::with(['siswa.kelas', 'siswa.penempatan.industri'])->get();
            $data = [];
            $kelas = Kelas::with('jurusan')->get();
            $dIzin = Izin::with('siswa.kelas.jurusan')
                ->orderBy('created_at', 'desc')
                ->get();

            return view('jurnal.index', [
                'data' => $data,
                'kelas' => $kelas,
                'dataIzin' => $dIzin,
            ]);
        }

    }

    public function create()
    {
        $siswa = Siswa::where('user_id', auth()->user()->id)->first();
        $penempatan = PenempatanIndustri::with(['industri.libur'])->where('siswa_id', $siswa->id)->first();

        // Cek apakah hari libur mingguan
        $hariLibur = $penempatan->industri->libur ?? [];
        $hariIni = Carbon::now();
        // $hariIni = Carbon::parse('2024-10-2');
        // dd($hariIni->toDateString());
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

        // dd($dataCurrentYear);

        // Cek apakah tanggal merah
        $isLT = false;
        foreach ($dataCurrentYear as $holiday) {
            if ($holiday['holiday_date'] == $hariIni->toDateString() && $holiday['is_national_holiday']) {
                $isLT = true;
            }
        }

        // apakah libur atau tanggal merah
        $libur = $isLM || $isLT;

        return view('jurnal.add', compact(['penempatan', 'libur']));
    }

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

        // hanya satu kali dalam sehari
        $jurnalToDay = Jurnal::whereDate('created_at', Carbon::today())->where('siswa_id', $siswa->id)->first();
        $izinToDay = Izin::whereDate('created_at', Carbon::today())->where('siswa_id', $siswa->id)->first();
        $lebih = isset($jurnalToDay) || isset($izinToDay);

        if ($lebih) {
            return redirect()->back()->with('error', 'Anda hanya dapat melakukan tindakan ini sekali dalam sehari.');
        }

        $create = collect($validatedData);
        $create->put('tanggal_waktu', $validatedData['tanggal'] . " " . $validatedData['time_start'] . " - " . $validatedData['time_end']);
        $create->put('siswa_id', $siswa->id);
        $this->model->create($create->toArray());
        
        // buat kehadiran hadir
        // Attendance::create([
        //     'siswa_id' => $siswa->id,
        //     'date' => Carbon::now(),
        //     'status' => 'hadir',
        // ]);

        return redirect('jurnal')->with('status', 'Data berhasil ditambah!');
    }

    public function show($id)
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

        return view('jurnal.show', [
            'data' => $data,
        ]);
    }

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

    public function destroy($id)
    {
        $data = $this->model->findOrFail($id);
        $data->delete();
        return response()->json(['success' => true]);
    }

    public function filter(Request $request)
    {
        $kelas = $request->kelas;

        $kelas = Kelas::with('jurusan.bidangKeahlian')
            ->get()
            ->first(function ($k) use ($kelas) {
                // Gabungkan nama kelas dengan jurusan dan klasifikasi untuk dibandingkan
                $nama = $k->nama . " " . $k->jurusan->singkatan . " " . $k->klasifikasi;
                return $kelas == $nama; // Bandingkan nama yang sudah dibentuk dengan row
            });

        // $siswa = Jurnal::with(['siswa.kelas', 'siswa.penempatan.industri'])->get();
        // // saya ingin filter siswa dari kelas id
        $siswa = Siswa::with(['kelas', 'user'])
            ->where('aktif', 1)
            ->where('kelas_id', $kelas->id) 
            ->orderBy('created_at', 'desc') 
            ->get();

        // Ambil data siswa dari Jurnal yang terhubung dengan kelas tertentu
        // $siswa = Jurnal::with(['siswa.kelas', 'siswa.penempatan.industri'])
        //     ->whereHas('siswa', function ($query) use ($kelas) {
        //         $query->where('kelas_id', $kelas->id); // Filter berdasarkan kelas_id
        //     })
        //     ->get();

        // $items = [];
        // foreach ($siswa as $d) {
        //     $items[] = [
        //         'nis' => $d->siswa->nis,
        //         'siswa' => $d->siswa->nama,
        //         'kelas' => $d->siswa->kelas->nama . " " . $d->siswa->kelas->jurusan->singkatan . " " . $d->siswa->kelas->klasifikasi ?? '-',
        //         'industri' => isset($d->siswa->penempatan->industri) ? $d->siswa->penempatan->industri->nama : '-',
        //         'tanggal_waktu' => $d->tanggal_waktu,
        //         'kegiatan' => $d->kegiatan,
        //         'keterangan' => $d->keterangan,
        //     ];
        // }

        // Return data dalam format JSON untuk di-render oleh simple-datatables
        return response()->json($siswa);
    }

    public function filterJurnal(Request $request)
    {
        // Ambil data siswa dari Jurnal yang terhubung dengan kelas tertentu
        $siswa = Jurnal::with(['siswa.kelas', 'siswa.penempatan.industri'])
            ->where('siswa_id', $request->siswa) 
            ->get();

        $items = [];
        foreach ($siswa as $d) {
            $items[] = [
                'nis' => $d->siswa->nis ?? '-',
                'siswa' => $d->siswa->nama_lengkap ?? '-',
                'kelas' => $d->siswa->kelas->nama . " " . $d->siswa->kelas->jurusan->singkatan . " " . $d->siswa->kelas->klasifikasi ?? '-',
                'industri' => isset($d->siswa->penempatan->industri) ? $d->siswa->penempatan->industri->nama : '-',
                'tanggal_waktu' => $d->tanggal_waktu ?? '-',
                'kegiatan' => $d->kegiatan ?? '-',
                'keterangan' => $d->keterangan ?? '-',
                'aksi' => $d->id,
            ];
        }

        // Return data dalam format JSON untuk di-render oleh simple-datatables
        return response()->json($items);
    }
}
