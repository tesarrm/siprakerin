<?php

namespace App\Imports;

use App\Models\Siswa;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class SiswaExport implements FromQuery, WithMapping, WithHeadings, WithStyles
{
    use Exportable;

    public function query()
    {
        return Siswa::query();
    }

    public function map($siswa): array
    {
        return [
            $siswa->nis,
            $siswa->nisn,
            $siswa->nama,
            $siswa->user->email,
            $siswa->kelas->nama . " " . $siswa->kelas->jurusan->singkatan . " " . $siswa->kelas->klasifikasi,
            $siswa->tempat_lahir,
            $siswa->tanggal_lahir,
            $siswa->jenis_kelamin,
            $siswa->agama,
            $siswa->alamat,
            $siswa->no_telp,
        ];
    }

    public function headings(): array
    {
        return [
            'NIS',
            'NISN',
            'NAMA',
            'EMAIL',
            'KELAS',
            'TEMPAT_LAHIR',
            'TANGGAL_LAHIR',
            'JENIS_KELAMIN',
            'AGAMA',
            'ALAMAT',
            'NO_TELP',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}
