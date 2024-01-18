<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisPengadaan extends Model
{
    use HasFactory;

    public function Kontrak()
    {
        return $this->hasMany(Kontrak::class);
    }
}
