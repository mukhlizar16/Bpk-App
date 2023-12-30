<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kontrak extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function Pagu()
    {
        return $this->belongsTo(Pagu::class, 'pagu_id');
    }

    public function Adendum()
    {
        return $this->hasMany(Adendum::class);
    }

    public function Sp2d()
    {
        return $this->hasMany(Sp2d::class);
    }
}
