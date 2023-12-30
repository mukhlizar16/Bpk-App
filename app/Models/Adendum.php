<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Adendum extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function Kontrak()
    {
        return $this->belongsTo(Kontrak::class, 'kontrak_id');
    }
}
