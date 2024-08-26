<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JenisPengadaan;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\JenisPengadaanRequest;

class PengadaanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = "Data Jenis Pengadaan";
        $pengadaans = JenisPengadaan::all();
        return view('dashboard.pengadaan.index')->with(compact('title', 'pengadaans'));
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
    public function store(JenisPengadaanRequest $request)
    {
        JenisPengadaan::create($request->validated());
        return to_route('pengadaan.index')->with('success', 'Berhasil disimpan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(JenisPengadaanRequest $request, JenisPengadaan $pengadaan)
    {
        $pengadaan->update($request->validated());
        return to_route('pengadaan.index')->with('success', 'Berhasil diupdate.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(JenisPengadaan $pengadaan)
    {
        $pengadaan->delete();
        DB::statement('ALTER TABLE jenis_pengadaan AUTO_INCREMENT=1');
        return to_route('pengadaan.index')->with('success', 'Berhasil dihapus.');
    }
}
