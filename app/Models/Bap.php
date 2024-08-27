<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Bap extends Model
{
    use HasFactory;

    protected $table = 'bap';
    protected $fillable = ['nomor', 'tanggal'];
    protected $casts = [
        'tanggal' => 'date'
    ];

    public function pagu(): BelongsTo
    {
        return $this->belongsTo(Pagu::class, 'pagu_id');
    }
}
