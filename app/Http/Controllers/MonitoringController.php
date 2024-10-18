<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\Industri;
use App\Models\Monitoring;
use Illuminate\Http\Request;

class MonitoringController extends Controller
{
    protected $model;
    public function __construct(Monitoring $a)
    {
        $this->model = $a;

        // $this->middleware('can:c_jadwal_monitoring`')->only(['create', 'store']);
        // $this->middleware('can:r_jadwal_monitoring`')->only(['index', 'show']);
        // $this->middleware('can:u_jadwal_monitoring`')->only(['edit', 'update']);
        // $this->middleware('can:d_jadwal_monitoring`')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Monitoring::with(['guru', 'industri'])->get();

        // $guru = Guru::with('user')->findOrFail(1);
        ///dd($guru->user->getRoleNames());

        
        // dd(auth()->user()->getRoleNames());
        // dd(auth()->user()->getAllPermissions());

        return view('monitoring.index', [
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

        return view('monitoring.add', [
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

        // assign role
        $guru = Guru::with('user')->findOrFail($validatedData['guru_id']);
        $guru->user->assignRole('pembimbing');

        // create 
        $create = collect($validatedData);
        $this->model->create($create->toArray());

        return redirect('monitoring')->with('status', 'Data berhasil ditambah!');
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

        return view('monitoring.edit', [
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
        $data = Monitoring::with('guru.user')->findOrFail($id);

        $validatedData = $request->validate([
            'guru_id' => 'required',
            'industri_id' => 'required',
            'tanggal' => 'required',
        ]);

        // remove role
        $data->guru->user->removeRole('pembimbing');

        // assign role
        $guru = Guru::with('user')->findOrFail($validatedData['guru_id']);
        $guru->user->assignRole('pembimbing');

        // update 
        $update = collect($validatedData);
        $data->update($update->toArray());

        return redirect('monitoring')->with('status', 'Data berhasil ditambah!');
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
