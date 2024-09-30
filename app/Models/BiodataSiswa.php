<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BiodataSiswa extends Model
{
    use HasFactory;

    protected $fillable = [
        'siswa_id',
        // 'nama_lengkap',
        // 'nama',
        // 'nis',
        // 'nisn',
        // 'tempat_lahir',
        // 'tanggal_lahir',
        // 'agama',
        // 'alamat',
        'kode_pos',
        // 'no_hp',
        // 'jenis_kelamin',
        'golongan_darah',
        'tinggi_badan',
        'hobi',
        'keahlian',
        'organisasi',
        'tahun_awal_1',
        'tahun_akhir_1',
        'tempat_1',
        'berijasah_1',
        'tahun_awal_2',
        'tahun_akhir_2',
        'tempat_2',
        'berijasah_2',
        'tahun_awal_3',
        'tahun_akhir_3',
        'tempat_3',
        'berijasah_3',
        'ayah_nama',
        'ibu_nama',
        'ayah_usia',
        'ibu_usia',
        'ayah_pendidikan_terakhir',
        'ibu_pendidikan_terakhir',
        'ayah_pekerjaan',
        'ibu_pekerjaan',
        'ayah_alamat',
        'ibu_alamat',
        'ayah_no_telp',
        'ibu_no_telp',
        'nama_0',
        'alamat_0',
        'no_telp_0',
        'hub_keluarga_0',
        'nama_1',
        'alamat_1',
        'no_telp_1',
        'hub_keluarga_1',
        'nama_2',
        'alamat_2',
        'no_telp_2',
        'hub_keluarga_2',
        'penyakit',
    ];

    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }
}
