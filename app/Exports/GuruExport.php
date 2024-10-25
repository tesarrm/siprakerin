<?php

namespace App\Exports;

use App\Models\Guru;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class GuruExport implements FromQuery, WithMapping, WithHeadings, WithStyles
{
    use Exportable;

    /**
    * @return \Illuminate\Support\Collection
    */
    public function query()
    {
        return Guru::query();
    }

    public function map($guru): array
    {
        return [
            $guru->nip,
            $guru->no_ktp,
            $guru->nama,
            $guru->user->email,
            $guru->tempat_lahir,
            $guru->tanggal_lahir,
            $guru->jenis_kelamin,
            $guru->golongan_darah,
            $guru->kecamatan,
            $guru->alamat,
            $guru->rt,
            $guru->rw,
            $guru->kode_pos,
            $guru->no_telp,
            $guru->no_hp,
            $guru->agama,
        ];
    }

    public function headings(): array
    {
        return [
            'NIP',
            'NO_KTP',
            'NAMA',
            'EMAIL',
            'TEMPAT_LAHIR',
            'TANGGAL_LAHIR',
            'JENIS_KELAMIN',
            'GOLONGAN_DARAH',
            'KECAMATAN',
            'ALAMAT',
            'RT',
            'RW',
            'KODE_POST',
            'NO_TELP',
            'NO_HP',
            'AGAMA',
        ];
    }

    /**
     * Apply styles to the spreadsheet.
     *
     * @param Worksheet $sheet
     * @return array
     */
    public function styles(Worksheet $sheet)
    {
        return [
            // Styling the first row as a header row
            // 1 => ['font' => ['bold' => true, 'size' => 12]],
            1 => ['font' => ['bold' => true]],
        ];
    }
}
