<?php

namespace App\Http\Controllers;

use App\Models\Kontrak;
use App\Models\Sp2d;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class Sp2dController extends Controller
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
                'jumlah' => 'required',
                'dokumen' => 'required',
            ]);
        } catch (\Illuminate\Validation\ValidationException $exception) {
            return redirect()->back()->with('failed', $exception->getMessage());
        }

        if ($request->file('dokumen')) {
            $validatedData['dokumen'] = $request->file('dokumen')->store('dokumen-sp2d');
        }

        Sp2d::create($validatedData);

        return redirect()->back()->with('success', 'Sp2d baru berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Kontrak $sp2d)
    {
        $title = "Data Sp2d - " . $sp2d->nomor;
        $sp2dses = Sp2d::where('kontrak_id', $sp2d->id)->get();
        return view('dashboard.pagu.sp2d.index')->with(compact('title', 'sp2dses', 'sp2d'));
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
    public function update(Request $request, Sp2d $sp2d)
    {
        try {
            $rules = [
                'nomor' => 'required',
                'tanggal' => 'required',
                'jumlah' => 'required',
                'dokumen' => 'required',
            ];

            $validatedData = $this->validate($request, $rules);


            if ($request->file('dokumen')) {
                if ($request->oldDokumen) {
                    Storage::delete($request->oldDokumen);
                }
                $validatedData['dokumen'] = $request->file('dokumen')->storeAs('dokumen-sp2d', $validatedData['dokumen']->getClientOriginalName());
            }

            Sp2d::where('id', $sp2d->id)->update($validatedData);

            return redirect()->back()->with('success', "Data Sp2d $sp2d->nomor berhasil diperbarui!");
        } catch (\Illuminate\Validation\ValidationException $exception) {
            return redirect()->back()->with('failed', 'Data gagal diperbarui! ' . $exception->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Sp2d $sp2d)
    {
        try {

            if ($sp2d->dokumen) {
                Storage::delete($sp2d->dokumen);
            }

            Sp2d::destroy($sp2d->id);
        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->getCode() == 23000) {
                //SQLSTATE[23000]: Integrity constraint violation
                return redirect()->back()->with('failed', "Sp2d $sp2d->nomor tidak dapat dihapus, karena sedang digunakan!");
            }
        }

        return redirect()->back()->with('success', "Sp2d $sp2d->nomor berhasil dihapus!");
    }
}
