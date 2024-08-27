<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kegiatan extends Model
{
    use HasFactory;

    protected $table = 'kegiatan';
    protected $guarded = ['id'];

    public function program()
    {
        return $this->belongsTo(Program::class, 'program_id');
    }

    public function subkegiatans()
    {
        return $this->hasMany(Subkegiatan::class, 'kegiatan_id');
    }
}
