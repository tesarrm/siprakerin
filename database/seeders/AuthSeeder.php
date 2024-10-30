<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class AuthSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $role_admin = Role::updateOrCreate(
            ['name' => 'admin'],
            ['name' => 'admin']
        );
        $role_koordinator = Role::updateOrCreate(
            ['name' => 'koordinator'],
            ['name' => 'koordinator']
        );
        $role_pembimbing = Role::updateOrCreate(
            ['name' => 'pembimbing'],
            ['name' => 'pembimbing']
        );
        $role_wali_kelas = Role::updateOrCreate(
            ['name' => 'wali_kelas'],
            ['name' => 'wali_kelas']
        );
        $role_siswa = Role::updateOrCreate(
            ['name' => 'siswa'],
            ['name' => 'siswa']
        );
        $role_guru = Role::updateOrCreate(
            ['name' => 'guru'],
            ['name' => 'guru']
        );
        $role_karyawan = Role::updateOrCreate(
            ['name' => 'karyawan'],
            ['name' => 'karyawan']
        );
        $role_wali_siswa = Role::updateOrCreate(
            ['name' => 'wali_siswa'],
            ['name' => 'wali_siswa']
        );
        $role_industri = Role::updateOrCreate(
            ['name' => 'industri'],
            ['name' => 'industri']
        );

// dash
        $permission_r_dashadmin = Permission::updateOrCreate(
            ['name' => 'r_dashadmin'],
            ['name' => 'r_dashadmin']
        );
        $permission_r_dashpembimbing = Permission::updateOrCreate(
            ['name' => 'r_dashpembimbing'],
            ['name' => 'r_dashpembimbing']
        );
        $permission_r_dashkoordinator = Permission::updateOrCreate(
            ['name' => 'r_dashkoordinator'],
            ['name' => 'r_dashkoordinator']
        );
        $permission_r_dashwalikelas = Permission::updateOrCreate(
            ['name' => 'r_dashwalikelas'],
            ['name' => 'r_dashwalikelas']
        );
        $permission_r_dashguru = Permission::updateOrCreate(
            ['name' => 'r_dashguru'],
            ['name' => 'r_dashguru']
        );
        $permission_r_dashsiswa = Permission::updateOrCreate(
            ['name' => 'r_dashsiswa'],
            ['name' => 'r_dashsiswa']
        );
        $permission_r_dashkaryawan = Permission::updateOrCreate(
            ['name' => 'r_dashkaryawan'],
            ['name' => 'r_dashkaryawan']
        );
        $permission_r_dashindustri = Permission::updateOrCreate(
            ['name' => 'r_dashindustri'],
            ['name' => 'r_dashindustri']
        );
        $permission_r_dashwalisiswa = Permission::updateOrCreate(
            ['name' => 'r_dashwalisiswa'],
            ['name' => 'r_dashwalisiswa']
        );
// guru
        $permission_c_guru = Permission::updateOrCreate(
            ['name' => 'c_guru'],
            ['name' => 'c_guru']
        );
        $permission_r_guru = Permission::updateOrCreate(
            ['name' => 'r_guru'],
            ['name' => 'r_guru']
        );
        $permission_u_guru = Permission::updateOrCreate(
            ['name' => 'u_guru'],
            ['name' => 'u_guru']
        );
        $permission_d_guru = Permission::updateOrCreate(
            ['name' => 'd_guru'],
            ['name' => 'd_guru']
        );
// bidang keahlian 
        $permission_c_bidang_keahlian = Permission::updateOrCreate(
            ['name' => 'c_bidang_keahlian'],
            ['name' => 'c_bidang_keahlian']
        );
        $permission_r_bidang_keahlian = Permission::updateOrCreate(
            ['name' => 'r_bidang_keahlian'],
            ['name' => 'r_bidang_keahlian']
        );
        $permission_u_bidang_keahlian = Permission::updateOrCreate(
            ['name' => 'u_bidang_keahlian'],
            ['name' => 'u_bidang_keahlian']
        );
        $permission_d_bidang_keahlian = Permission::updateOrCreate(
            ['name' => 'd_bidang_keahlian'],
            ['name' => 'd_bidang_keahlian']
        );
