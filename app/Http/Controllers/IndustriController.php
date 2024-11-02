<?php

namespace App\Http\Controllers;

use App\Imports\IndustriImport;
use App\Imports\IndustriKuotaImport;
use App\Models\Industri;
use App\Models\Kota;
use App\Models\LiburMingguan;
use App\Models\Pengaturan;
use App\Models\TemporaryFile;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Facades\Excel;

class IndustriController extends Controller
{
    protected $model;
    public function __construct(Industri $a)
    {
        $this->model = $a;

        $this->middleware('can:c_industri')->only(['create', 'store']);
        $this->middleware('can:r_industri')->only(['index', 'show']);
        $this->middleware('can:u_industri')->only(['edit', 'update']);
        $this->middleware('can:d_industri')->only('destroy');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Industri::with('kota')
            ->where('aktif', 1)
            ->orderBy('nama', 'asc')
            ->paginate(100);

        return view('industri.index', [
            'data' => $data
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $kota = Kota::get();
        $pengaturan = Pengaturan::first();

        return view('industri.add', [
            'kota' => $kota,
            'pengaturan' => $pengaturan
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama' => 'required|string',
            'alamat' => 'required|string',
            'kota_id' => 'required|string',
            'tanggal_awal' => 'nullable|string',
            'tanggal_akhir' => 'nullable|string',

            'nama_akun' => 'required',
            'no_telp' => 'nullable|string',
            'no_hp' => 'nullable|string',

            'username' => 'required|string|unique:users,username|max:255',
            'email' => 'nullable|string|unique:users,email|max:255',
            'password' => 'required',
        ]);

        $create = collect($validatedData);


        $create2 = collect($request)->except([
            'nama',
            'alamat',
            'kota_id',
            // 'tahun_ajaran',
            'tanggal_awal',
            'tanggal_akhir',

            'nama_akun',
            'username',
            'email',
            'password',
        ]);


        // ========

        // Create user data
        $userData = [
            'name' => $validatedData['nama_akun'],
            'username' => $validatedData['username'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
        ];

        // Create user
        $user = User::create($userData);
        
        // Assign role
        $user->assignRole('industri');

        // create industri
        $create->put('user_id', $user->id);

        $industri = Industri::create($create->toArray());
        $create2->put('industri_id', $industri->id);
        LiburMingguan::create($create2->toArray());

        return redirect('industri')->with('status', 'Data berhasil ditambah!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Industri $industri)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Industri $industri)
    {
        $kota = Kota::get();
        $libur = LiburMingguan::where('industri_id', $industri->id)->first();
        $industri = Industri::with(['user'])->findOrFail($industri->id);

        return view('industri.edit', [
            'data' => $industri,
            'kota' => $kota,
            'libur' => $libur,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($id, Request $request)
    {
        // Ambil data industri berdasarkan id
        $industri = Industri::with('user')->findOrFail($id);
        $user = $industri->user;

        // Validasi data industri
        $validatedData = $request->validate([
            'nama' => 'required|string',
            'alamat' => 'required|string',
            'kota_id' => 'required|string',
            'tanggal_awal' => 'nullable|string',
            'tanggal_akhir' => 'nullable|string',

            'nama_akun' => 'required',
            'username' => 'required|string|unique:users,username,' . $user->id,
            'no_telp' => 'nullable|string',
            'no_hp' => 'nullable|string',
        ]);

        $industriData = collect($validatedData)->except(['nama_akun', 'username'])->toArray();

        // Update data industri
        $update = collect($industriData);
        $industri->update($update->toArray());

        // hapus libur mingguan lama
        $liburI = LiburMingguan::where('industri_id', $industri->id)->get();

        foreach ($liburI as $data) {
            $data->delete();
        }

        // Ambil data libur mingguan yang berhubungan dengan industri
        $libur = LiburMingguan::where('industri_id', $industri->id)->first();

        // Ambil data request untuk hari libur (kecuali field industri yang sudah diupdate)
        $update2 = collect($request)->except([
            'nama',
            'alamat',
            'kota_id',
            // 'tahun_ajaran',
            'tanggal_awal',
            'tanggal_akhir',

            'nama_akun',
            'username',
            'no_telp',
        ]);

        // Tambahkan industri_id ke data libur mingguan
        $update2->put('industri_id', $industri->id);

        // Cek apakah data libur sudah ada atau belum, jika ada update, jika tidak create
        if ($libur) {
            $libur->update($update2->toArray());
        } else {
            LiburMingguan::create($update2->toArray());
        }

        $user->name = $validatedData['nama_akun'];
        $user->username = $validatedData['username'];
        $user->save();


        // Redirect dengan pesan status
        return redirect('industri')->with('status', 'Data berhasil diedit!');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $data = $this->model->findOrFail($id);
        $data->delete();
        return response()->json(['success' => true]);
    }

    public function nonaktif($id){
        $data = $this->model->find($id);

        if ($data) {
            $data->aktif = 0;
            $data->save();

            return response()->json(['success' => true]);
        } else {
            return response()->json(['success' => false]);
        }
    }

    public function aktif($id){
        $data = $this->model->find($id);

        if ($data) {
            $data->aktif = 1;
            $data->save();

            return response()->json(['success' => true]);
        } else {
            return response()->json(['success' => false]);
        }
    }

    public function indexAkun()
    {
        $data = Industri::with(['kota', 'user'])
            ->where('aktif', 1)
            ->orderBy('nama', 'asc')
            ->whereHas('user')
            ->paginate(100);

        return view('industri.index_akun', [
            'data' => $data
        ]);
    }

    public function resetPassword($user_id)
    {
        $user = User::find($user_id);

        if ($user) {
            $user->password = Hash::make('password');
            $user->save();

            return response()->json(['success' => true]);
        } else {
            return response()->json(['success' => false]);
        }
    }

    public function deleteMultiple(Request $request)
    {
        $ids = $request->input('ids');

        // Ambil semua data guru berdasarkan ID yang dipilih
        $data = Industri::whereIn('id', $ids)->get();

        foreach ($data as $d) {
            // Hapus datad 
            $d->delete();
        }

        return response()->json(['success' => true]);
    }

    public function import(Request $request){
        try {
            Excel::import(new IndustriImport, $request->file('excel'));
            return redirect()->back()->with('status', 'Data berhasil diimpor!');
        } catch (ValidationException $e) {
            $errors = $e->validator->errors()->getMessages();

            return redirect()->back()->withErrors($errors)->withInput();
        }
    }

    public function importKuota(Request $request){
        try {
            Excel::import(new IndustriKuotaImport, $request->file('excel'));
            return redirect()->back()->with('status', 'Data berhasil diimpor!');
        } catch (ValidationException $e) {
            $errors = $e->validator->errors()->getMessages();

            return redirect()->back()->withErrors($errors)->withInput();
        }
    }
}
