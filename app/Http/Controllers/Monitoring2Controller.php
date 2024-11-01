<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\Industri;
use App\Models\Monitoring;
use Illuminate\Http\Request;

class Monitoring2Controller extends Controller
{
    protected $model;
    public function __construct(Monitoring $a)
    {
        $this->model = $a;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Monitoring::with([
                'guru', 
                'industri',
                'hasilMonitoring'
                ])
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($item) {
                // Menambahkan key status berdasarkan kondisi whereHas hasilMonitoring
                $item->status = $item->hasilMonitoring()->exists() ? 'sudah monitoring' : 'belum monitoring';
                return $item;
            });

        dd($data);

        return view('monitoring2.index', [
            'data' => $data
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $guru = Guru::get();
        $industri = Industri::get();

        return view('monitoring2.add', [
            'guru' => $guru,
            'industri' => $industri,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'guru_id' => 'required',
            'industri_id' => 'required',
            'tanggal' => 'required',
        ]);

        $create = collect($validatedData);

        $this->model->create($create->toArray());

        return redirect('monitoring2')->with('status', 'Data berhasil ditambah!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Monitoring $monitoring)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Monitoring $monitoring)
    {
        $guru = Guru::get();
        $industri = Industri::get();

        return view('monitoring2.edit', [
            'data' => $monitoring,
            'guru' => $guru,
            'industri' => $industri,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($id, Request $request)
    {
        $data = $this->model->findOrFail($id);

        $validatedData = $request->validate([
            'guru_id' => 'required',
            'industri_id' => 'required',
            'tanggal' => 'required',
        ]);

        $update = collect($validatedData);

        $data->update($update->toArray());

        return redirect('monitoring2')->with('status', 'Data berhasil ditambah!');
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
}
