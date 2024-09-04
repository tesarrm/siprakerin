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
            $guru->nama_guru,
        ];
    }

    public function headings(): array
    {
        return [
            'NIP',
            'Nama'
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
            1 => ['font' => ['bold' => true, 'size' => 12]],
        ];
    }
}
