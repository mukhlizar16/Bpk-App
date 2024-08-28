<?php

namespace App\Http\Controllers;

use App\Models\Bap;
use App\Models\Pagu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BapController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = "Data Bap";
        $baps = Bap::with('pagu')->get();
        $pagus = Pagu::all();
        return view('dashboard.berita-acara.pemeriksaan.index', compact('title', 'baps', 'pagus'));
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
                'nomor' => 'required',
                'pagu_id' => 'required',
                'tanggal' => 'required',
            ]);
        } catch (\Illuminate\Validation\ValidationException $exception) {
            return redirect()->back()->with('failed', $exception->getMessage());
        }

        Bap::create($validatedData);

        return redirect()->back()->with('success', 'Bap baru berhasil ditambahkan!');
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
    public function update(Request $request, Bap $pemeriksaan)
    {
        try {
            $rules = [
                'nomor' => 'required',
                'pagu_id' => 'required',
                'tanggal' => 'required',
            ];

            $validatedData = $this->validate($request, $rules);

            $pemeriksaan->update($validatedData);

            return redirect()->back()->with('success', "Data Bap $pemeriksaan->nomor berhasil diperbarui!");
        } catch (\Illuminate\Validation\ValidationException $exception) {
            return redirect()->back()->with('failed', 'Data gagal diperbarui! ' . $exception->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Bap $pemeriksaan)
    {
        try {
            $pemeriksaan->delete();
            DB::statement('ALTER TABLE bap AUTO_INCREMENT=1');
        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->getCode() == 23000) {
                //SQLSTATE[23000]: Integrity constraint violation
                return redirect()->back()->with('failed', "Bap $pemeriksaan->nomor tidak dapat dihapus, karena sedang digunakan!");
            }
        }

        return redirect()->back()->with('success', "Bap $pemeriksaan->nomor berhasil dihapus!");
    }
}
