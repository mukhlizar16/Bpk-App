<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bap extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function Pagu()
    {
        return $this->belongsTo(Pagu::class, 'pagu_id');
    }
}
