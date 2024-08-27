<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bap extends Model
{
    use HasFactory;

    protected $table = 'bap';
    protected $fillable = ['nomor', 'tanggal'];
    protected $casts = [
        'tanggal' => 'date'
    ];

    public function Pagu()
    {
        return $this->belongsTo(Pagu::class, 'pagu_id');
    }
}
