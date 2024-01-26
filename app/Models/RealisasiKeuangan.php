<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RealisasiKeuangan extends Model
{
    use HasFactory;

    protected $table = 'realisasi_keuangan';
    protected $guarded = ['id'];

    public function Pagu()
    {
        return $this->belongsTo(Pagu::class, 'pagu_id');
    }
}
