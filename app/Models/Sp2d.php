<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sp2d extends Model
{
    use HasFactory;

    protected $table = 'sp2d';
    protected $guarded = ['id'];
    protected $casts = [
        'tanggal' => 'date'
    ];

    public function Kontrak()
    {
        return $this->belongsTo(Kontrak::class, 'kontrak_id');
    }
}
