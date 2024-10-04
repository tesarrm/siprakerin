<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Izin;
use App\Models\Jurnal;
use App\Models\PenempatanIndustri;
use App\Models\Siswa;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpKernel\Event\ResponseEvent;

class AttendanceController extends Controller
{
    public function index()
    {
        $attendances = Attendance::all();
        return view('attendance', compact('attendances'));
    }

    public function getAttendanceData()
    {
        $attendances = Attendance::all()->map(function ($attendance) {
            return [
                'title' => $attendance->status,
                'start' => $attendance->date,
            ];
        });

        return response()->json($attendances);
    }

// Masalah Autentikasi: Anda menggunakan auth()->user() dalam fungsi storeCron(), 
// yang mungkin tidak dapat mengambil pengguna yang terautentikasi 
// saat dijalankan dari scheduler. Karena scheduler tidak menjalankan 
// dalam konteks pengguna yang terautentikasi, ini bisa menjadi penyebab kegagalan.

    // public static function storeCron()
    // {
    //     $yesterday = Carbon::yesterday();
    //     // $yesterday= Carbon::now()->subDays(4);
    //     $jurnal = Jurnal::whereDate('created_at', $yesterday)->first();
    //     $izin = Izin::whereDate('created_at', $yesterday)->first();
    //     $siswa = Siswa::where('user_id', auth()->user()->id)->first();
    //     $penempatan = PenempatanIndustri::with('industri.libur')->where('siswa_id', $siswa->id)->first();
    //     $libur = $penempatan->industri->libur;
        

    //     $currentYear = Carbon::now()->year;
    //     $responseCurrentYear = Http::get('https://api-harilibur.vercel.app/api', [
    //         'year' => strval($currentYear),
    //     ]);

    //     if ($responseCurrentYear->successful()) {
    //         $dataCurrentYear = $responseCurrentYear->json();
    //     } else {
    //         dd('Error: ' . $responseCurrentYear->status());
    //     }

    //     // cek apakah kemarin tanggal merah
    //     // $fiveDaysAgo = Carbon::now()->subDays(19)->toDateString();
    //     // $isHoliday = ['is_national_holiday' => false];
    //     $isYesterdayLT = false;

    //     foreach ($dataCurrentYear as $holiday) {
    //         if ($holiday['holiday_date'] === $yesterday->toDateString() && $holiday['is_national_holiday']) {
    //             // Jika tanggal 5 hari lalu adalah libur nasional
    //             // $isHoliday = [
    //             //     'is_national_holiday' => true,
    //             //     'holiday_name' => $holiday['holiday_name']
    //             // ];
    //             $isYesterdayLT = true;
    //         } 
    //     }

    //     // cek apakah kemarin hari libur
    //     $dayName = strtolower($yesterday->locale('id')->dayName);
    //     $isYesterdayLM = false;

    //     if (isset($libur[$dayName]) && $libur[$dayName] === 'on') {
    //         $isYesterdayLM = true;
    //     } 

    //     // create
    //     $status = '';
    //     if ($jurnal) {
    //         $status = 'hadir';
    //     } else if ($izin) {
    //         $status = 'izin';
    //     } else {
    //         if ($isYesterdayLT || $isYesterdayLM) {
    //             $status = 'libur';
    //         } else {
    //             $status = 'alpa';
    //         }
    //     }

    //     Attendance::create([
    //         'date' => $yesterday->toDateString(),
    //         'status' => $status,
    //     ]);

    //     return response()->json('ok');
    // }


    // # SYARAT
    // 1. Siswa yang sudah ditempatkan
    // 2. Siswa yang masih dalam periode PKL
    public static function storeCron()
    {
        $yesterday = Carbon::yesterday();

        // Ambil semua siswa
        $siswas = Siswa::all();

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

        // Cek apakah kemarin adalah tanggal merah
        $isYesterdayLT = false;
        foreach ($dataCurrentYear as $holiday) {
            if ($holiday['holiday_date'] === $yesterday->toDateString() && $holiday['is_national_holiday']) {
                $isYesterdayLT = true;
            }
        }

        foreach ($siswas as $siswa) {
            $penempatan = PenempatanIndustri::with('industri.libur')->where('siswa_id', $siswa->id)->first();

            if($penempatan) {
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

                // Cek apakah kemarin di antara atau sama dengan tanggalAwal dan tanggalAkhir
                if ($yesterday->isBetween($tanggalAwal, $tanggalAkhir, null, '[]')) { // '[]' berarti inklusif
      
                    $libur = $penempatan->industri->libur ?? [];

                    // Cek apakah kemarin hari libur
                    $dayName = strtolower($yesterday->locale('id')->dayName);
                    $isYesterdayLM = isset($libur[$dayName]) && $libur[$dayName] === 'on';

                    // Ambil jurnal dan izin untuk siswa saat ini
                    $jurnal = Jurnal::whereDate('created_at', $yesterday)->where('siswa_id', $siswa->id)->first();
                    $izin = Izin::whereDate('created_at', $yesterday)->where('siswa_id', $siswa->id)->first();

                    // Tentukan status
                    $status = '';
                    if ($jurnal) {
                        $status = 'hadir';
                    } elseif ($izin) {
                        $status = 'izin';
                    } else {
                        if ($isYesterdayLT || $isYesterdayLM) {
                            $status = 'libur';
                        } else {
                            $status = 'alpa';
                        }
                    }

                    // Buat entri kehadiran
                    Attendance::create([
                        'date' => $yesterday->toDateString(),
                        'status' => $status,
                        'siswa_id' => $siswa->id, // Pastikan untuk mengaitkan dengan siswa
                    ]);

                }
 
            }
        }
        return response()->json('ok');
    }
}
