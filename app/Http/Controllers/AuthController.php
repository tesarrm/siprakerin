<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\Siswa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // public function login(Request $request)
    // {
    //     $credentials = $request->validate([
    //         'email' => 'required|email',
    //         'password' => 'required',
    //     ]);

    //     if (Auth::attempt($credentials)) {
    //         $request->session()->regenerate();
    //         return redirect('/')->with('success', 'Login successful');
    //     }

    //     return back()->withErrors([
    //         'email' => 'These credentials do not match our records.',
    //     ])->onlyInput('email');
    // }

    public function login(Request $request)
    {
        // Validasi password selalu ada
        $request->validate([
            'login' => 'required',
            'password' => 'required',
        ]);


        $loginField = $request->input('login');
        $password = $request->input('password');
        
        // Cek login berdasarkan email di tabel users
        $user = User::where('email', $loginField)
            ->orWhere('username', $loginField)
            ->first();

        // Jika tidak ditemukan, cek NIS di tabel siswa
        if (!$user) {
            $siswa = Siswa::where('nisn', $loginField)
                        ->orWhere('no_telp', $loginField)
                        ->first();
            
            if ($siswa) {
                $user = User::where('id', $siswa->user_id)->first();
            }
        }

        // Jika tetap tidak ditemukan, cek NIP dan no_telp di tabel guru
        if (!$user) {
            $guru = Guru::where('nip', $loginField)
                        ->orWhere('no_telp', $loginField)
                        ->first();
            
            if ($guru) {
                $user = User::where('id', $guru->user_id)->first();
            }
        }

        // Verifikasi user dan password
        if (!$user || !Hash::check($password, $user->password)) {
            return back()->withErrors([
                'login' => 'These credentials do not match our records.',
            ])->onlyInput('login');
        }

        // Login user yang ditemukan
        Auth::login($user);
        $request->session()->regenerate();

        return redirect('/')->with('success', 'Login successful');
    }

    // Logout
    public function logout(Request $request)
    {
        $user = Auth::user();
        unset($user->penempatan);
        unset($user->biodata);

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login')->with('success', 'Logout successful');
    }

    // Menampilkan form registrasi
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    // Proses registrasi
    public function register(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
        ]);

        Auth::login($user);

        return redirect()->route('dashboard')->with('success', 'Registration successful');
    }

    // Proses ganti password
    public function updateUbahPassword(Request $request)
    {
        // Memastikan konfirmasi password baru benar
        if ($request->new_password !== $request->new_password_confirmation) {
            return back()->with('error', 'Konfirmasi password baru tidak cocok!');
        }

        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|string|min:8|confirmed',
        ]);

        // Memastikan password lama benar
        if (!Hash::check($request->current_password, Auth::user()->password)) {
            return back()->with('error', 'Password lama salah!');
        }

        // Update password baru
        $user = Auth::user();
        unset($user->penempatan);
        unset($user->biodata);
        $user->password = Hash::make($request->new_password);
        $user->save();

        return back()->with('success', 'Password berhasil diubah!');
    }
}
