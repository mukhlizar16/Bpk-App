<?php

namespace App\Http\Controllers;

use App\Exports\PaguDataExport;
use App\Models\JenisPengadaan;
use App\Models\Pagu;
use App\Models\Subkegiatan;
use App\Models\SumberDana;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class PaguController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = "Data Pagu";
        $pagus = Pagu::all();
        $subs = Subkegiatan::all();
        $danas = SumberDana::all();
        return view('dashboard.pagu.index')->with(compact('title', 'pagus', 'subs', 'danas'));
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
                'subkegiatan_id' => 'required',
                'paket' => 'required',
                'sumber_dana_id' => 'required',
                'jumlah' => 'required',

            ]);
        } catch (\Illuminate\Validation\ValidationException $exception) {
            return redirect()->route('pagu.index')->with('failed', $exception->getMessage());
        }

        Pagu::create($validatedData);

        return redirect()->route('pagu.index')->with('success', 'Pagu baru berhasil ditambahkan!');
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
    public function update(Request $request, Pagu $pagu)
    {
        try {
            $rules = [
                'subkegiatan_id' => 'required',
                'paket' => 'required',
                'sumber_dana_id' => 'required',
                'jumlah' => 'required',

            ];

            $validatedData = $this->validate($request, $rules);

            Pagu::where('id', $pagu->id)->update($validatedData);

            return redirect()->route('pagu.index')->with('success', "Data Pagu $pagu->keterangan berhasil diperbarui!");
        } catch (\Illuminate\Validation\ValidationException $exception) {
            return redirect()->route('pagu.index')->with('failed', 'Data gagal diperbarui! ' . $exception->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pagu $pagu)
    {
        try {
            Pagu::destroy($pagu->id);
        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->getCode() == 23000) {
                //SQLSTATE[23000]: Integrity constraint violation
                return redirect()->route('pagu.index')->with('failed', "Pagu $pagu->keterangan tidak dapat dihapus, karena sedang digunakan!");
            }
        }

        return redirect()->route('pagu.index')->with('success', "Pagu $pagu->keterangan berhasil dihapus!");
    }

    public function exportAll()
    {
        return Excel::download(new PaguDataExport, 'Data_Pagu.xlsx');
    }
}
