<?php

namespace App\Http\Controllers;

use App\Imports\SiswaExport;
use App\Imports\SiswaImport;
use App\Models\Kelas;
use App\Models\Pengaturan;
use App\Models\PilihanKota;
use App\Models\Siswa;
use App\Models\TemporaryFile;
use App\Models\User;
use App\Models\WaliSiswa;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Facades\Excel;

class SiswaController extends Controller
{
    protected $model;
    public function __construct(Siswa $a)
    {
        $this->model = $a;

        $this->middleware('can:c_siswa')->only(['create', 'store']);
        $this->middleware('can:r_siswa')->only(['index', 'show']);
        $this->middleware('can:u_siswa')->only(['edit', 'update']);
        $this->middleware('can:d_siswa')->only('destroy');
    }

    public function index()
    {
        $pengaturan = Pengaturan::first();
        $data = Siswa::with(['kelas', 'user', 'tahunAjaran'])
            ->where('aktif', 1)
            ->where('tahun_ajaran_id', $pengaturan->tahun_ajaran_id)
            ->join('users', 'siswas.user_id', '=', 'users.id') // Menyambungkan dengan tabel users
            ->orderBy('users.name', 'asc') // Mengurutkan berdasarkan nama di tabel users
            ->select('siswas.*') // Memilih kolom dari tabel gurus agar tidak terjadi duplikasi
            ->paginate(250);
        $kelas = Kelas::with('jurusan')->get();

        return view('siswa.index', [
            'data' => $data,
            'kelas' => $kelas,
            'pengaturan' => $pengaturan
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $kelas = Kelas::with('jurusan.bidangKeahlian')->get();
        $pengaturan = Pengaturan::first();

        return view('siswa.add', [
            'kelas' => $kelas,
            'pengaturan' => $pengaturan,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi input
        $validatedData = $request->validate([
            'kelas_id' => 'required|string',
            'aktif' => 'nullable|string',
            'gambar' => 'nullable|string',
            'nis' => 'required|unique:siswas,nis',
            'nisn' => 'nullable|string',
            'nama' => 'required|string|max:255',
            'tempat_lahir' => 'nullable|string',
            'tanggal_lahir' => 'nullable|string',
            'jenis_kelamin' => 'required',
            'agama' => 'nullable|string',
            'alamat' => 'nullable|string',
            'no_telp' => 'nullable|string',
            'tahun_ajaran_id' => 'required',

            'email' => 'required|string|unique:users,email|max:255',
            'password' => 'required',

            'nama_wali' => 'required',
            'pekerjaan' => 'nullable|string',
            'no_telp_wali' => 'required|string|unique:wali_siswas,no_telp',
            'jenis_kelamin_wali' => 'nullable|string',

            'email_wali' => 'required|string|unique:users,email|max:255',
            'password_wali' => 'required',
        ]);


        // Create user data
        $userData = [
            'name' => $validatedData['nama'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
        ];

        // kondisi cek gambar
        if (!empty($validatedData['gambar'])) {
            $tmp_file = TemporaryFile::where('folder', $validatedData['gambar'])->first();

            if ($tmp_file) {
                Storage::copy('posts/tmp/' . $tmp_file->folder . '/'.$tmp_file->file, 'posts/' . $tmp_file->folder . '/' . $tmp_file->file);

                $userData['gambar'] = $tmp_file->folder . '/' . $tmp_file->file;

                Storage::deleteDirectory('posts/tmp/' . $tmp_file->folder);
                $tmp_file->delete();
            }
        } else {
            $userData['gambar'] = null;
        }

        // Create user
        $user = User::create($userData);
        
        // Assign role
        $user->assignRole('siswa');

        // create siswa 
        $siswaData = collect($validatedData)->except([
            'gambar', 
            'email', 
            'password',
            'nama_wali',
            'pekerjaan',
            'no_telp_wali',
            'jenis_kelamin',
            ])->toArray();
        $siswaData['user_id'] = $user->id;
        $siswa = Siswa::create($siswaData);

        //====== create wali siswa

        // Create user data
        $userData2 = [
            'name' => $validatedData['nama_wali'],
            'email' => $validatedData['email_wali'],
            'password' => Hash::make($validatedData['password_wali']),
        ];
        $user2 = User::create($userData2);
        $user2->assignRole('siswa');

        WaliSiswa::create([
            'user_id' => $user2->id,
            'siswa_id' => $siswa->id,
            'pekerjaan' => $validatedData['pekerjaan'],
            'no_telp' => $validatedData['no_telp_wali'],
            'jenis_kelamin' => $validatedData['jenis_kelamin_wali'],
        ]);

        return redirect('siswa')->with('status', 'Data berhasil ditambah!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Siswa $siswa)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Siswa $siswa)
    {
        $kelas = Kelas::get();

        $siswa = Siswa::with(['walisiswa', 'tahunAjaran'])->findOrFail($siswa->id);

        return view('siswa.edit', [
            'data' => $siswa,
            'kelas' => $kelas,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($id, Request $request)
    {
        $siswa = Siswa::with(['user', 'walisiswa.user'])->findOrFail($id);
        $user = $siswa->user;

        // Validasi input
        $validatedData = $request->validate([
            'data.*.ortu_id' => 'required|string',
            'kelas_id' => 'required|string',
            'aktif' => 'nullable|string',
            'gambar' => 'nullable|string',
            'nis' => 'required|unique:siswas,nis,' . $id,
            'nisn' => 'nullable|string',
            'nama' => 'required|string|max:255',
            'tempat_lahir' => 'nullable|string',
            'tanggal_lahir' => 'nullable|string',
            'jenis_kelamin' => 'required',
            'agama' => 'nullable|string',
            'alamat' => 'nullable|string',
            'no_telp' => 'nullable|string',

            'nama_wali' => 'required',
            'pekerjaan' => 'nullable|string',
            'no_telp_wali' => 'required|string|unique:wali_siswas,no_telp,' . $siswa->walisiswa->id,
            'jenis_kelamin_wali' => 'nullable|string',
        ]);

        $siswaData = collect($validatedData)->except([
            'gambar',
            'nama_wali',
            'pekerjaan',
            'no_telp_wali',
            'jenis_kelamin_wali',
            ])->toArray();

        // Cek apakah ada gambar baru
        if (!empty($validatedData['gambar'])) {
            $tmp_file = TemporaryFile::where('folder', $validatedData['gambar'])->first();

            if ($tmp_file) {
                // Hapus gambar lama dari user jika ada
                if ($user->gambar) {
                    Storage::delete('posts/' . $user->gambar);
                }

                // Pindahkan gambar baru ke direktori final
                $path = 'posts/' . $tmp_file->folder . '/' . $tmp_file->file;
                Storage::copy('posts/tmp/' . $tmp_file->folder . '/' . $tmp_file->file, $path);

                // Update gambar pada user
                $user->gambar = $tmp_file->folder . '/' . $tmp_file->file;
                $user->save();

                // Hapus temporary file dan direktori
                Storage::deleteDirectory('posts/tmp/' . $tmp_file->folder);
                $tmp_file->delete();
            }
        } else {
            // Jika tidak ada gambar baru, hapus gambar lama jika ada
            if ($user->gambar) {
                Storage::delete('posts/' . $user->gambar);
                $user->gambar = null;
                $user->save();
            }
        }

        // update
        $user->name = $validatedData['nama'];
        $user->save();

        $siswa->update($siswaData);

        //====== update wali siswa

        $waliSiswa = $siswa->waliSiswa;
        $user2 = $siswa->walisiswa->user;

        // update nama user
        $user2->name = $validatedData['nama_wali'];
        $user2->save();

        // upate wali siswa
        $waliSiswa->update([
            'pekerjaan' => $validatedData['pekerjaan'],
            'no_telp' => $validatedData['no_telp_wali'],
            'jenis_kelamin' => $validatedData['jenis_kelamin_wali'],
        ]);

        return redirect('siswa')->with('status', 'Data berhasil diubah!');
    }

    public function destroy($id)
    {
        $data = $this->model->findOrFail($id);

        // Hapus gambar dan foldernya dari storage
        if ($data->user->gambar) {
            $folderPath = 'posts/' . dirname($data->user->gambar);
            Storage::deleteDirectory($folderPath);
        }
        $data->delete();

        return response()->json(['success' => true]);
    }

    public function deleteMultiple(Request $request)
    {
        $ids = $request->input('ids');

        // Ambil semua data guru berdasarkan ID yang dipilih
        $datas = $this->model->whereIn('id', $ids)->get();

        foreach ($datas as $data) {
            // Hapus gambar dan foldernya dari storage
            if ($data->user->gambar) {
                $folderPath = 'posts/' . dirname($data->user->gambar);
                Storage::deleteDirectory($folderPath);
            }

            // Hapus datadata 
            $data->delete();
        }

        return response()->json(['success' => true]);
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

    public function unconfirm($id){
        $data = PilihanKota::where('siswa_id', $id)->first();

        if ($data) {
            $data->status = null;
            $data->save();

            return response()->json(['success' => true]);
        } else {
            return response()->json(['success' => false]);
        }
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

    public function import(Request $request){
        try {
            Excel::import(new SiswaImport, $request->file('excel'));
            return redirect()->back()->with('status', 'Data berhasil diimpor!');
        } catch (ValidationException $e) {
            $errors = $e->validator->errors()->getMessages();

            return redirect()->back()->withErrors($errors)->withInput();
        }
    }

    public function export() 
    {
        return (new SiswaExport)->download('siswa-'.Carbon::now()->timestamp.'.xlsx');
    }

    public function downloadTemplate()
    {
        $filePath = public_path('files/siswa.xlsx'); 
        return Response::download($filePath);
    }

    public function filter(Request $request)
    {
        $kelas = $request->kelas; // Ambil parameter kelas dari request
        

        $kelas = Kelas::with('jurusan.bidangKeahlian')
            ->get()
            ->first(function ($k) use ($kelas) {
                // Gabungkan nama kelas dengan jurusan dan klasifikasi untuk dibandingkan
                $nama = $k->nama . " " . $k->jurusan->singkatan . " " . $k->klasifikasi;
                return $kelas == $nama; // Bandingkan nama yang sudah dibentuk dengan row
            });

        // saya ingin filter siswa dari kelas id
        $siswa = Siswa::with(['kelas', 'user'])
            ->where('aktif', 1)
            ->where('kelas_id', $kelas->id) 
            ->get();

        $items = [];
        foreach ($siswa as $d) {
            $items[] = [
                'id' => $d->id ?? '-',
                'nis' => $d->nis ?? '-',
                'nama' => $d->nama ?? '-',
                'jenis_kelamin' => $d->jenis_kelamin ?? '-',
                'agama' => $d->agama ?? '-',
                'kelas' => $d->kelas->nama . " " . $d->kelas->jurusan->singkatan . " " . $d->kelas->klasifikasi ?? '-',
                'tahun_ajaran' => Pengaturan::first()->tahun_ajaran ?? '-', // Tambahkan jika diperlukan
                'email' => $d->user->email ?? '-',
                'gambar' => $d->gambar, 
                'action' => $d->id ?? '-', 

                '_user_id' => $d->user_id ?? '-', 
                '_kelas_id' => $d->kelas->nama ?? '-',
                '_aktif' => $d->aktif ?? '-',
                '_gambar' => $d->gambar,
                '_nis' => $d->nis ?? '-',
                '_nisn' => $d->nisn ?? '-',
                '_nama_lengkap' => $d->user->name?? '-',
                '_nama' => $d->nama ?? '-',
                '_tempat_lahir' => $d->tempat_lahir ?? '-',
                '_tanggal_lahir' => $d->tanggal_lahir ?? '-',
                '_jenis_kelamin' => $d->jenis_kelamin ?? '-', 
                '_agama' => $d->agama ?? '-',
                '_alamat' => $d->alamat ?? '-',
                '_no_telp' => $d->no_telp ?? '-',
                '_email' => $d->user->email ?? '-',
            ];
        }

        // Return data dalam format JSON untuk di-render oleh simple-datatables
        return response()->json($items);
    }

    public function indexWali()
    {
        $data = Siswa::with(['kelas', 'user', 'walisiswa.user'])
            ->where('siswas.aktif', 1)
            ->join('users as siswa_user', 'siswas.user_id', '=', 'siswa_user.id') // Join untuk user siswa
            ->join('wali_siswas', 'siswas.id', '=', 'wali_siswas.siswa_id') // Join ke wali siswa
            ->join('users as wali_user', 'wali_siswas.user_id', '=', 'wali_user.id') // Join untuk user wali siswa
            ->orderBy('wali_user.name', 'asc') // Urutkan berdasarkan nama wali siswa
            ->select('siswas.*') 
            ->whereHas('user')
            ->paginate(250);
        $pengaturan = Pengaturan::first();
        $kelas = Kelas::with('jurusan')->get();

        return view('siswa.index_wali', [
            'data' => $data,
            'kelas' => $kelas,
            'pengaturan' => $pengaturan
        ]);
    }
    public function updateWali()
    {
    }

    public function resetPasswordWali($id)
    {
        $user = User::find($id);

        if ($user) {
            $user->password = Hash::make('password');
            $user->save();

            return response()->json(['success' => true]);
        } else {
            return response()->json(['success' => false]);
        }
    }
}
