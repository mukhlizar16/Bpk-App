<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kontrak extends Model
{
    use HasFactory;

    protected $table = 'kontrak';
    protected $fillable = ['pagu_id', 'penyedia', 'pengadaan_id', 'nomor', 'tanggal', 'jumlah', 'jangka_waktu', 'bukti', 'hps', 'dokumen'];
    protected $casts = [
        'tanggal' => 'date'
    ];

    public function pagu()
    {
        return $this->belongsTo(Pagu::class, 'pagu_id');
    }

    public function adendum()
    {
        return $this->hasMany(Adendum::class);
    }

    public function sp2d()
    {
        return $this->hasMany(Sp2d::class);
    }

    public function jenisPengadaan()
    {
        return $this->belongsTo(JenisPengadaan::class, 'pengadaan_id');
    }
}
