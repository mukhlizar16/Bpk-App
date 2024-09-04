<?php

namespace App\Http\Controllers;

use App\Models\Pagu;
use App\Models\Kontrak;
use Illuminate\Http\Request;
use App\Models\JenisPengadaan;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Requests\StoreKontrakRequest;
use App\Http\Requests\UpdateKontrakRequest;

class KontrakController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $title = "Data Kontrak";
        if ($request->ajax()) {
            $kontrak = Kontrak::with([
                'pagu',
                'jenisPengadaan',
                'adendum',
                'sp2d'
            ])->latest()->get();
            return DataTables::of($kontrak)
                ->addIndexColumn()
                ->addColumn('dokumen', function ($kontrak) {
                    if ($kontrak->dokumen) {
                        return ' <a class="btn btn-outline-primary text-nowrap"
                                    data-bs-toggle="tooltip" title="Unduh" href="' . asset('storage/' . $kontrak->dokumen) . '" download>
                                    <i class="fa-solid fa-download me-1"></i>
                                </a>';
                    } else {
                        return 'No document available.';
                    }
                })
                ->addColumn('action', function ($kontrak) {
                    return '<div class="text-center">
                            <div class="btn-group">
                                    <button type="button" class="btn btn-sm btn-warning btn-edit"
                                            data-id="' . $kontrak->id . '"
                                            data-pagu="' . $kontrak->pagu_id . '">
                                        <i class="fa fa-pencil"></i>
                                    </button>
                                    <button class="btn btn-sm btn-danger btn-delete" type="button"
                                        data-id="' . $kontrak->id . '"
                                        data-nomor="' . $kontrak->nomor . '">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </div>
                        </div>';
                })
                ->rawColumns(['dokumen', 'action'])
                ->make();
        }

        $pagus = Pagu::all();
        $jenises = JenisPengadaan::all();
        return view('dashboard.pagu.kontrak.index', compact('title', 'pagus', 'jenises'));
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
    public function edit($kontrak)
    {
        $data = Kontrak::with('pagu', 'jenisPengadaan')->find($kontrak);

        return response()->json($data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateKontrakRequest $request, Kontrak $kontrak)
    {
        $validatedData = $request->validated();

        if ($request->file('dokumen')) {
            if ($request->oldDokumen) {
                Storage::delete($request->oldDokumen);
            }
            $validatedData['dokumen'] = $request->file('dokumen')->store('dokumen-kontrak');
        }

        $kontrak->update($validatedData);

        return redirect()->route('kontrak.index')->with('success', "Data Kontrak dengan nomor $kontrak->nomor berhasil diperbarui!");

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreKontrakRequest $request)
    {
        $validatedData = $request->validated();
        //        dd($validatedData);
        if ($request->file('dokumen')) {
            $validatedData['dokumen'] = $request->file('dokumen')->store('dokumen-kontrak');
        }

        Kontrak::create($validatedData);

        return redirect()->route('kontrak.index')->with('success', 'Kontrak baru berhasil ditambahkan!');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Kontrak $kontrak)
    {
        try {
            if ($kontrak->dokumen && Storage::disk('public')->exists($kontrak->dokumen)) {
                Storage::delete($kontrak->dokumen);
            }
            Kontrak::destroy($kontrak->id);
        } catch (QueryException $e) {
            if ($e->getCode() == 23000) {
                //SQLSTATE[23000]: Integrity constraint violation
                return redirect()->route('kontrak.index')->with('failed', "Kontrak $kontrak->keterangan tidak dapat dihapus, karena sedang digunakan!");
            }
        }

        return redirect()->route('kontrak.index')->with('success', "Kontrak $kontrak->keterangan berhasil dihapus!");
    }
}