// jurusan 
        $permission_c_jurusan = Permission::updateOrCreate(
            ['name' => 'c_jurusan'],
            ['name' => 'c_jurusan']
        );
        $permission_r_jurusan = Permission::updateOrCreate(
            ['name' => 'r_jurusan'],
            ['name' => 'r_jurusan']
        );
        $permission_u_jurusan = Permission::updateOrCreate(
            ['name' => 'u_jurusan'],
            ['name' => 'u_jurusan']
        );
        $permission_d_jurusan = Permission::updateOrCreate(
            ['name' => 'd_jurusan'],
            ['name' => 'd_jurusan']
        );
// kelas
        $permission_c_kelas = Permission::updateOrCreate(
            ['name' => 'c_kelas'],
            ['name' => 'c_kelas']
        );
        $permission_r_kelas = Permission::updateOrCreate(
            ['name' => 'r_kelas'],
            ['name' => 'r_kelas']
        );
        $permission_u_kelas = Permission::updateOrCreate(
            ['name' => 'u_kelas'],
            ['name' => 'u_kelas']
        );
        $permission_d_kelas = Permission::updateOrCreate(
            ['name' => 'd_kelas'],
            ['name' => 'd_kelas']
        );
// siswa
        $permission_c_siswa = Permission::updateOrCreate(
            ['name' => 'c_siswa'],
            ['name' => 'c_siswa']
        );
        $permission_r_siswa = Permission::updateOrCreate(
            ['name' => 'r_siswa'],
            ['name' => 'r_siswa']
        );
        $permission_u_siswa = Permission::updateOrCreate(
            ['name' => 'u_siswa'],
            ['name' => 'u_siswa']
        );
        $permission_d_siswa = Permission::updateOrCreate(
            ['name' => 'd_siswa'],
            ['name' => 'd_siswa']
        );
// kota
        $permission_c_kota = Permission::updateOrCreate(
            ['name' => 'c_kota'],
            ['name' => 'c_kota']
        );
        $permission_r_kota = Permission::updateOrCreate(
            ['name' => 'r_kota'],
            ['name' => 'r_kota']
        );
        $permission_u_kota = Permission::updateOrCreate(
            ['name' => 'u_kota'],
            ['name' => 'u_kota']
        );
        $permission_d_kota = Permission::updateOrCreate(
            ['name' => 'd_kota'],
            ['name' => 'd_kota']
        );
// industri 
        $permission_c_industri = Permission::updateOrCreate(
            ['name' => 'c_industri'],
            ['name' => 'c_industri']
        );
        $permission_r_industri = Permission::updateOrCreate(
            ['name' => 'r_industri'],
            ['name' => 'r_industri']
        );
        $permission_u_industri = Permission::updateOrCreate(
            ['name' => 'u_industri'],
            ['name' => 'u_industri']
        );
        $permission_d_industri = Permission::updateOrCreate(
            ['name' => 'd_industri'],
            ['name' => 'd_industri']
        );
// kuota industri 
        $permission_c_kuota_industri = Permission::updateOrCreate(
            ['name' => 'c_kuota_industri'],
            ['name' => 'c_kuota_industri']
        );
        $permission_r_kuota_industri = Permission::updateOrCreate(
            ['name' => 'r_kuota_industri'],
            ['name' => 'r_kuota_industri']
        );
        $permission_u_kuota_industri = Permission::updateOrCreate(
            ['name' => 'u_kuota_industri'],
            ['name' => 'u_kuota_industri']
        );
        $permission_d_kuota_industri = Permission::updateOrCreate(
            ['name' => 'd_kuota_industri'],
            ['name' => 'd_kuota_industri']
        );
// pilihan kota 
        $permission_c_pilihan_kota = Permission::updateOrCreate(
            ['name' => 'c_pilihan_kota'],
            ['name' => 'c_pilihan_kota']
        );
        $permission_r_pilihan_kota = Permission::updateOrCreate(
            ['name' => 'r_pilihan_kota'],
            ['name' => 'r_pilihan_kota']
        );
        $permission_u_pilihan_kota = Permission::updateOrCreate(
            ['name' => 'u_pilihan_kota'],
            ['name' => 'u_pilihan_kota']
        );
        $permission_d_pilihan_kota = Permission::updateOrCreate(
            ['name' => 'd_pilihan_kota'],
            ['name' => 'd_pilihan_kota']
        );
