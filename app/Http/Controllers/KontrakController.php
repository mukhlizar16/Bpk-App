<?php

namespace App\Http\Controllers;

use App\Models\Kontrak;
use App\Models\Pagu;
use Illuminate\Http\Request;

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
        return view('dashboard.pagu.kontrak.index')->with(compact('title', 'kontraks', 'pagus'));
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
        try {
            $validatedData = $request->validate([
                'pagu_id' => 'required',
                'penyedia' => 'required',
                'nomor' => 'required',
                'tanggal' => 'required',
                'jumlah' => 'required',
                'jangka_waktu' => 'required',
                'bukti' => 'required',
                'hps' => 'required',
                'dokumen' => 'required',
            ]);
        } catch (\Illuminate\Validation\ValidationException $exception) {
            return redirect()->route('kontrak.index')->with('failed', $exception->getMessage());
        }

        Kontrak::create($validatedData);

        return redirect()->route('kontrak.index')->with('success', 'Kontrak baru berhasil ditambahkan!');
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
        try {
            $rules = [
                'pagu_id' => 'required',
                'penyedia' => 'required',
                'nomor' => 'required',
                'tanggal' => 'required',
                'jumlah' => 'required',
                'jangka_waktu' => 'required',
                'bukti' => 'required',
                'hps' => 'required',
                'dokumen' => 'required',
            ];

            $validatedData = $this->validate($request, $rules);

            Kontrak::where('id', $kontrak->id)->update($validatedData);

            return redirect()->route('kontrak.index')->with('success', "Data Kontrak $kontrak->keterangan berhasil diperbarui!");
        } catch (\Illuminate\Validation\ValidationException $exception) {
            return redirect()->route('kontrak.index')->with('failed', 'Data gagal diperbarui! ' . $exception->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Kontrak $kontrak)
    {
        try {
            Kontrak::destroy($kontrak->id);
        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->getCode() == 23000) {
                //SQLSTATE[23000]: Integrity constraint violation
                return redirect()->route('kontrak.index')->with('failed', "Kontrak $kontrak->keterangan tidak dapat dihapus, karena sedang digunakan!");
            }
        }

        return redirect()->route('kontrak.index')->with('success', "Kontrak $kontrak->keterangan berhasil dihapus!");
    }
}
