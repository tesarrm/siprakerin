<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class IfUserLogin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
    {
        // Jika pengguna sudah login, redirect ke dashboard
        if (Auth::check()) {
            return redirect('/');
        }

        // Jika belum login, lanjutkan ke halaman yang diminta (misalnya, login)
        return $next($request);
    }
}