// penempatan industri 
        $permission_c_penempatan_industri = Permission::updateOrCreate(
            ['name' => 'c_penempatan_industri'],
            ['name' => 'c_penempatan_industri']
        );
        $permission_r_penempatan_industri = Permission::updateOrCreate(
            ['name' => 'r_penempatan_industri'],
            ['name' => 'r_penempatan_industri']
        );
        $permission_u_penempatan_industri = Permission::updateOrCreate(
            ['name' => 'u_penempatan_industri'],
            ['name' => 'u_penempatan_industri']
        );
        $permission_d_penempatan_industri = Permission::updateOrCreate(
            ['name' => 'd_penempatan_industri'],
            ['name' => 'd_penempatan_industri']
        );
// jurnal 
        $permission_c_jurnal = Permission::updateOrCreate(
            ['name' => 'c_jurnal'],
            ['name' => 'c_jurnal']
        );
        $permission_r_jurnal = Permission::updateOrCreate(
            ['name' => 'r_jurnal'],
            ['name' => 'r_jurnal']
        );
        $permission_u_jurnal = Permission::updateOrCreate(
            ['name' => 'u_jurnal'],
            ['name' => 'u_jurnal']
        );
        $permission_d_jurnal = Permission::updateOrCreate(
            ['name' => 'd_jurnal'],
            ['name' => 'd_jurnal']
        );
// kehadiran 
        $permission_c_kehadiran = Permission::updateOrCreate(
            ['name' => 'c_kehadiran'],
            ['name' => 'c_kehadiran']
        );
        $permission_r_kehadiran = Permission::updateOrCreate(
            ['name' => 'r_kehadiran'],
            ['name' => 'r_kehadiran']
        );
        $permission_u_kehadiran = Permission::updateOrCreate(
            ['name' => 'u_kehadiran'],
            ['name' => 'u_kehadiran']
        );
        $permission_d_kehadiran = Permission::updateOrCreate(
            ['name' => 'd_kehadiran'],
            ['name' => 'd_kehadiran']
        );
// pelanggaran 
        $permission_c_pelanggaran = Permission::updateOrCreate(
            ['name' => 'c_pelanggaran'],
            ['name' => 'c_pelanggaran']
        );
        $permission_r_pelanggaran = Permission::updateOrCreate(
            ['name' => 'r_pelanggaran'],
            ['name' => 'r_pelanggaran']
        );
        $permission_u_pelanggaran = Permission::updateOrCreate(
            ['name' => 'u_pelanggaran'],
            ['name' => 'u_pelanggaran']
        );
        $permission_d_pelanggaran = Permission::updateOrCreate(
            ['name' => 'd_pelanggaran'],
            ['name' => 'd_pelanggaran']
        );
// pkl 
        $permission_c_pkl = Permission::updateOrCreate(
            ['name' => 'c_pkl'],
            ['name' => 'c_pkl']
        );
        $permission_r_pkl = Permission::updateOrCreate(
            ['name' => 'r_pkl'],
            ['name' => 'r_pkl']
        );
        $permission_u_pkl = Permission::updateOrCreate(
            ['name' => 'u_pkl'],
            ['name' => 'u_pkl']
        );
        $permission_d_pkl = Permission::updateOrCreate(
            ['name' => 'd_pkl'],
            ['name' => 'd_pkl']
        );
// capaian_tujuan 
        $permission_c_capaian_tujuan = Permission::updateOrCreate(
            ['name' => 'c_capaian_tujuan'],
            ['name' => 'c_capaian_tujuan']
        );
        $permission_r_capaian_tujuan = Permission::updateOrCreate(
            ['name' => 'r_capaian_tujuan'],
            ['name' => 'r_capaian_tujuan']
        );
        $permission_u_capaian_tujuan = Permission::updateOrCreate(
            ['name' => 'u_capaian_tujuan'],
            ['name' => 'u_capaian_tujuan']
        );
        $permission_d_capaian_tujuan = Permission::updateOrCreate(
            ['name' => 'd_capaian_tujuan'],
            ['name' => 'd_capaian_tujuan']
        );
