<?php

namespace App\Http\Controllers;

use App\Models\Pagu;
use App\Models\RealisasiKeuangan;
use Illuminate\Http\Request;

class KeuanganController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = "Data Realisasi Keuangan " ;
        $keuangans = RealisasiKeuangan::all();
        $pagus = Pagu::all();
        return view('dashboard.pagu.keuangan.index')->with(compact('title', 'keuangans', 'pagus'));
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
                'nilai' => 'required',
                'bobot' => 'required',
            ]);
        } catch (\Illuminate\Validation\ValidationException $exception) {
            return redirect()->back()->with('failed', $exception->getMessage());
        }

        RealisasiKeuangan::create($validatedData);

        return redirect()->back()->with('success', 'Keuangan baru berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Pagu $keuangan)
    {

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
    public function update(Request $request, RealisasiKeuangan $keuangan)
    {
        try {
            $rules = [
                'nilai' => 'required',
                'bobot' => 'required',
            ];

            $validatedData = $this->validate($request, $rules);

            RealisasiKeuangan::where('id', $keuangan->id)->update($validatedData);

            return redirect()->back()->with('success', "Data Keuangan $keuangan->nilai berhasil diperbarui!");
        } catch (\Illuminate\Validation\ValidationException $exception) {
            return redirect()->back()->with('failed', 'Data gagal diperbarui! ' . $exception->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(RealisasiKeuangan $keuangan)
    {
        try {
            RealisasiKeuangan::destroy($keuangan->id);
        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->getCode() == 23000) {
                //SQLSTATE[23000]: Integrity constraint violation
                return redirect()->back()->with('failed', "Keuangan $keuangan->nilai tidak dapat dihapus, karena sedang digunakan!");
            }
        }

        return redirect()->back()->with('success', "Keuangan $keuangan->nilai berhasil dihapus!");
    }
}
