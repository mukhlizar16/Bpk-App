<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBastPhoRequest;
use App\Models\BastPho;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class BastPhoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = "Data Bast Pho";
        $basts = BastPho::all();
        return view('dashboard.berita-acara.bast-pho.index', compact('title', 'basts'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBastPhoRequest $request)
    {
        BastPho::create($request->validated());
        return redirect()->back()->with('success', 'Bast baru berhasil ditambahkan!');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
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

            BastPho::find($bast_pho->id)->update($validatedData);

            return redirect()->back()->with('success', "Data Bast Pho $bast_pho->nomor berhasil diperbarui!");
        } catch (ValidationException $exception) {
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
        } catch (QueryException $e) {
            if ($e->getCode() == 23000) {
                //SQLSTATE[23000]: Integrity constraint violation
                return redirect()->back()->with('failed', "Bast Pho $bast_pho->nomor tidak dapat dihapus, karena sedang digunakan!");
            }
        }

        return redirect()->back()->with('success', "Bast Pho $bast_pho->nomor berhasil dihapus!");
    }
}