// nilai 
        $permission_c_nilai = Permission::updateOrCreate(
            ['name' => 'c_nilai'],
            ['name' => 'c_nilai']
        );
        $permission_r_nilai = Permission::updateOrCreate(
            ['name' => 'r_nilai'],
            ['name' => 'r_nilai']
        );
        $permission_u_nilai = Permission::updateOrCreate(
            ['name' => 'u_nilai'],
            ['name' => 'u_nilai']
        );
        $permission_d_nilai = Permission::updateOrCreate(
            ['name' => 'd_nilai'],
            ['name' => 'd_nilai']
        );
// jadwal_monitoring 
        $permission_c_jadwal_monitoring = Permission::updateOrCreate(
            ['name' => 'c_jadwal_monitoring'],
            ['name' => 'c_jadwal_monitoring']
        );
        $permission_r_jadwal_monitoring = Permission::updateOrCreate(
            ['name' => 'r_jadwal_monitoring'],
            ['name' => 'r_jadwal_monitoring']
        );
        $permission_u_jadwal_monitoring = Permission::updateOrCreate(
            ['name' => 'u_jadwal_monitoring'],
            ['name' => 'u_jadwal_monitoring']
        );
        $permission_d_jadwal_monitoring = Permission::updateOrCreate(
            ['name' => 'd_jadwal_monitoring'],
            ['name' => 'd_jadwal_monitoring']
        );
// hasil monitoring 
        $permission_c_hasil_monitoring = Permission::updateOrCreate(
            ['name' => 'c_hasil_monitoring'],
            ['name' => 'c_hasil_monitoring']
        );
        $permission_r_hasil_monitoring = Permission::updateOrCreate(
            ['name' => 'r_hasil_monitoring'],
            ['name' => 'r_hasil_monitoring']
        );
        $permission_u_hasil_monitoring = Permission::updateOrCreate(
            ['name' => 'u_hasil_monitoring'],
            ['name' => 'u_hasil_monitoring']
        );
        $permission_d_hasil_monitoring = Permission::updateOrCreate(
            ['name' => 'd_hasil_monitoring'],
            ['name' => 'd_hasil_monitoring']
        );
// user 
        $permission_c_user = Permission::updateOrCreate(
            ['name' => 'c_user'],
            ['name' => 'c_user']
        );
        $permission_r_user = Permission::updateOrCreate(
            ['name' => 'r_user'],
            ['name' => 'r_user']
        );
        $permission_u_user = Permission::updateOrCreate(
            ['name' => 'u_user'],
            ['name' => 'u_user']
        );
        $permission_d_user = Permission::updateOrCreate(
            ['name' => 'd_user'],
            ['name' => 'd_user']
        );
// guru industri 
        $permission_c_guru_industri = Permission::updateOrCreate(
            ['name' => 'c_guru_industri'],
            ['name' => 'c_guru_industri']
        );
        $permission_r_guru_industri = Permission::updateOrCreate(
            ['name' => 'r_guru_industri'],
            ['name' => 'r_guru_industri']
        );
        $permission_u_guru_industri = Permission::updateOrCreate(
            ['name' => 'u_guru_industri'],
            ['name' => 'u_guru_industri']
        );
        $permission_d_guru_industri = Permission::updateOrCreate(
            ['name' => 'd_guru_industri'],
            ['name' => 'd_guru_industri']
        );
// pengaturan 
        $permission_c_pengaturan = Permission::updateOrCreate(
            ['name' => 'c_pengaturan'],
            ['name' => 'c_pengaturan']
        );
        $permission_r_pengaturan = Permission::updateOrCreate(
            ['name' => 'r_pengaturan'],
            ['name' => 'r_pengaturan']
        );
        $permission_u_pengaturan = Permission::updateOrCreate(
            ['name' => 'u_pengaturan'],
            ['name' => 'u_pengaturan']
        );
        $permission_d_pengaturan = Permission::updateOrCreate(
            ['name' => 'd_pengaturan'],
            ['name' => 'd_pengaturan']
        );
