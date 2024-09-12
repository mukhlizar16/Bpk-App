<?php

namespace App\Http\Controllers;

use App\Models\SumberDana;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $title = 'Dashboard';
        $sumber = SumberDana::select(DB::raw('SUM(pagu.jumlah) AS jumlah'), 'sumber_dana.keterangan')
            ->join('pagu', 'pagu.sumber_dana_id', '=', 'sumber_dana.id')
            ->groupBy('sumber_dana.keterangan')->get()->pluck('jumlah', 'keterangan');

        return view('dashboard.index')->with(compact('title', 'sumber'));
    }
}
