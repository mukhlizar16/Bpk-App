<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreKontrakRequest;
use App\Http\Requests\UpdateKontrakRequest;
use App\Models\JenisPengadaan;
use App\Models\Kontrak;
use App\Models\Pagu;
use Illuminate\Database\QueryException;
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
        return view('dashboard.pagu.kontrak.index', compact('title', 'kontraks', 'pagus', 'jenises'));
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
    public function update(UpdateKontrakRequest $request, Kontrak $kontrak)
    {
        $validatedData = $request->validated();

        if ($request->file('dokumen')) {
            if ($request->oldDokumen) {
                Storage::delete($request->oldDokumen);
            }
            $validatedData['dokumen'] = $request->file('dokumen')->store('dokumen-kontrak');
        }

        $kontrak->update($validatedData);

        return redirect()->route('kontrak.index')->with('success', "Data Kontrak $kontrak->keterangan berhasil diperbarui!");

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreKontrakRequest $request)
    {
        $validatedData = $request->validated();
//        dd($validatedData);
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