// karyawan 
        $permission_c_karyawan = Permission::updateOrCreate(
            ['name' => 'c_karyawan'],
            ['name' => 'c_karyawan']
        );
        $permission_r_karyawan = Permission::updateOrCreate(
            ['name' => 'r_karyawan'],
            ['name' => 'r_karyawan']
        );
        $permission_u_karyawan = Permission::updateOrCreate(
            ['name' => 'u_karyawan'],
            ['name' => 'u_karyawan']
        );
        $permission_d_karyawan = Permission::updateOrCreate(
            ['name' => 'd_karyawan'],
            ['name' => 'd_karyawan']
        );
// wali siswa 
        $permission_c_wali_siswa = Permission::updateOrCreate(
            ['name' => 'c_wali_siswa'],
            ['name' => 'c_wali_siswa']
        );
        $permission_r_wali_siswa = Permission::updateOrCreate(
            ['name' => 'r_wali_siswa'],
            ['name' => 'r_wali_siswa']
        );
        $permission_u_wali_siswa = Permission::updateOrCreate(
            ['name' => 'u_wali_siswa'],
            ['name' => 'u_wali_siswa']
        );
        $permission_d_wali_siswa = Permission::updateOrCreate(
            ['name' => 'd_wali_siswa'],
            ['name' => 'd_wali_siswa']
        );
// pusat unduhan 
        $permission_c_pusat_unduhan = Permission::updateOrCreate(
            ['name' => 'c_pusat_unduhan'],
            ['name' => 'c_pusat_unduhan']
        );
        $permission_r_pusat_unduhan = Permission::updateOrCreate(
            ['name' => 'r_pusat_unduhan'],
            ['name' => 'r_pusat_unduhan']
        );
        $permission_u_pusat_unduhan = Permission::updateOrCreate(
            ['name' => 'u_pusat_unduhan'],
            ['name' => 'u_pusat_unduhan']
        );
        $permission_d_pusat_unduhan = Permission::updateOrCreate(
            ['name' => 'd_pusat_unduhan'],
            ['name' => 'd_pusat_unduhan']
        );

// =================================================================
// =================================================================

// dash
        $role_admin->givePermissionTo($permission_r_dashadmin);
        $role_pembimbing->givePermissionTo($permission_r_dashpembimbing);
        $role_koordinator->givePermissionTo($permission_r_dashkoordinator);
        $role_wali_kelas->givePermissionTo($permission_r_dashwalikelas);
        $role_guru->givePermissionTo($permission_r_dashguru);
        $role_siswa->givePermissionTo($permission_r_dashsiswa);
        $role_industri->givePermissionTo($permission_r_dashindustri);
        $role_wali_siswa->givePermissionTo($permission_r_dashwalisiswa);

