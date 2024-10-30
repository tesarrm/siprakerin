<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Authenticated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Auth;

class StoreAdditionalUserData
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(Authenticated $event)
    {
        // // Misalkan kita ingin menambahkan role dan profile lengkap ke Auth
        // $user = $event->user;

        // // Contoh: Ambil data dari model yang berhubungan atau dari database
        // $user->role = $user->role()->first();
        // $user->profile = $user->profile()->first();

        // // Sekarang $user memiliki data tambahan yang bisa diakses melalui Auth di mana-mana
        // Auth::setUser($user);

        $user = $event->user;

        dd($user);

        // Cek apakah pengguna adalah siswa
        if ($user->role == 'siswa') {
            $siswa = \App\Models\Siswa::where('user_id', $user->id)->first();
            // Ambil data dari tabel penempatan berdasarkan user_id
            $penempatanData = \App\Models\PenempatanIndustri::where('siswa_id', $siswa->id)->first();

            // Tambahkan data penempatan ke dalam objek user di Auth
            $user->penempatan = $penempatanData;

            // Update user di Auth
            Auth::setUser($user);
        }
    }
}
