<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisTugas extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function Sppd()
    {
        return $this->hasMany(Sppd::class, 'jenis_tugas_id');
    }
}