// admin
        $role_admin->givePermissionTo($permission_c_guru);
        $role_admin->givePermissionTo($permission_r_guru);
        $role_admin->givePermissionTo($permission_u_guru);
        $role_admin->givePermissionTo($permission_d_guru);

        $role_admin->givePermissionTo($permission_c_bidang_keahlian);
        $role_admin->givePermissionTo($permission_r_bidang_keahlian);
        $role_admin->givePermissionTo($permission_u_bidang_keahlian);
        $role_admin->givePermissionTo($permission_d_bidang_keahlian);

        $role_admin->givePermissionTo($permission_c_jurusan);
        $role_admin->givePermissionTo($permission_r_jurusan);
        $role_admin->givePermissionTo($permission_u_jurusan);
        $role_admin->givePermissionTo($permission_d_jurusan);

        $role_admin->givePermissionTo($permission_c_kelas);
        $role_admin->givePermissionTo($permission_r_kelas);
        $role_admin->givePermissionTo($permission_u_kelas);
        $role_admin->givePermissionTo($permission_d_kelas);

        $role_admin->givePermissionTo($permission_c_siswa);
        $role_admin->givePermissionTo($permission_r_siswa);
        $role_admin->givePermissionTo($permission_u_siswa);
        $role_admin->givePermissionTo($permission_d_siswa);

        $role_admin->givePermissionTo($permission_c_kota);
        $role_admin->givePermissionTo($permission_r_kota);
        $role_admin->givePermissionTo($permission_u_kota);
        $role_admin->givePermissionTo($permission_d_kota);

        $role_admin->givePermissionTo($permission_c_industri);
        $role_admin->givePermissionTo($permission_r_industri);
        $role_admin->givePermissionTo($permission_u_industri);
        $role_admin->givePermissionTo($permission_d_industri);

        $role_admin->givePermissionTo($permission_c_kuota_industri);
        $role_admin->givePermissionTo($permission_r_kuota_industri);
        $role_admin->givePermissionTo($permission_u_kuota_industri);
        $role_admin->givePermissionTo($permission_d_kuota_industri);

        $role_admin->givePermissionTo($permission_r_pilihan_kota);
        $role_admin->givePermissionTo($permission_u_pilihan_kota);
        $role_admin->givePermissionTo($permission_d_pilihan_kota);

        $role_admin->givePermissionTo($permission_c_penempatan_industri);
        $role_admin->givePermissionTo($permission_r_penempatan_industri);
        $role_admin->givePermissionTo($permission_u_penempatan_industri);
        $role_admin->givePermissionTo($permission_d_penempatan_industri);

        $role_admin->givePermissionTo($permission_r_jurnal);

        $role_admin->givePermissionTo($permission_r_kehadiran);
        $role_admin->givePermissionTo($permission_d_kehadiran);

        $role_admin->givePermissionTo($permission_c_pelanggaran);
        $role_admin->givePermissionTo($permission_r_pelanggaran);
        $role_admin->givePermissionTo($permission_u_pelanggaran);
        $role_admin->givePermissionTo($permission_d_pelanggaran);

        $role_admin->givePermissionTo($permission_c_pkl);
        $role_admin->givePermissionTo($permission_r_pkl);
        $role_admin->givePermissionTo($permission_u_pkl);
        $role_admin->givePermissionTo($permission_d_pkl);

        $role_admin->givePermissionTo($permission_c_capaian_tujuan);
        $role_admin->givePermissionTo($permission_r_capaian_tujuan);
        $role_admin->givePermissionTo($permission_u_capaian_tujuan);
        $role_admin->givePermissionTo($permission_d_capaian_tujuan);

        $role_admin->givePermissionTo($permission_c_nilai);
        $role_admin->givePermissionTo($permission_r_nilai);
        $role_admin->givePermissionTo($permission_u_nilai);
        $role_admin->givePermissionTo($permission_d_nilai);

        $role_admin->givePermissionTo($permission_c_jadwal_monitoring);
        $role_admin->givePermissionTo($permission_r_jadwal_monitoring);
        $role_admin->givePermissionTo($permission_u_jadwal_monitoring);
        $role_admin->givePermissionTo($permission_d_jadwal_monitoring);

        $role_admin->givePermissionTo($permission_c_hasil_monitoring);
        $role_admin->givePermissionTo($permission_r_hasil_monitoring);
        $role_admin->givePermissionTo($permission_u_hasil_monitoring);
        $role_admin->givePermissionTo($permission_d_hasil_monitoring);

        $role_admin->givePermissionTo($permission_c_user);
        $role_admin->givePermissionTo($permission_r_user);
        $role_admin->givePermissionTo($permission_u_user);
        $role_admin->givePermissionTo($permission_d_user);

        $role_admin->givePermissionTo($permission_c_guru_industri);
        $role_admin->givePermissionTo($permission_r_guru_industri);
        $role_admin->givePermissionTo($permission_u_guru_industri);
        $role_admin->givePermissionTo($permission_d_guru_industri);

        $role_admin->givePermissionTo($permission_c_pengaturan);
        $role_admin->givePermissionTo($permission_r_pengaturan);
        $role_admin->givePermissionTo($permission_u_pengaturan);
        $role_admin->givePermissionTo($permission_d_pengaturan);

        $role_admin->givePermissionTo($permission_c_wali_siswa);
        $role_admin->givePermissionTo($permission_r_wali_siswa);
        $role_admin->givePermissionTo($permission_u_wali_siswa);
        $role_admin->givePermissionTo($permission_d_wali_siswa);

        $role_admin->givePermissionTo($permission_c_karyawan);
        $role_admin->givePermissionTo($permission_r_karyawan);
        $role_admin->givePermissionTo($permission_u_karyawan);
        $role_admin->givePermissionTo($permission_d_karyawan);

        $role_admin->givePermissionTo($permission_c_pusat_unduhan);
        $role_admin->givePermissionTo($permission_r_pusat_unduhan);
        $role_admin->givePermissionTo($permission_u_pusat_unduhan);
        $role_admin->givePermissionTo($permission_d_pusat_unduhan);

