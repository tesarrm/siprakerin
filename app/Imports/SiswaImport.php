<?php

namespace App\Imports;

use App\Models\Kelas;
use App\Models\Siswa;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;



class SiswaImport implements ToCollection, WithHeadingRow
{
    protected $errors = [];

    public function collection(Collection $rows)
    {
        foreach ($rows as $row){
            // Membuat array nama kelas yang valid
            $kelas = Kelas::with('jurusan')->get();

            $validKelas = $kelas->map(function ($k) {
                return $k->nama . " " . $k->jurusan->singkatan . " " . $k->klasifikasi;
            })->toArray();

            // Validasi setiap baris data
            $validator = Validator::make($row->toArray(), [
                'kelas' => [
                    'required',
                    'in:' . implode(',', $validKelas), 
                ],
                'nis' => 'required',
                'nama' => 'required',
                'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
                'email' => 'required|string|unique:users,email|max:255',
            ]);

            // relasi kelas
            $kelas = Kelas::with('jurusan.bidangKeahlian')
                ->get()
                ->first(function ($k) use ($row) {
                    // Gabungkan nama kelas dengan jurusan dan klasifikasi untuk dibandingkan
                    $nama = $k->nama . " " . $k->jurusan->singkatan . " " . $k->klasifikasi;
                    return $row['kelas'] == $nama; // Bandingkan nama yang sudah dibentuk dengan row
                });


            // Jika validasi gagal, tambahkan error ke dalam array $errors
            if ($validator->fails()) {
                $this->errors[] = $validator->errors()->all();
                continue; // lewati row ini jika validasi gagal
            }

            // buat data user
            $user = User::create([
                'name' => $row['nama'], 
                'email' => $row['email'],
                'password' => Hash::make('password123#'), 
            ]);

            // assign role
            $user->assignRole('siswa');

            // create
            Siswa::create([
                'user_id' => $user->id,
                'kelas_id' => $kelas->id,
                'nis' => $row['nis'],
                'nisn' => $row['nisn'],
                // 'nama_lengkap' => $row['nama'],
                // 'nama' => $row['nama'],
                'tempat_lahir' => $row['tempat_lahir'],
                'tanggal_lahir' => $row['tanggal_lahir'],
                'jenis_kelamin' => $row['jenis_kelamin'],
                'agama' => $row['agama'],
                'alamat' => $row['alamat'],
                'no_telp' => $row['no_telp'],
            ]);
        }

        if (!empty($this->errors)) {
            throw ValidationException::withMessages($this->errors);
        }
    }


}
