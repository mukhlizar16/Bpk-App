<?php

namespace App\Http\Controllers;

use App\Models\Program;
use Illuminate\Http\Request;

class ProgramController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = "Data Program";
        $programs = Program::all();
        return view('dashboard.kegiatan.program.index')->with(compact('title', 'programs'));
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
                'kode' => 'required',
                'keterangan' => 'required',
            ]);
        } catch (\Illuminate\Validation\ValidationException $exception) {
            return redirect()->route('program.index')->with('failed', $exception->getMessage());
        }

        Program::create($validatedData);

        return redirect()->route('program.index')->with('success', 'Program baru berhasil ditambahkan!');
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
    public function update(Request $request, Program $program)
    {
        try {
            $rules = [
                'kode' => 'required',
                'keterangan' => 'required',
            ];

            $validatedData = $this->validate($request, $rules);

            Program::where('id', $program->id)->update($validatedData);

            return redirect()->route('program.index')->with('success', "Data Program $program->keterangan berhasil diperbarui!");
        } catch (\Illuminate\Validation\ValidationException $exception) {
            return redirect()->route('program.index')->with('failed', 'Data gagal diperbarui! ' . $exception->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Program $program)
    {
        try {
            Program::destroy($program->id);
        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->getCode() == 23000) {
                //SQLSTATE[23000]: Integrity constraint violation
                return redirect()->route('program.index')->with('failed', "Program $program->keterangan tidak dapat dihapus, karena sedang digunakan!");
            }
        }

        return redirect()->route('program.index')->with('success', "Program $program->keterangan  berhasil dihapus!");
    }
}
