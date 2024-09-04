<?php

namespace App\Imports;

use App\Models\Guru;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class GuruImport implements ToCollection, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function collection(Collection $rows)
    {
        foreach ($rows as $row){
            Guru::create([
                'nip' => $row['nip'],
                'nama_guru' => $row['nama'],
            ]);
        }
    }
}