// koordinator 
        $role_koordinator->givePermissionTo($permission_r_pilihan_kota);
        $role_koordinator->givePermissionTo($permission_u_pilihan_kota);
        $role_koordinator->givePermissionTo($permission_d_pilihan_kota);

        $role_koordinator->givePermissionTo($permission_c_penempatan_industri);
        $role_koordinator->givePermissionTo($permission_r_penempatan_industri);
        $role_koordinator->givePermissionTo($permission_u_penempatan_industri);
        $role_koordinator->givePermissionTo($permission_d_penempatan_industri);

        $role_koordinator->givePermissionTo($permission_c_pelanggaran);
        $role_koordinator->givePermissionTo($permission_r_pelanggaran);
        $role_koordinator->givePermissionTo($permission_u_pelanggaran);
        $role_koordinator->givePermissionTo($permission_d_pelanggaran);

        $role_koordinator->givePermissionTo($permission_c_pkl);
        $role_koordinator->givePermissionTo($permission_r_pkl);
        $role_koordinator->givePermissionTo($permission_u_pkl);
        $role_koordinator->givePermissionTo($permission_d_pkl);

        $role_koordinator->givePermissionTo($permission_c_nilai);
        $role_koordinator->givePermissionTo($permission_r_nilai);
        $role_koordinator->givePermissionTo($permission_u_nilai);
        $role_koordinator->givePermissionTo($permission_d_nilai);

        $role_koordinator->givePermissionTo($permission_c_jadwal_monitoring);
        $role_koordinator->givePermissionTo($permission_r_jadwal_monitoring);
        $role_koordinator->givePermissionTo($permission_u_jadwal_monitoring);
        $role_koordinator->givePermissionTo($permission_d_jadwal_monitoring);

        $role_koordinator->givePermissionTo($permission_r_hasil_monitoring);

        $role_koordinator->givePermissionTo($permission_r_jurnal);

        $role_koordinator->givePermissionTo($permission_r_pusat_unduhan);

// pembimbing 
        $role_pembimbing->givePermissionTo($permission_c_hasil_monitoring);
        $role_pembimbing->givePermissionTo($permission_r_hasil_monitoring);
        $role_pembimbing->givePermissionTo($permission_u_hasil_monitoring);
        $role_pembimbing->givePermissionTo($permission_d_hasil_monitoring);

        $role_pembimbing->givePermissionTo($permission_c_pelanggaran);
        $role_pembimbing->givePermissionTo($permission_r_pelanggaran);
        $role_pembimbing->givePermissionTo($permission_u_pelanggaran);
        $role_pembimbing->givePermissionTo($permission_d_pelanggaran);

        $role_pembimbing->givePermissionTo($permission_c_nilai);
        $role_pembimbing->givePermissionTo($permission_r_nilai);
        $role_pembimbing->givePermissionTo($permission_u_nilai);
        $role_pembimbing->givePermissionTo($permission_d_nilai);

        $role_pembimbing->givePermissionTo($permission_r_jurnal);

        $role_pembimbing->givePermissionTo($permission_r_pkl);

        $role_pembimbing->givePermissionTo($permission_r_pusat_unduhan);

// siswa 
        $role_siswa->givePermissionTo($permission_c_pilihan_kota);
        $role_siswa->givePermissionTo($permission_r_pilihan_kota);
        $role_siswa->givePermissionTo($permission_u_pilihan_kota);
        $role_siswa->givePermissionTo($permission_d_pilihan_kota);

        $role_siswa->givePermissionTo($permission_c_jurnal);
        $role_siswa->givePermissionTo($permission_r_jurnal);
        $role_siswa->givePermissionTo($permission_u_jurnal);

        $role_siswa->givePermissionTo($permission_r_hasil_monitoring);

        $role_siswa->givePermissionTo($permission_r_pusat_unduhan);

