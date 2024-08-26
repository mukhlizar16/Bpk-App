<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subkegiatan extends Model
{
    protected $table = 'subkegiatan';

    protected $fillable = ['kode', 'keterangan'];

    public function Kegiatan()
    {
        return $this->belongsTo(Kegiatan::class, 'kegiatan_id');
    }

    public function Pagu()
    {
        return $this->hasMany(Pagu::class);
    }
}
