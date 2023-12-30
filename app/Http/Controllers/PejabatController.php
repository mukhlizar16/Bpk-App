<?php

namespace App\Http\Controllers;

use App\Models\Jabatan;
use App\Models\Pejabat;
use Illuminate\Http\Request;

class PejabatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = "Data Pejabat";
        $jabatans = Jabatan::all();
        $pejabats = Pejabat::with('Jabatan')->get();
        return view('dashboard.jabatan.index')->with(compact('title', 'jabatans', 'pejabats'));
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
                'nama' => 'required|max:255',
                'jabatan_id' => 'required',
                'hp' => 'required|max:12'
            ]);
        } catch (\Illuminate\Validation\ValidationException $exception) {
            return redirect()->route('pejabat.index')->with('failed', $exception->getMessage());
        }

        Pejabat::create($validatedData);

        return redirect()->route('pejabat.index')->with('success', 'Pejabat baru berhasil ditambahkan!');
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
    public function update(Request $request, Pejabat $pejabat)
    {
        try {
            $rules = [
                'nama' => 'required|max:255',
                'jabatan_id' => 'required',
                'hp' => 'required|max:12',
            ];

            $validatedData = $this->validate($request, $rules);

            Pejabat::where('id', $pejabat->id)->update($validatedData);

            return redirect()->route('pejabat.index')->with('success', "Data pejabat $pejabat->nama berhasil diperbarui!");
        } catch (\Illuminate\Validation\ValidationException $exception) {
            return redirect()->route('pejabat.index')->with('failed', 'Data pejabat gagal diperbarui! ' . $exception->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pejabat $pejabat)
    {
        try {
            Pejabat::destroy($pejabat->id);
        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->getCode() == 23000) {
                //SQLSTATE[23000]: Integrity constraint violation
                return redirect()->route('pejabat.index')->with('failed', "Pejabat $pejabat->nama tidak dapat dihapus, karena sedang digunakan!");
            }
        }

        return redirect()->route('pejabat.index')->with('success', "Pejabat $pejabat->nama berhasil dihapus!");
    }
}
