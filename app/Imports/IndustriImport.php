<?php

namespace App\Imports;

use App\Models\Industri;
use App\Models\Kota;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class IndustriImport implements ToCollection, WithHeadingRow
{
    protected $errors = [];

    public function collection(Collection $rows)
    {

        foreach ($rows as $index => $row){
            // membuat array nama kelas yang valid
            $kota = Kota::get();

            $validKota = $kota->map(function ($k) {
                return $k->nama;
            })->toArray();

            // Validasi setiap baris data
            $validator = Validator::make($row->toArray(), [
                'nama' => 'required',
                'alamat' => 'nullable',
                'kota' => [
                    'required',
                    'in:' . implode(',', $validKota), 
                ],

                'username' => 'required',
                'nama_akun' => 'nullable',
                'email' => 'nullable|string|unique:users,email|max:255',
            ]);

            // Jika validasi gagal, tambahkan error ke dalam array $errors
            // if ($validator->fails()) {
            //     $this->errors[] = $validator->errors()->all();
            //     continue; // lewati row ini jika validasi gagal
            // }

            // Jika validasi gagal, tambahkan nomor baris ke dalam error
            if ($validator->fails()) {
                foreach ($validator->errors()->all() as $message) {
                    $this->errors[] = "Row " . ($index + 1) . ": " . $message;
                }
                continue; // lewati row ini jika validasi gagal
            }


            // buat data user
            $user = User::create([
                'name' => $row['nama'], 
                'username' => $row['username'],
                'email' => $row['email'],
                'password' => Hash::make('password'), 
            ]);
            // assign role
            $user->assignRole('industri');

            $kota = Kota::where('nama', $row['kota'])->first();

            // create
            Industri::create([
                'user_id' => $user->id,
                'kota_id' => $kota->id,
                'nama' => $row['nama'],
                'alamat' => $row['alamat'],
            ]);
        }

        if (!empty($this->errors)) {
            throw ValidationException::withMessages($this->errors);
        }
    }
}
