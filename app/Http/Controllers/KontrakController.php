<?php

namespace App\Http\Controllers;

use App\Models\JenisPengadaan;
use App\Models\Kontrak;
use App\Models\Pagu;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class KontrakController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = "Data Kontrak";
        $kontraks = Kontrak::all();
        $pagus = Pagu::all();
        $jenises = JenisPengadaan::all();
        return view('dashboard.pagu.kontrak.index')->with(compact('title', 'kontraks', 'pagus', 'jenises'));
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
    public function update(Request $request, Kontrak $kontrak)
    {
        $rules = [
            'pagu_id' => 'required',
            'pengadaan_id' => 'required',
            'penyedia' => 'required',
            'nomor' => 'required',
            'tanggal' => 'required',
            'nilai_kontrak' => 'required',
            'jangka_waktu' => 'required',
            'bukti' => 'required',
            'cara_pengadaan' => 'required',
            'hps' => 'required',
        ];

        $validatedData = $this->validate($request, $rules);

        if ($request->file('dokumen')) {
            if ($request->oldDokumen) {
                Storage::delete($request->oldDokumen);
            }
            $validatedData['dokumen'] = $request->file('dokumen')->store('dokumen-kontrak');
        }

        Kontrak::find($kontrak->id)->update($validatedData);

        return redirect()->route('kontrak.index')->with('success', "Data Kontrak $kontrak->keterangan berhasil diperbarui!");

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'pagu_id' => 'required',
            'pengadaan_id' => 'required',
            'penyedia' => 'required',
            'nomor' => 'required',
            'tanggal' => 'required',
            'nilai_kontrak' => 'required',
            'jangka_waktu' => 'required',
            'bukti' => 'required',
            'hps' => 'required',
            'dokumen' => 'required',
        ]);

        if ($request->file('dokumen')) {
            $validatedData['dokumen'] = $request->file('dokumen')->store('dokumen-kontrak');
        }

        Kontrak::create($validatedData);

        return redirect()->route('kontrak.index')->with('success', 'Kontrak baru berhasil ditambahkan!');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Kontrak $kontrak)
    {
        try {
            if ($kontrak->dokumen) {
                Storage::delete($kontrak->dokumen);
            }
            Kontrak::destroy($kontrak->id);
        } catch (QueryException $e) {
            if ($e->getCode() == 23000) {
                //SQLSTATE[23000]: Integrity constraint violation
                return redirect()->route('kontrak.index')->with('failed', "Kontrak $kontrak->keterangan tidak dapat dihapus, karena sedang digunakan!");
            }
        }

        return redirect()->route('kontrak.index')->with('success', "Kontrak $kontrak->keterangan berhasil dihapus!");
    }
}
