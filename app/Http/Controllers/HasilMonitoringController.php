<?php

namespace App\Http\Controllers;

use App\Models\HasilMonitoring;
use Illuminate\Http\Request;

class HasilMonitoringController extends Controller
{
    protected $model;
    public function __construct(HasilMonitoring $a)
    {
        $this->model = $a;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = HasilMonitoring::with(['monitoring.guru', 'monitoring.siswa'])->get();

        return view('hasil_monitoring.index', [
            'data' => $data
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(HasilMonitoring $hasilMonitoring)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(HasilMonitoring $hasilMonitoring)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, HasilMonitoring $hasilMonitoring)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(HasilMonitoring $hasilMonitoring)
    {
        //
    }
}
