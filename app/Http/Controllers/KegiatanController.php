<?php

namespace App\Http\Controllers;

use App\Models\Kegiatan;
use App\Models\Program;
use App\Models\Subkegiatan;
use Illuminate\Http\Request;

class KegiatanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = "Data Kegiatan";
        $kegiatans = Kegiatan::with('Program')->get();
        $programs = Program::all();
        return view('dashboard.kegiatan.index')->with(compact('title', 'kegiatans', 'programs'));
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
                'program_id' => 'required',
                'kode' => 'required',
                'keterangan' => 'required',
            ]);
        } catch (\Illuminate\Validation\ValidationException $exception) {
            return redirect()->route('utama.index')->with('failed', $exception->getMessage());
        }

        Kegiatan::create($validatedData);

        return redirect()->route('utama.index')->with('success', 'Kegiatan baru berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Kegiatan $utama)
    {
        $title = "Data Sub Kegiatan - $utama->keterangan";
        $subkegiatans = Subkegiatan::where('kegiatan_id', $utama->id)->get();
        return view('dashboard.kegiatan.sub-kegiatan.index')->with(compact('title', 'utama', 'subkegiatans'));
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
    public function update(Request $request, Kegiatan $utama)
    {
        try {
            $rules = [
                'program_id' => 'required',
                'kode' => 'required',
                'keterangan' => 'required',
            ];

            $validatedData = $this->validate($request, $rules);

            Kegiatan::where('id', $utama->id)->update($validatedData);

            return redirect()->route('utama.index')->with('success', "Data Kegiatan $utama->keterangan berhasil diperbarui!");
        } catch (\Illuminate\Validation\ValidationException $exception) {
            return redirect()->route('utama.index')->with('failed', 'Data gagal diperbarui! ' . $exception->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Kegiatan $utama)
    {
        try {
            Kegiatan::destroy($utama->id);
        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->getCode() == 23000) {
                //SQLSTATE[23000]: Integrity constraint violation
                return redirect()->route('utama.index')->with('failed', "Kegiatan $utama->keterangan tidak dapat dihapus, karena sedang digunakan!");
            }
        }

        return redirect()->route('utama.index')->with('success', "Kegiatan $utama->keterangan berhasil dihapus!");
    }
}
