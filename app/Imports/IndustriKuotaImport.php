<?php

namespace App\Imports;

use App\Models\Industri;
use App\Models\Jurusan;
use App\Models\Kota;
use App\Models\KuotaIndustri;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class IndustriKuotaImport implements ToCollection, WithHeadingRow
{
    /**
    * @param Collection $collection
    */
    protected $errors = [];

    public function collection(Collection $rows)
    {
        // syarat:
        // - kota sudah diisi dan harus sama persis dengan yang ada di excel
        // - jurusan harus sama persis dengan jurusan yang ada di sistem
        // - urutan kuota jurusan dari laki-laki dulu baru perempuan

        // urutan:
        // - membuat industri
        // - mengisi kuotanya

        foreach ($rows as $index => $row){
            // membuat valid kota 
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
                'nama_akun' => 'nullable',
                'username' => 'required',
                'email' => 'nullable|string|unique:users,email|max:255',
                'no_telp' => 'nullable|string|max:255',
                'no_hp' => 'nullable|string|max:255',
                'keterangan' => 'nullable',
            ]);
            // validasi harus ada salah satu dari username, email, no_telp, no_hp
            $validator->after(function ($validator) use ($row) {
                if (
                    empty($row['username']) && 
                    empty($row['email']) && 
                    empty($row['no_telp']) && 
                    empty($row['no_hp'])
                ) {
                    $validator->errors()
                        ->add('required_fields', 
                            'Salah satu dari usename, email, no telp atau no HP harus diisi.');
                }
            });
            // Jika validasi gagal, tambahkan nomor baris ke dalam error
            if ($validator->fails()) {
                foreach ($validator->errors()->all() as $message) {
                    $this->errors[] = "Row " . ($index + 2) . ": " . $message;
                }
                continue; // lewati row ini jika validasi gagal
            }

            // buat user industri
            $user = User::create([
                'name' => $row['nama_akun'] ?? $row['nama'], 
                'username' => $row['username'],
                'email' => $row['email'],
                'password' => Hash::make('password'), 
            ]);
            // assign role
            $user->assignRole('industri');

            // get kuota yg sama dari row
            $kota = Kota::where('nama', $row['kota'])->first();
            // buat industri 
            $industri = Industri::create([
                'user_id' => $user->id,
                'kota_id' => $kota->id,
                'nama' => $row['nama'],
                'alamat' => $row['alamat'],
                'no_telp' => $row['no_telp'],
                'no_hp' => $row['no_hp'],
                'keterangan' => $row['keterangan'],
            ]);

            // ======================================
            // KUOTA INDUSTRI 
            // ======================================

            $jurusanList = Jurusan::doesntHave('jurusans')->get()->keyBy('singkatan'); // Mengambil semua jurusan dan mengindeks dengan nama jurusan

            // dd($jurusanList);

            // Iterasi kuota berdasarkan jurusan laki-laki dan perempuan
            foreach ($jurusanList as $jurusan) {
                // dd($row[strtolower('L_'.'DKV')]);
                // dd($row);
                // Ambil kuota laki-laki dan perempuan dari row
                $kuotaLaki = $row[strtolower('L_' . $jurusan->singkatan)] ?? 0; // Ambil kuota laki-laki
                $kuotaPerempuan = $row[strtolower('P_' . $jurusan->singkatan)] ?? 0; // Ambil kuota perempuan

                // Cek jika kuota laki-laki lebih dari 0
                if ($kuotaLaki > 0) {
                    KuotaIndustri::create([
                        'industri_id' => $industri->id,
                        'jurusan_id' => $jurusan->id, // Ambil ID dari model jurusan
                        'jenis_kelamin' => 'Laki-laki',
                        'kuota' => $kuotaLaki,
                    ]);
                }

                // Cek jika kuota perempuan lebih dari 0
                if ($kuotaPerempuan > 0) {
                    KuotaIndustri::create([
                        'industri_id' => $industri->id,
                        'jurusan_id' => $jurusan->id, // Ambil ID dari model jurusan
                        'jenis_kelamin' => 'Perempuan',
                        'kuota' => $kuotaPerempuan,
                    ]);
                }
            }
        }
        if (!empty($this->errors)) {
            throw ValidationException::withMessages($this->errors);
        }
    }
}
