<?php

namespace App\Http\Controllers;

use App\Models\PilihanKota;
use Illuminate\Http\Request;

class PilihanKotaController extends Controller
{
    protected $model;
    public function __construct(PilihanKota $a)
    {
        $this->model = $a;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = PilihanKota::with(['siswa', 'kota1', 'kota2', 'kota3'])->get();

        return view('pilihan_kota.index', [
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
    public function show(PilihanKota $pilihanKota)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PilihanKota $pilihanKota)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PilihanKota $pilihanKota)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PilihanKota $pilihanKota)
    {
        //
    }
}
