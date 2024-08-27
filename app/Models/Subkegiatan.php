<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subkegiatan extends Model
{
    protected $table = 'subkegiatan';

    protected $fillable = ['kode', 'keterangan'];

    public function kegiatan()
    {
        return $this->belongsTo(Kegiatan::class, 'kegiatan_id');
    }

    public function pagus()
    {
        return $this->hasMany(Pagu::class, 'subkegiatan_id');
    }
}
