<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Pagu extends Model
{
    use HasFactory;

    protected $table = 'pagu';

    protected $fillable = ['subkegiatan_id', 'jumlah', 'paket', 'sumber_dana_id', 'pengadaan_id'];

    public function subkegiatan()
    {
        return $this->belongsTo(Subkegiatan::class, 'subkegiatan_id');
    }

    public function sumberDana()
    {
        return $this->belongsTo(SumberDana::class, 'sumber_dana_id');
    }

    public function realisasiKeuangan()
    {
        return $this->hasMany(RealisasiKeuangan::class);
    }

    public function realisasiFisik()
    {
        return $this->hasMany(RealisasiFisik::class);
    }

    public function bap(): HasOne
    {
        return $this->hasOne(Bap::class, 'pagu_id');
    }

    public function bast()
    {
        return $this->hasOne(Bast::class);
    }

    public function bastPho()
    {
        return $this->hasOne(BastPho::class);
    }

    public function spmk()
    {
        return $this->hasOne(Spmk::class);
    }

    public function kontrak()
    {
        return $this->hasOne(Kontrak::class, 'pagu_id');
    }

    public function jenisPengadaan(): BelongsTo
    {
        return $this->belongsTo(JenisPengadaan::class, 'pengadaan_id');
    }
}
