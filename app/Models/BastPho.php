<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BastPho extends Model
{
    use HasFactory;

    protected $table = 'bast_pho';
    protected $fillable = ['pagu_id', 'nomor', 'tanggal', 'keterangan'];
    protected $casts = [
        'tanggal' => 'date'
    ];

    public function pagu()
    {
        return $this->belongsTo(Pagu::class, 'pagu_id');
    }
}
