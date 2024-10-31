<?php

namespace App\Imports;

use App\Models\Guru;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class GuruImport implements ToCollection, WithHeadingRow
{
    protected $errors = [];

    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function collection(Collection $rows)
    {
        foreach ($rows as $index => $row){
            // // Validasi setiap baris data
            // $validator = Validator::make($row->toArray(), [
            //     'nip' => 'required',
            //     'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            // ]);
            // // Terapkan validasi unique hanya jika email ada
            // $validator->sometimes('email', 'required|string|email|unique:users,email|max:255', function ($input) {
            //     return !empty($input->email);
            // });
            // // Terapkan validasi unique hanya jika username ada
            // $validator->sometimes('username', 'required|string|unique:users,username|max:255', function ($input) {
            //     return !empty($input->username);
            // });
            // // Jika validasi gagal, tambahkan error ke dalam array $errors
            // if ($validator->fails()) {
            //     $this->errors[] = $validator->errors()->all();
            //     continue; // lewati row ini jika validasi gagal
            // }

            // Validasi setiap baris data
            $validator = Validator::make($row->toArray(), [
                // 'nip' => 'required_without_all:email,username',
                // 'jenis_kelamin' => 'required|in:L,P',

                // 'email' => 'nullable|string|email|unique:users,email|max:255',
                // 'username' => 'nullable|string|unique:users,username|max:255',
                'nip' => 'nullable',
                'jenis_kelamin' => 'required|in:L,P',
                'email' => 'nullable|string|email|max:255|unique:users,email',
                'username' => 'nullable|string|max:255|unique:users,username',
            ]);

            // Tambahkan validasi untuk memastikan salah satu dari email, username, atau nip harus ada
            $validator->after(function ($validator) use ($row) {
                if (empty($row['email']) && empty($row['username']) && empty($row['nip'])) {
                    $validator->errors()->add('required_fields', 'Salah satu dari email, username, atau NIP harus diisi.');
                }
            });


            // // Jika validasi gagal, tambahkan error ke dalam array $errors
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

            // Konversi Collection menjadi array
            $rowArray = $row->toArray();
            // Inisialisasi data untuk User
            $userData = [
                'name' => $rowArray['nama'],
                'password' => Hash::make('password'),
            ];
            // Tambahkan email jika kunci 'email' ada dan tidak kosong
            if (array_key_exists('email', $rowArray) && !empty($rowArray['email'])) {
                $userData['email'] = $rowArray['email'];
            }
            // Tambahkan username jika kunci 'username' ada dan tidak kosong
            if (array_key_exists('username', $rowArray) && !empty($rowArray['username'])) {
                $userData['username'] = $rowArray['username'];
            }
            // Buat data User dengan data yang valid
            $user = User::create($userData);
            // assign role
            $user->assignRole('guru');

            // create
            Guru::create([
                'user_id' => $user->id,
                'nip' => $row['nip'],
                'no_ktp' => $row['no_ktp'],
                'nama' => $row['nama'],
                'tempat_lahir' => $row['tempat_lahir'],
                'tanggal_lahir' => $row['tanggal_lahir'],
                'jenis_kelamin' => $row['jenis_kelamin'] == 'L' ? 'Laki-laki' : 'Perempuan',
                'golongan_darah' => $row['golongan_darah'],
                'kecamatan' => $row['kecamatan'],
                'alamat' => $row['alamat'],
                'rt' => $row['rt'],
                'rw' => $row['rw'],
                'kode_pos' => $row['kode_pos'],
                'no_telp' => $row['no_telp'],
                'no_hp' => $row['no_hp'],
                'agama' => $row['agama'],
            ]);

        }

        if (!empty($this->errors)) {
            throw ValidationException::withMessages($this->errors);
        }
    }
}
