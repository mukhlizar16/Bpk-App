<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pejabat extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function Jabatan()
    {
        return $this->belongsTo(Jabatan::class, 'jabatan_id');
    }
}
