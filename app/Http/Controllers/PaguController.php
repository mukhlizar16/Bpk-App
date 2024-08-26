<?php

namespace App\Http\Controllers;

use App\Exports\PaguDataExport;
use App\Models\Pagu;
use App\Models\Subkegiatan;
use App\Models\SumberDana;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

class PaguController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $title = 'Data Pagu';
        $subs = Subkegiatan::all();
        $danas = SumberDana::all();

        if ($request->ajax()) {
            $pagu = Pagu::with(['sumberDana', 'subkegiatan'])->latest()->get();

            return DataTables::of($pagu)
                ->addIndexColumn()
                ->addColumn('aksi', function ($pagu) {
                    return '<div class="text-center">
                                <form action="'.route('pagu.destroy', $pagu->id).'" method="POST" style="display:inline;">
                                    '.csrf_field().'
                                    '.method_field('DELETE').'
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-sm btn-warning btn-edit"
                                                data-id="'.$pagu->id.'"
                                                data-subkegiatan="'.$pagu->subkegiatan_id.'"
                                                data-sumber="'.$pagu->sumber_dana_id.'"
                                                data-paket="'.$pagu->paket.'"
                                                data-jumlah="'.$pagu->jumlah.'">
                                            <i class="fa fa-pencil"></i>
                                        </button>
                                        <button class="btn btn-sm btn-danger" type="submit" id="btn-delete" onclick="return confirm(\'Apakah Anda yakin ingin menghapus data ini?\')">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </div>
                                </form>
                            </div>';
                })
                ->rawColumns(['aksi'])
                ->make();
        }

        return view('dashboard.pagu.index')->with(compact('title', 'subs', 'danas'));
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
        } catch (ValidationException $exception) {
            return redirect()->route('pagu.index')->with('failed', $exception->getMessage());
        }

        Pagu::create($validatedData);

        return redirect()->route('pagu.index')->with('success', 'Pagu baru berhasil ditambahkan!');
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
        } catch (ValidationException $exception) {
            return redirect()->route('pagu.index')->with('failed', 'Data gagal diperbarui! '.$exception->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pagu $pagu)
    {
        try {
            Pagu::destroy($pagu->id);
        } catch (QueryException $e) {
            if ($e->getCode() == 23000) {
                //SQLSTATE[23000]: Integrity constraint violation
                return redirect()->route('pagu.index')->with('failed',
                    "Pagu $pagu->keterangan tidak dapat dihapus, karena sedang digunakan!");
            }
        }

        return redirect()->route('pagu.index')->with('success', "Pagu $pagu->keterangan berhasil dihapus!");
    }

    public function exportAll()
    {
        return Excel::download(new PaguDataExport, 'Data_Pagu.xlsx');
    }
}
