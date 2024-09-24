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

// dash
        $role_admin->givePermissionTo($permission_r_dashadmin);
        $role_guru->givePermissionTo($permission_r_dashguru);
        $role_kabeng->givePermissionTo($permission_r_dashkabeng);
        $role_siswa->givePermissionTo($permission_r_dashsiswa);
        $role_industri->givePermissionTo($permission_r_dashindustri);
        $role_ortu->givePermissionTo($permission_r_dashortu);

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

        $user   = User::find(1);
        // $user2  = User::find(2);

        $user->assignRole('admin');
        // $user2->assignRole('writer');
    }
}
