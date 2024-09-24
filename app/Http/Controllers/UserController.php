<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // Menampilkan semua data User
    // public function index()
    // {
    //     $data = User::all();
    //     return view('user.index', compact('data'));
    // }

    public function index()
    {
        $data = User::all()->map(function ($user) {
            // Cek apakah user memiliki role, jika tidak, isi dengan "-"
            $user->peran = $user->roles->isNotEmpty() 
                ? $user->roles->pluck('name')->implode(', ') 
                : '-';
            return $user;
        });

        return view('user.index', compact('data'));
    }

    // Menampilkan form untuk membuat user baru
    public function create()
    {
        return view('user.add');
    }

    // Menyimpan user baru
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);
        // dd($request);

        User::create([
            'name' => $validatedData['nama'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
        ]);

        return redirect()->route('user.index')->with('success', 'User created successfully.');
    }

    // Menampilkan form untuk mengedit user
    public function edit($id)
    {
        $data = User::findOrFail($id);
        return view('user.edit', compact('data'));
    }

    // Memperbarui data user
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validatedData = $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $user->update([
            'name' => $validatedData['nama'],
            'email' => $validatedData['email'],
            'password' => $request->password ? Hash::make($request->password) : $user->password,
        ]);

        return redirect()->route('user.index')->with('success', 'User updated successfully.');
    }

    public function destroy($id)
    {
        $data = User::findOrFail($id);
        $data->delete();
        return response()->json(['success' => true]);
    }
}
