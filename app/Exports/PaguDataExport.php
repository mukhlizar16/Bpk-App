<?php

namespace App\Exports;

use App\Models\Pagu;
use App\Models\Program;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class PaguDataExport implements FromView, ShouldAutoSize
{
    use Exportable;

    public function view(): View
    {
        $data = Pagu::with('Subkegiatan', 'SumberDana', 'RealisasiKeuangan', 'RealisasiFisik', 'Spmk', 'Kontrak')->get();
        $program = Program::with('Kegiatan')->get();

        return view('export.pagu', [
            'pagus' => $data,
            'programs' => $program,
        ]);
    }
}
