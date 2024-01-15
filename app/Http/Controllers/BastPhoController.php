<?php

namespace App\Http\Controllers;

use App\Models\BastPho;
use Illuminate\Http\Request;

class BastPhoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = "Data Bast Pho";
        $basts = BastPho::all();
        return view('dashboard.berita-acara.bast-pho.index')->with(compact('title', 'basts'));
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
                'tanggal' => 'required',
            ]);
        } catch (\Illuminate\Validation\ValidationException $exception) {
            return redirect()->back()->with('failed', $exception->getMessage());
        }

        BastPho::create($validatedData);

        return redirect()->back()->with('success', 'Bast baru berhasil ditambahkan!');
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
    public function update(Request $request, BastPho $bast_pho)
    {
        try {
            $rules = [
                'nomor' => 'required',
                'tanggal' => 'required',
            ];

            $validatedData = $this->validate($request, $rules);

            BastPho::where('id', $bast_pho->id)->update($validatedData);

            return redirect()->back()->with('success', "Data Bast Pho $bast_pho->nomor berhasil diperbarui!");
        } catch (\Illuminate\Validation\ValidationException $exception) {
            return redirect()->back()->with('failed', 'Data gagal diperbarui! ' . $exception->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BastPho $bast_pho)
    {
        try {
            BastPho::destroy($bast_pho->id);
        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->getCode() == 23000) {
                //SQLSTATE[23000]: Integrity constraint violation
                return redirect()->back()->with('failed', "Bast Pho $bast_pho->nomor tidak dapat dihapus, karena sedang digunakan!");
            }
        }

        return redirect()->back()->with('success', "Bast Pho $bast_pho->nomor berhasil dihapus!");
    }
}
