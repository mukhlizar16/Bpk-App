<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pagu extends Model
{
    use HasFactory;

    protected $table = 'pagu';
    protected $fillable = ['subkegiatan_id', 'jumlah', 'paket', 'sumber_dana_id', 'pengadaan_id'];

    public function Subkegiatan()
    {
        return $this->belongsTo(Subkegiatan::class, 'subkegiatan_id');
    }

    public function SumberDana()
    {
        return $this->belongsTo(SumberDana::class, 'sumber_dana_id');
    }

    public function RealisasiKeuangan()
    {
        return $this->hasMany(RealisasiKeuangan::class);
    }

    public function RealisasiFisik()
    {
        return $this->hasMany(RealisasiFisik::class);
    }

    public function Spmk()
    {
        return $this->hasOne(Spmk::class);
    }

    public function Kontrak()
    {
        return $this->hasOne(Kontrak::class);
    }
}
