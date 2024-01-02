<?php

namespace App\Http\Controllers;

use App\Models\Pagu;
use App\Models\Spmk;
use Illuminate\Http\Request;

class SpmkController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = "Data Pagu";
        return view('dashboard.pagu.spmk.index')->with(compact('title'));
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
                'nomor' => 'required',
                'tanggal' => 'required',
                'dokumen' => 'required',
            ]);
        } catch (\Illuminate\Validation\ValidationException $exception) {
            return redirect()->back()->with('failed', $exception->getMessage());
        }

        Spmk::create($validatedData);

        return redirect()->back()->with('success', 'Spmk baru berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Pagu $spmk)
    {
        $title = "Data SPMK - " . $spmk->paket;
        $spmks = Spmk::where('pagu_id', $spmk->id)->get();
        return view('dashboard.pagu.spmk.index')->with(compact('title', 'spmks', 'spmk'));
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
    public function update(Request $request, Spmk $spmk)
    {
        try {
            $rules = [
                'nomor' => 'required',
                'tanggal' => 'required',
                'dokumen' => 'required',
            ];

            $validatedData = $this->validate($request, $rules);

            Spmk::where('id', $spmk->id)->update($validatedData);

            return redirect()->back()->with('success', "Data Spmk $spmk->nomor berhasil diperbarui!");
        } catch (\Illuminate\Validation\ValidationException $exception) {
            return redirect()->back()->with('failed', 'Data gagal diperbarui! ' . $exception->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Spmk $spmk)
    {
        try {
            Spmk::destroy($spmk->id);
        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->getCode() == 23000) {
                //SQLSTATE[23000]: Integrity constraint violation
                return redirect()->back()->with('failed', "Spmk $spmk->nomor tidak dapat dihapus, karena sedang digunakan!");
            }
        }

        return redirect()->back()->with('success', "Spmk $spmk->nomor berhasil dihapus!");
    }
}
