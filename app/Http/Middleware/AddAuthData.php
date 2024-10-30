<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AddAuthData
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Pastikan pengguna telah terautentikasi
        if (Auth::check()) {
            $user = Auth::user();

            $siswa = \App\Models\Siswa::where('user_id', $user->id)->first();
            if($siswa) {
                $penempatanData = \App\Models\PenempatanIndustri::where('siswa_id', $siswa ? $siswa->id : '')->first();
                $biodata = \App\Models\BiodataSiswa::where('siswa_id', $siswa ? $siswa->id : '')->first();

                $user->penempatan = $penempatanData;
                $user->biodata = $biodata;

                Auth::setUser($user);
            }
        }

        return $next($request);
    }
}
