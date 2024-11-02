<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\Jurusan;
use App\Models\Kelas;
use App\Models\User;
use Illuminate\Http\Request;

class KelasController extends Controller
{
    protected $model;
    public function __construct(Kelas $a)
    {
        $this->model = $a;

        $this->middleware('can:c_kelas')->only(['create', 'store']);
        $this->middleware('can:r_kelas')->only(['index', 'show']);
        $this->middleware('can:u_kelas')->only(['edit', 'update']);
        $this->middleware('can:d_kelas')->only('destroy');
    }

    public function index()
    {
        $data = Kelas::with(['jurusan.bidangKeahlian', 'jurusan2', 'guru'])
            ->where('aktif', 1)
            ->get();

        return view('kelas.index', [
            'data' => $data
        ]);
    }

    public function create()
    {
        $jurusan = Jurusan::get();
        $subJurusan = Jurusan::whereNotNull('jurusan_id')->get();
        $guru = Guru::with('user')->get();

        return view('kelas.add', [
            'jurusan' => $jurusan,
            'subJurusan' => $subJurusan,
            'guru' => $guru,
        ]);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama' => 'required|string',
            'jurusan_id' => 'required',
            'jurusan_id_2' => 'nullable',
            'klasifikasi' => 'required|string',
            'guru_id' => 'required',
        ]);

        $guru = Guru::with('user')->findOrFail($validatedData['guru_id']);
        $user = User::findOrFail($guru->user->id);
        $user->assignRole('wali_kelas');

        $create = collect($validatedData);

        $this->model->create($create->toArray());

        return redirect('kelas')->with('status', 'Data berhasil ditambah!');
    }

    public function edit($id)
    {

        $kelas = Kelas::findOrFail($id);
        $jurusan = Jurusan::get();
        $subJurusan = Jurusan::whereNotNull('jurusan_id')->get();
        $guru = Guru::with('user')->get();

        return view('kelas.edit', [
            'data' => $kelas,
            'jurusan' => $jurusan,
            'subJurusan' => $subJurusan,
            'guru' => $guru,
        ]);
    }

    public function update($id, Request $request)
    {
        $data = $this->model->findOrFail($id);

        $validatedData = $request->validate([
            'nama' => 'required|string',
            'jurusan_id' => 'required',
            'jurusan_id_2' => 'nullable',
            'klasifikasi' => 'required|string',
            'guru_id' => 'required',
        ]);


        $kelas = Kelas::findOrFail($id);
        $oldGuru = Guru::with('user')->findOrFail($kelas->guru_id);
        $oldUser = User::findOrFail($oldGuru->user->id);
        $oldUser->removeRole('wali_kelas');

        $guru = Guru::with('user')->findOrFail($validatedData['guru_id']);
        $user = User::findOrFail($guru->user->id);
        $user->assignRole('wali_kelas');

        $update = collect($validatedData);

        $data->update($update->toArray());

        return redirect('kelas')->with('status', 'Data berhasil ditambah!');
    }

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

    public function deleteMultiple(Request $request)
    {
        $ids = $request->input('ids');

        $datas = Kelas::whereIn('id', $ids)->get();

        foreach ($datas as $data) {
            $data->delete();
        }

        return response()->json(['success' => true]);
    }
}
