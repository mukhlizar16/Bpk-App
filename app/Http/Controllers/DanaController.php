<?php

namespace App\Http\Controllers;

use App\Models\SumberDana;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\SumberDanaRequest;

class DanaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = 'Data Sumber Dana';
        $danas = SumberDana::all();

        return view('dashboard.dana.index')->with(compact('title', 'danas'));
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
    public function store(SumberDanaRequest $request)
    {
        SumberDana::create($request->validated());
        return to_route('dana.index')->with('success', 'Berhasil disimpan.');
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
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SumberDana $dana)
    {
        $dana->delete();
        DB::statement('ALTER TABLE sumber_dana AUTO_INCREMENT=1');
        return to_route('dana.index')->with('success', 'Berhasil dihapus.');
    }
}
