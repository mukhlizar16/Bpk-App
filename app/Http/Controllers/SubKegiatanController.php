<?php

namespace App\Http\Controllers;

use App\Models\Kegiatan;
use App\Models\Subkegiatan;
use Illuminate\Http\Request;

class SubKegiatanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = "Data Sub Kegiatan";
        $subkegiatans = Subkegiatan::all();
        $kegiatans = Kegiatan::all();
        return view('dashboard.kegiatan.sub-kegiatan.index')->with(compact('title', 'subkegiatans', 'kegiatans'));
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
                'kegiatan_id' => 'required',
                'kode' => 'required',
                'keterangan' => 'required',
            ]);
        } catch (\Illuminate\Validation\ValidationException $exception) {
            return redirect()->back()->with('failed', $exception->getMessage());
        }

        Subkegiatan::create($validatedData);

        return redirect()->back()->with('success', 'Sub Kegiatan baru berhasil ditambahkan!');
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
    public function update(Request $request, Subkegiatan $sub_kegiatan)
    {
        try {
            $rules = [
                'kegiatan_id' => 'required',
                'kode' => 'required',
                'keterangan' => 'required',
            ];

            $validatedData = $this->validate($request, $rules);

            Subkegiatan::where('id', $sub_kegiatan->id)->update($validatedData);

            return redirect()->back()->with('success', "Data Sub Kegiatan $sub_kegiatan->keterangan berhasil diperbarui!");
        } catch (\Illuminate\Validation\ValidationException $exception) {
            return redirect()->back()->with('failed', 'Data gagal diperbarui! ' . $exception->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Subkegiatan $sub_kegiatan)
    {
        try {
            SubKegiatan::destroy($sub_kegiatan->id);
        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->getCode() == 23000) {
                //SQLSTATE[23000]: Integrity constraint violation
                return redirect()->back()->with('failed', "Sub Kegiatan $sub_kegiatan->keterangan tidak dapat dihapus, karena sedang digunakan!");
            }
        }

        return redirect()->back()->with('success', "Sub Kegiatan $sub_kegiatan->keterangan berhasil dihapus!");
    }
}
