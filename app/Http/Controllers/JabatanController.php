<?php

namespace App\Http\Controllers;

use App\Models\Jabatan;
use Illuminate\Http\Request;

class JabatanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $jabatans = Jabatan::all();
        $title = "Data Jabatan";
        return view('dashboard.jabatan.jabatan')->with(compact('title', 'jabatans'));
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
            ]);
        } catch (\Illuminate\Validation\ValidationException $exception) {
            return redirect()->route('jabatan.index')->with('failed', $exception->getMessage());
        }

        Jabatan::create($validatedData);

        return redirect()->route('jabatan.index')->with('success', 'Jabatan baru berhasil ditambahkan!');
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
    public function update(Request $request, Jabatan $jabatan)
    {
        try {
            $rules = [
                'nama' => 'required|max:255'
            ];

            $validatedData = $this->validate($request, $rules);

            Jabatan::where('id', $jabatan->id)->update($validatedData);

            return redirect()->route('jabatan.index')->with('success', "Data jabatan $jabatan->nam berhasil diperbarui!");
        } catch (\Illuminate\Validation\ValidationException $exception) {
            return redirect()->route('jabatan.index')->with('failed', 'Data jabatan gagal diperbarui! ' . $exception->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Jabatan $jabatan)
    {
        try {
            Jabatan::destroy($jabatan->id);
        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->getCode() == 23000) {
                //SQLSTATE[23000]: Integrity constraint violation
                return redirect()->route('jabatan.index')->with('failed', "Jabatan $jabatan->nama tidak dapat dihapus, karena sedang digunakan!");
            }
        }

        return redirect()->route('jabatan.index')->with('success', "Jabatan $jabatan->nama berhasil dihapus!");
    }
}
