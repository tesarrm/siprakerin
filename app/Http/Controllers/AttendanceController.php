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

    public function getAttendanceData(Request $request)
    {
        $id = $request->query('id');



        if($id) {
            $attendances = Attendance::where('siswa_id', $id)->get()->map(function ($attendance) {
                return [
                    'title' => $attendance->status,
                    'start' => $attendance->date,
                ];
            });

            return response()->json($attendances);
        } else {
            $siswa= Siswa::where('user_id', auth()->user()->id)->first();

            $attendances = Attendance::where('siswa_id', $siswa->id)->get()->map(function ($attendance) {
                return [
                    'title' => $attendance->status,
                    'start' => $attendance->date,
                ];
            });

            return response()->json($attendances);
        }
    }

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

        // biar tnaggal ngga ada 0nya
        $yesterdayFormatted = $yesterday->format('Y-m-j');


        // Cek apakah kemarin adalah tanggal merah
        $isYesterdayLT = false;
        foreach ($dataCurrentYear as $holiday) {
            if ($holiday['holiday_date'] == $yesterdayFormatted && $holiday['is_national_holiday']) {
                $isYesterdayLT = true;
            }
        }

        // dd($dataCurrentYear);

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

                $tanggalAwal = Carbon::createFromFormat('j F Y', $tanggalAwal)->subDay();
                $tanggalAkhir = Carbon::createFromFormat('j F Y', $tanggalAkhir)->addDay();


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
                        'siswa_id' => $siswa->id, 
                    ]);
                }
            }
        }
        return response()->json('ok');
    }
}