// wali kelas 
        $role_wali_kelas->givePermissionTo($permission_r_penempatan_industri);

        $role_wali_kelas->givePermissionTo($permission_r_jurnal);

        $role_wali_kelas->givePermissionTo($permission_r_pelanggaran);

        $role_wali_kelas->givePermissionTo($permission_r_pkl);

        $role_wali_kelas->givePermissionTo($permission_r_nilai);

        $role_wali_kelas->givePermissionTo($permission_r_hasil_monitoring);

        $role_wali_kelas->givePermissionTo($permission_r_pusat_unduhan);

// guru
        $role_guru->givePermissionTo($permission_r_industri);

        $role_guru->givePermissionTo($permission_r_kuota_industri);

        $role_guru->givePermissionTo($permission_r_penempatan_industri);

        $role_guru->givePermissionTo($permission_r_jurnal);

        $role_guru->givePermissionTo($permission_r_kehadiran);

        $role_guru->givePermissionTo($permission_r_pelanggaran);

        $role_guru->givePermissionTo($permission_r_pkl);

        $role_guru->givePermissionTo($permission_r_nilai);

        $role_guru->givePermissionTo($permission_r_jadwal_monitoring);

        $role_guru->givePermissionTo($permission_r_hasil_monitoring);

        $role_guru->givePermissionTo($permission_r_pusat_unduhan);

// karyawan 
        $role_karyawan->givePermissionTo($permission_r_industri);

        $role_karyawan->givePermissionTo($permission_r_kuota_industri);

        $role_karyawan->givePermissionTo($permission_r_penempatan_industri);

        $role_karyawan->givePermissionTo($permission_r_jurnal);

        $role_karyawan->givePermissionTo($permission_r_kehadiran);

        $role_karyawan->givePermissionTo($permission_r_pelanggaran);

        $role_karyawan->givePermissionTo($permission_r_pkl);

        $role_karyawan->givePermissionTo($permission_r_nilai);

        $role_karyawan->givePermissionTo($permission_r_jadwal_monitoring);

        $role_karyawan->givePermissionTo($permission_r_hasil_monitoring);

        $role_karyawan->givePermissionTo($permission_r_pusat_unduhan);

// wali siswa 

        $role_wali_siswa->givePermissionTo($permission_r_industri);

        $role_wali_siswa->givePermissionTo($permission_r_kuota_industri);

        $role_wali_siswa->givePermissionTo($permission_r_penempatan_industri);

        $role_wali_siswa->givePermissionTo($permission_r_jurnal);

        $role_wali_siswa->givePermissionTo($permission_r_kehadiran);

        $role_wali_siswa->givePermissionTo($permission_r_pelanggaran);

        $role_wali_siswa->givePermissionTo($permission_r_pkl);

        $role_wali_siswa->givePermissionTo($permission_r_nilai);

        $role_wali_siswa->givePermissionTo($permission_r_hasil_monitoring);

        $role_wali_siswa->givePermissionTo($permission_r_pusat_unduhan);

// industri 
        $role_industri->givePermissionTo($permission_r_industri);

        $role_industri->givePermissionTo($permission_r_kuota_industri);

        $role_industri->givePermissionTo($permission_r_penempatan_industri);

        $role_industri->givePermissionTo($permission_r_jurnal);

        $role_industri->givePermissionTo($permission_r_kehadiran);

        $role_industri->givePermissionTo($permission_r_pelanggaran);

        $role_industri->givePermissionTo($permission_r_pkl);

        $role_industri->givePermissionTo($permission_r_nilai);

        $role_industri->givePermissionTo($permission_r_jadwal_monitoring);

        $role_industri->givePermissionTo($permission_r_hasil_monitoring);

        $role_industri->givePermissionTo($permission_r_pusat_unduhan);


// assign role to user
        $admin = User::find(1);

        $admin->assignRole('admin');
    }
}
