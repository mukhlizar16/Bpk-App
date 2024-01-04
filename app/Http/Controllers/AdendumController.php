<?php

namespace App\Http\Controllers;

use App\Models\Adendum;
use App\Models\Kontrak;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdendumController extends Controller
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
                'kontrak_id' => 'required',
                'nomor' => 'required',
                'tanggal' => 'required',
                'keterangan' => 'required',
                'dokumen' => 'required',
            ]);
        } catch (\Illuminate\Validation\ValidationException $exception) {
            return redirect()->back()->with('failed', $exception->getMessage());
        }

        if ($request->file('dokumen')) {
            $validatedData['dokumen'] = $request->file('dokumen')->store('dokumen-adendum');
        }

        Adendum::create($validatedData);

        return redirect()->back()->with('success', 'Adendum baru berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Kontrak $adendum)
    {
        $title = "Data Adendum - " . $adendum->nomor;
        $adendumses = Adendum::where('kontrak_id', $adendum->id)->get();
        return view('dashboard.pagu.adendum.index')->with(compact('title', 'adendumses', 'adendum'));
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
    public function update(Request $request, Adendum $adendum)
    {
        try {
            $rules = [
                'nomor' => 'required',
                'tanggal' => 'required',
                'keterangan' => 'required',
                'dokumen' => 'required',
            ];

            $validatedData = $this->validate($request, $rules);

            if ($request->file('dokumen')) {
                if ($request->oldDokumen) {
                    Storage::delete($request->oldDokumen);
                }
                $validatedData['dokumen'] = $request->file('dokumen')->storeAs('dokumen-adendum', $validatedData['dokumen']->getClientOriginalName());
            }

            Adendum::where('id', $adendum->id)->update($validatedData);

            return redirect()->back()->with('success', "Data Adendum $adendum->nomor berhasil diperbarui!");
        } catch (\Illuminate\Validation\ValidationException $exception) {
            return redirect()->back()->with('failed', 'Data gagal diperbarui! ' . $exception->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Adendum $adendum)
    {
        try {

            if ($adendum->dokumen) {
                Storage::delete($adendum->dokumen);
            }

            Adendum::destroy($adendum->id);
        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->getCode() == 23000) {
                //SQLSTATE[23000]: Integrity constraint violation
                return redirect()->back()->with('failed', "Adendum $adendum->nomor tidak dapat dihapus, karena sedang digunakan!");
            }
        }

        return redirect()->back()->with('success', "Adendum $adendum->nomor berhasil dihapus!");
    }
}
