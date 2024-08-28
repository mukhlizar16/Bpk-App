<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bast extends Model
{
    use HasFactory;

    protected $table = 'bast';
    protected $fillable = ['pagu_id', 'nomor', 'tanggal'];
    protected $casts = [
        'tanggal' => 'date'
    ];

    public function pagu()
    {
        return $this->belongsTo(Pagu::class, 'pagu_id');
    }
}
