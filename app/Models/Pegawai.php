<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pegawai extends Model
{
    protected $guarded= ['id'];

    use HasFactory;

    public function SuratTugas()
    {
        return $this->hasMany(SuratTugas::class, 'pegawai_id');
    }

    public function Asn()
    {
        return $this->belongsTo(Asn::class, 'jenis_asn_id');
    }

    public function Golongan()
    {
        return $this->belongsTo(Golongan::class, 'golongan_id');
    }
}
