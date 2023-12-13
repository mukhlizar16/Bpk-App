<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuratTugas extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function Sppd()
    {
        return $this->belongsTo(Sppd::class, 'sppd_id');
    }

    public function Pegawai()
    {
        return $this->belongsTo(Pegawai::class, 'pegawai_id');
    }
}
