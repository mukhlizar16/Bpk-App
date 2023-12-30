<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kegiatan extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function Program()
    {
        return $this->belongsTo(Program::class, 'program_id');
    }

    public function Subkegiatan()
    {
        return $this->hasMany(Subkegiatan::class);
    }
}
