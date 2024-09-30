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
        $role_guru = Role::updateOrCreate(
            ['name' => 'guru'],
            ['name' => 'guru']
        );
        $role_kabeng = Role::updateOrCreate(
            ['name' => 'kabeng'],
            ['name' => 'kabeng']
        );
        $role_wali_siswa = Role::updateOrCreate(
            ['name' => 'wali_siswa'],
            ['name' => 'wali_siswa']
        );
        $role_siswa = Role::updateOrCreate(
            ['name' => 'siswa'],
            ['name' => 'siswa']
        );
        $role_industri = Role::updateOrCreate(
            ['name' => 'industri'],
            ['name' => 'industri']
        );
        $role_ortu = Role::updateOrCreate(
            ['name' => 'ortu'],
            ['name' => 'ortu']
        );

// dash
        $permission_r_dashadmin = Permission::updateOrCreate(
            ['name' => 'r_dashadmin'],
            ['name' => 'r_dashadmin']
        );
        $permission_r_dashguru = Permission::updateOrCreate(
            ['name' => 'r_dashguru'],
            ['name' => 'r_dashguru']
        );
        $permission_r_dashkabeng = Permission::updateOrCreate(
            ['name' => 'r_dashkabeng'],
            ['name' => 'r_dashkabeng']
        );
        $permission_r_dashsiswa = Permission::updateOrCreate(
            ['name' => 'r_dashsiswa'],
            ['name' => 'r_dashsiswa']
        );
        $permission_r_dashindustri = Permission::updateOrCreate(
            ['name' => 'r_dashindustri'],
            ['name' => 'r_dashindustri']
        );
        $permission_r_dashortu = Permission::updateOrCreate(
            ['name' => 'r_dashortu'],
            ['name' => 'r_dashortu']
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
// penempatan prakerin 
        $permission_c_penempatan_prakerin = Permission::updateOrCreate(
            ['name' => 'c_penempatan_prakerin'],
            ['name' => 'c_penempatan_prakerin']
        );
        $permission_r_penempatan_prakerin = Permission::updateOrCreate(
            ['name' => 'r_penempatan_prakerin'],
            ['name' => 'r_penempatan_prakerin']
        );
        $permission_u_penempatan_prakerin = Permission::updateOrCreate(
            ['name' => 'u_penempatan_prakerin'],
            ['name' => 'u_penempatan_prakerin']
        );
        $permission_d_penempatan_prakerin = Permission::updateOrCreate(
            ['name' => 'd_penempatan_prakerin'],
            ['name' => 'd_penempatan_prakerin']
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

// dash
        $role_guru->givePermissionTo($permission_r_dashguru);
        $role_industri->givePermissionTo($permission_r_dashindustri);
        $role_ortu->givePermissionTo($permission_r_dashortu);

// admin
        $role_admin->givePermissionTo($permission_r_dashadmin);

        $role_admin->givePermissionTo($permission_c_guru);
        $role_admin->givePermissionTo($permission_r_guru);
        $role_admin->givePermissionTo($permission_u_guru);
        $role_admin->givePermissionTo($permission_d_guru);

        $role_admin->givePermissionTo($permission_c_siswa);
        $role_admin->givePermissionTo($permission_r_siswa);
        $role_admin->givePermissionTo($permission_u_siswa);
        $role_admin->givePermissionTo($permission_d_siswa);

        $role_admin->givePermissionTo($permission_c_kelas);
        $role_admin->givePermissionTo($permission_r_kelas);
        $role_admin->givePermissionTo($permission_u_kelas);
        $role_admin->givePermissionTo($permission_d_kelas);

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

        $role_admin->givePermissionTo($permission_c_penempatan_prakerin);
        $role_admin->givePermissionTo($permission_r_penempatan_prakerin);
        $role_admin->givePermissionTo($permission_u_penempatan_prakerin);
        $role_admin->givePermissionTo($permission_d_penempatan_prakerin);

        $role_admin->givePermissionTo($permission_r_jurnal);
        $role_admin->givePermissionTo($permission_d_jurnal);

        $role_admin->givePermissionTo($permission_c_jadwal_monitoring);
        $role_admin->givePermissionTo($permission_r_jadwal_monitoring);
        $role_admin->givePermissionTo($permission_u_jadwal_monitoring);
        $role_admin->givePermissionTo($permission_d_jadwal_monitoring);

        $role_admin->givePermissionTo($permission_c_hasil_monitoring);
        $role_admin->givePermissionTo($permission_r_hasil_monitoring);
        $role_admin->givePermissionTo($permission_u_hasil_monitoring);
        $role_admin->givePermissionTo($permission_d_hasil_monitoring);
// kabeng 
        $role_kabeng->givePermissionTo($permission_r_dashkabeng);

        $role_kabeng->givePermissionTo($permission_c_penempatan_prakerin);
        $role_kabeng->givePermissionTo($permission_r_penempatan_prakerin);
        $role_kabeng->givePermissionTo($permission_u_penempatan_prakerin);
        $role_kabeng->givePermissionTo($permission_d_penempatan_prakerin);

        $role_kabeng->givePermissionTo($permission_c_hasil_monitoring);
        $role_kabeng->givePermissionTo($permission_r_hasil_monitoring);
        $role_kabeng->givePermissionTo($permission_u_hasil_monitoring);
        $role_kabeng->givePermissionTo($permission_d_hasil_monitoring);
// wali siswa 
        $role_wali_siswa->givePermissionTo($permission_r_penempatan_prakerin);

        $role_wali_siswa->givePermissionTo($permission_r_jurnal);

        $role_wali_siswa->givePermissionTo($permission_c_hasil_monitoring);
        $role_wali_siswa->givePermissionTo($permission_r_hasil_monitoring);
        $role_wali_siswa->givePermissionTo($permission_u_hasil_monitoring);
        $role_wali_siswa->givePermissionTo($permission_d_hasil_monitoring);
// siswa 
        $role_siswa->givePermissionTo($permission_r_dashsiswa);

        $role_siswa->givePermissionTo($permission_c_pilihan_kota);
        $role_siswa->givePermissionTo($permission_r_pilihan_kota);
        $role_siswa->givePermissionTo($permission_u_pilihan_kota);
        $role_siswa->givePermissionTo($permission_d_pilihan_kota);

        $role_siswa->givePermissionTo($permission_c_jurnal);
        $role_siswa->givePermissionTo($permission_r_jurnal);
        $role_siswa->givePermissionTo($permission_u_jurnal);
        $role_siswa->givePermissionTo($permission_d_jurnal);

        $role_siswa->givePermissionTo($permission_c_hasil_monitoring);
        $role_siswa->givePermissionTo($permission_r_hasil_monitoring);
        $role_siswa->givePermissionTo($permission_u_hasil_monitoring);
        $role_siswa->givePermissionTo($permission_d_hasil_monitoring);


// assign role to user
        $admin = User::find(1);
        $kabeng = User::find(2);
        $wali_siswa = User::find(3);
        $siswa = User::find(4);

        $admin->assignRole('admin');
        $kabeng->assignRole('kabeng');
        $wali_siswa->assignRole('wali_siswa');
        $siswa->assignRole('siswa');
    }
}
