<?php

namespace App\Http\Controllers;

use App\Models\Pagu;
use App\Models\RealisasiFisik;
use Illuminate\Http\Request;

class FisikController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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

        RealisasiFisik::create($validatedData);

        return redirect()->back()->with('success', 'Fisik baru berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Pagu $fisik)
    {
        $title = "Data Realisasi Fisik - " . $fisik->paket;
        $fisiks = RealisasiFisik::where('pagu_id', $fisik->id)->get();
        return view('dashboard.pagu.fisik.index')->with(compact('title', 'fisiks', 'fisik'));
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
    public function update(Request $request, RealisasiFisik $fisik)
    {
        try {
            $rules = [
                'nilai' => 'required',
                'bobot' => 'required',
            ];

            $validatedData = $this->validate($request, $rules);

            RealisasiFisik::where('id', $fisik->id)->update($validatedData);

            return redirect()->back()->with('success', "Data Fisik $fisik->nilai berhasil diperbarui!");
        } catch (\Illuminate\Validation\ValidationException $exception) {
            return redirect()->back()->with('failed', 'Data gagal diperbarui! ' . $exception->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(RealisasiFisik $fisik)
    {
        try {
            RealisasiFisik::destroy($fisik->id);
        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->getCode() == 23000) {
                //SQLSTATE[23000]: Integrity constraint violation
                return redirect()->back()->with('failed', "Fisik $fisik->nilai tidak dapat dihapus, karena sedang digunakan!");
            }
        }

        return redirect()->back()->with('success', "Fisik $fisik->nilai berhasil dihapus!");
    }
}
